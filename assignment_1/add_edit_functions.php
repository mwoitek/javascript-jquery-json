<?php
// $operation = 'add' or 'edit'

$fields = array(
    'first_name',
    'last_name',
    'email',
    'headline',
    'summary'
);

function have_post_data($operation) {
    global $fields;
    foreach ( $fields as $field ) {
        if ( !isset($_POST[$field]) ) {
            return false;
        }
    }
    if ( $operation == 'edit' ) {
        return isset($_POST['profile_id']);
    } else {
        return true;
    }
}

function check_if_field_is_filled($field) {
    return strlen($_POST[$field]) > 0;
}

function where_to_redirect($operation) {
    $get_parameter = ( $operation == 'edit' ) ? '?profile_id=' . urlencode($_POST['profile_id']) : '';
    return 'Location: ' . $operation . '.php' . $get_parameter;
}

function check_all_fields_filled($operation) {
    global $fields;
    foreach ( $fields as $field ) {
        $is_filled = check_if_field_is_filled($field);
        if ( !$is_filled ) {
            $_SESSION['error'] = 'All fields are required';
            header(where_to_redirect($operation));
            exit;
        }
    }
}

function check_email_contains_at_sign($operation) {
    if ( strpos($_POST['email'], '@') == false ) {
        $_SESSION['error'] = 'Email address must contain @';
        header(where_to_redirect($operation));
        exit;
    }
}

function validate_profile_data($operation) {
    check_all_fields_filled($operation);
    check_email_contains_at_sign($operation);
}

function add_or_edit($operation) {
    require_once 'pdo.php';
    $placeholders = array(
        ':uid' => $_SESSION['user_id'],
        ':fn' => $_POST['first_name'],
        ':ln' => $_POST['last_name'],
        ':em' => $_POST['email'],
        ':hl' => $_POST['headline'],
        ':su' => $_POST['summary']
    );
    if ( $operation == 'add' ) {
        $sql = 'INSERT INTO Profile (user_id, first_name, last_name, email, headline, summary) '
             . 'VALUES (:uid, :fn, :ln, :em, :hl, :su)';
        $_SESSION['success'] = 'Record added';
    } else {
        $placeholders[':pid'] = $_POST['profile_id'];
        $sql = 'UPDATE Profile '
             . 'SET user_id = :uid, first_name = :fn, last_name = :ln, '
             . 'email = :em, headline = :hl, summary = :su '
             . 'WHERE profile_id = :pid';
        $_SESSION['success'] = 'Record edited';
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($placeholders);
    header('Location: index.php');
    exit;
}

function handle_post_data($operation) {
    if ( have_post_data($operation) ) {
        validate_profile_data($operation);
        add_or_edit($operation);
    }
}
?>
