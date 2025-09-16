<!DOCTYPE html>

<?php
$directory_prefix = "../";
require_once($directory_prefix . "php/main.php");

if (!isset($_SESSION["logged_in"])) {
    header("Location: ../login");
    exit();
}
?>

<html lang="en">


<head>
    <!-- Meta tags -->
    <meta charset="UTF-8">
    <meta name="author" content="David">
    <meta name="description" content="A website where you can play Tic Tac Toe">
    <meta name="keywords" content="Tic Tac Toe, Noughts and Crosses, Xs and Os, Game, Play">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Title & Favicon -->
    <title> Tic Tac Toe | Account </title>
    <link href="<?= $favicon_url ?>" rel="icon" type="image/svg+xml">

    <!-- CSS files -->
    <link href="<?= $index_css_url ?>" rel="stylesheet" type="text/css">
    <link href="<?= $navigation_css_url ?>" rel="stylesheet" type="text/css">
    <link href="<?= $footer_css_url ?>" rel="stylesheet" type="text/css">

    <!-- Script files -->
    <script defer src="<?= $main_script_url ?>"></script>
    <script defer src="<?= $navigation_script_url ?>"></script>
</head>



<body>

    <!-- Header & Navigation -->
    <?php
    include_once($header_php_url);
    ?>


    <!-- MAIN -->
    <main class="cflex">

        <section class="cflex has_bg_color" id="main_section">

            <article class="general">

                <h2 class="title">
                    Account
                </h2>

                <p class="text">
                    Username: <?= $_SESSION["user_username"] ?>
                </p>

                <p class="text">
                    Email: <?= $_SESSION["user_email"] ?>
                </p>

                <p class="text">
                    Last login: <?= $_SESSION["user_last_login"] ?>
                </p>

                <p class="text">
                    Registration date: <?= $_SESSION["user_reg_date"] ?>
                </p>

            </article>

            <article class="general">

                <h2 class="title">
                    Active games
                </h2>

                <?php
                $db_connection = establish_db_connection("tictactoe database");

                function getUsername($user_id, $db_connection)
                {
                    if (!$user_id) return;
                    $db_query = "SELECT user_username FROM users WHERE user_id = ?";
                    $db_parameters = [$user_id];
                    $db_parameter_types = "i";
                    $db_results = db_get_query_results($db_connection, $db_query, $db_parameters, $db_parameter_types);
                    return $db_results ? mysqli_fetch_array($db_results)[0] : false;
                }

                $db_query = "SELECT game_id, game_state, user_x_id, user_o_id FROM ultimatetictactoe_games WHERE user_x_id = ? OR user_o_id = ?";
                $db_parameters = [$_SESSION["user_id"], $_SESSION["user_id"]];
                $db_parameter_types = "ii";
                $db_results = db_get_query_results($db_connection, $db_query, $db_parameters, $db_parameter_types);

                if ($db_results && mysqli_num_rows($db_results) > 0) {
                    echo '<ul class="active_list">';
                    while ($row = mysqli_fetch_assoc($db_results)) {
                        echo '<li>';
                        echo 'Game against: ' . htmlspecialchars(getUsername($row['user_o_id'], $db_connection));
                        echo ' <a href="../play/ultimatetictactoe/?gameID=' . urlencode($row['game_id']) . '">Join</a>';
                        echo '</li>';
                    }
                    echo '</ul>';
                } else {
                    echo '<p class="text">No active games found.</p>';
                }
                ?>

            </article>

            <article class="general">

                <h2 class="title">
                    Invites
                </h2>

                <?php
                $db_query = "SELECT user_inviter_id, game_id FROM user_invites WHERE user_invitee_id = ?";
                $db_parameters = [$_SESSION["user_id"]];
                $db_parameter_types = "i";
                $db_results = db_get_query_results($db_connection, $db_query, $db_parameters, $db_parameter_types);

                if ($db_results && mysqli_num_rows($db_results) > 0) {
                    echo '<ul class="active_list">';
                    while ($row = mysqli_fetch_assoc($db_results)) {
                        echo '<li>';
                        echo 'Invited by: ' . htmlspecialchars(getUsername($row['user_inviter_id'], $db_connection));
                        echo ' <a href="../play/ultimatetictactoe/?gameID=' . urlencode($row['game_id']) . '">Join</a>';
                        echo '</li>';
                    }
                    echo '</ul>';
                } else {
                    echo '<p class="text">No active invites found.</p>';
                }

                mysqli_close($db_connection);
                ?>

            </article>

        </section>

    </main>


    <!-- Footer -->
    <?php
    include_once($footer_php_url);
    ?>

</body>

</html>