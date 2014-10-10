<?php
/* gitlab deploy webhook */
/* file.php?token=oGN3YTBuPizLa5Pwgx8ICvoNn3OqFVFKBOxtwchjs2a8z8vOdEqcUiLWsvjfz5j */

/* security */
$access_token = 'oGN3YTBuPizLa5Pwgx8ICvoNn3OqFVFKBOxtwchjs2a8z8vOdEqcUiLWsvjfz5j';
$access_ip = array('122.34.65.90');

/* get user token and ip address */
$client_token = $_GET['token'];
$client_ip = $_SERVER['REMOTE_ADDR'];

/* create open log */
$fs = fopen('./webhook.log', 'a');
fwrite($fs, 'Request on ['.date("Y-m-d H:i:s").'] from ['.$client_ip.']'.PHP_EOL);

/* test token */
if ($client_token !== $access_token)
{
    echo "error 403";
    fwrite($fs, "Invalid token [{$client_token}]".PHP_EOL);
    exit(0);
}

/* test ip */
if ( ! in_array($client_ip, $access_ip))
	{
    echo "error 503";
    fwrite($fs, "Invalid ip [{$client_ip}]".PHP_EOL);
    exit(0);
	}

/* get json data */
$json = file_get_contents('php://input');
$data = json_decode($json, true);

/* get branch */
$branch = $data["ref"];
fwrite($fs, '======================================================================='.PHP_EOL);
/* if you need get full json input */
//fwrite($fs, 'DATA: '.print_r($data, true).PHP_EOL);

/* branch filter */
if ($branch === 'refs/heads/master')
	{
	/* if master branch*/
	fwrite($fs, 'BRANCH: '.print_r($branch, true).PHP_EOL);
	fwrite($fs, '======================================================================='.PHP_EOL);
	$fs and fclose($fs);
	/* then pull master */
	exec("/home/deploy/master_deploy.sh");
	} 
else 
	{
	/* if devel branch */
	fwrite($fs, 'BRANCH: '.print_r($branch, true).PHP_EOL);
	fwrite($fs, '======================================================================='.PHP_EOL);
	$fs and fclose($fs);
	/* pull devel branch */
	exec("/home/deploy/devel_deploy.sh");
	}
?>
