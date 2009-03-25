<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<title>Blackboard Batch file helper</title>
	<style type="text/css" media="screen">
		html {
			font-family: Arial, "MS Trebuchet", sans-serif;
		}
		#users, #modules {
			width: 25%;
			float: left;
		}
		#mainform, #options {
			width: 100%;
			clear: both;
		}
	</style>
</head>
<body id="index">
	<h1>Blackboard Batch file helper</h1>
	<h2>Instructions</h2>
	<p style="width: 70%">This script will create a batch file to enrol all user names in the left column (one per line) onto all the modules listed in the right hand column (one per line).</p>

	<p>User names can be staff format (e.g. smusim), AD student format (e.g. u0000001) or ASIS format (e.g. 0000001/1, with or without the /[number] at the end)</p>
	<form action="bb-batch.php" method="post" accept-charset="utf-8">	
	<div id='mainform'>
		<div id="users">
			Enrole these users...<br>
			<textarea name="users" rows="20" cols="20"></textarea>
		</div>

		<div id="modules">
			...onto these modules<br>
			<textarea name="modules" rows="20" cols="20"></textarea>
		</div>
	</div>
	<div id="options">
		<h2>Year Code</h2>
		What to add when year code is not present in module code:<br>
		<?php
		$year = date('Y');
		$thisyear = date('y');
		$nextyear = date('y', mktime(0, 0, 0, 0, 0, $year+2));
		$lastyear = date('y', mktime(0, 0, 0, 0, 0, $year));
		$yearcode1 = "-".$lastyear.$thisyear;
		$yearcode2 = "-".$thisyear.$nextyear;			
		?>
		<input type="radio" name="yearcode" value="nothing" checked> Nothing<br>
		<input type="radio" name="yearcode" value="<?=$yearcode1?>"> <?=$yearcode1?><br>
		<input type="radio" name="yearcode" value="<?=$yearcode2?>"> <?=$yearcode2?>
		<h2 >Access Level</h2>
		<select name="access" id="access">
  			<option value ="S">Student</option>
  			<option value ="T">Teaching Assistant</option>
  			<option value ="P">Instructor</option>
  			<option value ="B">Course Builder</option>
  			<option value ="G">Grader</option>
  			<option value ="U">Guest</option>
		</select>
		<p>
		<input type="submit" name="submit" value="Generate Batch file" id="submit">
		</p>
</div>
	</form>	
</body>
</html>