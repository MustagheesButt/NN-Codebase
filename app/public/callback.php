<?php
	require("../includes/config.php");

	$data_to_send = [
		'user_id' => (int)$_POST['id'],
		'email' => $_POST['email'],
		'full_name' => $_POST['first_name'] . ($_POST['middle_name'] == '' ? ' ' : ' ' . $_POST['middle_name'] . ' ') . $_POST['last_name'],
		'profile_pic' => '',
		'about' => 'About you...'
	];

	login_or_register($data_to_send, $_POST['sess_id']);
?>