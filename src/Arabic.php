<?php 

namespace Adnane\Arabic;

use Adnane\Arabic\Ar\Grammar;
use Adnane\Arabic\Caller;

class Arabic
{
    use Caller;
    /**
     * Here where you can define new methods & refrence them
     * to theire containing instances , as they will be handled 
     * & declared dynamicly by this instance.
     * you may override methods' names and name theme as you 
     * or your project desire !
    */
    private static $methods = 
    [
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
}
