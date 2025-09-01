<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

if (isset($_SESSION["logged_in"])) {
    header("Location: ../");
    exit();
}

require_once("db_connection.php");
require_once("session_token_generation.php");


if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../login");
    exit();
}


if (!isset($_POST["user_email"], $_POST["user_password"])) {
    header("Location: ../login/?error=empty_inputs");
    exit();
}


$db_connection = establish_db_connection("tictactoe database");


$db_query = "SELECT * FROM users WHERE user_email LIKE ? LIMIT 1";
$db_parameters = [$_POST["user_email"]];
$db_parameter_types = "s";
$db_results = db_get_query_results($db_connection, $db_query, $db_parameters, $db_parameter_types);


if (isset($_SESSION["db_connection_error"])) {
    header("Location: ../login/?error=db_connection&error_identifier=S1");
    exit();
}


if (!($db_results && mysqli_num_rows($db_results) > 0)) {
    header("Location: ../login/?error=unknown_email");
    exit();
}


$db_data = mysqli_fetch_assoc($db_results);


$encrypted_password = "\$SHA#" . hash("sha256", hash("sha256", $_POST["user_password"]) . "\$256x2#");


if ($encrypted_password !== $db_data["user_password"]) {
    header("Location: ../login/?error=wrong_password");
    exit();
}


$current_timestamp = date("Y-m-d H:i:s");


$db_query = "UPDATE users SET user_last_login = ? WHERE user_id LIKE ?";
$db_parameters = [$current_timestamp, $db_data["user_id"]];
$db_parameter_types = "si";
$db_result = db_get_query_results($db_connection, $db_query, $db_parameters, $db_parameter_types);


if (isset($_SESSION["db_connection_error"])) {
    header("Location: ../login/?error=db_connection&error_identifier=U1");
    exit();
}


if (!$db_result) {
    header("Location: ../login/?error=last_login_date_save_failed");
    exit();
}


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
