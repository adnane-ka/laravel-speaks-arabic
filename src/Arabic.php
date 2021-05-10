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
        'toWords' => [ Ar\Tafkit::class ,'toWords' ],
        'fromWords' => [ Ar\Tafkit::class ,'fromWords' ],
        'toOrdinal'  => [ Ar\Tafkit::class ,'toOrdinal' ],
        'toIndianNums'   => [ Ar\Tafkit::class ,'toIndianNums' ],
        'toHijri'   => [ Ar\Tawkit::class ,'GregorianToHijri' ],
        'fromHijri'   => [ Ar\Tawkit::class ,'HijriToGregorian' ],
        'toRelative'   => [ Ar\Tawkit::class ,'toRelative' ],
        'fromRelative'   => [ Ar\Tawkit::class ,'fromRelative' ],
        'removeHarakat' => [ Ar\Strings::class ,'removeHarakat' ],
        'toKeyboardInput' => [ Ar\Strings::class ,'toKeyboardInput' ],
        'toSpelled' => [ Ar\Strings::class ,'toSpelled' ],
        'countWords' => [ Ar\Strings::class ,'utf8WordCount'],
        'containsAr' => [ Ar\Strings::class ,'containsArabic'],
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
