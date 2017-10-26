

## Simple package to manage permanent or transient settings in database
--------

##Usage:

`$pdoInstance=new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);`
`$settingTableName='settings';` `$settings=\Scriptburn\Settings($pdoInstance,$settingTableName);`
    
`$settings->set('someSettingName','someSettingValue',$optionalExpiresInSeconds);`
`$settings->set(['someSettingName'=>'someSettingValue'],$optionalExpiresInSeconds);`

`$value=$settings->get('someSettingName','optionalDefaultValueIfNotFound');`
 `$value=$settings->get(['someSettingName','someAnotherSettingName']);`


  if you pass an array of settings name to `get` method and if that array has more then 1 index it will return only value otherwise it will return a key value pair 

