<?php

include_once "../utils/connection.php";
include_once "../utils/parser.php";

function get_users($c)
{
    $filter_active = null;
    $filter_login_count = null;
    $id = null;

    // mengambil query param
    if (isset($_GET['filter']["active"])) {
        $filter_active = $_GET["filter"]["active"] == 1 ? "1" : "0";
    }
    if (isset($_GET['filter']["loginMoreThan3"])) {
        $filter_login_count = $_GET["filter"]["loginMoreThan3"] == 1 ? true : false;
    }
    if (isset($_GET['id'])) {
        $id = (int) $_GET["id"];
    }

    // menyiapkan query
    $sql = "SELECT id, nim, name, loginCount, active from user_service.Users";

    // filter user yang active
    if (!is_null($filter_active)) {
        $sql = $sql . " WHERE active = " . $filter_active;
    }

    // filter user yang telah login > 3
    if (!is_null($filter_login_count) && $filter_login_count) {
        $whereptrn = "/WHERE/i";
        if (preg_match($whereptrn, $sql)) {
            $sql = $sql . " AND";
        } else {
            $sql = $sql . " WHERE";
        }

        $sql = $sql . " loginCount > 3";
    }

    // filter berdasarkan id
    if (!is_null($id)) {
        $whereptrn = "/WHERE/i";
        if (preg_match($whereptrn, $sql)) {
            $sql = $sql . " AND";
        } else {
            $sql = $sql . " WHERE";
        }

        $sql = $sql . " id = '" . $id . "'";
    }

    // eksekusi query
    $result = $c->query($sql);

    $users = [];
    if ($result->num_rows > 0) {
        // menyiapkan data user
        while ($row = $result->fetch_assoc()) {
            $row["loginCount"] = intval($row["loginCount"]);
            $row["active"] = intval($row["active"]) ? true : false;
            array_push($users, $row);
        }
    }

    json_response($users);
}

function post_users($c)
{
    // mengambil data form
    $nim = post_str("nim");
    $name = post_str("name");
    $login_count = post_int("loginCount");
    $active = post_bool("active");

    // menyiapkan query
    $sql = sprintf('INSERT INTO Users (nim, name, loginCount, active) VALUES ("%s", "%s", %s, %s)', $nim, $name, $login_count, $active);

    // eksekusi query
    $insert_success = $c->query($sql);

    // menangani error query
    if (!$insert_success) {
        error_response(500, sprintf("gagal menyimpan data: %s", $c->error));
    }

    json_response([
        "id" => $c->insert_id,
        "nim" => $nim,
        "name" => $name,
        "loginCount" => $login_count,
        "active" => $active ? true : false
    ]);
}

switch ($_SERVER["REQUEST_METHOD"]) {
    case "POST":
        post_users($conn);
        break;
    case "GET":
        get_users($conn);
        break;
    default:
        error_response(404, "metode request tidak sah");
}
