<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2017-08-17 21:43:39 --> Severity: Notice --> Undefined variable: date2 /Applications/MAMP/htdocs/smartWater/application/models/photon/Tools_devices.php 181
ERROR - 2017-08-17 21:43:39 --> Severity: Notice --> Undefined variable: date2 /Applications/MAMP/htdocs/smartWater/application/models/photon/Tools_devices.php 187
ERROR - 2017-08-17 21:43:39 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '[tdevice] GD
                            inner join [tpackage] GP on GP.id = GD.' at line 8 - Invalid query: select
                          GD.name,
                          GD.id_device ,
                          GD.particle_id as 'particle_id',
                          GP.active ,
                          GP.name  as 'package',
                          GPP.name as 'project'
                          from [tdevice] GD
                            inner join [tpackage] GP on GP.id = GD.id_package
                            inner join [tproject] GPP on GPP.id = GP.id_project
ERROR - 2017-08-17 21:43:39 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 21:43:39 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/smartWater/system/core/Exceptions.php:271) /Applications/MAMP/htdocs/smartWater/system/core/Common.php 578
ERROR - 2017-08-17 21:44:04 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '[tdevice] GD
                            inner join [tpackage] GP on GP.id = GD.' at line 8 - Invalid query: select
                          GD.name,
                          GD.id_device ,
                          GD.particle_id as 'particle_id',
                          GP.active ,
                          GP.name  as 'package',
                          GPP.name as 'project'
                          from [tdevice] GD
                            inner join [tpackage] GP on GP.id = GD.id_package
                            inner join [tproject] GPP on GPP.id = GP.id_project
ERROR - 2017-08-17 21:44:04 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 21:45:16 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '[tdevice] GD
                            inner join [tpackage] GP on GP.id = GD.' at line 8 - Invalid query: select
                          GD.name,
                          GD.id_device ,
                          GD.particle_id as 'particle_id',
                          GP.active ,
                          GP.name  as 'package',
                          GPP.name as 'project'
                          from [tdevice] GD
                            inner join [tpackage] GP on GP.id = GD.id_package
                            inner join [tproject] GPP on GPP.id = GP.id_project
ERROR - 2017-08-17 21:45:16 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 21:45:16 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/smartWater/application/controllers/Dashboard.php:1079) /Applications/MAMP/htdocs/smartWater/system/core/Common.php 578
ERROR - 2017-08-17 21:45:23 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '[tdevice] GD
                            inner join [tpackage] GP on GP.id = GD.' at line 8 - Invalid query: select
                          GD.name,
                          GD.id_device ,
                          GD.particle_id as 'particle_id',
                          GP.active ,
                          GP.name  as 'package',
                          GPP.name as 'project'
                          from [tdevice] GD
                            inner join [tpackage] GP on GP.id = GD.id_package
                            inner join [tproject] GPP on GPP.id = GP.id_project
ERROR - 2017-08-17 21:45:23 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 21:45:23 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/smartWater/application/controllers/Dashboard.php:1079) /Applications/MAMP/htdocs/smartWater/system/core/Common.php 578
ERROR - 2017-08-17 21:47:34 --> Query error: Unknown column 'SD.data' in 'field list' - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_device SD
                                inner join ga_package GD on GD.particle_id= SD.device_id
                                    where 
                                        GD.id_device = 3
                                    and 
                                    SD.date between '2017-07-18 00:00:00' and '2017-07-18 23:59:59'
                                    limit 0 , 20;
                            
ERROR - 2017-08-17 21:47:34 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 21:47:34 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/smartWater/application/controllers/Dashboard.php:1079) /Applications/MAMP/htdocs/smartWater/system/core/Common.php 578
ERROR - 2017-08-17 21:48:16 --> Query error: Unknown column 'SD.data' in 'field list' - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_device SD
                                inner join ga_package GD on GD.particle_id= SD.device_id
                                    where 
                                        GD.id_device = 3
                                    and 
                                    SD.date between '2017-07-18 00:00:00' and '2017-07-18 23:59:59'
                                    limit 0 , 20
                            
