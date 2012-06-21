<?php defined('SYSPATH') or die('No direct script access.'); ?>

2012-04-17 18:41:58 --- NOTICE: 
2012-04-17 18:57:17 --- NOTICE: 
2012-04-17 18:57:18 --- NOTICE: 
2012-04-17 18:57:22 --- NOTICE: 
2012-04-17 19:34:13 --- NOTICE: 
2012-04-17 19:35:34 --- NOTICE: 
2012-04-17 19:35:35 --- NOTICE: 
2012-04-17 19:35:36 --- NOTICE: 
2012-04-17 19:44:23 --- ERROR: ErrorException [ 1 ]: Call to undefined method Model_User::get() ~ APPPATH/classes/controller/entry.php [ 21 ]
2012-04-17 19:44:23 --- STRACE: ErrorException [ 1 ]: Call to undefined method Model_User::get() ~ APPPATH/classes/controller/entry.php [ 21 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2012-04-17 22:11:52 --- ERROR: ErrorException [ 1 ]: Call to undefined function add() ~ APPPATH/classes/controller/upload.php [ 34 ]
2012-04-17 22:11:52 --- STRACE: ErrorException [ 1 ]: Call to undefined function add() ~ APPPATH/classes/controller/upload.php [ 34 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2012-04-17 22:16:17 --- NOTICE: 0
2012-04-17 22:57:10 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected T_VARIABLE ~ APPPATH/classes/controller/entry.php [ 43 ]
2012-04-17 22:57:10 --- STRACE: ErrorException [ 4 ]: syntax error, unexpected T_VARIABLE ~ APPPATH/classes/controller/entry.php [ 43 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2012-04-17 22:57:43 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected T_VARIABLE ~ APPPATH/classes/controller/entry.php [ 43 ]
2012-04-17 22:57:43 --- STRACE: ErrorException [ 4 ]: syntax error, unexpected T_VARIABLE ~ APPPATH/classes/controller/entry.php [ 43 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2012-04-17 22:57:52 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected T_VARIABLE ~ APPPATH/classes/controller/entry.php [ 43 ]
2012-04-17 22:57:52 --- STRACE: ErrorException [ 4 ]: syntax error, unexpected T_VARIABLE ~ APPPATH/classes/controller/entry.php [ 43 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2012-04-17 22:58:07 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected T_VARIABLE ~ APPPATH/classes/controller/entry.php [ 43 ]
2012-04-17 22:58:07 --- STRACE: ErrorException [ 4 ]: syntax error, unexpected T_VARIABLE ~ APPPATH/classes/controller/entry.php [ 43 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2012-04-17 22:58:50 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected T_VARIABLE ~ APPPATH/classes/controller/entry.php [ 43 ]
2012-04-17 22:58:50 --- STRACE: ErrorException [ 4 ]: syntax error, unexpected T_VARIABLE ~ APPPATH/classes/controller/entry.php [ 43 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2012-04-17 22:59:05 --- ERROR: ErrorException [ 8 ]: Undefined property: Controller_Entry::$_model ~ APPPATH/classes/controller/entry.php [ 38 ]
2012-04-17 22:59:05 --- STRACE: ErrorException [ 8 ]: Undefined property: Controller_Entry::$_model ~ APPPATH/classes/controller/entry.php [ 38 ]
--
#0 /Users/gg/Sites/4.dev/application/classes/controller/entry.php(38): Kohana_Core::error_handler(8, 'Undefined prope...', '/Users/gg/Sites...', 38, Array)
#1 [internal function]: Controller_Entry->action_update()
#2 /Users/gg/Sites/4.dev/system/classes/kohana/request/client/internal.php(118): ReflectionMethod->invoke(Object(Controller_Entry))
#3 /Users/gg/Sites/4.dev/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#4 /Users/gg/Sites/4.dev/system/classes/kohana/request.php(1143): Kohana_Request_Client->execute(Object(Request))
#5 /Users/gg/Sites/4.dev/index.php(109): Kohana_Request->execute()
#6 {main}
2012-04-17 23:00:03 --- ERROR: ErrorException [ 8 ]: Undefined property: Controller_Entry::$_model ~ APPPATH/classes/controller/entry.php [ 38 ]
2012-04-17 23:00:03 --- STRACE: ErrorException [ 8 ]: Undefined property: Controller_Entry::$_model ~ APPPATH/classes/controller/entry.php [ 38 ]
--
#0 /Users/gg/Sites/4.dev/application/classes/controller/entry.php(38): Kohana_Core::error_handler(8, 'Undefined prope...', '/Users/gg/Sites...', 38, Array)
#1 [internal function]: Controller_Entry->action_update()
#2 /Users/gg/Sites/4.dev/system/classes/kohana/request/client/internal.php(118): ReflectionMethod->invoke(Object(Controller_Entry))
#3 /Users/gg/Sites/4.dev/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#4 /Users/gg/Sites/4.dev/system/classes/kohana/request.php(1143): Kohana_Request_Client->execute(Object(Request))
#5 /Users/gg/Sites/4.dev/index.php(109): Kohana_Request->execute()
#6 {main}