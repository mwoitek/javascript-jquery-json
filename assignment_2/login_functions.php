<?php
function have_email_password() {
    return isset($_POST['email']) && isset($_POST['pass']);
}

function logout_curr_user() {
    unset($_SESSION['name']);
    unset($_SESSION['user_id']);
}

function compute_hashed_password($salt, $password) {
    return hash('md5', $salt . $password);
}

function query_email_hashed_password($email, $hashed_password) {
    require_once 'pdo.php';
    $placeholders = array(
        ':em' => $email,
        ':pw' => $hashed_password
    );
    $sql = 'SELECT name, user_id FROM users WHERE email = :em AND password = :pw';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($placeholders);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function incorrect_password() {
    $_SESSION['error'] = 'Incorrect password';
    header('Location: login.php');
    exit;
}

function login_curr_user($match) {
    $_SESSION['name'] = $match['name'];
    $_SESSION['user_id'] = $match['user_id'];
    header('Location: index.php');
    exit;
}

function check_password() {
    if ( have_email_password() ) {
        logout_curr_user();
        $computed_hash = compute_hashed_password('XyZzy12*_', $_POST['pass']);
        $match = query_email_hashed_password($_POST['email'], $computed_hash);
        if ( $match === false ) {
            incorrect_password();
        } else {
            login_curr_user($match);
        }
    }
}
?>
