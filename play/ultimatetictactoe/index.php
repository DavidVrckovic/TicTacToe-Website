<!DOCTYPE html>

<?php
$directory_prefix = "../../";
require_once($directory_prefix . "php/main.php");
isset($_GET["game_type"]) && $_GET["game_type"] === "local" ? $game_type = "local" : $game_type = "online";
$game_type === "online" && !isset($_SESSION["logged_in"]) ? header("Location: " . $nav_login_url) : null;
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
    <title> Ultimate Tic Tac Toe | Play </title>
    <link href="<?= $favicon_url ?>" rel="icon" type="image/png">

    <!-- CSS files -->
    <link href="<?= $index_css_url ?>" rel="stylesheet" type="text/css">
    <link href="<?= $navigation_css_url ?>" rel="stylesheet" type="text/css">
    <link href="<?= $footer_css_url ?>" rel="stylesheet" type="text/css">
    <link href="<?= $tictactoe_css_url ?>" rel="stylesheet" type="text/css">

    <!-- Script files -->
    <script defer src="<?= $main_script_url ?>"></script>
    <script defer src="<?= $navigation_script_url ?>"></script>
    <script defer src="<?= $game_type === "local" ? $ultimatetictactoe_script_local_url : $ultimatetictactoe_script_online_url ?>"></script>
</head>


<body>

    <!-- Header & Navigation -->
    <?php
    include_once($header_php_url);
    ?>


    <!-- MAIN -->
    <main class="cflex">

        <!-- SECTION -->
        <section class="cflex everything_center has_bg_color" id="welcome_section">

            <!-- Title -->
            <h1 class="title" id="main_title">
                Ultimate Tic Tac Toe
            </h1>

            <p class="text" id="main_subtitle">
                Player VS Player (<?= htmlspecialchars($game_type) ?>)
            </p>

            <?php
            if ($game_type === "local") {
                echo ('<button class="play" id="start_game_button" type="button"> Start game </button>');
            } else {
                echo ('<button class="play" id="create_game_button" type="button"> Create game </button>' .
                    '<button class="play" id="join_game_button" type="button"> Join game </button>');
            }
            ?>

        </section>

        <!-- SECTION -->
        <section class="cflex everything_center has_bg_color" id="game_section">

            <!-- Inner section -->
            <article class="inner cflex everything_center" id="game_inner">

                <!-- Game board -->
                <div class="ultimate_game_board" id="ultimate_game_board">
                    <div class="game_board" data-game_board>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_board_state"></div>
                    </div>
                    <div class="game_board" data-game_board>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_board_state"></div>
                    </div>
                    <div class="game_board" data-game_board>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_board_state"></div>
                    </div>
                    <div class="game_board" data-game_board>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_board_state"></div>
                    </div>
                    <div class="game_board" data-game_board>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_board_state"></div>
                    </div>
                    <div class="game_board" data-game_board>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_board_state"></div>
                    </div>
                    <div class="game_board" data-game_board>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_board_state"></div>
                    </div>
                    <div class="game_board" data-game_board>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_board_state"></div>
                    </div>
                    <div class="game_board" data-game_board>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_cell" data-game_cell></div>
                        <div class="game_board_state"></div>
                    </div>
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

        <dialog class="invite" id="game_invite_dialog">
            <div class="invite_message" id="invite_message"></div>
            <div class="invite_search">
                <input id="invite_search_input" placeholder="Search a username..." autocomplete="off" type="text">
                <ul id="invite_suggestions" class="invite_suggestions"></ul>
            </div>
            <div class="invite_actions">
                <button class="invite_button" id="invite_button">Invite a friend</button>
            </div>
        </dialog>

    </main>


    <!-- Footer -->
    <?php
    include_once($footer_php_url);
    ?>

</body>

</html>