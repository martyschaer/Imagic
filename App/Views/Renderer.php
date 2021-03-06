<?php
namespace Views;

use \Exception;

class Renderer
{
    private static $view;

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
        self::$view = $view;
        $params = self::extendParams($params);
        $content = self::prep($view, $params);
        echo $content;

    }

    /**
     * preps the view for displaying.
     * @param $view
     * @param $params
     * @return string
     * @throws Exception
     */
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

    /**
     * extends the $params array by some commonly used values
     * @param $params
     * @return mixed
     * @throws Exception
     */
    private function extendParams($params)
    {
        $is_logged_in = false;
        if(isset($_SESSION['user'])){
            $is_logged_in = true;
            $params['USER_EMAIL'] = $_SESSION['user']->getEmail();
        }

        $params['SESSION'] = print_r($_SESSION, true);
        $params['ROOT_PATH'] = "../../";
        $params['RESOURCE_PATH'] = $params['ROOT_PATH'] . '/Resources';
        $params['HEAD'] = self::prep('head', $params);
        $params['NAV'] = self::prep('menu', $params);
        $params['HEADER'] = self::prep(($is_logged_in ? 'in.header' : 'out.header'), $params);
        return $params;
    }
}