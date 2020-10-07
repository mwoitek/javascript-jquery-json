<?php
// $operation = 'delete', 'edit' or 'view'

function delete() {
    require_once 'delete_all_positions.php';
    global $pdo;
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
    global $pdo;
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

function retrieve_position_data() {
    global $pdo;
    $sql = 'SELECT year, description FROM Position WHERE profile_id = :pid ORDER BY rank';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':pid' => $_GET['profile_id']));
    $positions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $positions;
}

function prepare_position_data($positions) {
    $prepared_positions = [];
    foreach ( $positions as $position ) {
        $prepared_position = [];
        foreach ( $position as $key => $value ) {
            $prepared_position[$key] = htmlentities($value);
        }
        $prepared_positions[] = $prepared_position;
    }
    return $prepared_positions;
}

function retrieve_prepared_positions() {
    $positions = retrieve_position_data();
    $prepared_positions = prepare_position_data($positions);
    return $prepared_positions;
}

function retrieve_prepared_profile_positions($operation) {
    $prepared_profile = retrieve_prepared_profile($operation);
    $prepared_positions = retrieve_prepared_positions();
    return array($prepared_profile, $prepared_positions);
}

function print_position_div($pos, $year, $desc) {
    echo '<div id="position' . $pos . '">' . "\n";
    echo '<p>Year: <input type="text" name="year' . $pos . '" value="' . $year . '">' . "\n";
    echo '<input type="button" value="-" onclick="remove_position(' . $pos . '); return false;"></p>' . "\n";
    echo '<textarea name="desc' . $pos . '" rows="8" cols="80">' . "\n";
    echo $desc . "\n</textarea>\n</div>\n";
}

function print_positions_edit($prepared_positions) {
    if ( !empty($prepared_positions) ) {
        foreach ( $prepared_positions as $i => $position ) {
            $count_pos = $i + 1;
            $year = $position['year'];
            $desc = $position['description'];
            print_position_div($count_pos, $year, $desc);
        }
    }
}

function print_positions_list($prepared_positions) {
    echo "<ul>\n";
    foreach ( $prepared_positions as $position ) {
        echo '<li>' . $position['year'] . ': ' . $position['description'] . "</li>\n";
    }
    echo "</ul>\n";
}

function print_positions_view($prepared_positions) {
    if ( !empty($prepared_positions) ) {
        echo "<p>Position:</p>\n";
        print_positions_list($prepared_positions);
    }
}

function print_positions($prepared_positions, $operation) {
    if ( $operation == 'edit' ) {
        print_positions_edit($prepared_positions);
    } else {
        print_positions_view($prepared_positions);
    }
}
?>
