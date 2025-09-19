<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

if (!isset($_SESSION["logged_in"])) {
    header("Location: ../login");
    exit();
}

require_once("db_connection.php");
$db_connection = establish_db_connection("tictactoe database");

header('Content-Type: application/json');


$game_id = bin2hex(random_bytes(8) . random_bytes(8));


$db_query = "SELECT game_id FROM ultimatetictactoe_games WHERE game_id LIKE ? LIMIT 1";
$db_parameters = [$game_id];
$db_parameter_types = "s";
$db_results = db_get_query_results($db_connection, $db_query, $db_parameters, $db_parameter_types);


if (isset($_SESSION["db_connection_error"])) {
    echo json_encode(['status' => 'error', 'status_message' => 'Database connection error: ' . $_SESSION["db_connection_error"]]);
    exit();
}


if ($db_results && mysqli_num_rows($db_results) > 0) {
    echo json_encode(['status' => 'error', 'status_message' => 'Game ID already exists.']);
    exit();
}


$db_query = "INSERT INTO ultimatetictactoe_games (game_id) VALUES (?)";
$db_parameters = [$game_id];
$db_parameter_types = "s";
$db_result = db_get_query_results($db_connection, $db_query, $db_parameters, $db_parameter_types);


if (isset($_SESSION["db_connection_error"])) {
    echo json_encode(['status' => 'error', 'status_message' => 'Database connection error: ' . $_SESSION["db_connection_error"]]);
    exit();
}


if (!$db_result) {
    echo json_encode(['status' => 'error', 'status_message' => 'Failed to create a new game.']);
    exit();
}

echo json_encode(['status' => 'success', 'status_message' => 'New game created successfully.', 'game_id' => $game_id]);
