<?php
namespace Utilities\Routing;

use \Exception;
use \Traversable;

class Router
{
    private $routes = [];
    private $names = [];
    private $basePath = '';
    private $matchTypes = [
        'i' => '[0-9]++',
        'a' => '[0-9A-Za-z]++',
        '*' => '.++',
        '' => '[^/\.]++'
    ];

    public function __construct($routes = [], $basePath = '')
    {
        $this->addRoutes($routes);
        $this->setBasePath($basePath);
    }

    public function addRoutes($routes)
    {
        if (!is_array($routes) && !$routes instanceof Traversable) {
            throw new Exception('Routes must be array and traversable');
        }
        foreach ($routes as $route) {
            call_user_func_array([$this, 'map'], $route);
        }
    }

    public function addRoute($route)
    {
        $this->addRoutes([$route]);
    }

    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    public function map($method, $route, $target, $name = null)
    {
        $this->routes[] = [$method, $route, $target, $name];
        if ($name) {
            if (in_array($name, $this->names)) {
                throw new Exception("Route with name '{$name}' already exists");
            } else {
                $this->names[] = $name;
            }
        }
    }

    //TODO understand and rewrite
    public function match($requestUrl = null, $requestMethod = null)
    {
        $params = array();
        $match = false;
        // set Request Url if it isn't passed as parameter
        if ($requestUrl === null) {
            $requestUrl = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
        }
        // strip base path from request url
        $requestUrl = substr($requestUrl, strlen($this->basePath));
        // Strip query string (?a=b) from Request Url
        if (($strpos = strpos($requestUrl, '?')) !== false) {
            $requestUrl = substr($requestUrl, 0, $strpos);
        }
        // set Request Method if it isn't passed as a parameter
        if ($requestMethod === null) {
            $requestMethod = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
        }
        foreach ($this->routes as $handler) {
            list($method, $_route, $target, $name) = $handler;
            $methods = explode('|', $method);
            $method_match = false;
            // Check if request method matches. If not, abandon early. (CHEAP)
            foreach ($methods as $method) {
                if (strcasecmp($requestMethod, $method) === 0) {
                    $method_match = true;
                    break;
                }
            }
            // Method did not match, continue to next route.
            if (!$method_match) continue;
            // Check for a wildcard (matches all)
            if ($_route === '*') {
                $match = true;
            } elseif (isset($_route[0]) && $_route[0] === '@') {
                $pattern = '`' . substr($_route, 1) . '`u';
                $match = preg_match($pattern, $requestUrl, $params);
            } else {
                $route = null;
                $regex = false;
                $j = 0;
                $n = isset($_route[0]) ? $_route[0] : null;
                $i = 0;
                // Find the longest non-regex substring and match it against the URI
                while (true) {
                    if (!isset($_route[$i])) {
                        break;
                    } elseif (false === $regex) {
                        $c = $n;
                        $regex = $c === '[' || $c === '(' || $c === '.';
                        if (false === $regex && false !== isset($_route[$i + 1])) {
                            $n = $_route[$i + 1];
                            $regex = $n === '?' || $n === '+' || $n === '*' || $n === '{';
                        }
                        if (false === $regex && $c !== '/' && (!isset($requestUrl[$j]) || $c !== $requestUrl[$j])) {
                            continue 2;
                        }
                        $j++;
                    }
                    $route .= $_route[$i++];
                }
                $regex = $this->compileRoute($route);
                $match = preg_match($regex, $requestUrl, $params);
            }
            if (($match == true || $match > 0)) {
                if ($params) {
                    foreach ($params as $key => $value) {
                        if (is_numeric($key)) unset($params[$key]);
                    }
                }
                return array(
                    'target' => $target,
                    'params' => $params,
                    'name' => $name
                );
            }
        }
        return false;
    }

    //TODO understand function
    private function compileRoute($route)
    {
        //TODO understand regex
        if (preg_match_all('`(/|\.|)\[([^:\]]*+)(?::([^:\]]*+))?\](\?|)`', $route, $matches, PREG_SET_ORDER)) {
            $matchTypes = $this->matchTypes;
            foreach ($matches as $match) {
                list($block, $pre, $type, $param, $opt) = $match;

                if (isset($matchTypes[$type])) {
                    $type = $matchTypes[$type];
                }

                if ($pre === '.') {
                    $pre = '\.';
                }

                $pattern = '(?:'
                    . ($pre !== '' ? $pre : null)
                    . '('
                    . ($param !== '' ? "?P<$param>" : null)
                    . $type
                    . '))'
                    . ($opt !== '' ? '?' : null);
                $route = str_replace($block, $pattern, $route);
            }
        }
        return "`^$route$`u";
    }
}