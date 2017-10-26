

## Simple package to manage permanent or transient settings in database
--------

##Installing and Usage in laraval:

`composer require scriptburn/db-settings ">=1.0.4"`

`php artisan migrate`

Add  `Scriptburn\Setting\SettingServiceProvider::class` in you `app/config.php` `provider` array
Add  `Setting' => Scriptburn\Setting\Facades\Setting::class` in you `app/config.php` `aliases` array

`use Scriptburn\Setting\Facades\Setting;` to refrence the package 

 `Settingget(name, <default_value = null>);`
 `Setting::set(<name>, <value = null>, <expires_in_seconds = null>);`
 `Setting::delete(<name>);`


##Installing and Usage in other scripts:

`composer require scriptburn/db-settings ">=1.0.4"`

`require_once "vendor/autoload.php";`


`$pdoInstance=new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);`

`$settingTableName='settings';` 
`$settings=\Scriptburn\Setting\Setting($pdoInstance,$settingTableName);`

`$settings->set('someSettingName','someSettingValue',$optionalExpiresInSeconds);`
`$settings->set(['someSettingName'=>'someSettingValue'],$optionalExpiresInSeconds);`

`$value=$settings->get('someSettingName','optionalDefaultValueIfNotFound');`
`$value=$settings->get(['someSettingName','someAnotherSettingName']);`



   



