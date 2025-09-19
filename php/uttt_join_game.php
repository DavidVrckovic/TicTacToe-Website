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

$game_id = $_GET["gameID"];


$db_query = "SELECT user_x_id, user_x_last_online, user_o_id, user_o_last_online, user_x_score, user_o_score, game_start_time, game_end_time, game_state FROM ultimatetictactoe_games WHERE game_id LIKE ?";
$db_parameters = [$game_id];
$db_parameter_types = "s";
$db_results = db_get_query_results($db_connection, $db_query, $db_parameters, $db_parameter_types);


if (isset($_SESSION["db_connection_error"])) {
    echo json_encode(['status' => 'error', 'status_message' => 'Database connection error: ' . $_SESSION["db_connection_error"]]);
    exit();
}


if (!($db_results && mysqli_num_rows($db_results) > 0)) {
    echo json_encode(['status' => 'error', 'status_message' => 'Unknown game ID.']);
    exit();
}


$db_results = mysqli_fetch_assoc($db_results);
$user_x_id = $db_results["user_x_id"];
$user_x_last_online = $db_results["user_x_last_online"];
$user_o_id = $db_results["user_o_id"];
$user_o_last_online = $db_results["user_o_last_online"];


if ($db_results["game_end_time"] !== null) {
    echo json_encode(['status' => 'error', 'status_message' => 'This game has already ended.']);
    exit();
} // TO EDIT


function start_game_timer($db_connection, $game_id)
{
    $db_query = "UPDATE ultimatetictactoe_games SET game_start_time = ? WHERE game_id LIKE ?";
    $db_parameters = [date("Y-m-d H:i:s"), $game_id];
    $db_parameter_types = "ss";
    $db_result = db_get_query_results($db_connection, $db_query, $db_parameters, $db_parameter_types);

    if (isset($_SESSION["db_connection_error"])) {
        echo json_encode(['status' => 'error', 'status_message' => 'Database connection error: ' . $_SESSION["db_connection_error"]]);
        exit();
    }

    if (!$db_result) {
        echo json_encode(['status' => 'error', 'status_message' => 'Saving the game start time failed.']);
        exit();
    }
}


