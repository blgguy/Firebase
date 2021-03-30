<?php
// include class file.
require_once('class.php');

//$obj = new Engine();
/**
//redirect if logged in
if (!$obj->im_logIn() || (trim ($obj->session()) == '')) {
	$obj->rd('logout.php');
}
**/
$projId = 'aikinow-web';
$view = get_all($projId);


foreach ($view as $key) {
	//if (!empty($user['lname'])) {
            printf('Last Name: %s' . PHP_EOL, $key['lname']);
            printf(PHP_EOL);
       // }
}
?>