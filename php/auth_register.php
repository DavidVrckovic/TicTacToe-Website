<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

if (isset($_SESSION["logged_in"])) {
    header("Location: ../");
    exit();
}

require_once("db_connection.php");
require_once("session_token_generation.php");


if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../register");
    exit();
}


if (!isset($_POST["user_username"], $_POST["user_email"], $_POST["user_password"], $_POST["user_repeated_password"])) {
    header("Location: ../register/?error=empty_inputs");
    exit();
}


if ($_POST["user_password"] !== $_POST["user_repeated_password"]) {
    header("Location: ../register/?error=passwords_do_not_match");
    exit();
}


$db_connection = establish_db_connection("tictactoe database");


$db_query = "SELECT user_id FROM users WHERE user_email LIKE ? LIMIT 1";
$db_parameters = [$_POST["user_email"]];
$db_parameter_types = "s";
$db_results = db_get_query_results($db_connection, $db_query, $db_parameters, $db_parameter_types);


if (isset($_SESSION["db_connection_error"])) {
    header("Location: ../register/?error=db_connection&error_identifier=S1");
    exit();
}


if ($db_results && mysqli_num_rows($db_results) > 0) {
    header("Location: ../register/?error=email_already_exists");
    exit();
}


$encrypted_password = "\$SHA#" . hash("sha256", hash("sha256", $_POST["user_password"]) . "\$256x2#");
$current_timestamp = date("Y-m-d H:i:s");


$db_query = "INSERT INTO users (user_username, user_email, user_password, user_last_login, user_reg_date) VALUES (?, ?, ?, ?, ?)";
$db_parameters = [$_POST["user_username"], $_POST["user_email"], $encrypted_password, $current_timestamp, $current_timestamp];
$db_parameter_types = "sssss";
$db_result = db_get_query_results($db_connection, $db_query, $db_parameters, $db_parameter_types);


if (isset($_SESSION["db_connection_error"])) {
    header("Location: ../register/?error=db_connection&error_identifier=I1");
    exit();
}


if (!$db_result) {
    header("Location: ../register/?error=registration_failed");
    exit();
}


$db_query = "SELECT user_id, user_username, user_email, user_last_login, user_reg_date FROM users WHERE user_email LIKE ? LIMIT 1";
$db_parameters = [$_POST["user_email"]];
$db_parameter_types = "s";
$db_results = db_get_query_results($db_connection, $db_query, $db_parameters, $db_parameter_types);


if (isset($_SESSION["db_connection_error"])) {
    header("Location: ../login/?error=db_connection&error_identifier=S2");
    exit();
}


if (!($db_results && mysqli_num_rows($db_results) > 0)) {
    header("Location: ../login/?error=registration_check_failed");
    exit();
}


$db_data = mysqli_fetch_assoc($db_results);


session_regenerate_id();
$_SESSION["logged_in"] = true;
$_SESSION["user_id"] = $db_data["user_id"];
$_SESSION["user_username"] = $db_data["user_username"];
$_SESSION["user_email"] = $db_data["user_email"];
$_SESSION["user_last_login"] = $db_data["user_last_login"];
$_SESSION["user_reg_date"] = $db_data["user_reg_date"];
$_SESSION["db_connection_error"] = null;


if (!isset($_POST["user_remember_me"])) {
    header("Location: ../");
    exit();
}


generate_session_token($db_connection, $current_timestamp);


mysqli_close($db_connection);


header("Location: ../");
exit();
