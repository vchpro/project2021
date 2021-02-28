<?php 
require 'lib/rb.php';
R::setup( 'mysql:host=127.0.0.1;dbname=root','root', 'root' ); 

if ( !R::testconnection() )
{
	exit ('Нет соединения с базой данных');
}

session_start();

$user;

if (isset($_SESSION['logged_user']) ) {
     $user = R::findOne('users', 'auth = ?', array($_SESSION['logged_user']));
     if (! $user ) {
     	// Critical error
     	unset($_SESSION['logged_user']);
     }
}