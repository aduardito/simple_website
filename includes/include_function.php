<?php
function sanitazeString($check_sentence){
	$value = trim($check_sentence);
	if (!preg_match('/^[a-zA-Z\s]+/', $value)){
		$value = "errorrr";
	}
	return $value;
}
function sanitazePassword($check_pass){
	if (!preg_match('/^[a-zA-Z\s\-_0-9]+/', $check_pass)){
		$check_pass = "";
	}
	return $check_pass;
}

function sanitazeEmail($check_email){
	if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$check_email)) {
		$check_email = "email";
	}
	return $check_email;
}

function sanitazeNumber($check_number){
	if(!preg_match('/^[69][0-9]{8}$/', $check_number)){
		$check_number = 0;
	}	
	return $check_number;
}
