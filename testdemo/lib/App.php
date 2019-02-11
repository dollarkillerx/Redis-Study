<?php

class App
{
    /**
     * @const string DEFAULT_CONTROLLER 默认控制器
     */
    const DEFAULT_CONTROLLER = 'index';

    /**
     * @const string DEFAULT_ACTION 默认action
     */
    const DEFAULT_ACTION = 'index';

    /**
     * @const string PREFIX_CONTROLLER 控制器类的前缀
     */
    const PREFIX_CONTROLLER = 'Controller';

    /**
     * @const string PARAMNAME_CONTROLLER 控制器在get中的参数名
     */
    const PARAMNAME_CONTROLLER = 'c';

    /**
     * @const string PARAMNAME_ACTION action在get中的参数名
     */
    const PARAMNAME_ACTION = 'a';

    public static function run()
    {
        $controllerName = self::get(self::PARAMNAME_CONTROLLER, self::DEFAULT_CONTROLLER);
        $actionName = self::get(self::PARAMNAME_ACTION, self::DEFAULT_ACTION);
        $controllerClass = self::PREFIX_CONTROLLER . ucfirst(strtolower($controllerName));
        if(!class_exists($controllerClass))
        {
            self::_404("controller {$controllerName} not found!");
        }
     
        $controller = new $controllerClass();
       
        if(!method_exists($controller, $actionName))
        {
            self::_404("action {$actionName} not found!");
        }

        $controller->$actionName();
    }

    /**
     * 获取get参数
     * @param string $name
     * @param string $default
     * @return string
     */
    public static function get($name, $default = '')
    {
        return isset($_GET[$name]) ? $_GET[$name] : $default;
    }

    /**
     * 获取post参数
     * @param string $name
     * @param string $default
     * @return string
     */
    public static function post($name, $default = '')
    {
        return isset($_POST[$name]) ? $_POST[$name] : $default;
    }

    /**
     * 生成url的行对路径
     * @param string $controller
     * @param string $action
     * @param array $param
     * @return string
     */
    public static function genUrl($controller, $action, $param = [])
    {
        $urlStr = '/?' . self::PARAMNAME_CONTROLLER . '=' . $controller . '&' . self::PARAMNAME_ACTION . '=' . $action;

        if(!empty($param))
        {
            foreach($param as $k => $v)
            {
                $k = trim($k);
                if($k == self::PARAMNAME_CONTROLLER || $k == self::DEFAULT_ACTION)
                {
                    continue;
                }
                if(!empty($k))
                {
                    $urlStr .= "&{$k}={$v}";
                }
            }
        }

        return $urlStr;
    }

    /**
     * 输出404
     * @param string $msg
     */
    public static function _404($msg = '')
    {
        header('HTTP/1.1 404 Not Found');
        exit('<h1>404 not found</h1><br>' . $msg);
    }
}
