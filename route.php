<?php

class Route
{
    public static function parse_url()
    {
        $dirname = dirname($_SERVER['SCRIPT_NAME']);
        $dirname = $dirname != '/' ? $dirname : null;
        $basename = basename($_SERVER['SCRIPT_NAME']);
        $request_uri = str_replace([$dirname, $basename], null, $_SERVER['REQUEST_URI']);
        return $request_uri;
    }

    public static function run($url, $callback, $method = 'get')
    {
    
        $method = explode('|', strtoupper($method));

        if (in_array($_SERVER['REQUEST_METHOD'], $method)) {

            $patterns = [
                '{url}' => '([0-9a-zA-Z?=&]+)',
                '{id}' => '([0-9]+)',
                '{tag}'=> '([a-z\-]+)',
                '{menu}' => '([0-9a-zA-Z-]+)',
                '{user}'=>'([a-zA-Z_]+[a-zA-Z_?=0-9/]+)'
            ];

            
            $url = str_replace(array_keys($patterns), array_values($patterns), $url);

            $request_uri = self::parse_url();
            if (preg_match('@^' . $url . '$@', $request_uri, $parameters)) {

               
                unset($parameters[0]);

                foreach($parameters as &$param){
                    if(strpos($param,'?'))
                        $param = substr($param,0,strpos($param,'?'));
                }

               
                if (is_callable($callback)) {
                   
                   
                    
                    call_user_func_array($callback, $parameters);
                    die;
                } else {
                    $controller = explode('@', $callback);
                    $className = explode('/', $controller[0]);
                    $className = end($className);
                    $controllerFile = __DIR__ . '/controller/' . strtolower($controller[0]) . '.php';

                    if (file_exists($controllerFile)) {
                     
                        require $controllerFile;
                        call_user_func_array([new $className, $controller[1]], $parameters);
                        die;
                    
                    }
                    
                }

            }

        }

    }

    public static function get($url,$callback){
        Route::run($url,$callback,'get');
    }
    public static function post($url,$callback){
        Route::run($url,$callback,'post');
    }
    public static function default($url){
        $page = __DIR__ . '/view/'.strtolower($url).'.php';
        if(file_exists($page)){
            require $page;
        }
    }

}
