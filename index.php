<!DOCTYPE html>

<?php
$directory_prefix = "";
require_once($directory_prefix . "php/main.php");
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
    <title> Tic Tac Toe </title>
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


    <!-- Main Content -->
    <main class="cflex">

        <section class="everything_center has_bg_color" id="games_section">

            <article class="game everything_center has_bg_img" style='background-image: url("Assets/Images/TicTacToe Image (tiny).png");'>

                <img class="bg" alt="TTT" src="Assets/Images/TicTacToe Image.png" loading="lazy">

                <h1 class="title">
                    Tic Tac Toe
                </h1>

                <a class="link" href="<?= $play_tictactoe_url ?>">Play locally</a>

            </article>

            <article class="game everything_center has_bg_img" style='background-image: url("Assets/Images/Ultimate TicTacToe Image (tiny).png");'>

                <img class="bg" alt="UTTT" src="Assets/Images/Ultimate TicTacToe Image.png" loading="lazy">

                <h1 class="title">
                    Ultimate Tic Tac Toe
                </h1>

                <a class="link" href="<?= $play_ultimatetictactoe_local_url ?>">Play locally</a>
                <a class="link" href="<?= $play_ultimatetictactoe_online_url ?>">Play online</a>

            </article>

        </section>

    </main>


    <!-- Footer -->
    <?php
    include_once($footer_php_url);
    ?>

</body>

</html>