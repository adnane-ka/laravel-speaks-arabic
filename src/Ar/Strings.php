<?php 
namespace Adnane\Arabic\Ar;

use Adnane\Arabic\Ar\data\strings\loader;

class Strings{
    
    use loader;
    private static $data;

    /* 
    |
    | get rid of The vowel diacritics in Arabic  
    | @params : $str (string) [ string to clean ]
    |
    */
    public static function removeHarakat($str)
    {
        $harakat = ['ِ', 'ُ', 'ٓ', 'ٰ', 'ْ', 'ٌ', 'ٍ', 'ً', 'ّ', 'َ'];
        $str = str_replace($harakat, '', $str);
        return $str;
    }
    
    /* 
    |
    | rewrite strings and texts to match the keyboard reveresed in english 
    | can be really helpful when it comes to making search proccess better 
    | kinda , using PHP as a web-scripting language 
    | @params : $str (string) [ string to reverse ]
    |
    */
    public static function toKeyboardInput($str)
    {    
        $letters = loader::load()['map'];

        foreach(array_keys($letters) as $letter)
        {
            $str = str_replace($letter ,$letters[$letter] ,$str);
        }
        return $str;
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
        // remove harakat first 
        $str = self::removeHarakat($str);
        
        // load data 
        $data = loader::load();
        // replace doubled letters like تو , سي , سا
        // doubled letters are formed like : letter(ت) + unique letter(و) = تو
        $uniques = $data['uniques'];
        $letters = $data['letters'];

        foreach(array_keys($letters) as $letter)
        {
            foreach(array_keys($uniques) as $unique)
            {
                $doubled = $letter . $unique;
                $sub = $letters[$letter] . $uniques[$unique];

                $str = str_replace($doubled ,$sub ,$str);
            }
        }

        // replace letters 
        foreach(array_keys($letters) as $letter)
        {
            $str = str_replace($letter ,$letters[$letter] ,$str);
        }
        return $str;
    }


    /*
    | equivilant of str_word_count in non-utf8 strings
    |
    | @params : $str require 
    | @return : int 
    */
    public static function utf8WordCount($str)
    {
        $regex = '/\\pL[\\pL\\p{Mn}\'-]*/u';
           
        return preg_match_all($regex, $str);
    }
    
    /*
    | check if a given string contains arabic 
    | charachters 
    |
    | @params : $str require 
    | @return : boolean  
    */
    public static function containsArabic($str)
    {
        if (preg_match('/[اأإء-ي]/ui', $str)) {
            return true;
        } 
        return false;
    }
   
}