<?php
include '../utils/error_publish.php';
include '../utils/uuid_generate.php';
include '../utils/model_checking.php';
include '../helpers/files_helper.php';
require '../config.php';

$config = $config_f['tests'];

$post_body = file_get_contents('php://input');

if (empty($post_body) and empty($_GET)) {
	$files = get_files_from_directory($config['tests_directory'], $config['tests_extention']);
	$content = get_files_content($files);
	echo $content;
} elseif (!empty($post_body) and !empty($_GET)) {
	show_error("Cannot process request. Undefined request purpose: both GET and POST parameters found.");
} elseif (!empty($post_body)) {
	$test = get_test(json_decode($post_body, true));

	if ($test != null) {
		$new_test_id = guidv4();
		$test['testId'] = $new_test_id;
		$test_content = json_encode($test);

		file_put_contents($config['tests_directory'].'test_'.$new_test_id.'.'.$config['tests_extention'], 
			$test_content, FILE_APPEND | LOCK_EX);
		echo "Test $test_to_delete_id has been added successful.";
	} else {
		echo "Provided file has not correct test data.";
	}

} elseif (!empty($_GET)) {
	$test_id = $_GET[$config['test_id_param']];
	$test_to_delete_id = $_GET[$config['test_to_delete_id_param']];
	if (!empty($test_id)) {
		header("Location: ".$config['tests_directory'].'test_'.$test_id.'.'.$config['tests_extention']);
	} elseif (!empty($test_to_delete_id)) {
		unlink($config['tests_directory'].'test_'.$test_to_delete_id.'.'.$config['tests_extention']);
		echo "Test $test_to_delete_id has been deleted successful.";
	} else {
		show_error("Cannot process request. Could not find ".$config['test_id_param']
			.' or '.$config['test_to_delete_id_param']." params");
	}
}