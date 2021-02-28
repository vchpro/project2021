<?php 
	require 'db.php';
	unset($_SESSION['logged_user']);
	echo "<script>document.location.href = '/index.php';</script>";
?>
