<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

if (!isset($_SESSION["logged_in"])) {
    header("Location: ../login");
    exit();
}

require_once("db_connection.php");
$db_connection = establish_db_connection("tictactoe database");

header('Content-Type: application/json');


if (!isset($_GET["gameID"])) {
    echo json_encode(['status' => 'error', 'status_message' => 'No game ID provided.']);
    exit();
}

if (!isset($_GET["invitee_id"], $_GET["invitee_username"])) {
    echo json_encode(['status' => 'error', 'status_message' => 'No user ID provided.']);
    exit();
}

$game_id = $_GET["gameID"];
$invitee_id = $_GET["invitee_id"];
$invitee_username = $_GET["invitee_username"];


$db_query = "INSERT INTO user_invites (user_inviter_id, user_invitee_id, game_id) VALUES (?, ?, ?)";
$db_parameters = [$_SESSION["user_id"], $invitee_id, $game_id];
$db_parameter_types = "iis";
$db_result = db_get_query_results($db_connection, $db_query, $db_parameters, $db_parameter_types);


if (isset($_SESSION["db_connection_error"])) {
    echo json_encode(['status' => 'error', 'status_message' => 'Database connection error: ' . $_SESSION["db_connection_error"]]);
    exit();
}


if (!$db_result) {
    echo json_encode(['status' => 'error', 'status_message' => 'No user found with ID: ' . $invitee_id]);
    exit();
}


echo json_encode(['status' => 'success', 'status_message' => 'User ' . $invitee_username . ' invited to the game!']);
