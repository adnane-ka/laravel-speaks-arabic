<?php 

namespace Adnane\Arabic\Ar\data\tawkit;
 
trait loader
{
    private static $rootDir;
    
    public static function load()
    {
        return [
            'hijri_months' => self::toAssoc('hijri_months.json'),

            'time' => self::toAssoc('time.json'),
            'uniques' => self::toAssoc('uniques.json'),
            
            'days' => self::toAssoc('days.json'),
            'relative' => self::toAssoc('relative.json'),
            'units' => self::toAssoc('units.json'),

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


