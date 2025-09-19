<!DOCTYPE html>

<?php
$directory_prefix = "../../";
require_once($directory_prefix . "php/main.php");
$game_type = "local";
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
    <title> Tic Tac Toe | Play </title>
    <link href="<?= $favicon_url ?>" rel="icon" type="image/png">

    <!-- CSS files -->
    <link href="<?= $index_css_url ?>" rel="stylesheet" type="text/css">
    <link href="<?= $navigation_css_url ?>" rel="stylesheet" type="text/css">
    <link href="<?= $footer_css_url ?>" rel="stylesheet" type="text/css">
    <link href="<?= $tictactoe_css_url ?>" rel="stylesheet" type="text/css">

    <!-- Script files -->
    <script defer src="<?= $main_script_url ?>"></script>
    <script defer src="<?= $navigation_script_url ?>"></script>
    <script defer src="<?= $tictactoe_script_url ?>"></script>
</head>


<body>

    <!-- Header & Navigation -->
    <?php
    include_once($header_php_url);
    ?>


    <!-- MAIN -->
    <main class="cflex">

        <section class="cflex everything_center has_bg_color" id="welcome_section">

            <h1 class="title" id="main_title">
                Tic Tac Toe
            </h1>

            <p class="text" id="main_subtitle">
                Player VS Player (<?= htmlspecialchars($game_type) ?>)
            </p>

            <button class="play" id="start_game_button" type="button">
                Start game
            </button>

        </section>

        <section class="cflex everything_center has_bg_color" id="game_section">

            <article class="inner cflex everything_center" id="game_inner">

                <!-- Game board -->
                <div class="game_board" id="game_board">
                    <div class="game_cell" data-game_cell></div>
                    <div class="game_cell" data-game_cell></div>
                    <div class="game_cell" data-game_cell></div>
                    <div class="game_cell" data-game_cell></div>
                    <div class="game_cell" data-game_cell></div>
                    <div class="game_cell" data-game_cell></div>
                    <div class="game_cell" data-game_cell></div>
                    <div class="game_cell" data-game_cell></div>
                    <div class="game_cell" data-game_cell></div>
                </div>

            </article>

            <dialog class="game_info" id="game_info">

                <div class="player_score player_score_left">
                    <span id="score_x">0</span>
                </div>

                <div id="current_player_text">
                    Current turn: <span id="current_player_mark">X</span>
                </div>

                <div class="player_score player_score_right">
                    <span id="score_o">0</span>
                </div>

            </dialog>

        </section>

        <dialog class="game" id="game_finished_dialog">
            <div class="game_finished_message" id="game_finished_message"></div>
            <div class="game_finished_actions">
                <button class="game_finished_button" id="restart_button">Restart</button>
                <button class="game_finished_button" id="exit_button">Exit</button>
            </div>
        </dialog>

    </main>


    <!-- Footer -->
    <?php
    include_once($footer_php_url);
    ?>

</body>

</html>