ERROR - 2017-08-17 21:48:16 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 21:48:16 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/smartWater/application/controllers/Dashboard.php:1079) /Applications/MAMP/htdocs/smartWater/system/core/Common.php 578
ERROR - 2017-08-17 21:56:22 --> Query error: Unknown column 'SD.data' in 'field list' - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_device SD
                                inner join ga_package GD on GD.particle_id= SD.device_id
                                    where 
                                        GD.id_device = 3
                                    and 
                                    SD.date between '2017-07-18 00:00:00' and '2017-07-18 23:59:59'
                                    limit 0 , 20
                            
ERROR - 2017-08-17 21:56:22 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 21:56:22 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/smartWater/application/controllers/Dashboard.php:1079) /Applications/MAMP/htdocs/smartWater/system/core/Common.php 578
ERROR - 2017-08-17 21:58:33 --> Query error: Unknown column 'SD.data' in 'field list' - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_device SD
                                inner join ga_package GD on GD.particle_id= SD.device_id
                                    where 
                                        GD.id_device = 3
                                    and 
                                    SD.date between '2017-07-18 00:00:00' and '2017-07-18 23:59:59'
                                    limit 0 , 20
                            
ERROR - 2017-08-17 21:58:33 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 21:58:33 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/smartWater/application/controllers/Dashboard.php:1079) /Applications/MAMP/htdocs/smartWater/system/core/Common.php 578
ERROR - 2017-08-17 22:04:51 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''0' , '20'' at line 7 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD
                                inner join ga_device GD on GD.particle_id= SD.device_id
                                    where 
                                        GD.id_device = '3'
                                    and 
                                    SD.date between '17-08-2017 00:00:00' and '17-08-2017 23:59:59'
                                    limit '0' , '20'
                            
ERROR - 2017-08-17 22:04:51 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 22:06:57 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''0' , '20'' at line 7 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD
                                inner join ga_device GD on GD.particle_id= SD.device_id
                                    where 
                                        GD.id_device = '3'
                                    and 
                                    SD.date between '2017-08-17 00:00:00' and '2017-08-17 23:59:59'
                                    limit '0' , '20'
                            
ERROR - 2017-08-17 22:06:57 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 22:07:07 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''0' , '20'' at line 7 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD
                                inner join ga_device GD on GD.particle_id= SD.device_id
                                    where 
                                        GD.id_device = '3'
                                    and 
                                    SD.date between '2017-8-16 00:00:00' and '2017-8-16 23:59:59'
                                    limit '0' , '20'
                            
ERROR - 2017-08-17 22:07:07 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 22:07:14 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''0' , '20'' at line 7 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD
                                inner join ga_device GD on GD.particle_id= SD.device_id
                                    where 
                                        GD.id_device = '3'
                                    and 
                                    SD.date between '2017-7-32 00:00:00' and '2017-7-32 23:59:59'
                                    limit '0' , '20'
                            
ERROR - 2017-08-17 22:07:14 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 22:08:21 --> Severity: Warning --> json_decode() expects parameter 1 to be string, array given /Applications/MAMP/htdocs/smartWater/application/models/services/Logs.php 33
ERROR - 2017-08-17 22:11:43 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''0' , '20'' at line 7 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD
                                inner join ga_device GD on GD.particle_id= SD.device_id
                                    where 
                                        GD.id_device = '3'
                                    and 
                                    SD.date between '2017-08-17 00:00:00' and '2017-08-17 23:59:59'
                                    limit '0' , '20'
                            
ERROR - 2017-08-17 22:11:43 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 22:14:08 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''0' , '20'' at line 7 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD
                                inner join ga_device GD on GD.particle_id= SD.device_id
                                    where 
                                        GD.id_device = '2'
                                    and 
                                    SD.date between '2017-08-17 00:00:00' and '2017-08-17 23:59:59'
                                    limit '0' , '20'
                            
