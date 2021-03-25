<?php 

namespace Adnane\Arabic;


use Adnane\Arabic\Ar\Grammar;

class Arabic
{
    /* 
    | ========================================================
    | => Here where you can define new methods & refrence them 
    | to theire containing instances , as they will be handled 
    | & declared dynamicly by this instance.
    |
    | => you may override methods' names and name theme as you 
    | or your project desire !
    | ========================================================
    */
    private static $methods = 
    [
        #numbers and integers
        'kalimat' => [ Ar\Tafkit::class ,'kalimat' ],
        'tartib'  => [ Ar\Tafkit::class ,'tartib' ],
        'arkam'   => [ Ar\Tafkit::class ,'toIndianNums' ],
        
        #dates and times
        'toHijri'   => [ Ar\Tawkit::class ,'GregorianToHijri' ],
        'fromHijri'   => [ Ar\Tawkit::class ,'HijriToGregorian' ],
        'fariq'   => [ Ar\Tawkit::class ,'getRelativeTime' ],
        
        #strings & texts
        'removeHarakat' => [ Ar\Strings::class ,'removeHarakat' ],
        'toKeyboardInput' => [ Ar\Strings::class ,'toKeyboardInput' ],
        'toSpelled' => [ Ar\Strings::class ,'toSpelled' ],
    ];

    /* 
    | ========================================================
    | Here where you we are loading & calling the methods using 
    |
    | the instance's private property $methods 
    | method can be called staticly using __callStatic
    | or non staticly using __call , as they both use the calls
    | handler method
    | ========================================================
    */
    # static 
    public static function __callStatic($method ,$params)
    {

        return self::handleCall($method ,$params);
    
    }

    # non static
    function __call($method ,$params)
    {

        return self::handleCall($method ,$params);
    
    }
    
    # calls handler
    private static function handleCall($method ,$params)
    {
        if(array_key_exists($method ,self::$methods))
        {
            $instance = self::$methods[$method][0];

            $method = self::$methods[$method][1];
            
            return call_user_func_array([$instance , $method] ,$params);
        }
    }
}
