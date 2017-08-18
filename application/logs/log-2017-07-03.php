<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2017-07-03 21:40:49 --> Severity: Notice --> Trying to get property of non-object /Applications/MAMP/htdocs/smartWater/application/models/scada/View_scada.php 29
ERROR - 2017-07-03 21:41:33 --> Severity: Notice --> Trying to get property of non-object /Applications/MAMP/htdocs/smartWater/application/models/scada/View_scada.php 29
ERROR - 2017-07-03 21:42:53 --> Severity: Notice --> Undefined property: Dashboard::$table /Applications/MAMP/htdocs/smartWater/system/core/Model.php 77
ERROR - 2017-07-03 21:42:53 --> Severity: Notice --> Trying to get property of non-object /Applications/MAMP/htdocs/smartWater/application/models/photon/Tools_devices.php 284
ERROR - 2017-07-03 21:42:53 --> Query error: Table 'scada.ga_' doesn't exist - Invalid query: INSERT INTO `ga_` (`data`, `name`, `create_date`, `modify_date`, `id_device`, `id_user`) VALUES ('{ \"class\": \"go.GraphLinksModel\",\n  \"name\": \"#scada_name\",\n  \"nodeDataArray\": [],\n  \"linkDataArray\": []}', '', '2017-07-03 09:Jul:53', '2017-07-03 09:Jul:53', '3', '1')
ERROR - 2017-07-03 21:42:53 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-07-03 21:42:53 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/smartWater/application/models/scada/View_scada.php:2) /Applications/MAMP/htdocs/smartWater/system/core/Common.php 578
ERROR - 2017-07-03 21:44:19 --> Severity: Notice --> Undefined property: Dashboard::$table /Applications/MAMP/htdocs/smartWater/system/core/Model.php 77
ERROR - 2017-07-03 21:44:19 --> Severity: Notice --> Trying to get property of non-object /Applications/MAMP/htdocs/smartWater/application/models/photon/Tools_devices.php 284
ERROR - 2017-07-03 21:44:55 --> Severity: Warning --> Illegal string offset 'id' /Applications/MAMP/htdocs/smartWater/application/models/photon/Tools_devices.php 294
ERROR - 2017-07-03 21:47:55 --> Severity: Warning --> Illegal string offset 'id' /Applications/MAMP/htdocs/smartWater/application/models/photon/Tools_devices.php 294
ERROR - 2017-07-03 22:13:22 --> Severity: Notice --> Undefined property: Dashboard::$table /Applications/MAMP/htdocs/smartWater/system/core/Model.php 77
ERROR - 2017-07-03 22:13:22 --> Severity: Notice --> Trying to get property of non-object /Applications/MAMP/htdocs/smartWater/application/models/photon/Tools_devices.php 273
ERROR - 2017-07-03 22:13:22 --> Query error: Table 'scada.ga_' doesn't exist - Invalid query: UPDATE `ga_` SET `data` = '{ \"class\": \"go.GraphLinksModel\",\n  \"name\": \"#scada_name\",\n  \"nodeDataArray\": [],\n  \"linkDataArray\": []}', `name` = 'Prueba FIBO', `modify_date` = '2017-07-03 10:Jul:22', `id_user` = '1'
WHERE `id_scada` = '4'
ERROR - 2017-07-03 22:13:22 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-07-03 22:13:22 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/smartWater/application/models/scada/View_scada.php:2) /Applications/MAMP/htdocs/smartWater/system/core/Common.php 578
ERROR - 2017-07-03 23:05:49 --> Severity: error --> Exception: Call to undefined function tr_split() /Applications/MAMP/htdocs/smartWater/application/views/scada/show_scada.php 9
