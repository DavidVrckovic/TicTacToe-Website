<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

if (!isset($_SESSION["logged_in"])) {
    header("Location: ../login");
    exit();
}

require_once("db_connection.php");
$db_connection = establish_db_connection("tictactoe database");

header('Content-Type: application/json');


$searchTerm = $_GET['searchTerm'] ?? '';
if (strlen($searchTerm) < 3) {
    echo json_encode([]);
    exit;
}

$db_query = "SELECT user_id, user_username FROM users WHERE user_username LIKE ? LIMIT 10";
$db_parameters = [$searchTerm];
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


$users = [];
while ($row = mysqli_fetch_assoc($db_results)) {
    $users[] = [
        'user_id' => $row['user_id'],
        'user_username' => $row['user_username']
    ];
}

echo json_encode($users);
