<?php 

namespace Adnane\Arabic;

use Adnane\Arabic\Ar\Tafkit;
use Adnane\Arabic\Ar\Tawkit;
use Adnane\Arabic\Ar\Strings;

class Arabic
{
    protected static $numberFormat = 'la';
    
    public function __construct($numberFormat = null)
    {
        if(!! $numberFormat) self::$numberFormat = 'ar';
    }
    /* 
    | ========================================================
    | [ Working with numbers & integers ] 
    |
    | handle methods calls for Class located  at 
    | [ Adnane\Arabic\Ar\Tafkit ]
    | 
    | ========================================================
    */
 
    /* 
    |
    | convert numeric numbers to spelled strings 
    | example : from 23 to ثلاث وعشرون
    | max number supported : 999999999999999
    | @params : $integer (int)
    |
    */
    public static function tafkit($integer)
    {
        return Tafkit::kalimat($integer);
    }

    /* 
    |
    | convert numeric numbers to ordered declares
    | example : from 23 to الثالث والعشرون
    | max number supported : 999999999999999
    | @params : $integer (int)
    |
    */
    public static function tartib($integer)
    {
        return Tafkit::tartib($integer);
    }
    /* 
    |
    | rewrite numbers to be like ۱٧۳۱۸
    | 
    | @params : $str (string)
    |
    */
    public static function arkam($integer)
    {
        return Tafkit::toIndianNums($integer); 
    }

    /* 
    | ========================================================
    | [ Working with dates & unix times ] 
    |
    | handle calls for Class located  at 
    | [ Adnane\Arabic\Ar\Tawkit  ]
    | 
    | ========================================================
    */

    /* 
    |
    | convert a given date to hijri takwim date 
    | format supported : f , s , n 
    | @params : $format (string) , $date (dateformat) 
    |
    */
    public static function hijri($format = 'f' ,$date = null)
    {
        return Tawkit::fullHijri($date,$format); 
    }
    
    /* 
    |
    | Get the relative time between two given dates 
    | 
    | 
    | @params : $date (dateformat) , $date2 (dateformat) , $detailed (boolean) 
    |
    */
    public static function fariq($date ,$date2 = null ,$detailed = false)
    { 
        return Tawkit::relativeTime($date ,$date2 ,$detailed); 
    }

    /* 
    | ========================================================
    | [ Working with long texts & strings ] 
    |
    | handle calls for Class located  at 
    | [ Adnane\Arabic\Ar\Strings   ]
    | 
    | ========================================================
    */

    /* 
    |
    | get rid of The vowel diacritics in Arabic  
    | @params : $str (string) [ string to clean ]
    |
    */
    public static function removeHarakat($str)
    {
        return Strings::removeHarakat($str);
    }

    /* 
    |
    | rewrite strings and texts to match the keyboard reveresed in english 
    | can be really helpful when it comes to making search proccess better 
    | 
    | @params : $str (string) [ string to reverse ]
    |
    */
    public static function toKeyboardInput($str)
    {
        return Strings::toKeyboardInput($str);
    }
    
    /* 
    |
    | rewrite strings and texts to be written and spelled in english letters 
    | this can be really helpful when it comes to making seo friendly url's or slugs 
    | 
    | @params : $str (string) [ string to write in spelled form ]
    |
    */
    public static function toSpelled($str)
    {
        return Strings::toSpelled($str);
    }
   
}
