<?php

$name = "Tic \"Tac\" Toe 'Ultimate' Yes 1";
$name2 = "Tic \"Tac\" Toe 'Ultimate' Yes 2";
$name3 = "Tic \"Tac\" Toe 'Ultimate' Yes 3";
$name_json = json_encode($name);
$name2_json = json_encode(["name" => $name2]);
$name3_json = json_encode(["name" => $name, "name2" => $name2]);

header("Content-Type: application/json");

echo $name3_json . "<br>";
echo json_decode($name2_json, true)["name"] . "<br><br>";

echo json_encode(['status' => 'error', 'status_message' => 'Saving the player failed.']) . "<br><br>" . json_encode(['status2' => 'error2', 'status_message2' => '2IJe3nnndj']) . "<br><br>";







if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo $_SERVER['REQUEST_METHOD'] . "<br>" . print_r($_POST, true) . "<br>" . $_POST["test"] . "<br><br>";
    echo print_r($_GET, true) . "<br>" . $_GET["test"] . "<br><br>";
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo $_SERVER['REQUEST_METHOD'] . "<br>" . print_r($_GET, true) . "<br>" . $_GET["test"] . "<br><br>";
}



?>

<form action="" id="register_form" method="POST">

    <label class="input_title" for="input_password">
        Lozinka
    </label>
    <input class="input_field" id="input_password" name="test" autocomplete="new-password" placeholder="Enter a password">

    <button class="authenticate" id="register" type="submit">
        Registriraj se
    </button>


</form>