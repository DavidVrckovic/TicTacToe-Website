<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

if (!isset($_SESSION["logged_in"])) {
    header("Location: ../login");
    exit();
}

require_once("db_connection.php");
$db_connection = establish_db_connection("tictactoe database");

header('Content-Type: application/json');


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_GET["gameID"])) {
        echo json_encode(['status' => 'error', 'status_message' => 'No game ID provided.']);
        exit();
    }
    $game_id = $_GET["gameID"];

    $game_state = json_decode(file_get_contents('php://input'), true);

    $db_query = "UPDATE ultimatetictactoe_games SET game_state = ?, user_x_score = ?, user_o_score = ? WHERE game_id LIKE ?";
    $db_parameters = [json_encode($game_state), $game_state['xScore'], $game_state['oScore'], $game_id];
    $db_parameter_types = "siis";
    $db_result = db_get_query_results($db_connection, $db_query, $db_parameters, $db_parameter_types);

    if (isset($_SESSION["db_connection_error"])) {
        echo json_encode(['status' => 'error', 'status_message' => 'Database connection error: ' . $_SESSION["db_connection_error"]]);
        exit();
    }

    if (!$db_result) {
        echo json_encode(['status' => 'error', 'status_message' => 'Saving the game state failed.']);
        exit();
    }

    echo json_encode(['status' => 'success', 'status_message' => 'Game state saved successfully.']);
    exit();
} else if (isset($_GET["gameID"], $_GET["userMark"])) {
    $game_id = $_GET["gameID"];
    $user_mark = $_GET["userMark"];

    $db_query = "SELECT * FROM ultimatetictactoe_games WHERE game_id LIKE ? LIMIT 1";
    $db_parameters = [$game_id];
    $db_parameter_types = "s";
    $db_results = db_get_query_results($db_connection, $db_query, $db_parameters, $db_parameter_types);

    if (isset($_SESSION["db_connection_error"])) {
        echo json_encode(['status' => 'error', 'status_message' => 'Database connection error: ' . $_SESSION["db_connection_error"]]);
        exit();
    }

    if (!($db_results && mysqli_num_rows($db_results) > 0)) {
        echo json_encode(['status' => 'error', 'status_message' => 'No game found with the provided ID.']);
        exit();
    }

    $db_data = mysqli_fetch_assoc($db_results);

    if ($user_mark === "x") {
        $user_mark_column = "user_x_id";
        $user_mark_last_online_column = "user_x_last_online";
    } else if ($user_mark === "o") {
        $user_mark_column = "user_o_id";
        $user_mark_last_online_column = "user_o_last_online";
    } else {
        if ($db_data["game_state"] === null) {
            echo json_encode(['status' => 'error', 'status_message' => 'No game state found.']);
            exit();
        }
        echo $db_data["game_state"];
        exit();
    }

    $current_timestamp = date("Y-m-d H:i:s");
    $db_query = "UPDATE ultimatetictactoe_games SET " . $user_mark_last_online_column . " = ? WHERE " . $user_mark_column . " LIKE ?";
    $db_parameters = [$current_timestamp, $_SESSION["user_id"]];
    $db_parameter_types = "si";
    $db_result = db_get_query_results($db_connection, $db_query, $db_parameters, $db_parameter_types);

    if (isset($_SESSION["db_connection_error"])) {
        echo json_encode(['status' => 'error', 'status_message' => 'Database connection error: ' . $_SESSION["db_connection_error"]]);
        exit();
    }

    if (!$db_result) {
        echo json_encode(['status' => 'error', 'status_message' => 'Saving the player online status failed.']);
        exit();
    }

    // if ($user_mark === "x" && time() - strtotime($db_data["user_x_last_online"]) < 2) {
    //     echo json_encode(['status' => 'success', 'status_message' => 'Player X is offline.']);
    // } else if ($user_mark === "o" && time() - strtotime($db_data["user_o_last_online"]) < 2) {
    //     echo json_encode(['status' => 'success', 'status_message' => 'Player O is offline.']);
    // }

    if ($db_data["game_state"] === null) {
        echo json_encode(['status' => 'error', 'status_message' => 'No game state found.']);
        exit();
    }

    echo $db_data["game_state"];
    exit();
}



// require_once("db_connection.php");
// header('Content-Type: application/json');
// $gameFile = '../Protected/game_state.json';

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $data = json_decode(file_get_contents('php://input'), true);
//     file_put_contents($gameFile, json_encode($data));
//     echo json_encode(['status' => 'saved']);
// } else {
//     if (file_exists($gameFile)) {
//         echo file_get_contents($gameFile);
//     } else {
//         echo json_encode(['status' => 'no game']);
//     }
// }