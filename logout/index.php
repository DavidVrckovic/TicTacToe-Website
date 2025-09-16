<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

$directory_prefix = "../";
require_once($directory_prefix . "php/db_connection.php");


if (isset($_SESSION["logged_in"])) {
    session_destroy();
} else {
    session_regenerate_id(true);
}

if (isset($_COOKIE['session_token'])) {

    $db_connection = establish_db_connection("tictactoe database");

    $encrypted_session_token = "\$RB#\$SHA#" . hash("sha256", hash("sha256", hex2bin($_COOKIE["session_token"])) . "\$256x2#\$64#");

    $db_query = "SELECT user_id FROM user_sessions WHERE session_token LIKE ? LIMIT 1";
    $db_parameters = [$encrypted_session_token];
    $db_parameter_types = "s";
    $db_results = db_get_query_results($db_connection, $db_query, $db_parameters, $db_parameter_types);

    if (isset($_SESSION["db_connection_error"])) {
        header("Location: ../?error=logout_db_connection");
        exit();
    }

    if (!($db_results && mysqli_num_rows($db_results) > 0)) {
        header("Location: ../?error=logout_invalid_session_token");
        exit();
    }

    $db_query = "DELETE FROM user_sessions WHERE session_token LIKE ? LIMIT 1";
    $db_parameters = [$encrypted_session_token];
    $db_parameter_types = "s";
    $db_result = db_get_query_results($db_connection, $db_query, $db_parameters, $db_parameter_types);

    if (isset($_SESSION["db_connection_error"])) {
        header("Location: ../?error=logout_db_connection");
        exit();
    }

    if (!$db_result) {
        header("Location: ../?error=logout_session_token_removal");
        exit();
    }

    setcookie("session_token", "", time() - 3600, "/");
    //unset($_COOKIE['session_token']);

    mysqli_close($db_connection);
}

header("Location: ../");
