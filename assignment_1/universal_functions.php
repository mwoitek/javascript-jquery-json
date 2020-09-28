<?php
function check_user_logged() {
    return isset($_SESSION['name']) && isset($_SESSION['user_id']);
}

function deny_access_if_not_logged($is_logged) {
    if ( !$is_logged ) {
        die('Not logged in');
    }
}

function check_clicked_on_cancel() {
    if ( isset($_POST['cancel']) ) {
        header('Location: index.php');
        exit;
    }
}

function check_profile_id() {
    if ( !isset($_GET['profile_id']) ) {
        $_SESSION['error'] = 'Missing profile_id';
        header('Location: index.php');
        exit;
    }
}

function print_flash_msg($msg_type, $color) {
    // $msg_type = 'error' or 'success'
    if ( isset($_SESSION[$msg_type]) ) {
        echo '<p style="color: ' . $color . ';">' . $_SESSION[$msg_type] . "</p>\n";
        unset($_SESSION[$msg_type]);
    }
}

function print_error_or_success() {
    print_flash_msg('error', 'red');
    print_flash_msg('success', 'green');
}
?>
