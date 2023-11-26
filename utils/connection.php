<?php

include_once "../utils/response.php";

// menyiapkan kredensial
$db_host = "l-mysql-8";
$db_username = "root";
$db_password  = "root";
$db_port = 3306;
$db = "user_service";

// mengkoneksikan aplikasi dengan db
$conn = new mysqli($db_host, $db_username, $db_password, $db, $db_port);

// menangani error
if ($conn->connect_error) {
    $db_url = "mysql://" . $db_username . ":" . $db_password . "@" . $db_host . ":" . $db_port . "/" . $db . "<br />";
    error_response(500, $conn->connect_error . " - dbUrl: " . $db_url);
}

// set tipe konten menjadi json
header('Content-type: application/json');
