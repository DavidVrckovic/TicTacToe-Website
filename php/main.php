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
$favicon_image = $directory_prefix . "Assets/Images/Icons/TicTacToe Logo.png";

// CSS files
$index_css = $directory_prefix . "Assets/Styles/index.css";
$navigation_css = $directory_prefix . "Assets/Styles/navigation.css";
$footer_css = $directory_prefix . "Assets/Styles/footer.css";
$back_to_top_css = $directory_prefix . "Assets/Styles/back_to_top.css";
$authentication_css = $directory_prefix . "Assets/Styles/authentication.css";
$tictactoe_css = $directory_prefix . "Assets/Styles/tictactoe.css";
$ultimateTictactoe_css = $directory_prefix . "Assets/Styles/ultimateTictactoe.css";

// Script files
$main_script = $directory_prefix . "Assets/Scripts/main.js";
$navigation_script = $directory_prefix . "Assets/Scripts/navigation.js";
$back_to_top_script = $directory_prefix . "Assets/Scripts/back_to_top.js";
$tictactoe_script = $directory_prefix . "Assets/Scripts/tictactoe.js";
$ultimateTictactoe_script = $directory_prefix . "Assets/Scripts/ultimateTictactoe.js";

// Parts
$navigation_php = $directory_prefix . "Assets/Parts/navigation.php";
$footer_php = $directory_prefix . "Assets/Parts/footer.php";
$back_to_top_php = $directory_prefix . "Assets/Parts/back_to_top.php";
$auth_login_php = $directory_prefix . "php/auth_login.php";
$auth_register_php = $directory_prefix . "php/auth_register.php";
$login_php = $directory_prefix . "login/";
$register_php = $directory_prefix . "register/";
$play_php = $directory_prefix . "play/";



// Header & Navigation
$header_image = $directory_prefix . "Assets/Images/Icons/TicTacToe Logo.png";

$nav_faq = $directory_prefix . "faq";
$nav_faq_icon = $directory_prefix . "Assets/Images/Navigation/faq_icon_black.png";
$nav_faq_icon_black = $directory_prefix . "Assets/Images/Navigation/faq_icon_black.png";
$nav_faq_icon_gold = $directory_prefix . "Assets/Images/Navigation/faq_icon_gold.png";
$nav_faq_icon_white = $directory_prefix . "Assets/Images/Navigation/faq_icon_white.png";

$nav_gamemodes = $directory_prefix . "gamemodes";
$nav_gamemodes_icon = $directory_prefix . "Assets/Images/Navigation/gamemodes_icon_black.png";
$nav_gamemodes_icon_black = $directory_prefix . "Assets/Images/Navigation/gamemodes_icon_black.png";
$nav_gamemodes_icon_gold = $directory_prefix . "Assets/Images/Navigation/gamemodes_icon_gold.png";
$nav_gamemodes_icon_white = $directory_prefix . "Assets/Images/Navigation/gamemodes_icon_white.png";

$nav_home = $directory_prefix . "";
$nav_home_icon = $directory_prefix . "Assets/Images/Navigation/home_icon_black.png";
$nav_home_icon_black = $directory_prefix . "Assets/Images/Navigation/home_icon_black.png";
$nav_home_icon_gold = $directory_prefix . "Assets/Images/Navigation/home_icon_gold.png";
$nav_home_icon_white = $directory_prefix . "Assets/Images/Navigation/home_icon_white.png";

$nav_info = $directory_prefix . "info";
$nav_info_icon = $directory_prefix . "Assets/Images/Navigation/info_icon_black.png";
$nav_info_icon_black = $directory_prefix . "Assets/Images/Navigation/info_icon_black.png";
$nav_info_icon_gold = $directory_prefix . "Assets/Images/Navigation/info_icon_gold.png";
$nav_info_icon_white = $directory_prefix . "Assets/Images/Navigation/info_icon_white.png";

$nav_menu = $directory_prefix . "menu";
$nav_menu_icon = $directory_prefix . "Assets/Images/Navigation/menu_icon_black.png";
$nav_menu_icon_black = $directory_prefix . "Assets/Images/Navigation/menu_icon_black.png";
$nav_menu_icon_gold = $directory_prefix . "Assets/Images/Navigation/menu_icon_gold.png";
$nav_menu_icon_white = $directory_prefix . "Assets/Images/Navigation/menu_icon_white.png";

$nav_news = $directory_prefix . "news";
$nav_news_icon = $directory_prefix . "Assets/Images/Navigation/news_icon_black.png";
$nav_news_icon_black = $directory_prefix . "Assets/Images/Navigation/news_icon_black.png";
$nav_news_icon_gold = $directory_prefix . "Assets/Images/Navigation/news_icon_gold.png";
$nav_news_icon_white = $directory_prefix . "Assets/Images/Navigation/news_icon_white.png";

$nav_options = $directory_prefix . "options";
$nav_options_icon = $directory_prefix . "Assets/Images/Navigation/options_icon_black.png";
$nav_options_icon_black = $directory_prefix . "Assets/Images/Navigation/options_icon_black.png";
$nav_options_icon_gold = $directory_prefix . "Assets/Images/Navigation/options_icon_gold.png";
$nav_options_icon_white = $directory_prefix . "Assets/Images/Navigation/options_icon_white.png";

$nav_store = $directory_prefix . "store";
$nav_store_icon = $directory_prefix . "Assets/Images/Navigation/store_icon_black.png";
$nav_store_icon_black = $directory_prefix . "Assets/Images/Navigation/store_icon_black.png";
$nav_store_icon_gold = $directory_prefix . "Assets/Images/Navigation/store_icon_gold.png";
$nav_store_icon_white = $directory_prefix . "Assets/Images/Navigation/store_icon_white.png";

$nav_apply = $directory_prefix . "apply";



// Options dropdown menu
if (!isset($_SESSION["logged_in"])) {
    $nav_auth = $directory_prefix . "login";
} else {
    $nav_auth = $directory_prefix . "logout";
    $nav_account = $directory_prefix . "account";
}



$nav_icons = "
    <script>
        const nav_faq_icon = '$nav_faq_icon';
        const nav_gamemodes_icon = '$nav_gamemodes_icon';
        const nav_home_icon = '$nav_home_icon';
        const nav_info_icon = '$nav_info_icon';
        const nav_news_icon = '$nav_news_icon';
        const nav_options_icon = '$nav_options_icon';
        const nav_store_icon = '$nav_store_icon';

        const nav_faq_icon_darkmode = '$nav_faq_icon_white';
        const nav_gamemodes_icon_darkmode = '$nav_gamemodes_icon_white';
        const nav_home_icon_darkmode = '$nav_home_icon_white';
        const nav_info_icon_darkmode = '$nav_info_icon_white';
        const nav_news_icon_darkmode = '$nav_news_icon_white';
        const nav_options_icon_darkmode = '$nav_options_icon_white';
        const nav_store_icon_darkmode = '$nav_store_icon_white';
    </script>
";



// Back to top
$back_to_top_image = $directory_prefix . "Assets/Images/Back to top/Back to top - White.png";


?>