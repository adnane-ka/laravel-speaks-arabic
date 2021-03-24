<?php 

namespace Adnane\Arabic\Ar;

use Adnane\Arabic\Ar\data\tafkit\loader;

class Tafkit
{
    private static $seperator = ' و ';
    private static $maxNumber = 999999999999999;
    private static $identifier = 'الـ';

    use loader;

    
    /* 
    |
    | rewrite numbers to be like 
    | 
    | @params : $str (string)
    |
    */
    public static function toIndianNums($str)
    {
        $nums = loader::load()['numbers'];
        
        foreach(array_keys($nums) as $num)
        {
            $str = str_replace($num ,$nums[$num] ,$str);
        }
        
        return $str;
    }
    /* 
    | get the order of a certain int 
    | 
    |
    | examples : 1 = الأول
    */
    public static function tartib($int)
    {
        if(array_key_exists($int ,loader::load()['order']))
        {
            if(intval($int) == 1)
            {
                return loader::load()['order'][1]['unique'];
            }
            return loader::load()['order'][$int];
        }

        switch (strlen($int)) {
            case 1:
                return loader::load()['order'][1]['unique'];
                break;

            case 2:
                $ones = self::getOnes($int);
                $tens = self::getTens($int);
    
                $tens = loader::load()['order'][$tens];
                
                if($ones == 1)
                {
                    $ones = loader::load()['order'][1]['standard'].self::$seperator;
                }
                elseif($ones !== 0)
                {
                    $ones = loader::load()['order'][$ones].self::$seperator;
                }
                else
                {
                    $ones = '';
                }
                return $ones.$tens;
                break;
            default:
                return self::$identifier . self::kalimat($int);
                break;
        }
        return $int;
    }
    /* 
    | which is the main function in the class
    |
    | can summerize the whole proccess and return string depending on a valid int given 
    */
    public static function kalimat($int)
    {
        # validate incoming charchter 
        if(! self::validate($int)){ return 'invalid'; };   
        
        # name the levels and prepare a descriptive array 
        $decription = self::nameLevels($int);

        # reverse array to read it in arabic 
        return self::process($decription);
    }

    /*  
    | this function takes the result of getLevels and return it to 
    | words depending on the level 
    |
    | example: it takes 2 from the level of tens and returns عشرون and so on .. 
    | 
    */
    private static function nameLevels($int)
    {
        # get levels 
        $levels = self::getLevels($int);
        
        # load data 
        $data = loader::load();

        # descriptive array 
        $decription = [];
                
        # loop throught levels and name them 
        for($i = 0 ; $i < count($levels) ; $i++)
        {   
            $index = $i;
            $level = $levels[$i];
            
            if($index > 0)
            {
                $words = self::toPhrase($level);
        
                if($level > 1 && $level < 11)
                {
                    array_push($decription ,$words.' '.$data['levels'][$index]['plural']);
                }
                else
                {
                    array_push($decription ,$words.' '.$data['levels'][$index]['singular']);
                }
            }
            else
            {
                array_push($decription ,self::toPhrase($level));
            }
        }

        return $decription;
    }
    
    /*  
    | this function gets the levels of the target integer 
    | for example : 
    | levels of 12472 are : 
    | [2 , 7 ,4 ,2 ,1]
    | 
    | as we need to reverse the result array to be easy when it comes to naming 
    | 
    */
    private static function getLevels($int)
    {
        $number = number_format($int , 0 ,"." ,",");

        $levels = explode(',' ,$number);

        $levels = array_reverse($levels);

        return $levels;
    }
    
    /*  
    | 
    | this function basiclly use other methods in certain order
    | with certain logic 
    | it takes the array of named levels , combine it and clean it 
    | 
    | example of use : 
    | 
    | proccess([
    |    0 => "ست مئة و خمس و ثلاثون ",
    |    1 => "خمس مئة و ثلاث و تسعون  ألف",
    |    2 => "سبع مئة و واحد و عشرة  مليون",
    |    3 => "مئة و اثنان و عشرة  مليار",
    |    4 => "أربع مئة و خمس و عشرة  ترليون" 
    | ]);
    |
    | result : 
    | أربع مئة و خمس عشر ترليون و مئة و اثنا عشر مليار و سبع مئة
    | و أحدا عشر مليون و خمس مئة و ثلاث و تسعون ألف و ست مئة و خمس و ثلاثون
    |
    */
    private static function process($decription)
    {  
        $decription = array_reverse($decription);

        $digit = implode(self::$seperator , $decription);

        $digit = self::clean($digit);

        $digit = self::handleSpecialChars($digit);

        $digit = self::organize($digit);

        return $digit;
    }

    /*
    | cleans the result string after being proccessed  
    | 
    | for example , it will change this from : "ألف وصفر مئة وصفر" 
    | to : "ألف"
    |
    */
    private static function clean($str)
    {
        $spliced = loader::load()['extra'];
        
        foreach($spliced as $replaced)
        {
            $str = str_replace($spliced ,'' ,$str);
        }
        return $str;
    }

