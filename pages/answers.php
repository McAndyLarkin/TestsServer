<?php
include '../utils/error_publish.php';
include '../utils/uuid_generate.php';
include '../utils/model_checking.php';
include '../helpers/files_helper.php';
include '../helpers/dao.php';
require '../config.php';

$config = $config_f['answers'];
$config_private = $config_f['private'];

$post_body = file_get_contents('php://input');
$dao = new Dao(
    $config_private['db_host'], 
    $config_private['db_user'], 
    $config_private['db_password'], 
    $config_private['db_name']
);

if (empty($post_body) and empty($_GET)) {
    if ($dao->connected() == true) {
        echo "[";
        $sets = $dao->getAnswersSets();
        while ( ($set = mysqli_fetch_assoc($sets)) ) {
            echo '{"testId":"' . $set["testId"].'"'
                .',"author":"'. $set["author"].'"'
                .',"id":'. $set["id"]
                .',"count":'. $set["count"]
                .',"answers":[';
            $answers = $dao->getAnswersBySetId($set["id"]);

            while ( ($answer = mysqli_fetch_assoc($answers)) ) {
                $val = "null";
                if(!is_null($answer["value"]) and !$answer["value"] == ""){
                    $val = $answer["value"];
                }
                echo '{"number":'.$answer["questionNum"]
                    .',"value":"'.$val
                    .'","type":"'.$answer["type"]
                    .'"},';
            }
            echo "]},";
        }
        echo "]";
    } else {
        echo "DB failed";
    }
} elseif (!empty($post_body) and !empty($_GET)) {
	show_error("Cannot process request. Undefined request purpose: both GET and POST parameters found.");
} elseif (!empty($post_body)) {
	$answer = get_test(json_decode($post_body, true));

	if ($answer != null) {
        $dao->addAnswer($answer);
		
		echo "Answer has been added successful.";
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