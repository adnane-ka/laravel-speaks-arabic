<?php 

namespace Adnane\Arabic\Ar\data\tafkit;
 
trait loader
{
    private static $rootDir;
    
    public static function load()
    {
        return [
            'ones' => self::toAssoc('ones.json'),
            'tens' => self::toAssoc('tens.json'),
            'hundreds' => self::toAssoc('hundreds.json'),

            'levels' => self::toAssoc('levels.json'),
            'uniques' => self::toAssoc('uniqes.json'),
            'extra' => self::toAssoc('extra.json'),

            'order' => self::toAssoc('order.json'),

            'numbers' => self::toAssoc('numbers.json'),

            'zero_to_20' => self::toAssoc('zero_to_20.json'),
            'spaced_ones' => self::toAssoc('spaced_ones.json'),
            'trimed_uniques' => self::toAssoc('trimed_uniques.json'),
            'trimed_tens' => self::toAssoc('trimed_tens.json'),
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


