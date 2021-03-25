# ```Laravel Speaks Arabic```

**"Laravel Speaks Arabic" is a light weight ,open-source laravel package . It facilitates dealing with arabic concepts in Laravel Framework using a set of classes and methods to make laravel speaks arabic! concepts like , Hijri Dates & Arabic strings and so on ..**

**code example**

```php 
use Adnane\Arabic\Arabic;

echo Arabic::tafkit(12078437); // اثنا عشر مليون و ثمان و سبعون ألف و أربع مئة و سبع و ثلاثون

```
# ```installation```

1.install via composer 
```
composer require adnane/laravel-speaks-arabic
```
2.in your ```config\app.php``` add the service provider in providers array 

```php 
'providers' => [ 
    Adnane\Arabic\ArabicServiceProvider::class,
]
```

> as you can define an alias in ```config\app.php``` in the aliases array 
```php 
'Arabic' => Adnane\Arabic\Arabic::class,
```

# ```use in blade files```
> change ```method``` to needed method like ```Arabic::tafkit(643646)``` or ```arabic()->tafkit(643646)```

```php 
{{ Arabic::method($input) }}
// make sure you define an alias first
```
or
```php 
{{ arabic()->method($input) }}
```
 
# ```How to use``` 
>Methods Can Be Called in Severeal Ways . statically, non-statically or using a helper or an imported class.

**1.using a helper**
```php 
arabic()->method($params)
// or
arabic()::method($params)
```
**2.using an imported class**
```php 
use Adnane\Arabic\Arabic;
// or by using an alias 
use Arabic;


Arabic::method($params)
```


# ```Methods```
**1.Working with numbers & integers**
```php 
/* 
| convert numeric numbers to spelled strings 
| @params : $integer (int) required | max : 999999999999999
|
| example of output :خمس عشر مليون و مئتان و أحدا عشر ألف و ثمان مئة و اثنان و تسعون
*/
Arabic::tafkit($integer)

/* 
| convert numeric numbers to ordered declares
| @params : $integer (int) required | max : 999999999999999
|
| example of output : الثالث و العشرون
*/
Arabic::tartib($integer)

/* 
| rewrite numbers in a containing string to be like ۱٧۳۱۸
| @params : $str (string) required
| 
| example of output : ولد عليه الصلاة والسلام في ۱۲ ربيع الاول من عام ٦۲۲ ميلادية
*/
Arabic::arkam($longText) 

```

**2.Working with dates & times**

```php 
/* 
| convert a given date to hijri takwim date 
| format : f , s , n 
| @params : $format (string) , $date (Y/m/d) 
|
| example of output : الحادي عشر من شعبان من السنة الهجرية ألف و أربع مئة و اثنان و أربعون
*/
Arabic::toHijri($format = 'f' ,$date = null)

// reverse 

Arabic::fromHijri($date /*Y/m/d*/);
/* 
| Get the relative time between two given dates 
| @params : $date (Y/m/d) required , $date2 (Y/m/d) , $detailed (boolean) 
| 
| example of output : منذ ثلاث أشهر 
| example of output2 : مئة و أحدا عشر سنة 
*/
Arabic::fariq($date ,$date2 = null ,$detailed = false)

```
**3.Working with Strings & longTexts**

```php 
/* 
| get rid of The vowel diacritics in Arabic  
| @params : $str (string) required [ string to clean ]
| example :
| [input] : أَحَبُّ النَّاسِ إِلَى اللَّهِ أَنْفَعَهُمْ لِلنَّاسِ، وَأَحَبُّ الْأَعْمَالِ إِلَى اللَّهِ سُرُورٍ تُدْخِلُهُ عَلَى مُسْلِمٍ،
| output : أحب الناس إلى الله أنفعهم للناس، وأحب الأعمال إلى الله سرور تدخله على مسلم 
*/
Arabic::removeHarakat($longText)

/* 
| rewrite strings and texts to match the keyboard reveresed in english 
| this method can be really helpful when it comes to making search procces better 
| @params : $str (string) required [ string to reverse ]
| 
| example :
| [input] : sg,h hggi uglh khtuh ,,ju,`,h fhggi lk ugl gh dktu
| [output] : سلوا الله علما نافعا ووتعوذوا بالله من علم لا ينفع
*/
Arabic::toKeyboardInput($longText)

/* 
| rewrite strings and texts to be written and spelled in english letters 
| this mehotd can be really helpful when it comes to making seo friendly url's or arabic slugs 
| @params : $str (string) required [ string to write in spelled form ]
| 
| [input] : إِذَا مَاتَ الإنْسَانُ انْقَطَعَ عنْه عَمَلُهُ إِلَّا مِن ثَلَاثَةٍ: إِلَّا مِن صَدَقَةٍ جَارِيَةٍ، أَوْ عِلْمٍ يُنْتَفَعُ بِهِ، أَوْ وَلَدٍ صَالِحٍ يَدْعُو له
| [output] : izaa maat ālinsaan ānqta anh amlh ilaa mn thlaatht: ilaa mn sdqt jaariit، āoo alm yntfa bh، āoo wld saalh ydaoo lh
*/
Arabic::toSpelled($longText)

```

# ```Important Notes```
**This package is still under development ,as it was recently created, please feel free to contribute or help us making laravel speaks arabic better by opening a discuss , fixing a bug or helping in improving some methods!**

**it's highly recommended you follow the written code manner**
1. Create new PHP class in [/src/Ar/](/ar/)
2. You may need to add some data in [/Ar/data/YourFolder/](/Ar/data/YourFolder/) 
2. define your method & related instance in ```$methods property``` in [/src/Arabic.php](/src/Arabic.php) !

That's it!
