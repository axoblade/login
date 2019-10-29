<?php
require_once 'core/init.php';
if(session::exists('home')){
	echo '<p>' . session::flash('home') . '</p>';
}
$user = new User();
if($user->isLoggedIn()){
	if($user->hasPermission('admin')){
		Redirect::to('files/admin/index.php');
	}
	if($user->hasPermission('fundi')){
		Redirect::to('fundi.php');
	}
	else{
	Redirect::to('client.php');
    }
}
else{
	Redirect::to('login.php');
}
