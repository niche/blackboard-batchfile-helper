<?php
function __autoload($class_name) {
    require_once "classes/class.".$class_name . '.php';
}
/**
* 
*/
class batchcreate extends processtext
{
	function users($users){
		$users = $this->text2array(trim($users));
		foreach ($users as $key => $user){
			if (is_numeric(substr($user,0,1))){
				$user = "u".trim($user);
			}
			if (strrchr($user,"/")){
				$usertemp = explode("/",$user);
				$user = trim($usertemp[0]);
			}
			$newuser[$key] = trim($user);
		}
		return $newuser;
	}
	
	function modules($modules,$yearcode=null){
		$modules = $this->text2array(trim($modules));
		foreach ($modules as $key => $module){
			if (isset($yearcode) && $yearcode != 'nothing'){			
				if (!strstr($module,$yearcode)){
					$newmodule[$key] = trim($module).$yearcode;
				} else {
					$newmodule[$key] = trim($module);
				}
			} else {
				$newmodule[$key] = trim($module);
			}
		}
		return $newmodule;
	}
}
$process = new batchcreate;
$usernames = $process->users(trim($_POST['users']));
$modules = $process->modules(trim($_POST['modules']),$_POST["yearcode"]);
$key = 0;
foreach($usernames as $user){
	foreach ($modules as $module){
		$lines[$key] = '"'.$module.'","'.$user.'","'.$_POST['access'].'"';
		$key++;
	}
}
$filedata="";
foreach ($lines as $line){
	$filedata .= $line."\r\n";
}
$myFile = "files/batchfile".time().".txt";
$fh = fopen($myFile, 'w') or die("can't open file");
fwrite($fh, $filedata);
fclose($fh);
header('Content-type: text/plain');
header('Content-Disposition: attachment; filename="batchfile.txt"');
readfile($myFile);
?>