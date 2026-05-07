<?php

$host = getenv('MYSQLHOST');
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');
$db   = getenv('MYSQLDATABASE');
$port = getenv('MYSQLPORT');

$koneksi = mysqli_connect($host, $user, $pass, $db, $port);

if (!$koneksi) {
    die(json_encode([
        "status" => "error",
        "message" => mysqli_connect_error()
    ]));
}
?>
