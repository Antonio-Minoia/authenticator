<?php
$connection = mysqli_connect("127.0.0.1:3306", "root", "root", "stlgroup");

$connection->options(MYSQLI_OPT_CONNECT_TIMEOUT, 10);


function db_disconnect()
{
    global $connection;
    mysqli_close($connection);
}