ERROR - 2017-08-17 22:14:08 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 22:14:18 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''0' , '20'' at line 7 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD
                                inner join ga_device GD on GD.particle_id= SD.device_id
                                    where 
                                        GD.id_device = '3'
                                    and 
                                    SD.date between '2017-08-17 00:00:00' and '2017-08-17 23:59:59'
                                    limit '0' , '20'
                            
ERROR - 2017-08-17 22:14:18 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 22:20:24 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''0' , '20'' at line 7 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD
                                inner join ga_device GD on GD.particle_id= SD.device_id
                                    where 
                                        GD.id_device = '3'
                                    and 
                                    SD.date between '2017-08-17 00:00:00' and '2017-08-17 23:59:59'
                                    limit '0' , '20'
                            
ERROR - 2017-08-17 22:20:24 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 22:21:30 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''0' , '20'' at line 7 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD
                                inner join ga_device GD on GD.particle_id= SD.device_id
                                    where 
                                        GD.id_device = '3'
                                    and 
                                    SD.date between '2017-8-16 00:00:00' and '2017-8-16 23:59:59'
                                    limit '0' , '20'
                            
ERROR - 2017-08-17 22:21:30 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 22:21:37 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''0' , '20'' at line 7 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD
                                inner join ga_device GD on GD.particle_id= SD.device_id
                                    where 
                                        GD.id_device = '2'
                                    and 
                                    SD.date between '2017-8-16 00:00:00' and '2017-8-16 23:59:59'
                                    limit '0' , '20'
                            
ERROR - 2017-08-17 22:21:37 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 22:21:41 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''0' , '20'' at line 7 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD
                                inner join ga_device GD on GD.particle_id= SD.device_id
                                    where 
                                        GD.id_device = '2'
                                    and 
                                    SD.date between '2017-8-14 00:00:00' and '2017-8-14 23:59:59'
                                    limit '0' , '20'
                            
ERROR - 2017-08-17 22:21:41 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 22:23:33 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''0' , '20'' at line 7 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD
                                inner join ga_device GD on GD.particle_id= SD.device_id
                                    where 
                                        GD.id_device = '3'
                                    and 
                                    SD.date between '2017-8-14 00:00:00' and '2017-8-14 23:59:59'
                                    limit '0' , '20'
                            
ERROR - 2017-08-17 22:23:33 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 22:23:38 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''0' , '20'' at line 7 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD
                                inner join ga_device GD on GD.particle_id= SD.device_id
                                    where 
                                        GD.id_device = '4'
                                    and 
                                    SD.date between '2017-8-14 00:00:00' and '2017-8-14 23:59:59'
                                    limit '0' , '20'
                            
ERROR - 2017-08-17 22:23:38 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 22:25:53 --> Severity: Warning --> json_decode() expects parameter 1 to be string, array given /Applications/MAMP/htdocs/smartWater/application/models/services/Logs.php 32
ERROR - 2017-08-17 22:26:48 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''0' , '20'' at line 7 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD
                                inner join ga_device GD on GD.particle_id= SD.device_id
                                    where 
                                        GD.id_device = '3'
                                    and 
                                    SD.date between '2017-8-14 00:00:00' and '2017-8-14 23:59:59'
                                    limit '0' , '20'
                            
ERROR - 2017-08-17 22:26:48 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 22:28:46 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''0' , '20'' at line 7 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD
                                inner join ga_device GD on GD.particle_id= SD.device_id
                                    where 
                                        GD.id_device = '2'
                                    and 
                                    SD.date between '2017-8-14 00:00:00' and '2017-8-14 23:59:59'
                                    limit '0' , '20'
                            