if ($user_x_id === null) {
    $user_x_id = $_SESSION["user_id"];

    $db_query = "UPDATE ultimatetictactoe_games SET user_x_id = ?, user_x_last_online = ? WHERE game_id LIKE ?";
    $db_parameters = [$user_x_id, date("Y-m-d H:i:s"), $game_id];
    $db_parameter_types = "iss";
    $db_result = db_get_query_results($db_connection, $db_query, $db_parameters, $db_parameter_types);

    if (isset($_SESSION["db_connection_error"])) {
        echo json_encode(['status' => 'error', 'status_message' => 'Database connection error: ' . $_SESSION["db_connection_error"]]);
        exit();
    }

    if (!$db_result) {
        echo json_encode(['status' => 'error', 'status_message' => 'Saving the player X failed.']);
        exit();
    }

    if ($db_results["game_start_time"] === null && $user_o_id !== null && strtotime($user_o_last_online) < time() - 5) {
        start_game_timer($db_connection, $game_id);
    }

    echo json_encode(['status' => 'success', 'status_message' => 'You joined as player X.', 'user_mark' => 'x', 'game_state' => $db_results["game_state"]]);
    exit();
} elseif ($user_x_id === $_SESSION["user_id"] && strtotime($user_x_last_online) < time() - 5) {
    $db_query = "UPDATE ultimatetictactoe_games SET user_x_last_online = ? WHERE game_id LIKE ?";
    $db_parameters = [date("Y-m-d H:i:s"), $game_id];
    $db_parameter_types = "ss";
    $db_result = db_get_query_results($db_connection, $db_query, $db_parameters, $db_parameter_types);

    if (isset($_SESSION["db_connection_error"])) {
        echo json_encode(['status' => 'error', 'status_message' => 'Database connection error: ' . $_SESSION["db_connection_error"]]);
        exit();
    }

    if (!$db_result) {
        echo json_encode(['status' => 'error', 'status_message' => 'Saving the player X\'s last online time failed.']);
        exit();
    }

    if ($db_results["game_start_time"] === null && $user_o_id !== null && strtotime($user_o_last_online) < time() - 5) {
        start_game_timer($db_connection, $game_id);
    }

    echo json_encode(['status' => 'success', 'status_message' => 'You joined as player X.', 'user_mark' => 'x', 'game_state' => $db_results["game_state"]]);
    exit();
} elseif ($user_o_id === null) {
    $user_o_id = $_SESSION["user_id"];

    $db_query = "UPDATE ultimatetictactoe_games SET user_o_id = ?, user_o_last_online = ? WHERE game_id LIKE ?";
    $db_parameters = [$user_o_id, date("Y-m-d H:i:s"), $game_id];
    $db_parameter_types = "iss";
    $db_result = db_get_query_results($db_connection, $db_query, $db_parameters, $db_parameter_types);

    if (isset($_SESSION["db_connection_error"])) {
        echo json_encode(['status' => 'error', 'status_message' => 'Database connection error: ' . $_SESSION["db_connection_error"]]);
        exit();
    }

    if (!$db_result) {
        echo json_encode(['status' => 'error', 'status_message' => 'Saving the player O failed.']);
        exit();
    }

    if ($db_results["game_start_time"] === null && $user_x_id !== null && strtotime($user_x_last_online) < time() - 5) {
        start_game_timer($db_connection, $game_id);
    }

    echo json_encode(['status' => 'success', 'status_message' => 'You joined as player O.', 'user_mark' => 'o', 'game_state' => $db_results["game_state"]]);
    exit();
} elseif ($user_o_id === $_SESSION["user_id"] && strtotime($user_o_last_online) < time() - 5) {
    $db_query = "UPDATE ultimatetictactoe_games SET user_o_last_online = ? WHERE game_id LIKE ?";
    $db_parameters = [date("Y-m-d H:i:s"), $game_id];
    $db_parameter_types = "ss";
    $db_result = db_get_query_results($db_connection, $db_query, $db_parameters, $db_parameter_types);

    if (isset($_SESSION["db_connection_error"])) {
        echo json_encode(['status' => 'error', 'status_message' => 'Database connection error: ' . $_SESSION["db_connection_error"]]);
        exit();
    }

    if (!$db_result) {
        echo json_encode(['status' => 'error', 'status_message' => 'Saving the player O\'s last online time failed.']);
        exit();
    }

    if ($db_results["game_start_time"] === null && $user_x_id !== null && strtotime($user_x_last_online) < time() - 5) {
        start_game_timer($db_connection, $game_id);
    }

    echo json_encode(['status' => 'success', 'status_message' => 'You joined as player O.', 'user_mark' => 'o', 'game_state' => $db_results["game_state"]]);
    exit();
} else {
    echo json_encode(['status' => 'success', 'status_message' => 'You joined as a spectator.', 'user_mark' => 'Spectator']);
    exit();
}




// header('Content-Type: application/json');
// $playersFile = '../Protected/game_players.json';

// // Load current players
// $players = [];
// if (file_exists($playersFile)) {
//     $players = json_decode(file_get_contents($playersFile), true) ?: [];
// }

// // Assign player ID
// if (!in_array('X', $players)) {
//     $players[] = 'X';
//     $playerId = 'X';
// } elseif (!in_array('O', $players)) {
//     $players[] = 'O';
//     $playerId = 'O';
// } else {
//     // Game full
//     echo json_encode(['error' => 'Game is full']);
//     exit;
// }

// // Save updated players list
// file_put_contents($playersFile, json_encode($players));

// // Respond with assigned player ID
// echo json_encode(['playerId' => $playerId]);
