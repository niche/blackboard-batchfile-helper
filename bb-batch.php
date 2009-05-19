<?php
/**
 * 
 * Blackboard Batch file helper	
 * @author Ian McNaught http://twitter.com/ianmcnaught
 **/

function __autoload($class_name) {
    require_once "classes/class.".$class_name . '.php';
}

class batchcreate extends processtext
{
	function users($users){
		/**
		 * takes each user line, and converts it to an AD username in the format: U0123456
		 * input formats can be any of the following:
		 * u0123456 (complete)
		 * 0123456 (ASIS without revision number)
		 * 0123456/1 (ASIS with revision number)
		 */
		$users = $this->text2array(trim($users));
		foreach ($users as $key => $user){
			if (is_numeric(substr($user,0,1))){//if the "u" prefix doesn't exist, add it
				$user = "u".trim($user);
			}
			if (strrchr($user,"/")){//if there is a revision number (e.g. /1) split by "/" and take the first portion
				$usertemp = explode("/",$user);
				$user = trim($usertemp[0]);
			}
			$newuser[$key] = trim($user);
		}
		return $newuser;
	}
	
	function modules($modules,$yearcode=null){
		/**
		 * adds yearcode to modules where appropriate and trims whitespace from module codes
		 */
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
$myFile = "files/batchfile".time().".txt";//where to archive the files to (must have write permissions)
$fh = fopen($myFile, 'w') or die("can't open file");
fwrite($fh, $filedata);
fclose($fh);
header('Content-type: text/plain');//output the file to the browser
header('Content-Disposition: attachment; filename="batchfile.txt"');
readfile($myFile);
?>