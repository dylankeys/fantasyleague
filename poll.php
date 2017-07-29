<?php
	
	include ("dbConnect.php");
	
	$user=$_POST["userid"];
	$option=$_POST["polloption"];

	$dbQuery=$db->prepare("insert into fl_poll_votes values (null,:user,:option)");
	$dbParams=array('user'=>$user,'option'=>$option);
	$dbQuery->execute($dbParams);

	$dbQuery=$db->prepare("update `fl_poll` set `votes`=`votes`+1 where `option`=:option");
	$dbParams=array('option'=>$option);
	$dbQuery->execute($dbParams);

	header("Location: home.php");

?>