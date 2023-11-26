<?php

/*
    fungsi untuk menangani error tidak terduga
*/
function myErrorHandler($errno, $errstr, $errfile, $errline)
{
    // menghilangkan karakter spesial
    $errstr = htmlspecialchars($errstr);

    // internal error
    switch ($errno) {
        case E_USER_ERROR:
            $msg = "";
            $msg = $msg . "<b>ERROR</b> [$errno] $errstr<br />\n";
            $msg = $msg . "  Fatal error on line $errline in file $errfile";
            $msg = $msg . ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
            $msg = $msg . "Aborting...<br />\n";
            error_response(500, $msg);
    }

    // tidak mengeksekusi internal error
    return true;
}

function json_response($data)
{
    // membalikan data berbentuk json
    echo json_encode($data);
}

function error_response($code, $message)
{
    // menyusun format error
    $response = [
        "code" => $code,
        "message" => $message,
    ];

    // mengembalikan error json
    json_response($response);
    exit(1);
}

set_error_handler("myErrorHandler");
