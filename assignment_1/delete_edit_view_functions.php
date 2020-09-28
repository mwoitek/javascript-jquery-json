<?php
// $operation = 'delete', 'edit' or 'view'

function delete_edit_redirect() {
    require_once 'universal_functions.php';
    $is_logged = check_user_logged();
    deny_access_if_not_logged($is_logged);
    check_clicked_on_cancel();
    check_profile_id();
}

function delete() {
    require_once 'pdo.php';
    $sql = 'DELETE FROM Profile WHERE profile_id = :pid';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':pid' => $_POST['profile_id']));
    $_SESSION['success'] = 'Profile deleted';
    header('Location: index.php');
    exit;
}

function retrieve_profile_data($operation) {
    require_once 'pdo.php';
    $extra_fields = ( $operation == 'delete' ) ? '' : ', email, headline, summary';
    $extra_condition = ( $operation == 'view' ) ? '' : ' AND user_id = :uid';
    $sql = 'SELECT first_name, last_name' . $extra_fields . ' FROM Profile '
         . 'WHERE profile_id = :pid' . $extra_condition;
    $stmt = $pdo->prepare($sql);
    $placeholders = array(':pid' => $_GET['profile_id']);
    if ( $operation != 'view' ) {
        $placeholders[':uid'] = $_SESSION['user_id'];
    }
    $stmt->execute($placeholders);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function invalid_id_redirect($row) {
    if ( $row === false ) {
        $_SESSION['error'] = 'Invalid ID';
        header('Location: index.php');
        exit;
    }
}

function prepare_profile_data($row) {
    $prepared_row = [];
    foreach ( $row as $key => $value ) {
        $prepared_row[$key] = htmlentities($value);
    }
    return $prepared_row;
}

function retrieve_prepared_data($operation) {
    $row = retrieve_profile_data($operation);
    invalid_id_redirect($row);
    $prepared_row = prepare_profile_data($row);
    return $prepared_row;
}
?>
