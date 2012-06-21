<?php defined('SYSPATH') or die('No direct script access.'); ?>

2012-04-09 11:37:52 --- ERROR: ErrorException [ 1 ]: Class 'Contoller_REST' not found ~ APPPATH/classes/controller/entry.php [ 3 ]
2012-04-09 11:37:52 --- STRACE: ErrorException [ 1 ]: Class 'Contoller_REST' not found ~ APPPATH/classes/controller/entry.php [ 3 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2012-04-09 11:39:01 --- ERROR: ErrorException [ 1 ]: Class 'Contoller_REST' not found ~ APPPATH/classes/controller/entry.php [ 3 ]
2012-04-09 11:39:01 --- STRACE: ErrorException [ 1 ]: Class 'Contoller_REST' not found ~ APPPATH/classes/controller/entry.php [ 3 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2012-04-09 11:39:49 --- ERROR: ErrorException [ 1 ]: Class 'Contoller_REST' not found ~ APPPATH/classes/controller/entry.php [ 3 ]
2012-04-09 11:39:49 --- STRACE: ErrorException [ 1 ]: Class 'Contoller_REST' not found ~ APPPATH/classes/controller/entry.php [ 3 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2012-04-09 11:43:11 --- NOTICE: 
2012-04-09 11:43:15 --- NOTICE: 
2012-04-09 11:43:48 --- NOTICE: 
2012-04-09 11:43:56 --- NOTICE: 
2012-04-09 11:45:18 --- NOTICE: 
2012-04-09 11:45:35 --- NOTICE: 
2012-04-09 13:42:53 --- NOTICE: 
2012-04-09 13:45:33 --- ERROR: Kohana_Exception [ 0 ]: Model_Entry should extend Model_Backbone ~ MODPATH/backbone/classes/controller/backbone.php [ 53 ]
2012-04-09 13:45:33 --- STRACE: Kohana_Exception [ 0 ]: Model_Entry should extend Model_Backbone ~ MODPATH/backbone/classes/controller/backbone.php [ 53 ]
--
#0 /Users/gg/Sites/4.dev/application/classes/controller/entry.php(18): Controller_Backbone->before()
#1 [internal function]: Controller_Entry->before()
#2 /Users/gg/Sites/4.dev/system/classes/kohana/request/client/internal.php(103): ReflectionMethod->invoke(Object(Controller_Entry))
#3 /Users/gg/Sites/4.dev/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#4 /Users/gg/Sites/4.dev/system/classes/kohana/request.php(1144): Kohana_Request_Client->execute(Object(Request))
#5 /Users/gg/Sites/4.dev/index.php(109): Kohana_Request->execute()
#6 {main}
2012-04-09 13:46:51 --- NOTICE: 
2012-04-09 14:28:00 --- NOTICE: 
2012-04-09 14:28:23 --- NOTICE: 
2012-04-09 14:39:24 --- NOTICE: 
2012-04-09 14:39:56 --- NOTICE: 
2012-04-09 14:41:22 --- NOTICE: 
2012-04-09 14:59:41 --- NOTICE: 
2012-04-09 15:01:02 --- NOTICE: 
2012-04-09 15:01:28 --- NOTICE: 
2012-04-09 15:01:39 --- NOTICE: 
2012-04-09 15:01:39 --- ERROR: ErrorException [ 8 ]: Undefined offset: 0 ~ APPPATH/classes/controller/entry.php [ 96 ]
2012-04-09 15:01:39 --- STRACE: ErrorException [ 8 ]: Undefined offset: 0 ~ APPPATH/classes/controller/entry.php [ 96 ]
--
#0 /Users/gg/Sites/4.dev/application/classes/controller/entry.php(96): Kohana_Core::error_handler(8, 'Undefined offse...', '/Users/gg/Sites...', 96, Array)
#1 [internal function]: Controller_Entry->action_create()
#2 /Users/gg/Sites/4.dev/system/classes/kohana/request/client/internal.php(118): ReflectionMethod->invoke(Object(Controller_Entry))
#3 /Users/gg/Sites/4.dev/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#4 /Users/gg/Sites/4.dev/system/classes/kohana/request.php(1144): Kohana_Request_Client->execute(Object(Request))
#5 /Users/gg/Sites/4.dev/index.php(109): Kohana_Request->execute()
#6 {main}
2012-04-09 15:02:05 --- NOTICE: 
2012-04-09 15:06:45 --- NOTICE: 
2012-04-09 15:10:16 --- NOTICE: 
2012-04-09 15:10:16 --- ERROR: ErrorException [ 8 ]: Undefined index: title ~ APPPATH/classes/model/entry.php [ 66 ]
2012-04-09 15:10:16 --- STRACE: ErrorException [ 8 ]: Undefined index: title ~ APPPATH/classes/model/entry.php [ 66 ]
--
#0 /Users/gg/Sites/4.dev/application/classes/model/entry.php(66): Kohana_Core::error_handler(8, 'Undefined index...', '/Users/gg/Sites...', 66, Array)
#1 /Users/gg/Sites/4.dev/application/classes/model/entry.php(15): Model_Entry->filter_values(Array)
#2 /Users/gg/Sites/4.dev/modules/backbone/classes/controller/backbone.php(73): Model_Entry->create_model(Array)
#3 [internal function]: Controller_Backbone->action_create()
#4 /Users/gg/Sites/4.dev/system/classes/kohana/request/client/internal.php(118): ReflectionMethod->invoke(Object(Controller_Entry))
#5 /Users/gg/Sites/4.dev/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 /Users/gg/Sites/4.dev/system/classes/kohana/request.php(1144): Kohana_Request_Client->execute(Object(Request))
#7 /Users/gg/Sites/4.dev/index.php(109): Kohana_Request->execute()
#8 {main}
2012-04-09 15:11:11 --- NOTICE: 
2012-04-09 15:11:11 --- ERROR: ErrorException [ 8 ]: Undefined index: title ~ APPPATH/classes/model/entry.php [ 67 ]
2012-04-09 15:11:11 --- STRACE: ErrorException [ 8 ]: Undefined index: title ~ APPPATH/classes/model/entry.php [ 67 ]
--
#0 /Users/gg/Sites/4.dev/application/classes/model/entry.php(67): Kohana_Core::error_handler(8, 'Undefined index...', '/Users/gg/Sites...', 67, Array)
#1 /Users/gg/Sites/4.dev/application/classes/model/entry.php(15): Model_Entry->filter_values(Array)
#2 /Users/gg/Sites/4.dev/modules/backbone/classes/controller/backbone.php(73): Model_Entry->create_model(Array)
#3 [internal function]: Controller_Backbone->action_create()
#4 /Users/gg/Sites/4.dev/system/classes/kohana/request/client/internal.php(118): ReflectionMethod->invoke(Object(Controller_Entry))
#5 /Users/gg/Sites/4.dev/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 /Users/gg/Sites/4.dev/system/classes/kohana/request.php(1144): Kohana_Request_Client->execute(Object(Request))
#7 /Users/gg/Sites/4.dev/index.php(109): Kohana_Request->execute()
#8 {main}
2012-04-09 15:12:38 --- NOTICE: 
2012-04-09 15:12:38 --- ERROR: ErrorException [ 8 ]: Undefined index: title ~ APPPATH/classes/model/entry.php [ 66 ]
2012-04-09 15:12:38 --- STRACE: ErrorException [ 8 ]: Undefined index: title ~ APPPATH/classes/model/entry.php [ 66 ]
--
#0 /Users/gg/Sites/4.dev/application/classes/model/entry.php(66): Kohana_Core::error_handler(8, 'Undefined index...', '/Users/gg/Sites...', 66, Array)
#1 /Users/gg/Sites/4.dev/application/classes/model/entry.php(15): Model_Entry->filter_values(Array)
#2 /Users/gg/Sites/4.dev/modules/backbone/classes/controller/backbone.php(74): Model_Entry->create_model(Array)
#3 [internal function]: Controller_Backbone->action_create()
#4 /Users/gg/Sites/4.dev/system/classes/kohana/request/client/internal.php(118): ReflectionMethod->invoke(Object(Controller_Entry))
#5 /Users/gg/Sites/4.dev/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 /Users/gg/Sites/4.dev/system/classes/kohana/request.php(1144): Kohana_Request_Client->execute(Object(Request))
#7 /Users/gg/Sites/4.dev/index.php(109): Kohana_Request->execute()
#8 {main}
2012-04-09 15:13:08 --- NOTICE: 
2012-04-09 15:13:08 --- ERROR: ErrorException [ 8 ]: Undefined index: title ~ APPPATH/classes/model/entry.php [ 66 ]
2012-04-09 15:13:08 --- STRACE: ErrorException [ 8 ]: Undefined index: title ~ APPPATH/classes/model/entry.php [ 66 ]
--
#0 /Users/gg/Sites/4.dev/application/classes/model/entry.php(66): Kohana_Core::error_handler(8, 'Undefined index...', '/Users/gg/Sites...', 66, Array)
#1 /Users/gg/Sites/4.dev/application/classes/model/entry.php(15): Model_Entry->filter_values(Array)
#2 /Users/gg/Sites/4.dev/modules/backbone/classes/controller/backbone.php(74): Model_Entry->create_model(Array)
#3 [internal function]: Controller_Backbone->action_create()
#4 /Users/gg/Sites/4.dev/system/classes/kohana/request/client/internal.php(118): ReflectionMethod->invoke(Object(Controller_Entry))
#5 /Users/gg/Sites/4.dev/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 /Users/gg/Sites/4.dev/system/classes/kohana/request.php(1144): Kohana_Request_Client->execute(Object(Request))
#7 /Users/gg/Sites/4.dev/index.php(109): Kohana_Request->execute()
#8 {main}
2012-04-09 15:17:58 --- NOTICE: 
2012-04-09 15:17:58 --- ERROR: ErrorException [ 8 ]: Undefined index: title ~ APPPATH/classes/model/entry.php [ 66 ]
2012-04-09 15:17:58 --- STRACE: ErrorException [ 8 ]: Undefined index: title ~ APPPATH/classes/model/entry.php [ 66 ]
--
#0 /Users/gg/Sites/4.dev/application/classes/model/entry.php(66): Kohana_Core::error_handler(8, 'Undefined index...', '/Users/gg/Sites...', 66, Array)
#1 /Users/gg/Sites/4.dev/application/classes/model/entry.php(15): Model_Entry->filter_values(Array)
#2 /Users/gg/Sites/4.dev/modules/backbone/classes/controller/backbone.php(74): Model_Entry->create_model(Array)
#3 [internal function]: Controller_Backbone->action_create()
#4 /Users/gg/Sites/4.dev/system/classes/kohana/request/client/internal.php(118): ReflectionMethod->invoke(Object(Controller_Entry))
#5 /Users/gg/Sites/4.dev/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 /Users/gg/Sites/4.dev/system/classes/kohana/request.php(1144): Kohana_Request_Client->execute(Object(Request))
#7 /Users/gg/Sites/4.dev/index.php(109): Kohana_Request->execute()
#8 {main}
2012-04-09 15:24:09 --- NOTICE: 
2012-04-09 15:24:09 --- ERROR: ErrorException [ 8 ]: Undefined index: title ~ APPPATH/classes/model/entry.php [ 66 ]
2012-04-09 15:24:09 --- STRACE: ErrorException [ 8 ]: Undefined index: title ~ APPPATH/classes/model/entry.php [ 66 ]
--
#0 /Users/gg/Sites/4.dev/application/classes/model/entry.php(66): Kohana_Core::error_handler(8, 'Undefined index...', '/Users/gg/Sites...', 66, Array)
#1 /Users/gg/Sites/4.dev/application/classes/model/entry.php(15): Model_Entry->filter_values(Array)
#2 /Users/gg/Sites/4.dev/modules/backbone/classes/controller/backbone.php(74): Model_Entry->create_model(Array)
#3 [internal function]: Controller_Backbone->action_create()
#4 /Users/gg/Sites/4.dev/system/classes/kohana/request/client/internal.php(118): ReflectionMethod->invoke(Object(Controller_Entry))
#5 /Users/gg/Sites/4.dev/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 /Users/gg/Sites/4.dev/system/classes/kohana/request.php(1144): Kohana_Request_Client->execute(Object(Request))
#7 /Users/gg/Sites/4.dev/index.php(109): Kohana_Request->execute()
#8 {main}
2012-04-09 15:24:26 --- NOTICE: 
2012-04-09 15:24:26 --- ERROR: ErrorException [ 8 ]: Undefined index: title ~ APPPATH/classes/model/entry.php [ 66 ]
2012-04-09 15:24:26 --- STRACE: ErrorException [ 8 ]: Undefined index: title ~ APPPATH/classes/model/entry.php [ 66 ]
--
#0 /Users/gg/Sites/4.dev/application/classes/model/entry.php(66): Kohana_Core::error_handler(8, 'Undefined index...', '/Users/gg/Sites...', 66, Array)
#1 /Users/gg/Sites/4.dev/application/classes/model/entry.php(15): Model_Entry->filter_values(Array)
#2 /Users/gg/Sites/4.dev/modules/backbone/classes/controller/backbone.php(74): Model_Entry->create_model(Array)
#3 [internal function]: Controller_Backbone->action_create()
#4 /Users/gg/Sites/4.dev/system/classes/kohana/request/client/internal.php(118): ReflectionMethod->invoke(Object(Controller_Entry))
#5 /Users/gg/Sites/4.dev/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 /Users/gg/Sites/4.dev/system/classes/kohana/request.php(1144): Kohana_Request_Client->execute(Object(Request))
#7 /Users/gg/Sites/4.dev/index.php(109): Kohana_Request->execute()
#8 {main}
2012-04-09 15:31:11 --- NOTICE: 
2012-04-09 15:31:11 --- ERROR: ErrorException [ 8 ]: Undefined index: title ~ APPPATH/classes/model/entry.php [ 66 ]
2012-04-09 15:31:11 --- STRACE: ErrorException [ 8 ]: Undefined index: title ~ APPPATH/classes/model/entry.php [ 66 ]
--
#0 /Users/gg/Sites/4.dev/application/classes/model/entry.php(66): Kohana_Core::error_handler(8, 'Undefined index...', '/Users/gg/Sites...', 66, Array)
#1 /Users/gg/Sites/4.dev/application/classes/model/entry.php(15): Model_Entry->filter_values(Array)
#2 /Users/gg/Sites/4.dev/modules/backbone/classes/controller/backbone.php(74): Model_Entry->create_model(Array)
#3 [internal function]: Controller_Backbone->action_create()
#4 /Users/gg/Sites/4.dev/system/classes/kohana/request/client/internal.php(118): ReflectionMethod->invoke(Object(Controller_Entry))
#5 /Users/gg/Sites/4.dev/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 /Users/gg/Sites/4.dev/system/classes/kohana/request.php(1144): Kohana_Request_Client->execute(Object(Request))
#7 /Users/gg/Sites/4.dev/index.php(109): Kohana_Request->execute()
#8 {main}
2012-04-09 15:38:41 --- NOTICE: 
2012-04-09 15:38:41 --- ERROR: ErrorException [ 8 ]: Undefined index: title ~ APPPATH/classes/model/entry.php [ 66 ]
2012-04-09 15:38:41 --- STRACE: ErrorException [ 8 ]: Undefined index: title ~ APPPATH/classes/model/entry.php [ 66 ]
--
#0 /Users/gg/Sites/4.dev/application/classes/model/entry.php(66): Kohana_Core::error_handler(8, 'Undefined index...', '/Users/gg/Sites...', 66, Array)
#1 /Users/gg/Sites/4.dev/application/classes/model/entry.php(15): Model_Entry->filter_values(Array)
#2 /Users/gg/Sites/4.dev/modules/backbone/classes/controller/backbone.php(74): Model_Entry->create_model(Array)
#3 [internal function]: Controller_Backbone->action_create()
#4 /Users/gg/Sites/4.dev/system/classes/kohana/request/client/internal.php(118): ReflectionMethod->invoke(Object(Controller_Entry))
#5 /Users/gg/Sites/4.dev/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 /Users/gg/Sites/4.dev/system/classes/kohana/request.php(1144): Kohana_Request_Client->execute(Object(Request))
#7 /Users/gg/Sites/4.dev/index.php(109): Kohana_Request->execute()
#8 {main}
2012-04-09 15:45:57 --- NOTICE: 
2012-04-09 15:45:57 --- ERROR: ErrorException [ 8 ]: Undefined property: Controller_Entry::$input ~ MODPATH/backbone/classes/controller/backbone.php [ 77 ]
2012-04-09 15:45:57 --- STRACE: ErrorException [ 8 ]: Undefined property: Controller_Entry::$input ~ MODPATH/backbone/classes/controller/backbone.php [ 77 ]
--
#0 /Users/gg/Sites/4.dev/modules/backbone/classes/controller/backbone.php(77): Kohana_Core::error_handler(8, 'Undefined prope...', '/Users/gg/Sites...', 77, Array)
#1 [internal function]: Controller_Backbone->action_create()
#2 /Users/gg/Sites/4.dev/system/classes/kohana/request/client/internal.php(118): ReflectionMethod->invoke(Object(Controller_Entry))
#3 /Users/gg/Sites/4.dev/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#4 /Users/gg/Sites/4.dev/system/classes/kohana/request.php(1143): Kohana_Request_Client->execute(Object(Request))
#5 /Users/gg/Sites/4.dev/index.php(109): Kohana_Request->execute()
#6 {main}
2012-04-09 15:46:23 --- NOTICE: 
2012-04-09 15:47:34 --- NOTICE: 
2012-04-09 15:47:34 --- ERROR: ErrorException [ 2 ]: Missing argument 1 for Model_Entry::get_entry_URI(), called in /Users/gg/Sites/4.dev/application/classes/model/entry.php on line 52 and defined ~ APPPATH/classes/model/entry.php [ 327 ]
2012-04-09 15:47:34 --- STRACE: ErrorException [ 2 ]: Missing argument 1 for Model_Entry::get_entry_URI(), called in /Users/gg/Sites/4.dev/application/classes/model/entry.php on line 52 and defined ~ APPPATH/classes/model/entry.php [ 327 ]
--
#0 /Users/gg/Sites/4.dev/application/classes/model/entry.php(327): Kohana_Core::error_handler(2, 'Missing argumen...', '/Users/gg/Sites...', 327, Array)
#1 /Users/gg/Sites/4.dev/application/classes/model/entry.php(52): Model_Entry->get_entry_URI()
#2 /Users/gg/Sites/4.dev/modules/backbone/classes/controller/backbone.php(80): Model_Entry->as_array()
#3 [internal function]: Controller_Backbone->action_create()
#4 /Users/gg/Sites/4.dev/system/classes/kohana/request/client/internal.php(118): ReflectionMethod->invoke(Object(Controller_Entry))
#5 /Users/gg/Sites/4.dev/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 /Users/gg/Sites/4.dev/system/classes/kohana/request.php(1143): Kohana_Request_Client->execute(Object(Request))
#7 /Users/gg/Sites/4.dev/index.php(109): Kohana_Request->execute()
#8 {main}
2012-04-09 15:48:01 --- NOTICE: 
2012-04-09 15:48:01 --- ERROR: ErrorException [ 2 ]: scandir(/Users/gg/Sites/4.dev/files/2) [function.scandir]: failed to open dir: No such file or directory ~ APPPATH/classes/model/entry.php [ 280 ]
2012-04-09 15:48:01 --- STRACE: ErrorException [ 2 ]: scandir(/Users/gg/Sites/4.dev/files/2) [function.scandir]: failed to open dir: No such file or directory ~ APPPATH/classes/model/entry.php [ 280 ]
--
#0 [internal function]: Kohana_Core::error_handler(2, 'scandir(/Users/...', '/Users/gg/Sites...', 280, Array)
#1 /Users/gg/Sites/4.dev/application/classes/model/entry.php(280): scandir('/Users/gg/Sites...')
#2 /Users/gg/Sites/4.dev/application/classes/model/entry.php(53): Model_Entry->get_formatted_file_names()
#3 /Users/gg/Sites/4.dev/modules/backbone/classes/controller/backbone.php(80): Model_Entry->as_array()
#4 [internal function]: Controller_Backbone->action_create()
#5 /Users/gg/Sites/4.dev/system/classes/kohana/request/client/internal.php(118): ReflectionMethod->invoke(Object(Controller_Entry))
#6 /Users/gg/Sites/4.dev/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#7 /Users/gg/Sites/4.dev/system/classes/kohana/request.php(1143): Kohana_Request_Client->execute(Object(Request))
#8 /Users/gg/Sites/4.dev/index.php(109): Kohana_Request->execute()
#9 {main}
2012-04-09 15:49:57 --- NOTICE: 
2012-04-09 15:49:57 --- ERROR: ErrorException [ 2 ]: scandir(/Users/gg/Sites/4.dev/files/3) [function.scandir]: failed to open dir: No such file or directory ~ APPPATH/classes/model/entry.php [ 280 ]
2012-04-09 15:49:57 --- STRACE: ErrorException [ 2 ]: scandir(/Users/gg/Sites/4.dev/files/3) [function.scandir]: failed to open dir: No such file or directory ~ APPPATH/classes/model/entry.php [ 280 ]
--
#0 [internal function]: Kohana_Core::error_handler(2, 'scandir(/Users/...', '/Users/gg/Sites...', 280, Array)
#1 /Users/gg/Sites/4.dev/application/classes/model/entry.php(280): scandir('/Users/gg/Sites...')
#2 /Users/gg/Sites/4.dev/application/classes/model/entry.php(53): Model_Entry->get_formatted_file_names()
#3 /Users/gg/Sites/4.dev/modules/backbone/classes/controller/backbone.php(80): Model_Entry->as_array()
#4 [internal function]: Controller_Backbone->action_create()
#5 /Users/gg/Sites/4.dev/system/classes/kohana/request/client/internal.php(118): ReflectionMethod->invoke(Object(Controller_Entry))
#6 /Users/gg/Sites/4.dev/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#7 /Users/gg/Sites/4.dev/system/classes/kohana/request.php(1143): Kohana_Request_Client->execute(Object(Request))
#8 /Users/gg/Sites/4.dev/index.php(109): Kohana_Request->execute()
#9 {main}
2012-04-09 15:50:17 --- NOTICE: 
2012-04-09 15:53:32 --- NOTICE: 
2012-04-09 16:32:18 --- NOTICE: 
2012-04-09 16:37:01 --- NOTICE: 
2012-04-09 16:42:57 --- NOTICE: 
2012-04-09 16:43:17 --- NOTICE: 
2012-04-09 16:43:43 --- NOTICE: 
2012-04-09 16:44:02 --- NOTICE: 
2012-04-09 16:49:00 --- NOTICE: 
2012-04-09 16:49:06 --- NOTICE: 
2012-04-09 16:50:21 --- NOTICE: 
2012-04-09 17:05:33 --- NOTICE: 
2012-04-09 17:05:40 --- NOTICE: 
2012-04-09 17:05:48 --- NOTICE: 
2012-04-09 18:03:22 --- NOTICE: 
2012-04-09 18:04:36 --- NOTICE: 
2012-04-09 18:06:41 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected T_OBJECT_OPERATOR, expecting T_STRING or T_VARIABLE or '{' or '$' ~ APPPATH/classes/model/entry.php [ 27 ]
2012-04-09 18:06:41 --- STRACE: ErrorException [ 4 ]: syntax error, unexpected T_OBJECT_OPERATOR, expecting T_STRING or T_VARIABLE or '{' or '$' ~ APPPATH/classes/model/entry.php [ 27 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2012-04-09 18:07:07 --- NOTICE: 
2012-04-09 18:11:20 --- NOTICE: 
2012-04-09 18:11:54 --- NOTICE: 
2012-04-09 18:14:00 --- NOTICE: 
2012-04-09 18:14:07 --- NOTICE: 
2012-04-09 18:14:12 --- NOTICE: 
2012-04-09 18:24:30 --- NOTICE: 
2012-04-09 18:24:32 --- NOTICE: 
2012-04-09 18:24:41 --- NOTICE: 
2012-04-09 18:25:09 --- NOTICE: 
2012-04-09 18:25:43 --- NOTICE: 
2012-04-09 18:25:44 --- NOTICE: 
2012-04-09 18:39:06 --- ERROR: ErrorException [ 2 ]: scandir(/Users/gg/Sites/4.dev/files/5) [function.scandir]: failed to open dir: No such file or directory ~ APPPATH/classes/model/entry.php [ 265 ]
2012-04-09 18:39:06 --- STRACE: ErrorException [ 2 ]: scandir(/Users/gg/Sites/4.dev/files/5) [function.scandir]: failed to open dir: No such file or directory ~ APPPATH/classes/model/entry.php [ 265 ]
--
#0 [internal function]: Kohana_Core::error_handler(2, 'scandir(/Users/...', '/Users/gg/Sites...', 265, Array)
#1 /Users/gg/Sites/4.dev/application/classes/model/entry.php(265): scandir('/Users/gg/Sites...')
#2 /Users/gg/Sites/4.dev/application/classes/controller/view.php(58): Model_Entry->get_formatted_files()
#3 /Users/gg/Sites/4.dev/application/classes/controller/view.php(37): Controller_View->list_files()
#4 [internal function]: Controller_View->action_index()
#5 /Users/gg/Sites/4.dev/system/classes/kohana/request/client/internal.php(118): ReflectionMethod->invoke(Object(Controller_View))
#6 /Users/gg/Sites/4.dev/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#7 /Users/gg/Sites/4.dev/system/classes/kohana/request.php(1143): Kohana_Request_Client->execute(Object(Request))
#8 /Users/gg/Sites/4.dev/index.php(109): Kohana_Request->execute()
#9 {main}