    /*
    | handle special and unique named chrachters in the result string 
    |
    | as known , the arabic language follows a completly different 
    | naming rules . for example " Two Hundred " in English must be " اثنان مئة "
    | in arabic right ? well , that's not actually , Two hundreds is completly different thing 
    | it is : مئتان, and so are alot of other numbers .. 
    |
    | this function cleans the string given and replace all what's not ruled by arabic 
    | to what it is !
    |
    | example of use : 
    | $str = "ألف و اثنان مئة وأربعة وعشرون";
    | handleSpecialChars($str) 
    | 
    | result : ألف ومئتان وأربع وعشرون
    */
    private static function handleSpecialChars($str)
    {
        $uniques = loader::load()['uniques'];

        foreach(array_keys($uniques) as $unique)
        {
            $str = str_replace($unique ,$uniques[$unique] ,$str);
        }
        return $str;
    }

    /*
    | organize and re-shape final result
    | 
    | due to the dont proccess we may find
    | a lot of spaces . thus , making it a bit cleaner
    | looks so much better !
    |
    */
    private static function organize($str)
    {
        $str = explode(' ',$str);

        $str = array_filter($str);

        return implode(' ',$str);
    }
    
    /*
    | validate incoming input 
    | 
    | check if a given string is 
    | allowed to be translated to words 
    | example : 12D is not valid while 168 is valid 
    */
    private static function validate($num)
    {
        if(is_int($num))
        {
            if($num > self::$maxNumber)
            {
                return false;
            }
            return true;
        }
        return false;
    }

    /*
    | convert ones ,tens & hundreds numbers to phrases
    |
    | example of use : toPhrase(22) // اثنان وعشرون
    |
    | notice that this function just facilitates the naming rules 
    | in arabic , since we just need to format a number and name its parts 
    | following certain order . it's not the main function that converts 
    | big integers
    | 
    */
    private static function toPhrase($num)
    {       
        # load data 
        $data = loader::load();
        
        # handle ones 
        if(self::hasDigits($num ,1)) { return $data['ones'][$num]; }
        
        # handle tens
        elseif(self::hasDigits($num ,2)) { return self::handleTens($data ,$num); }
        
        # handle hundreds 
        elseif(self::hasDigits($num ,3)) { return self::handleHunds($data ,$num); }
        
        #otherwise return null
        return null;
    }

    /*
    | handle tens 
    | and name them 
    | example of use : handleTens(15) // خمسة عشر 
    */
    private static function handleTens($data ,$num)
    {
        if(!array_key_exists($num ,$data['tens']))
        {
            $ones = self::getOnes($num);
            $tens = self::getTens($num);

            if(is_int($tens))
            {
                return $data['ones'][$ones] .self::$seperator. $data['tens'][$tens];
            }
            return $data['ones'][$ones].' '.$data['tens'][$tens];
        }
        return $data['tens'][$num].' ';
    }

    /*
    | handle Hundreds  
    | and name them 
    |
    | example of use : handleHunds(120) // مئة وعشرون
    */
    private static function handleHunds($data ,$num)
    {
        if(!array_key_exists($num ,$data['hundreds']))
        {
            $ones = self::getOnes($num);
            
            $tens = substr(self::getTens($num),-2);

            $hundreds = self::getHundreds($num); 

            if(intval($ones) > 0)
            {
                $ones = self::toPhrase($ones);

                if(intval($tens) > 0){
                    
                    $tens = substr(self::getTens($num) , -2 ,-1).'0';

                    $tens = self::toPhrase($tens);

                    $hundreds = self::toPhrase($hundreds);

                    return $hundreds .self::$seperator. $ones . self::$seperator . $tens;
                }
                else 
                {
                    return self::toPhrase($hundreds) .self::$seperator. $ones;
                }

            }
            else
            {
                if(intval($tens) > 0){

                    $hundreds = intval(substr($hundreds ,0,-2));

                    $hundreds = self::toPhrase($hundreds).' '.$data['hundreds'][100];

                    $tens = substr(self::getTens($num) , -2 ,-1).'0';

                    $tens = self::toPhrase($tens);

                    return $hundreds.self::$seperator.$tens;
                }
                else 
                {
                    return self::toPhrase(substr($hundreds , 0 ,-2)).' '.$data['hundreds'][100];
                }
            }
        }
        return $data['hundreds'][$num];
    }

    /*
    | check if a given number has 
    | certain number of numbers 
    |
    | example of use : if(hasDigits($myInt ,5)){ // my int has 5 digits! }
    */
    private static function hasDigits($int ,$target)
    {
        if(strlen($int) > $target){
            return false;
        }

        return true;
    }

    /*
    | return the ones of a given integer
    |
    | example : the ones of 101 is 1 
    | 
    */
    private static function getOnes($int)
    {
        return intval(substr($int , -1));
    }
    
    /*
    | return the tens of a given integer
    |
    | example : the tens of 311 is 10
    |
    | notice that numbers from 11 to 19 follows a different 
    | naming rule , giving a unique value will be much helpful
    | when it comes to naming numbers like 13 
    | 
    */
    private static function getTens($int)
    {
        $ones = self::getOnes($int);
        
        $tens = intval(substr($int , 0 ,-1).'0');

        if($tens == 10 && $ones > 2 && $tens < 20)
        {
            $tens = 'unique'; // عشر 
        }

        return $tens;
    }
    
    /*
    | return the hundred of a given integer
    |
    | example : the hundreds of 101 is 100 
    | 
    */
    private static function getHundreds($int)
    {
        $hundreds = intval(substr($int , 0,-2).'00');

        return $hundreds;
    }
   
}