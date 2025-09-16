<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

require_once("db_connection.php");


if (!isset($_SESSION["logged_in"])) {

    if (isset($_COOKIE["session_token"])) {

        $db_connection = establish_db_connection("tictactoe database");

        $encrypted_session_token = "\$RB#\$SHA#" . hash("sha256", hash("sha256", hex2bin($_COOKIE["session_token"])) . "\$256x2#\$64#");

        $db_query = "SELECT user_id FROM user_sessions WHERE session_token LIKE ? LIMIT 1";
        $db_parameters = [$encrypted_session_token];
        $db_parameter_types = "s";
        $db_results = db_get_query_results($db_connection, $db_query, $db_parameters, $db_parameter_types);

        if (isset($_SESSION["db_connection_error"])) {
            header("Location: ../login/?error=db_connection&error_identifier=S1");
            exit();
        }

        if (!($db_results && mysqli_num_rows($db_results) > 0)) {
            header("Location: ../login/?error=invalid_session_token");
            exit();
        }

        $db_data = mysqli_fetch_array($db_results)[0];

        $db_query = "SELECT user_id, user_username, user_email, user_last_login, user_reg_date FROM users WHERE user_id LIKE ? LIMIT 1";
        $db_parameters = [$db_data];
        $db_parameter_types = "s";
        $db_results = db_get_query_results($db_connection, $db_query, $db_parameters, $db_parameter_types);

        if (isset($_SESSION["db_connection_error"])) {
            header("Location: ../login/?error=db_connection&error_identifier=S2");
            exit();
        }

        if (!($db_results && mysqli_num_rows($db_results) > 0)) {
            header("Location: ../login/?error=unknown_user");
            exit();
        }

        $db_data = mysqli_fetch_assoc($db_results);

        session_regenerate_id();
        $_SESSION["logged_in"] = true;
        $_SESSION["user_id"] = $db_data["user_id"];
        $_SESSION["user_username"] = $db_data["user_username"];
        $_SESSION["user_email"] = $db_data["user_email"];
        $_SESSION["user_last_login"] = $db_data["user_last_login"];
        $_SESSION["user_reg_date"] = $db_data["user_reg_date"];
        $_SESSION["db_connection_error"] = null;

        mysqli_close($db_connection);
    }
}



// Title & Favicon
$favicon_url = $directory_prefix . "Assets/Icons/TicTacToe Logo Icon.svg";

// CSS files
$index_css_url = $directory_prefix . "Assets/Styles/index.css";
$navigation_css_url = $directory_prefix . "Assets/Styles/navigation.css";
$footer_css_url = $directory_prefix . "Assets/Styles/footer.css";
$back_to_top_css_url = $directory_prefix . "Assets/Styles/back_to_top.css";
$authentication_css_url = $directory_prefix . "Assets/Styles/authentication.css";

$tictactoe_css_url = $directory_prefix . "Assets/Styles/tictactoe.css";

// Script files
$main_script_url = $directory_prefix . "Assets/Scripts/main.js";
$navigation_script_url = $directory_prefix . "Assets/Scripts/navigation.js";
$back_to_top_script_url = $directory_prefix . "Assets/Scripts/back_to_top.js";

$tictactoe_script_url = $directory_prefix . "Assets/Scripts/tictactoe.js";
$ultimatetictactoe_script_local_url = $directory_prefix . "Assets/Scripts/ultimatetictactoe_local.js";
$ultimatetictactoe_script_online_url = $directory_prefix . "Assets/Scripts/ultimatetictactoe_online.js";

// Parts
$header_php_url = $directory_prefix . "Assets/Parts/header.php";
$footer_php_url = $directory_prefix . "Assets/Parts/footer.php";
$back_to_top_php_url = $directory_prefix . "Assets/Parts/back_to_top.php";
$auth_login_php_url = $directory_prefix . "php/auth_login.php";
$auth_register_php_url = $directory_prefix . "php/auth_register.php";

// Header & Navigation
$logo_icon_url = $directory_prefix . "Assets/Icons/TicTacToe Logo Icon.svg";
$nav_account_icon_url = $directory_prefix . "Assets/Icons/Account Icon.svg";
$nav_menu_icon_url = $directory_prefix . "Assets/Icons/Menu Icon 2.svg";
$nav_options_icon_url = $directory_prefix . "Assets/Icons/Options Icon.svg";

$nav_tictactoe_icon = $directory_prefix . "Assets/Icons/TicTacToe Icon.svg";
$nav_ultimatetictactoe_icon = $directory_prefix . "Assets/Icons/UltimateTicTacToe Icon.svg";

// URLs
$nav_home_url = $directory_prefix . "";
$nav_account_url = $directory_prefix . "account/";
$nav_login_url = $directory_prefix . "login/";
$nav_logout_url = $directory_prefix . "logout/";
$nav_register_url = $directory_prefix . "register/";

$play_url = $directory_prefix . "play/";
$play_tictactoe_url = $directory_prefix . "play/tictactoe/";
$play_ultimatetictactoe_local_url = $directory_prefix . "play/ultimatetictactoe/?game_type=local";
$play_ultimatetictactoe_online_url = $directory_prefix . "play/ultimatetictactoe/";




// # TO DELETE
$nav_apply = $directory_prefix . "apply";



// Options dropdown menu
if (!isset($_SESSION["logged_in"])) {
    $nav_auth = $directory_prefix . "login";
} else {
    $nav_auth = $directory_prefix . "logout";
}



// Back to top
$back_to_top_image = $directory_prefix . "Assets/Images/Back to top/Back to top - White.png";
