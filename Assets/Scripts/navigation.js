let theme = localStorage.getItem('theme');

const nav_logo = document.getElementById('nav_logo');
const nav_options = document.getElementById('nav_options');

const nav_options_button = document.getElementById('nav_options_button');
const nav_menu_button = document.getElementById('nav_menu_button');

const nav_options_dialog = document.getElementById('nav_options_dialog');
const nav_menu_dialog = document.getElementById('nav_menu_dialog');

const dialog_theme_button = document.getElementById('dialog_theme_button');

let currentlyOpenDialog = null;


function toggleDialog(dialog, toggleButton) {
    if (!dialog || !toggleButton) return;

    toggleButton.addEventListener('click', event => {
        if (currentlyOpenDialog && currentlyOpenDialog !== dialog && currentlyOpenDialog.open) {
            currentlyOpenDialog.close();
            console.log("Dialog " + "#" + currentlyOpenDialog.id + " closed automatically.");
        }

        if (!dialog.open) {
            dialog.show();
            currentlyOpenDialog = dialog;
            console.log("Dialog " + "#" + dialog.id + " shown.");
        } else {
            dialog.close();
            currentlyOpenDialog = null;
            console.log("Dialog " + "#" + dialog.id + " closed.");
        }
        event.stopPropagation();
    });

    document.addEventListener('click', event => {
        if (!dialog.open) return;
        const dialog_dimensions = dialog.getBoundingClientRect();
        if (event.clientX < dialog_dimensions.left ||
            event.clientX > dialog_dimensions.right ||
            event.clientY < dialog_dimensions.top ||
            event.clientY > dialog_dimensions.bottom) {
            dialog.close();
            currentlyOpenDialog = null;
            console.log("Dialog " + "#" + dialog.id + " closed by clicking outside.");
        }
        event.stopPropagation();
    });

    dialog.addEventListener('click', event => event.stopPropagation());
}

toggleDialog(nav_options_dialog, nav_options_button);
toggleDialog(nav_menu_dialog, nav_menu_button);


function enableDarkTheme() {
    document.documentElement.classList.add('dark_theme');
    document.documentElement.classList.remove('light_theme');
    localStorage.setItem('theme', 'dark');
    console.log("Theme set to dark.");

    dialog_theme_button.innerHTML = "Set theme to Light";
}


function enableLightTheme() {
    document.documentElement.classList.add('light_theme');
    document.documentElement.classList.remove('dark_theme');
    localStorage.setItem('theme', 'light');
    console.log("Theme set to light.");

    dialog_theme_button.innerHTML = "Set theme to Dark";
}


if (theme === 'dark') {
    enableDarkTheme();
} else if (theme === 'light') {
    enableLightTheme();
} else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
    enableDarkTheme();
} else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches) {
    enableLightTheme();
} else {
    enableLightTheme();
}


if (dialog_theme_button) {
    dialog_theme_button.addEventListener('click', () => {
        theme = localStorage.getItem('theme');
        if (theme !== 'dark') {
            enableDarkTheme();
        } else {
            enableLightTheme();
        }
    });
}