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
    public static function view($view, $params = []){
        $path = __DIR__ . DIRECTORY_SEPARATOR . $view . ".view.php";
        if(file_exists($path)){
            $raw = file_get_contents($path);
            $content = self::fillTemplate($raw, $params);
            echo $content;
        }else{
            throw new Exception("Could not find '{$path}'. File does not exist.");
        }
    }

    /**
     * function that replaces all {{$param_name}}s with the actual data.
     * @param $raw
     * @param $params
     * @return string
     */
    private static function fillTemplate($raw, $params){
        $processed = $raw;
        foreach ($params as $key => $value) {
            $processed = str_replace('{{' . $key . '}}', (string)$value, $processed);
        }
        return (string)$processed;
    }
}