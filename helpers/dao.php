<?php
/**
 * Data Access Object
 */
class Dao {
	private $connection;

	function __construct($host, $user, $password, $db = "diploma")
	{
		$this->connection = mysqli_connect($host, $user, $password, $db);
	}

    function __destruct() {
        if ($this->connection != NULL) {
            mysqli_close($this->connection);
        }
    }

	function connected() {
		return $this->connection ? true : false;
	}

	function getAnswersSets() {
		return mysqli_query($this->connection, "SELECT * FROM `answers_sets`");
	}

	function getAnswersBySetId($setId) {
		return mysqli_query($this->connection, "SELECT * FROM `answers` WHERE answer_set_id=" 
            . $setId. ' ORDER BY questionNum');
	}

	function addAnswer($answer) {
        $qu = 'INSERT INTO `answers_sets` '
        .'(count, testId, author) VALUES ('.$answer["count"].', "'
        .$answer["testId"].'", "'
        .$answer["author"].'")';
        echo $qu;
		mysqli_query($this->connection, $qu);
            
        $id = mysqli_insert_id($this->connection);

        
        foreach ($answer["answers"] as $ans) {
            $qur = "INSERT INTO `answers` 
            (questionNum, value, type, answer_set_id) VALUES (".$ans["number"].', "'
            .$ans["value"].'", "'
            .$ans["type"].'", '
            .$id.')';
            echo $qur;
            mysqli_query($this->connection, $qur);
        }

	}
}