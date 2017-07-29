<?php
		include ("dbConnect.php");
		
		$fullname=$_POST["fullname"];
		$email=$_POST["email"];
		$password=$_POST["password"];
		
		$password = md5($password);
	
		$dbQuery=$db->prepare("insert into fl_users values (null,:name,:email,:pass)");
		$dbParams=array('name'=>$fullname,'email'=>$email,'pass'=>$password);
		$dbQuery->execute($dbParams);
		
		session_start();
   
		$_SESSION["message"]=1;
		
		header("Location: home.php");
		
?>