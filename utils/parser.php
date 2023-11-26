<?php

/**
 * mengambil dan mengubah post data menjadi string
 */
function post_str($data)
{
    if (!isset($_POST[$data])) {
        error_response(400, sprintf("mohon isi data %s", $data));
    }

    return $_POST[$data];
}

/**
 * mengambil dan mengubah post data menjadi integer
 */
function post_int($data)
{
    if (!isset($_POST[$data])) {
        error_response(400, sprintf("mohon isi data %s", $data));
    }

    return intval($_POST[$data]);
}


/**
 * mengambil dan mengubah post data menjadi boolean
 */
function post_bool($data)
{
    if (!isset($_POST[$data])) {
        error_response(400, sprintf("mohon isi data %s", $data));
    }

    return filter_var('on', FILTER_VALIDATE_BOOLEAN);
}
