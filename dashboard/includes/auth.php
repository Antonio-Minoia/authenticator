<?php

if (isset(getallheaders()['authorization'])) {
	$session_id = getallheaders()['authorization'];
} else {
	$session_id = getallheaders()['Authorization'];
}

session_id($session_id);
session_start();

if (!isset($_SESSION['user'])) {
	http_response_code(401);
	echo json_encode(['success' => false, 'error' => 'unauthorized', 'token' => $session_id],  JSON_INVALID_UTF8_SUBSTITUTE);
	die();
}

function getLevel()
{
	return $_SESSION['user']['livello'];
}

function checkLevel(int $desired)
{
	$perm = $_SESSION['user']['livello'];
	if ($perm < $desired) {
		http_response_code(406);
		echo json_encode(['success' => false, 'error' => 'permessi insufficienti', 'permessi' => $perm],  JSON_INVALID_UTF8_SUBSTITUTE);
		die();
	}
}