ERROR - 2017-08-17 22:28:46 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 22:29:07 --> Severity: error --> Exception: syntax error, unexpected ';', expecting ',' or ')' /Applications/MAMP/htdocs/smartWater/application/models/photon/Tools_devices.php 189
ERROR - 2017-08-17 22:29:08 --> Severity: error --> Exception: syntax error, unexpected ';', expecting ',' or ')' /Applications/MAMP/htdocs/smartWater/application/models/photon/Tools_devices.php 189
ERROR - 2017-08-17 22:29:49 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''0' , '20'' at line 7 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD
                                inner join ga_device GD on GD.particle_id= SD.device_id
                                    where 
                                        GD.id_device = '3'
                                    and 
                                    SD.date between '2017-8-14 00:00:00' and '2017-8-14 23:59:59'
                                    limit '0' , '20'
                            
ERROR - 2017-08-17 22:29:49 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 22:38:10 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''0' , '20'' at line 7 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD
                                inner join ga_device GD on GD.particle_id= SD.device_id
                                    where 
                                        GD.id_device = 0
                                    and 
                                    SD.date between '2017-08-17 00:00:00' and '2017-08-17 23:59:59'
                                    limit '0' , '20'
                            
ERROR - 2017-08-17 22:38:10 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 22:38:15 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''0' , '20'' at line 7 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD
                                inner join ga_device GD on GD.particle_id= SD.device_id
                                    where 
                                        GD.id_device = 0
                                    and 
                                    SD.date between '2017-08-17 00:00:00' and '2017-08-17 23:59:59'
                                    limit '0' , '20'
                            
ERROR - 2017-08-17 22:38:15 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 22:39:04 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''0' , '20'' at line 7 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD
                                inner join ga_device GD on GD.particle_id= SD.device_id
                                    where 
                                        GD.id_device = 0
                                    and 
                                    SD.date between '2017-8-14 00:00:00' and '2017-8-14 23:59:59'
                                    limit '0' , '20'
                            
ERROR - 2017-08-17 22:39:04 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 22:40:06 --> Severity: Notice --> Array to string conversion /Applications/MAMP/htdocs/smartWater/system/core/Output.php 537
ERROR - 2017-08-17 22:42:09 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '?
                                    and 
                                    S' at line 4 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD
                                inner join ga_device GD on GD.particle_id= SD.device_id
                                    where 
                                        GD.id_device = ?
                                    and 
                                    SD.date between ? and ?
                                    limit ? , ?
                            
ERROR - 2017-08-17 22:42:09 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 22:47:30 --> Query error: Unknown column 'SD.data' in 'field list' - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_device inner join ga_package GD on GD.particle_id= SD.device_id where GD.id_device = 3 and  SD.date between '2017-07-18 00:00:00' and '2017-07-18 23:59:59' limit 0 , 20
ERROR - 2017-08-17 22:47:30 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 22:48:39 --> Query error: Unknown column 'SD.data' in 'field list' - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_device inner join ga_package GD on GD.particle_id= SD.device_id where GD.id_device = 3  limit 0 , 20
ERROR - 2017-08-17 22:48:39 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 22:49:10 --> Query error: Unknown column 'SD.data' in 'field list' - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_device SD inner join ga_package GD on GD.particle_id= SD.device_id where GD.id_device = 3  limit 0 , 20
ERROR - 2017-08-17 22:49:10 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 22:50:45 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'between '2017-07-18 00:00:00' and '2017-07-18 23:59:59' limit 0 , 20' at line 1 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD inner join ga_device GD on GD.particle_id= SD.device_id where GD.id_device = 3 and  between '2017-07-18 00:00:00' and '2017-07-18 23:59:59' limit 0 , 20
ERROR - 2017-08-17 22:50:45 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 22:51:22 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'between '2017-18-07 00:00:00' and '2017-18-07 23:59:59' limit 0 , 20' at line 1 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD inner join ga_device GD on GD.particle_id= SD.device_id where GD.id_device = 3 and  between '2017-18-07 00:00:00' and '2017-18-07 23:59:59' limit 0 , 20
ERROR - 2017-08-17 22:51:22 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 22:52:40 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '00:00:00 and 2017-8-16 23:59:59 limit 0 , 20' at line 1 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD inner join ga_device GD on GD.particle_id= SD.device_id where GD.id_device = 3 and SD.date  between 2017-8-16 00:00:00 and 2017-8-16 23:59:59 limit 0 , 20
ERROR - 2017-08-17 22:52:40 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 22:53:39 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '?
                                    and 
                                    S' at line 4 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD
                                inner join ga_device GD on GD.particle_id= SD.device_id
                                    where 
                                        GD.id_device = ?
                                    and 
                                    SD.date between '?' and '?'
                                    limit ? , ?
                            
