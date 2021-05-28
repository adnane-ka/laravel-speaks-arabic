<?php 

namespace Adnane\Arabic;

trait Caller
{
    /** 
     * call methods staticly 
     * 
     * @return void
     * */
    public static function __callStatic($method ,$params)
    {
        return self::handleCall($method ,$params);
    }
    
    /** 
     * call methods non staticly  
     * 
     * @return void
     * */
    function __call($method ,$params)
    {
        return self::handleCall($method ,$params);
    }

    /** 
     * handle call  
     * 
     * @return void
     * */
    private static function handleCall($method ,$params)
    {
        if(array_key_exists($method ,self::$methods))
        {
            $instance = self::$methods[$method][0];
            $method = self::$methods[$method][1];
            
            return call_user_func_array([$instance , $method] ,$params);
        }

        throw new \Exception('The method "'.$method.'" does not exist !');
    }
}
