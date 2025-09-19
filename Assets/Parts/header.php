<header>

    <nav class="main left" id="nav_logo">

        <a class="nav logo" id="nav_logo_link" href="<?= $nav_home_url; ?>">
            <!-- <img alt="Home" class="nav_link" id="nav_logo_img" src="<?= $logo_icon_url; ?>"> -->
            <svg class="nav" id="tictactoe_logo_icon" data-name="TicTacToe Logo Icon" viewBox="0 0 1080 1080" xmlns="http://www.w3.org/2000/svg">
                <polygon class="svg_fill_exclusive" fill="#000" points="1080 530 550 530 550 0 530 0 530 530 0 530 0 550 530 550 530 1080 550 1080 550 550 1080 550 1080 530" />
                <polygon class="svg_fill" fill="#000" points="476.56 181.82 412.92 118.18 297.37 233.73 181.82 118.18 118.18 181.82 233.73 297.37 118.18 412.92 181.82 476.56 297.37 361.01 412.92 476.56 476.56 412.92 361.01 297.37 476.56 181.82" />
                <circle class="svg_stroke" fill="none" stroke="#000" stroke-miterlimit="10" stroke-width="90" cx="782.63" cy="297.37" r="147.37" />
                <circle class="svg_stroke" fill="none" stroke="#000" stroke-miterlimit="10" stroke-width="90" cx="297.37" cy="782.63" r="147.37" />
                <polygon class="svg_fill" fill="#000" points="961.82 667.08 898.18 603.44 782.63 718.99 667.08 603.44 603.44 667.08 718.99 782.63 603.44 898.18 667.08 961.82 782.63 846.27 898.18 961.82 961.82 898.18 846.27 782.63 961.82 667.08" />
            </svg>
            <span class="nav" id="nav_logo_text">Tic Tac Toe</span>
        </a>

    </nav>


    <nav class="main right multiple_elements" id="nav_options">

        <button class="nav" id="nav_options_button">
            <!-- <img alt="Options" class="nav" id="nav_options_img" src="<?= $nav_options_icon_url; ?>"> -->
            <svg class="nav" id="nav_options_icon" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path class="svg_stroke" fill="none" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2" d="M31,19v-6h-4.425   c-0.252-0.888-0.611-1.729-1.065-2.51L29,7l-4-4l-3.49,3.49C21.028,6.21,20.525,5.967,20,5.761V1h-8v4.761   c-0.525,0.205-1.028,0.449-1.51,0.728L7,3L3,7l3.49,3.49C6.036,11.271,5.676,12.112,5.425,13H1v6h4.425   c0.252,0.888,0.611,1.729,1.065,2.51L3,25l4,4l3.49-3.49c0.482,0.28,0.986,0.523,1.51,0.728V31h8v-4.761   c0.525-0.205,1.028-0.449,1.51-0.728L25,29l4-4l-3.49-3.49c0.454-0.781,0.813-1.622,1.065-2.51H31z" />
                <circle class="svg_stroke" fill="none" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2" r="5" cx="16" cy="16" />
            </svg>
        </button>

        <button class="nav" id="nav_menu_button">
            <!-- <img alt="Menu" class="nav" id="nav_menu_img" src="<?= $nav_menu_icon_url; ?>"> -->
            <svg class="nav" id="nav_menu_icon" viewBox="0 0 1080 1080" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect class="svg_fill" y="100" width="1080" height="100" rx="50"></rect>
                <rect class="svg_fill" y="490" width="1080" height="100" rx="50"></rect>
                <rect class="svg_fill" y="880" width="1080" height="100" rx="50"></rect>
            </svg>
        </button>

        <dialog class="nav" id="nav_options_dialog">

            <?php
            if (isset($_SESSION["logged_in"], $_SESSION["user_username"])) {
                echo '
                    <a class="dialog_link" href="' . $nav_account_url . '" id="dialog_account_link">
                        <img alt="Account" class="dialog_link" id="dialog_account_img" src="' . $nav_account_icon_url . '">
                        <span id="dialog_account_text">Logged in as: ' . $_SESSION["user_username"] . '</span>
                    </a>

                    <a class="dialog_link" href="' . $nav_logout_url . '" id="dialog_logout_link">
                        Logout
                    </a>
                ';
            } else {
                echo '
                    <a class="dialog_link" href="' . $nav_login_url . '" id="dialog_login_link">
                        Login
                    </a>

                    <a class="dialog_link" href="' . $nav_register_url . '" id="dialog_register_link">
                        Register
                    </a>
                ';
            }
            ?>

            <button class="dialog_button" id="dialog_theme_button">
                Set theme to Dark
            </button>

        </dialog>

        <dialog class="nav" id="nav_menu_dialog">

            <a class="dialog_link" href="<?= $play_tictactoe_url; ?>" id="dialog_tictactoe_link">
                Tic Tac Toe
            </a>

            <a class="dialog_link" href="<?= $play_ultimatetictactoe_local_url; ?>" id="dialog_ultimatetictactoe_local_link">
                Ultimate Tic Tac Toe (local)
            </a>

            <a class="dialog_link" href="<?= $play_ultimatetictactoe_online_url; ?>" id="dialog_ultimatetictactoe_online_link">
                Ultimate Tic Tac Toe (online)
            </a>

        </dialog>

    </nav>

</header>