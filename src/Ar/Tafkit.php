<?php 

namespace Adnane\Arabic\Ar;
use Adnane\Arabic\Ar\data\tafkit\loader;

class Tafkit
{
    private static $seperator = ' و ';
    private static $maxNumber = 999999999999999;
    private static $identifier = 'الـ';

    private static $and = 'و';
    private static $one = 'واحد';

    use loader;

    /** 
     * rewrite numbers in indian numbers forms 
     * which is also common in arabic language
     * 
     * @param $int (in)
     * @return string
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

    /** 
     * get the ordinal form of a certain int 
     * 
     * @param $int (int)
     * @return string
    */
    public static function toOrdinal($int)
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
                return self::$identifier . self::toWords($int);
                break;
        }
        return $int;
    }

    /** 
     * this method summerize the whole proccess and return string depending on a valid int given 
     * transform numbers to spelled words 
     * 
     * @param $int (in)
     * @return string
    */
    public static function toWords($int)
    {
        # validate incoming charchter 
        if(! self::validate($int)){ return 'invalid'; };   
        
        # name the levels and prepare a descriptive array 
        $decription = self::nameLevels($int);
        # reverse array to read it in arabic 
        return self::process($decription);
    }

    /** 
     * this function takes the result of getLevels and return it to words depending on the level 
     * 
     * @param $int (in)
     * @return int
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

    /** 
     * gets the levels of the target integer 
     * as we need to reverse the result array to be easy when it comes to naming 
     * 
     * @param $int (int)
     * @return array 
    */
    private static function getLevels($int)
    {
        $number = number_format($int , 0 ,"." ,",");

        $levels = explode(',' ,$number);

        $levels = array_reverse($levels);

        return $levels;
    }

    /** 
     * this function basiclly use other methods in certain order with certain logic 
     * it takes the array of named levels , combine it and clean it 
     * 
     * 
     * @param $decription (array)
     * @return string 
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

    /** 
     * cleans the result string after being proccessed  
     * 
     * 
     * @param $str (string)
     * @return string 
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

    /** 
     * handle special and unique named chrachters in the result string 
     * 
     *  as known , the arabic language follows a completly different 
     * naming rules . for example " Two Hundred " in English must be " اثنان مئة "
     * in arabic right ? well , that's not actually , Two hundreds is completly different thing 
     * it is : مئتان, and so are alot of other numbers .. 
     * 
     * @param $str (string)
     * @return string 
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

    /** 
     * organize and re-shape final result
     * 
     * due to the dont proccess we may find a lot of spaces . thus , making it a bit cleaner
     * looks so much better !
     * @param $str (string)
     * @return string 
    */
    private static function organize($str)
    {
        $str = explode(' ',$str);

        $str = array_filter($str);

        return implode(' ',$str);
    }
    
    /** 
     * validate incoming input , check if a given string is allowed to be translated to words 
     * 
     * @param $num (int)
     * @return boolean 
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

    /** 
     * convert ones ,tens & hundreds numbers to phrases
     * 
     * @param $data (array) , $num (int)
     * @return int 
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

    /** 
     * handle tens   and name them 
     * 
     * @param $data (array) , $num (int)
     * @return int 
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

    /** 
     * handle Hundreds  and name them 
     * 
     * @param $data (array) , $num (int)
     * @return int 
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

    /** 
     * check if a given integer has certain number of numbers 
     * 
     * @param $int (int) , $target (int)
     * @return boolean 
    */
    private static function hasDigits($int ,$target)
    {
        if(strlen($int) > $target){
            return false;
        }

        return true;
    }

    /** 
     * return the ones of a given integer
     * 
     * @param $int (int)
     * @return int 
    */
    private static function getOnes($int)
    {
        return intval(substr($int , -1));
    }
    
    /** 
     * get the tens of a given integer 
     * 
     * example : the tens of 311 is 10
     * 
     * notice that numbers from 11 to 19 follows a different 
     * naming rule , giving a unique value will be much helpful
     * when it comes to naming numbers like 13 
     * 
     * @param $int 
     * @return string,int 
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
    
    /** 
     * return the hundred of a given integer
     * 
     * @param $int (int)
     * @return int 
    */
    private static function getHundreds($int)
    {
        $hundreds = intval(substr($int , 0,-2).'00');

        return $hundreds;
    }
    

    /* 
    | =============================== 
    | Reversed methods 
    | ===============================    
    */

    /** 
     * this method is listerally the reversed method 
     * of Tafkit::toWords(), as it follows the same 
     * logic 
     * 
     * @param $str (string)
     * @return int  
    */ 
    public static function fromWords($str)
    {
       $levelsWithExtra = self::divideIntoLevels($str);
       
       return self::readFromWrittenLevels($levelsWithExtra);
    }
    
    /**
     *  this method is kinda the equivalent of number_format($int) 
     * the only non-common point is that this method chills with 
     * strings instead of integers :)
     * 
     * @param $str (string)
     * @return int 
    */
    private static function divideIntoLevels($str)
    {
        $uniques = [
            "اثنان الاف" => "ألفان",
            "اثنان ملايين" => "مليونان",
            "اثنان ملايير" => "ملياران",
            "اثنان ترليونات" => "ترليونان",
        ];

        foreach(array_keys($uniques) as $unique)
        {
            $str = str_replace($uniques[$unique] ,$unique ,$str);
        }

        $returned = [];
        $levels = array_reverse([
            'الاف' => 3,
            'ألف' => 3,  
            'الف'=>3,
            'ملايين' => 6,
            'مليون' => 6, 
            'ملايير' => 9,
            'مليار' => 9,  
            'ترليونات' =>12 ,
            'ترليون' =>12  
        ]);
        // foreach level do the following 
        // get the amount in the level example : 300 [amount :3 ,level :2]
        foreach(array_keys($levels) as $level)
        {
            if(strpos($str ,$level) !== false)
            {
                // get amount 
                $lastPos = strpos($str ,$level);                
                $amount = substr($str , 0 ,$lastPos);

                if(strlen($amount) == 0) $amount = 1;

                // push results in array 
                $returned[ $levels [ $level ] ] = $amount;

                // cut string and complete loop 
                $str = substr($str ,$lastPos + strlen($level));
            }
        }

        
        return [ $returned , $str ];
    }
    
    /**
     * this method handle reading strings divided into 
     * many levels , a level can be hundreds , thousands and so on 
     * 
     * @param $levelsWithExtra (array) 
     *  @return int 
     */
    private static function readFromWrittenLevels($levelsWithExtra)
    {
        $levels = $levelsWithExtra[0];
        $extra  = $levelsWithExtra[1];

        $num = 0;
        foreach (array_keys($levels) as $level) {
            
            if($levels[$level] == 1)
            {
                $piece  = 1;
            }
            else
            {
                $piece  = self::readThreeDigits($levels[$level]);
            }
            $piece .= ''.str_repeat('0', $level);
            
            $num .= intval($num + $piece);
        }
        return intval($num + self::readThreeDigits($extra));
    }

    /** 
     * three digits numbers are the principal 
     * unit in naming levels and reading numbers formats 
     * in arabic 
     * notice that this follows follows the same logic 
     * of the reversed method using in Tafkit::fromNumbers(int)
     *  
     * @param $str (string)
     * @return int 
     */
    private static function readThreeDigits($str)
    {
        # files located at : data/tafkit/json/
        $uniques = loader::load()['trimed_uniques'];
        
        # change مئتان to اثنان مئة to be more logical when it comes to processing it 
        foreach(array_keys($uniques) as $unique)
        {           
            $str = str_replace($uniques[$unique] ,$unique ,$str);
        }
        # read hundreds and conclue the tens 
        $amount = self::readHundreds($str)[0];
        $str = self::readHundreds($str)[1];

        # read tens with hundreds 
        return self::readTens($str) + $amount;
    }  

    /** 
     * Tens in arabic concepts are the considered units
     * in naming numbers 
     * so naming certain levels with tens makes it easier 
     * to get the target number 
     * @param $str (string)
     * @return int
    */
    private static function readTens($str)
    {
        // files located at : data/tafkit/json/
        $zero_to_20 = loader::load()['zero_to_20']; 
        $tens = loader::load()['trimed_tens']; 
        $ones = loader::load()['spaced_ones'];
        
        // trim string 
        $str = self::trimFromAnds($str);
        
        // handle zero to 20 
        if(array_key_exists(trim($str ,' '),$zero_to_20))
        {
            return $zero_to_20 [ trim($str ,' ') ];
        }

        // otherwise ,loop and name 20 to 99 
        foreach (array_keys($tens) as $ten) {
            foreach (array_keys($ones) as $one) {       
                if(strpos($str ,$ones[$one] . $tens[$ten]) !== false)
                {    
                    return intval($ten)+intval($one);
                }
            }
        }
        return 0;
    }
    
    /** 
     * notice that all numbers in arabic 
     * follows the naming manner : 
     * number followed by n digits (max (n) == 3) is a unit to name a level 
     * ex : 300,000 , is ثلاث مئة 
     * so naming levels requires naming handreds + name of level (ثلاث مئة ألف)
     * @param $str 
     * @return array (hundreds + left tens)
    */
    private static function readHundreds($str)
    {
        $hunds = [ 'مئة', 'مائة' ];
        $amount = 0; // an amount is like 3 in 300 (3 * 100)
        foreach($hunds as $h)
        {
            $pos = strpos($str ,$h);
            if($pos !== false)
            {
                $amount = substr($str ,0,$pos);
                $subStr = str_replace(['و' ,' '],'', $amount);
                if(strlen($subStr) == 0)
                {
                    $amount = 1;   
                }
                else
                {
                    $amount = self::readTens($amount);
                }
                $amount = intval($amount . '00');

                if(strlen($amount) == 0) $amount = 1;
                
                $str = substr($str ,$pos + strlen($h));
            }
        }
        return [ $amount , $str ];
    }

    /** 
     * due to the previous proccess 
     * a one string can be given with alot of seperators 
     * and connectors ,thus it needs to be trimmed and 
     * cleaned from spaces & seperators 
     * @param $str (string)
     * @return string
    */
    private static function trimFromAnds($str)
    {
        $subStr = self::$and.' '.self::$one;
        // if string starts with و واحد dont right trim it 
        if(strpos($str, $subStr) !== false)
        {
            $str = str_replace($subStr ,self::$one ,$str);
            
            return $str;
        }
        // otherwise it needs to be trimmed 
        $str = trim($str ,' ');
        $str = rtrim($str ,self::$and.' ');
        $str = ltrim($str ,self::$and.' ');
        $str = ltrim($str ,' '.self::$and.' ');
        $str = rtrim($str ,' '.self::$and.' ');
        $str = rtrim($str ,' '.self::$and);
        $str = ltrim($str ,' '.self::$and);
        return $str;
    }

}