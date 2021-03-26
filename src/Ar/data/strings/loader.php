<?php 

namespace Adnane\Arabic\Ar\data\strings;
 
trait loader
{
    private static $rootDir;
    
    public static function load()
    {
        return [
           'letters' => self::toAssoc('letters.json'),
           'en_letters'=> self::toAssoc('english_letters.json'),
           'en_unique'=> self::toAssoc('en_unique.json'),

           'uniques' => self::toAssoc('uniques.json'),

           'map' => self::toAssoc('map.json'),
        ];
    }
    /*
    | including the file and converting to associative array 
    | 
    */
    private static function toAssoc($filename)
    {
        self::$rootDir = dirname(__FILE__).'/json';

        return json_decode(file_get_contents(self::$rootDir.'/'.$filename) ,true);
    }
}


