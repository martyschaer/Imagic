<?php
namespace Views;

use \Exception;

class Renderer
{
    /**
     * function that renders a .view.php
     * supports some basic templating with {{$param_name}}
     * optionally pass an associative array as parameters.
     * @param $view
     * @param array $params
     * @throws Exception
     */
    public static function view($view, $params = [])
    {
        $params = self::extendParams($params);
        $content = self::prep($view, $params);
        echo $content;

    }

    private static function prep($view, $params)
    {
        $path = __DIR__ . DIRECTORY_SEPARATOR . $view . ".view.php";
        if (!file_exists($path)) {
            throw new Exception("Could not find '{$path}'. File does not exist.");
        }
        $raw = file_get_contents($path);
        return self::fillTemplate($raw, $params);
    }

    /**
     * function that replaces all {{$param_name}}s with the actual data.
     * @param $raw
     * @param $params
     * @return string
     */
    private static function fillTemplate($raw, $params)
    {
        $processed = $raw;
        foreach ($params as $key => $value) {
            $processed = str_replace('{{' . $key . '}}', (string)$value, $processed);
        }
        return (string)$processed;
    }

    private function extendParams($params)
    {
        $params['ROOT_PATH'] = "../../";
        $params['HEAD'] = self::prep('head', $params);
        return $params;
    }
}