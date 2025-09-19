<!DOCTYPE html>

<?php
$directory_prefix = "../";
require_once($directory_prefix . "php/main.php");

if (isset($_SESSION["logged_in"])) {
    header("Location: ../");
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
    <title> Tic Tac Toe | Register </title>
    <link href="<?= $favicon_url ?>" rel="icon" type="image/svg+xml">

    <!-- CSS files -->
    <link href="<?= $index_css_url ?>" rel="stylesheet" type="text/css">
    <link href="<?= $navigation_css_url ?>" rel="stylesheet" type="text/css">
    <link href="<?= $footer_css_url ?>" rel="stylesheet" type="text/css">
    <link href="<?= $authentication_css_url ?>" rel="stylesheet" type="text/css">

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

        <!-- SECTION -->
        <section class="flex form" id="register_section">

            <form action="<?= $auth_register_php_url ?>" class="cflex authenticate" id="register_form" method="POST">

                <h1 class="title">
                    Registration
                </h1>

                <p class="description">
                    Please fill in the details below to register your account.
                </p>

                <hr>

                <label class="input_title" for="input_username">
                    Username
                </label>
                <input class="input_field" id="input_username" name="user_username" autocomplete="username" placeholder="Enter a unique username" type="text" required>

                <label class="input_title" for="input_email">
                    Email address
                </label>
                <input class="input_field" id="input_email" name="user_email" autocomplete="email" placeholder="Enter a valid email address" type="email" required>

                <label class="input_title" for="input_password">
                    Password
                </label>
                <input class="input_field" id="input_password" name="user_password" autocomplete="new-password" placeholder="Enter a strong password" type="password" required>

                <label class="input_title" for="input_repeat_password">
                    Repeat password
                </label>
                <input class="input_field" id="input_repeat_password" name="user_repeated_password" autocomplete="new-password" placeholder="Repeat a strong password" type="password" required>

                <div class="input_checkbox">
                    <input class="input_checkbox" id="input_remember_me" name="user_remember_me" type="checkbox">
                    <label class="input_text" for="input_remember_me">
                        Remember me
                    </label>
                </div>

                <?php
                if (isset($_GET['error'])) {
                    if ($_GET['error'] == "empty_inputs") {
                        echo '<p class="error"> The provided inputs are empty. </p>';
                    }
                    if ($_GET['error'] == "unknown_email") {
                        echo '<p class="error"> The provided email is incorrect. </p>';
                    }
                    if ($_GET['error'] == "unknown_username") {
                        echo '<p class="error"> The provided username is incorrect. </p>';
                    }
                    if ($_GET['error'] == "wrong_password") {
                        echo '<p class="error"> The provided password is incorrect. </p>';
                    }
                    if ($_GET['error'] == "passwords_do_not_match") {
                        echo '<p class="error"> The provided passwords do not match. </p>';
                    }
                    if ($_GET['error'] == "email_already_exists") {
                        echo '<p class="error"> The provided email is already in use. </p>';
                    }
                    if ($_GET['error'] == "registration_failed") {
                        echo '<p class="error"> The registration failed. </p>';
                    }
                    if ($_GET['error'] == "registration_check_failed") {
                        echo '<p class="error"> The registration check failed. </p>';
                    }
                    if (isset($_SESSION['db_connection_error']) && $_GET['error'] == "db_connection") {
                        echo '<p class="error">' . $_SESSION['db_connection_error'] . '</p>';
                    }
                    if ($_GET['error'] == "session_registration_check_failed") {
                        echo '<p class="error"> The session registration check failed. </p>';
                    }
                    if ($_GET['error'] == "session_registration_failed") {
                        echo '<p class="error"> The session registration failed. </p>';
                    }
                }
                ?>

                <button class="authenticate" id="register" type="submit">
                    Register
                </button>

                <br>

                <a class="authenticate_other" href="<?= $nav_login_url ?>">
                    Log in instead
                </a>
                <a href="#login"></a>

            </form>

        </section>

    </main>


    <!-- Footer -->
    <?php
    include_once($footer_php_url);
    ?>

</body>

</html>