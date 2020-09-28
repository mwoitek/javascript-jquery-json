<?php
// $operation = 'delete', 'edit' or 'view'

function delete() {
    require_once 'pdo.php';
    require_once 'position_functions.php';
    $sql = 'DELETE FROM Profile WHERE profile_id = :pid';
    $stmt = $pdo->prepare($sql);
    $profile_id = $_POST['profile_id'];
    $stmt->execute(array(':pid' => $profile_id));
    delete_all_positions($profile_id);
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
    $profile = $stmt->fetch(PDO::FETCH_ASSOC);
    return $profile;
}

function invalid_id_redirect($profile) {
    if ( $profile === false ) {
        $_SESSION['error'] = 'Invalid ID';
        header('Location: index.php');
        exit;
    }
}

function prepare_profile_data($profile) {
    $prepared_profile = [];
    foreach ( $profile as $key => $value ) {
        $prepared_profile[$key] = htmlentities($value);
    }
    return $prepared_profile;
}

function retrieve_prepared_profile($operation) {
    $profile = retrieve_profile_data($operation);
    invalid_id_redirect($profile);
    $prepared_profile = prepare_profile_data($profile);
    return $prepared_profile;
}
?>
