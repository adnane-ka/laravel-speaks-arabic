# ```Laravel Speaks Arabic```

[![Latest Version on Packagist](https://img.shields.io/packagist/v/adnane/laravel-speaks-arabic.svg?style=flat-square)](https://packagist.org/packages/adnane/laravel-speaks-arabic)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/adnane/laravel-speaks-arabic.svg?style=flat-square)](https://packagist.org/packages/adnane/laravel-speaks-arabic)

**A light weight laravel package , That facilitates dealing with arabic concepts in Laravel Framework using a set of classes and methods to make laravel speaks arabic! concepts like , Hijri Dates & Arabic strings and so on ..**

**wanna see a code snippet?**

```php 
@toWords(12078437); 
// اثنا عشر مليون و ثمان و سبعون ألف و أربع مئة و سبع و ثلاثون
```
# ```installation```

1.install via composer 
```
composer require adnane/laravel-speaks-arabic
```

2.Add the Service provider in the Providers Array in ```config\app.php``` as bellow : 

```php 
'providers' => [ 
    Adnane\Arabic\ArabicServiceProvider::class,
]
```
 
# ```How to use``` 
- Make sure you correctly install & setup the package , import the class ```Adnane\Arabic\Arabic``` and call the available methods with  therequired paramateres 

> change ```method``` to needed method like ```Arabic::toWords(643646)``` or ```arabic()->toWords(643646)```

```php 
use Adnane\Arabic\Arabic;
Arabic::method($params)

// or directly by using a helper
arabic()::method($params)
```


# ```Methods```

**1.Working with numbers & integers**
```php 
/**
 * get the arabic words representation of a given int , called also تفقيط 
 * @return string 
*/
Arabic::toWords(int $integer)

/**
 * get the numeric representation of a given string , reverse of previous method 
 * @return int 
*/
Arabic::fromWords(string $str) 

/**
 * get the ordinal form of a given int
 * @return string 
*/
Arabic::toOrdinal(int $int) 

/**
 * rewrite numbers in a containing string to be like ۱٧۳۱۸
 * @return string 
*/
Arabic::toIndianNums(string $str) 
```

**2.Working with dates & times**

```php 
/**
 * convert a given date to hijri takwim date in a given format (format : f , s , n )
 * @return string 
*/
Arabic::toHijri(string $format = 'f' ,string $date)

/**
 * convert a given hijri hijri to gregorian normal date 
 * @return string 
*/
Arabic::fromHijri(string $date /*Y/m/d*/);

/**
 * Get the relative time between two given dates 
 * @return string 
*/
Arabic::toRelative(string $date ,string $date2 = null ,boolean $detailed = false);

/**
 * Get the date from a given relative time 
 * @return string 
*/
Arabic::fromRelative(string $relative);

```
**3.Working with Strings & longTexts**

```php 
/**
 * get rid of The vowel diacritics in Arabic  
 * @return string 
*/
Arabic::removeHarakat(string $str)

/**
 * rewrite strings and texts to match the keyboard reveresed in english 
 * this method can be really helpful when it comes to making search procces better 
 * @return string 
*/
Arabic::toKeyboardInput(string $str)

/**
 * rewrite strings and texts to be written and spelled in english letters 
 * this mehotd can be really helpful when it comes to making seo friendly url's or arabic slugs 
 * @return string 
*/
Arabic::toSpelled(string $str)

/**
 * equivilant of str_word_count in non utf8 strings & longTexts such as arabic  
 * @return int 
*/
Arabic::countWords(string $str);

/**
 * check if a given string contains arabic charachters 
 * @return boolean 
*/
Arabic::containsAr(string $str);
```

# ```Examples Of Different Uses```
```php
Arabic::toWords(56)
//  ست وخمسون

Arabic::fromWords("ثمان مئة و خمسة")
//  805

Arabic::toOrdinal(12)
//  الثاني عشر

Arabic::toIndianNums("ولد عليه الصلاة في 12 ربيع الأول")
//  ولد عليه الصلاة في ۱۲ ربيع الاول

Arabic::toHijri('f' ,'2021/12/12')
//  الثامن من جمادى الأولى من السنة الهجرية ألف و أربع مئة و ثلاث و أربعون

Arabic::fromHijri('1442/01/08')
// 8/27/2020

Arabic::toRelative('2010/01/10')
//  منذ أحد عشر سنة

Arabic::toRelative('2010/01/10' ,'2008/01/10')
//  ثلاث سنين 

Arabic::toRelative('2010/01/10' ,'2008/01/10' ,true)
// [ "y" => 3 , "m" => 39 ,"w" => 156 , "d" => 1096 ,"h" => 26304 ,"mn" => 1578240 ,"s" => 94694400 ] 

Arabic::fromRelative('زد سنة')
// 2022/03/28

Arabic::fromRelative('قل ست اشهر')
//  2020/09/28

Arabic::removeHarakat('لا حسَدَ إلَّا في اثنتيْنِ: رجلٌ آتاهُ اللهُ مالًا، فسلَّطَهُ على هلَكتِه في الحقِّ، ورجلٌ آتاهُ اللهُ الحِكمةَ، فهوَ يقضِي بِها، ويُعلِّمُها')
//  لا حسد إلا في اثنتين: رجل آتاه الله مالا، فسلطه على هلكته في الحق، ورجل آتاه الله الحكمة، فهو يقضي بها، ويعلمها

Arabic::toKeyboardInput('dl;k hsjulhg ihji hg]hgm td jpsdk ulgdhj hgfpe fl,ru!')
// يمكن استعمال هاته الدالة في تحسين عمليات البحث بموقع!

Arabic::toSpelled("قد تساعد هاته الدالة في عمل slugs أو تحسين عمليات البحث")
// qd tsaaad haath āldaalt fii aml slugs āoo thsiin amliiāt ālbhth

Arabic::countWords("هاته الدالة هي المكافئة لاخرى بالبي اتش بي غير ان هاته لا تتجاهل ترميز اليو تي اف ايت")
// 18

Arabic::containsAr("this method checks if a given string contains arabic words or charachters , for example : if we mentioned لارفيل يتحدث عربي it will return true!") 
// true
```
# ```use in blade files```
> change ```method``` to needed method like ```Arabic::toWords(643646)``` or ```arabic()->toWords(643646)```

```php 
{{ Arabic::method($input) }}
```
or
```php 
{{ arabic()->method($input) }}
```
as you can use the following blade directives for clean coding :
```php 
@toWords(4367)
@toOrdinal(564)
@toIndianNums(ولد عليه الصلاة في 12 ربيع الأول) 
@toHijri(2020/12/12)
@toRelative(2019/12/01)
@removeHarakat(فهوَ يقضِي بِها، ويُعلِّمُها)
```

# ```Important Notes```
**Please feel free to contribute or help us making laravel speaks arabic better by opening a discuss ,Adding some extra methods , fixing a bug or helping in improving some methods!**

# ```How to Contribute```

**it's highly recommended you follow the written code manner**
1. Create new PHP class in [/src/Ar/](/ar/)
2. You may need to add some data in [/Ar/data/YourFolder/](/Ar/data/YourFolder/) 
2. define your method & related instance in ```$methods property``` in [/src/Arabic.php](/src/Arabic.php) !

That's it!
