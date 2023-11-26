<?php
include_once("utils/response.php");

// set content-type header
header('Content-type: application/json');

// memastikan server atau program jalan meskipun tanpa menggunakan koneksi db
$health = ["name" => "User Service"];

json_response($health);
