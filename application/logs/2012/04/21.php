<?php defined('SYSPATH') or die('No direct script access.'); ?>

2012-04-21 13:42:50 --- ERROR: ErrorException [ 8 ]: Trying to get property of non-object ~ APPPATH/classes/model/entry.php [ 29 ]
2012-04-21 13:42:50 --- STRACE: ErrorException [ 8 ]: Trying to get property of non-object ~ APPPATH/classes/model/entry.php [ 29 ]
--
#0 /Users/gg/Sites/4.dev/application/classes/model/entry.php(29): Kohana_Core::error_handler(8, 'Trying to get p...', '/Users/gg/Sites...', 29, Array)
#1 /Users/gg/Sites/4.dev/application/classes/controller/list.php(33): Model_Entry->read_all(0, 3)
#2 [internal function]: Controller_List->action_index()
#3 /Users/gg/Sites/4.dev/system/classes/kohana/request/client/internal.php(118): ReflectionMethod->invoke(Object(Controller_List))
#4 /Users/gg/Sites/4.dev/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 /Users/gg/Sites/4.dev/system/classes/kohana/request.php(1143): Kohana_Request_Client->execute(Object(Request))
#6 /Users/gg/Sites/4.dev/index.php(109): Kohana_Request->execute()
#7 {main}