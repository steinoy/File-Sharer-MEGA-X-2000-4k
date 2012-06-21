<?php defined('SYSPATH') or die('No direct script access.'); ?>

2012-04-16 19:26:36 --- NOTICE: 
2012-04-16 19:30:52 --- ERROR: ErrorException [ 2 ]: scandir(/Users/gg/Sites/4.dev/files/1) [function.scandir]: failed to open dir: No such file or directory ~ APPPATH/classes/model/entry.php [ 266 ]
2012-04-16 19:30:52 --- STRACE: ErrorException [ 2 ]: scandir(/Users/gg/Sites/4.dev/files/1) [function.scandir]: failed to open dir: No such file or directory ~ APPPATH/classes/model/entry.php [ 266 ]
--
#0 [internal function]: Kohana_Core::error_handler(2, 'scandir(/Users/...', '/Users/gg/Sites...', 266, Array)
#1 /Users/gg/Sites/4.dev/application/classes/model/entry.php(266): scandir('/Users/gg/Sites...')
#2 /Users/gg/Sites/4.dev/application/classes/controller/view.php(58): Model_Entry->get_formatted_files()
#3 /Users/gg/Sites/4.dev/application/classes/controller/view.php(37): Controller_View->list_files()
#4 [internal function]: Controller_View->action_index()
#5 /Users/gg/Sites/4.dev/system/classes/kohana/request/client/internal.php(118): ReflectionMethod->invoke(Object(Controller_View))
#6 /Users/gg/Sites/4.dev/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#7 /Users/gg/Sites/4.dev/system/classes/kohana/request.php(1143): Kohana_Request_Client->execute(Object(Request))
#8 /Users/gg/Sites/4.dev/index.php(109): Kohana_Request->execute()
#9 {main}
2012-04-16 20:17:18 --- NOTICE: 
2012-04-16 20:17:22 --- NOTICE: 
2012-04-16 20:17:28 --- NOTICE: 
2012-04-16 20:18:06 --- NOTICE: 
2012-04-16 20:38:20 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: assets/js/main.js ~ SYSPATH/classes/kohana/request.php [ 1131 ]
2012-04-16 20:38:20 --- STRACE: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: assets/js/main.js ~ SYSPATH/classes/kohana/request.php [ 1131 ]
--
#0 /Users/gg/Sites/4.dev/index.php(109): Kohana_Request->execute()
#1 {main}
2012-04-16 20:38:21 --- ERROR: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: assets/js/main.js ~ SYSPATH/classes/kohana/request.php [ 1131 ]
2012-04-16 20:38:21 --- STRACE: HTTP_Exception_404 [ 404 ]: Unable to find a route to match the URI: assets/js/main.js ~ SYSPATH/classes/kohana/request.php [ 1131 ]
--
#0 /Users/gg/Sites/4.dev/index.php(109): Kohana_Request->execute()
#1 {main}
2012-04-16 20:40:17 --- ERROR: View_Exception [ 0 ]: The requested view list/show could not be found ~ SYSPATH/classes/kohana/view.php [ 252 ]
2012-04-16 20:40:17 --- STRACE: View_Exception [ 0 ]: The requested view list/show could not be found ~ SYSPATH/classes/kohana/view.php [ 252 ]
--
#0 /Users/gg/Sites/4.dev/system/classes/kohana/view.php(137): Kohana_View->set_filename('list/show')
#1 /Users/gg/Sites/4.dev/system/classes/kohana/view.php(30): Kohana_View->__construct('list/show', NULL)
#2 /Users/gg/Sites/4.dev/application/classes/controller/list.php(27): Kohana_View::factory('list/show')
#3 [internal function]: Controller_List->action_index()
#4 /Users/gg/Sites/4.dev/system/classes/kohana/request/client/internal.php(118): ReflectionMethod->invoke(Object(Controller_List))
#5 /Users/gg/Sites/4.dev/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 /Users/gg/Sites/4.dev/system/classes/kohana/request.php(1143): Kohana_Request_Client->execute(Object(Request))
#7 /Users/gg/Sites/4.dev/index.php(109): Kohana_Request->execute()
#8 {main}
2012-04-16 20:40:19 --- ERROR: View_Exception [ 0 ]: The requested view list/show could not be found ~ SYSPATH/classes/kohana/view.php [ 252 ]
2012-04-16 20:40:19 --- STRACE: View_Exception [ 0 ]: The requested view list/show could not be found ~ SYSPATH/classes/kohana/view.php [ 252 ]
--
#0 /Users/gg/Sites/4.dev/system/classes/kohana/view.php(137): Kohana_View->set_filename('list/show')
#1 /Users/gg/Sites/4.dev/system/classes/kohana/view.php(30): Kohana_View->__construct('list/show', NULL)
#2 /Users/gg/Sites/4.dev/application/classes/controller/list.php(27): Kohana_View::factory('list/show')
#3 [internal function]: Controller_List->action_index()
#4 /Users/gg/Sites/4.dev/system/classes/kohana/request/client/internal.php(118): ReflectionMethod->invoke(Object(Controller_List))
#5 /Users/gg/Sites/4.dev/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 /Users/gg/Sites/4.dev/system/classes/kohana/request.php(1143): Kohana_Request_Client->execute(Object(Request))
#7 /Users/gg/Sites/4.dev/index.php(109): Kohana_Request->execute()
#8 {main}
2012-04-16 20:43:18 --- ERROR: ErrorException [ 8 ]: Undefined variable: scripts_footer ~ APPPATH/views/backend.php [ 71 ]
2012-04-16 20:43:18 --- STRACE: ErrorException [ 8 ]: Undefined variable: scripts_footer ~ APPPATH/views/backend.php [ 71 ]
--
#0 /Users/gg/Sites/4.dev/application/views/backend.php(71): Kohana_Core::error_handler(8, 'Undefined varia...', '/Users/gg/Sites...', 71, Array)
#1 /Users/gg/Sites/4.dev/system/classes/kohana/view.php(61): include('/Users/gg/Sites...')
#2 /Users/gg/Sites/4.dev/system/classes/kohana/view.php(343): Kohana_View::capture('/Users/gg/Sites...', Array)
#3 /Users/gg/Sites/4.dev/system/classes/kohana/controller/template.php(44): Kohana_View->render()
#4 [internal function]: Kohana_Controller_Template->after()
#5 /Users/gg/Sites/4.dev/system/classes/kohana/request/client/internal.php(121): ReflectionMethod->invoke(Object(Controller_List))
#6 /Users/gg/Sites/4.dev/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#7 /Users/gg/Sites/4.dev/system/classes/kohana/request.php(1143): Kohana_Request_Client->execute(Object(Request))
#8 /Users/gg/Sites/4.dev/index.php(109): Kohana_Request->execute()
#9 {main}
2012-04-16 20:43:53 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected T_ECHO ~ APPPATH/views/backend.php [ 71 ]
2012-04-16 20:43:53 --- STRACE: ErrorException [ 4 ]: syntax error, unexpected T_ECHO ~ APPPATH/views/backend.php [ 71 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2012-04-16 20:43:54 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected T_ECHO ~ APPPATH/views/backend.php [ 71 ]
2012-04-16 20:43:54 --- STRACE: ErrorException [ 4 ]: syntax error, unexpected T_ECHO ~ APPPATH/views/backend.php [ 71 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2012-04-16 20:43:54 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected T_ECHO ~ APPPATH/views/backend.php [ 71 ]
2012-04-16 20:43:54 --- STRACE: ErrorException [ 4 ]: syntax error, unexpected T_ECHO ~ APPPATH/views/backend.php [ 71 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2012-04-16 20:44:10 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected '{' ~ APPPATH/views/backend.php [ 72 ]
2012-04-16 20:44:10 --- STRACE: ErrorException [ 4 ]: syntax error, unexpected '{' ~ APPPATH/views/backend.php [ 72 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2012-04-16 20:44:10 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected '{' ~ APPPATH/views/backend.php [ 72 ]
2012-04-16 20:44:10 --- STRACE: ErrorException [ 4 ]: syntax error, unexpected '{' ~ APPPATH/views/backend.php [ 72 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2012-04-16 20:44:11 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected '{' ~ APPPATH/views/backend.php [ 72 ]
2012-04-16 20:44:11 --- STRACE: ErrorException [ 4 ]: syntax error, unexpected '{' ~ APPPATH/views/backend.php [ 72 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}