ERROR - 2017-08-17 22:53:39 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 22:53:43 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '?
                                    and 
                                    S' at line 4 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD
                                inner join ga_device GD on GD.particle_id= SD.device_id
                                    where 
                                        GD.id_device = ?
                                    and 
                                    SD.date between '?' and '?'
                                    limit ? , ?
                            
ERROR - 2017-08-17 22:53:43 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 22:56:56 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''0' , '20'' at line 1 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD inner join ga_device GD on GD.particle_id= SD.device_id where GD.id_device = 0 and SD.date between '2017-8-14 00:00:00' and '2017-8-14 23:59:59' limit '0' , '20' 
ERROR - 2017-08-17 22:56:56 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 22:59:54 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''0' , '20'' at line 1 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD inner join ga_device GD on GD.particle_id= SD.device_id where GD.id_device = '3' and SD.date  between '2017-8-15 00:00:00' and '2017-8-15 23:59:59' limit '0' , '20'
ERROR - 2017-08-17 22:59:54 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 23:00:43 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '? and SD.date  between ? and ? limit '?' , '?'' at line 1 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD inner join ga_device GD on GD.particle_id= SD.device_id where GD.id_device = ? and SD.date  between ? and ? limit '?' , '?'
ERROR - 2017-08-17 23:00:43 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 23:05:25 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''20'' at line 1 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD inner join ga_device GD on GD.particle_id= SD.device_id where GD.id_device = '' and SD.date  between '2017-8-16 00:00:00' and '2017-8-16 23:59:59' limit '20'
ERROR - 2017-08-17 23:05:25 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 23:20:23 --> Severity: 4096 --> Object of class CI_DB_pdo_mysql_driver could not be converted to string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1030
ERROR - 2017-08-17 23:20:23 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'Object' at line 1 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD inner join ga_device GD on GD.particle_id= SD.device_id where GD.id_device = '' and SD.date  between '2017-8-15 00:00:00' and '2017-8-15 23:59:59' Object 
ERROR - 2017-08-17 23:20:23 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 23:20:23 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/smartWater/system/core/Exceptions.php:271) /Applications/MAMP/htdocs/smartWater/system/core/Common.php 578
ERROR - 2017-08-17 23:21:00 --> Severity: 4096 --> Object of class CI_DB_pdo_mysql_driver could not be converted to string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1028
ERROR - 2017-08-17 23:21:00 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '()' at line 1 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD inner join ga_device GD on GD.particle_id= SD.device_id where GD.id_device = '' and SD.date  between '2017-8-14 00:00:00' and '2017-8-14 23:59:59' () 
ERROR - 2017-08-17 23:21:00 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 23:21:00 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/smartWater/system/core/Exceptions.php:271) /Applications/MAMP/htdocs/smartWater/system/core/Common.php 578
ERROR - 2017-08-17 23:21:25 --> Severity: 4096 --> Object of class CI_DB_pdo_mysql_driver could not be converted to string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1028
ERROR - 2017-08-17 23:21:25 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '()' at line 1 - Invalid query: SELECT SD.data , SD.date , SD.event  FROM ga_data SD inner join ga_device GD on GD.particle_id= SD.device_id where GD.id_device = '2' and SD.date  between '2017-8-14 00:00:00' and '2017-8-14 23:59:59'  () 
ERROR - 2017-08-17 23:21:25 --> Severity: error --> Exception: Call to a member function load() on string /Applications/MAMP/htdocs/smartWater/system/database/DB_driver.php 1743
ERROR - 2017-08-17 23:21:25 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/smartWater/system/core/Exceptions.php:271) /Applications/MAMP/htdocs/smartWater/system/core/Common.php 578
ERROR - 2017-08-17 23:23:40 --> Severity: error --> Exception: syntax error, unexpected '" , "' (T_CONSTANT_ENCAPSED_STRING) /Applications/MAMP/htdocs/smartWater/application/models/photon/Tools_devices.php 191
ERROR - 2017-08-17 23:23:59 --> Severity: error --> Exception: syntax error, unexpected '" , "' (T_CONSTANT_ENCAPSED_STRING) /Applications/MAMP/htdocs/smartWater/application/models/photon/Tools_devices.php 191
ERROR - 2017-08-17 23:44:38 --> Severity: Notice --> Array to string conversion /Applications/MAMP/htdocs/smartWater/system/core/Output.php 537
ERROR - 2017-08-17 23:51:06 --> Severity: error --> Exception: syntax error, unexpected '$date' (T_VARIABLE) /Applications/MAMP/htdocs/smartWater/application/models/photon/Tools_devices.php 176
ERROR - 2017-08-17 23:51:06 --> Severity: error --> Exception: syntax error, unexpected '$date' (T_VARIABLE) /Applications/MAMP/htdocs/smartWater/application/models/photon/Tools_devices.php 176
ERROR - 2017-08-17 23:54:24 --> Severity: error --> Exception: syntax error, unexpected ';', expecting ',' or ')' /Applications/MAMP/htdocs/smartWater/application/models/photon/Tools_devices.php 202
ERROR - 2017-08-17 23:54:25 --> Severity: error --> Exception: syntax error, unexpected ';', expecting ',' or ')' /Applications/MAMP/htdocs/smartWater/application/models/photon/Tools_devices.php 202
ERROR - 2017-08-17 23:55:07 --> Severity: error --> Exception: Call to a member function result() on string /Applications/MAMP/htdocs/smartWater/application/models/photon/Tools_devices.php 206
ERROR - 2017-08-17 23:55:07 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/smartWater/application/models/photon/Tools_devices.php:198) /Applications/MAMP/htdocs/smartWater/system/core/Common.php 578
ERROR - 2017-08-17 23:56:04 --> Severity: error --> Exception: Call to a member function result() on string /Applications/MAMP/htdocs/smartWater/application/models/photon/Tools_devices.php 206
ERROR - 2017-08-17 23:56:04 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/smartWater/application/models/photon/Tools_devices.php:198) /Applications/MAMP/htdocs/smartWater/system/core/Common.php 578
ERROR - 2017-08-17 23:58:09 --> Severity: error --> Exception: Call to a member function result() on string /Applications/MAMP/htdocs/smartWater/application/models/photon/Tools_devices.php 206
ERROR - 2017-08-17 23:58:09 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/smartWater/application/models/photon/Tools_devices.php:198) /Applications/MAMP/htdocs/smartWater/system/core/Common.php 578
ERROR - 2017-08-17 23:59:22 --> Severity: error --> Exception: Call to a member function result() on string /Applications/MAMP/htdocs/smartWater/application/models/photon/Tools_devices.php 202
ERROR - 2017-08-17 23:59:22 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/smartWater/application/models/photon/Tools_devices.php:195) /Applications/MAMP/htdocs/smartWater/system/core/Common.php 578
ERROR - 2017-08-17 23:59:58 --> Severity: error --> Exception: Call to a member function result() on string /Applications/MAMP/htdocs/smartWater/application/models/photon/Tools_devices.php 198
