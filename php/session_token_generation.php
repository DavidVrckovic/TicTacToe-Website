<?php

function generate_session_token(mysqli $db_connection, string $current_timestamp)
{
    if (isset($_COOKIE["session_token"])) {
        header("Location: ../");
        exit();
    }


    $session_token = random_bytes(64);
    $encrypted_session_token = "\$RB#\$SHA#" . hash("sha256", hash("sha256", $session_token) . "\$256x2#\$64#");
    $session_token_expire_unixTimestamp = time() + 60 * 60 * 24 * 30;
    $session_token_expire_timestamp = date("Y-m-d H:i:s", $session_token_expire_unixTimestamp);


    $db_query = "SELECT user_id FROM users WHERE user_email LIKE ? LIMIT 1";
    $db_parameters = [$_SESSION["user_email"]];
    $db_parameter_types = "s";
    $db_results = db_get_query_results($db_connection, $db_query, $db_parameters, $db_parameter_types);


    if (isset($_SESSION["db_connection_error"])) {
        header("Location: ../login/?error=db_connection");
        exit();
    }


    if (!($db_results && mysqli_num_rows($db_results) > 0)) {
        header("Location: ../login/?error=session_registration_check_failed");
        exit();
    }


    $db_results = mysqli_fetch_array($db_results)[0];


    $db_query = "INSERT INTO user_sessions (user_id, session_token, session_create_date, session_expire_date) VALUES (?, ?, ?, ?)";
    $db_parameters = [$db_results, $encrypted_session_token, $current_timestamp, $session_token_expire_timestamp];
    $db_parameter_types = "isss";
    $db_result = db_get_query_results($db_connection, $db_query, $db_parameters, $db_parameter_types);


    if (isset($_SESSION["db_connection_error"])) {
        header("Location: ../login/?error=db_connection");
        exit();
    }


    if (!$db_result) {
        header("Location: ../login/?error=session_registration_failed");
        exit();
    }


    setcookie("session_token", bin2hex($session_token), $session_token_expire_unixTimestamp, "/");
}
