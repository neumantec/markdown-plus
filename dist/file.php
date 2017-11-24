<?php 

function isValidJSON($str) {
   json_decode($str);
   return json_last_error() == JSON_ERROR_NONE;
}

$file_name = null;
$contents = null;

//if the form is submitted
if($_SERVER['REQUEST_METHOD'] === 'POST') {
	header('Content-Type: application/json');
	
	$json_params = file_get_contents("php://input");
	
	if (strlen($json_params) > 0 && isValidJSON($json_params)) {
		$decoded_params = json_decode($json_params, true);
	} else {
		$decoded_params = [];
	}

	if(isset($decoded_params['filename']))
		$file_name = $decoded_params['filename'];
	
	if(isset($decoded_params['contents']))
		$contents = $decoded_params['contents'];
	
	$result = [];
	$result['status'] = 'ERROR';
	$result['message'] = 'Parameters missing';
	
	if($file_name && strlen($file_name) && $contents && strlen($contents)) {
		// All OK save the file
		$result['status'] = 'ERROR';
		$result['message'] = 'File Saving Failed: ' . $file_name;

		if(file_put_contents($file_name, $contents)) {
			$result['status'] = 'OK';
			$result['message'] = 'File Saved successfuly: ' . $file_name ;
		}
	} else {
		$result['status'] = 'ERROR';
		$result['message'] = 'Parameters missing';
	}
	echo json_encode($result);
} else {
	// assume method = GET
	header('Content-Type: application/json');
	$result = [];
	$directory = './saved';
	$result = array_diff(scandir($directory), array('..', '.'));
	echo json_encode(array_values($result));
}
?>