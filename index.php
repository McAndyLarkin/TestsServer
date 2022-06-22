<?php 
	include 'config.php';
	$config = $config_f['index'];
?>
<!DOCTYPE html>
<html lang="<?php echo $language; ?>">
	<head>
    	<title><?php echo $config['page_name']; ?></title>
  	</head>
  	<body>
  		<a href="pages/tests.php">tests</a>
  		<br/>
  		<a href="pages/answers.php">answers</a>
  	</body>
</html>