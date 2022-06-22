<?php

$config_f = array(
	'index' => array(
		'page_name' => 'Test_Diploma'
	), 
	'tests' => array(
		'tests_directory' => '../tests/',
		'tests_extention' => 'json',
		'test_id_param' => 'id',
		'test_to_delete_id_param' => 'id_to_del'
	),
	'answers' => array(
		'diploma_db' => 'diploma',
		'answers_directory' => '../answers/',
		'answers_extention' => 'json',
		'answers_id_param' => 'id',
		'answers_to_delete_id_param' => 'id_to_del',
		'answers_test_id_param' => 'testId',
		'answers_to_delete_test_id_param' => 'test_id_to_del'
	),
	'common' => array(
		''
	),
	"private" => array(
		'admin_login' => "admin",
		'admin_password' => "pass",
		'db_host' => "localhost:8889",
		"db_user" => "max",
		"db_password" => "max",
		"db_name" => "diploma"
	)
);