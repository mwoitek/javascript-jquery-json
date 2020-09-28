<?php
function check_year_description($year, $desc, $operation) {
    // $operation = 'add' or 'edit'
    if ( strlen($year) == 0 || strlen($desc) == 0 ) {
        $_SESSION['error'] = 'All fields are required';
        require_once 'universal_functions.php';
        header(where_to_redirect($operation));
        exit;
    }
}

function check_year_is_numeric($year, $operation) {
    // $operation = 'add' or 'edit'
    if ( !is_numeric($year) ) {
        $_SESSION['error'] = 'Year must be numeric';
        require_once 'universal_functions.php';
        header(where_to_redirect($operation));
        exit;
    }
}

function validate_position($operation) {
    // $operation = 'add' or 'edit'
    for ( $pos = 1; $pos < 10; $pos++ ) {
        $year_str = 'year' . $pos;
        $desc_str = 'desc' . $pos;
        if ( isset($_POST[$year_str]) && isset($_POST[$desc_str]) ) {
            $year = $_POST[$year_str];
            $desc = $_POST[$desc_str];
            check_year_description($year, $desc, $operation);
            check_year_is_numeric($year, $operation);
        }
    }
}

function add_position($profile_id, $rank, $year, $desc) {
    require_once 'pdo.php';
    $placeholders = array(
        ':pid' => $profile_id,
        ':rk' => $rank,
        ':yr' => $year,
        ':dc' => $desc
    );
    $sql = 'INSERT INTO Position (profile_id, rank, year, description) '
         . 'VALUES (:pid, :rk, :yr, :dc)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($placeholders);
}

function delete_all_positions($profile_id) {
    require_once 'pdo.php';
    $sql = 'DELETE FROM Position WHERE profile_id = :pid';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':pid' => $profile_id));
}

function add_or_edit_all_positions($profile_id, $operation) {
    // $operation = 'add' or 'edit'
    if ( $operation == 'edit' ) {
        delete_all_positions($profile_id);
    }
    $rank = 1;
    for ( $pos = 1; $pos < 10; $pos++ ) {
        $year_str = 'year' . $pos;
        $desc_str = 'desc' . $pos;
        if ( isset($_POST[$year_str]) && isset($_POST[$desc_str]) ) {
            $year = $_POST[$year_str];
            $desc = $_POST[$desc_str];
            add_position($profile_id, $rank, $year, $desc);
            $rank++;
        }
    }
}

function retrieve_position_data() {
    require_once 'pdo.php';
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

function set_count_pos($operation) {
    // $operation = 'add' or 'edit'
    if ( $operation == 'add' ) {
        $count_pos = 0;
    } else {
        global $prepared_positions;
        $count_pos = count($prepared_positions);
    }
    echo '<script>count_pos = ' . $count_pos . ";</script>\n";
}

function print_position_div($count_pos, $year, $desc) {
    echo '<div id="position' . $count_pos . '">' . "\n";
    echo '<p>Year: <input type="text" name="year' . $count_pos . '" value="' . $year . '">' . "\n";
    echo '<input type="button" value="-" onclick="$(';
    echo "\'#position" . $count_pos . "\'" . ').remove(); return false;"></p>' . "\n";
    echo '<textarea name="desc' . $count_pos . '" rows="8" cols="80">' . "\n";
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
    // $operation = 'edit' or 'view'
    if ( $operation == 'edit' ) {
        print_positions_edit($prepared_positions);
    } else {
        print_positions_view($prepared_positions);
    }
}
?>
