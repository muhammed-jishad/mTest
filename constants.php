<?php 

	/*Security*/
	define('SECRETE_KEY', 'jishadjwttest');
	
	/*Data Type*/
	define('BOOLEAN', 	'1');
	define('INTEGER', 	'2');
	define('STRING', 	'3');
/*Mysql Connection*/
	define('HOST', 	'127.0.0.1');
	define('DB', 	'MTestDb');
	define('USER', 	'root');
	define('PWD', 	'');
	/*Error Codes*/
	define('REQUEST_METHOD_NOT_VALID',		        400);
	define('REQUEST_CONTENTTYPE_NOT_VALID',	        400);
	define('REQUEST_NOT_VALID', 			        400);
    define('VALIDATE_PARAMETER_REQUIRED', 			400);
	define('VALIDATE_PARAMETER_DATATYPE', 			400);
	define('API_NAME_REQUIRED', 					400);
	define('API_PARAM_REQUIRED', 					400);
	define('API_DOST_NOT_EXIST', 					404);
	define('INVALID_USER_PASS', 					401);
	define('USER_NOT_ACTIVE', 						401);
	define('SUCCESS_RESPONSE', 						200);
	define('JWT_PROCESSING_ERROR',					300);
	define('ATHORIZATION_HEADER_NOT_FOUND',			403);
	define('ACCESS_TOKEN_ERRORS',					403);	
	define('SERVER_ERROR',				        	500);	
	/*

400 bad rerquest
401 invalid
403 forbidden
404 not foud
500 server error
	*/
?>