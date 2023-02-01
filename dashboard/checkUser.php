<?php


$id = $_GET['id'];
session_id($id);
session_start();


if (isset($_SESSION['user'])) {
    echo json_encode($_SESSION['user'],  JSON_INVALID_UTF8_SUBSTITUTE);
} else {
    echo json_encode(false);
}
