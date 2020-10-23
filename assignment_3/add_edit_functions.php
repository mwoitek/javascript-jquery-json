<?php
// $operation = 'add' or 'edit'

require_once 'universal_functions.php';

$fields = array(
    'first_name',
    'last_name',
    'email',
    'headline',
    'summary'
);

function have_post_data($operation)
{
    global $fields;
    foreach ($fields as $field) {
        if (!isset($_POST[$field])) {
            return false;
        }
    }
    if ($operation == 'edit') {
        return isset($_POST['profile_id']);
    } else {
        return true;
    }
}

function check_if_field_is_filled($field)
{
    return strlen($_POST[$field]) > 0;
}

function check_all_fields_filled($operation)
{
    global $fields;
    foreach ($fields as $field) {
        $is_filled = check_if_field_is_filled($field);
        if (!$is_filled) {
            $_SESSION['error'] = 'All fields are required';
            header(where_to_redirect($operation));
            exit;
        }
    }
}

function check_email_contains_at_sign($operation)
{
    if (strpos($_POST['email'], '@') == false) {
        $_SESSION['error'] = 'Email address must contain @';
        header(where_to_redirect($operation));
        exit;
    }
}

function check_year_description($year, $desc, $operation)
{
    if (strlen($year) == 0 || strlen($desc) == 0) {
        $_SESSION['error'] = 'All fields are required';
        header(where_to_redirect($operation));
        exit;
    }
}

function check_year_is_numeric($year, $operation)
{
    if (!is_numeric($year)) {
        $_SESSION['error'] = 'Year must be numeric';
        header(where_to_redirect($operation));
        exit;
    }
}

function retrieve_used_positions()
{
    return explode(',', $_POST['used_positions']);
}

function validate_position($used_positions, $operation)
{
    foreach ($used_positions as $pos) {
        $year_str = 'year' . $pos;
        $desc_str = 'desc' . $pos;
        if (isset($_POST[$year_str]) && isset($_POST[$desc_str])) {
            $year = $_POST[$year_str];
            $desc = $_POST[$desc_str];
            check_year_description($year, $desc, $operation);
            check_year_is_numeric($year, $operation);
        }
    }
}

function validate_profile_data($operation)
{
    check_all_fields_filled($operation);
    check_email_contains_at_sign($operation);
    $used_positions = retrieve_used_positions();
    if ($used_positions !== false) {
        validate_position($used_positions, $operation);
    }
}

function add_position($profile_id, $rank, $year, $desc)
{
    global $pdo;
    $placeholders = array(
        ':pid' => $profile_id,
        ':rk' => $rank,
        ':yr' => $year,
        ':dc' => $desc
    );
    $sql = 'INSERT INTO Position (profile_id, rank, year, description) VALUES (:pid, :rk, :yr, :dc)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($placeholders);
}

function add_or_edit_all_positions($profile_id, $operation)
{
    if ($operation == 'edit') {
        require_once 'delete_all_positions.php';
        delete_all_positions($profile_id);
    }
    $used_positions = retrieve_used_positions();
    if ($used_positions !== false) {
        $rank = 1;
        foreach ($used_positions as $pos) {
            $year_str = 'year' . $pos;
            $desc_str = 'desc' . $pos;
            if (isset($_POST[$year_str]) && isset($_POST[$desc_str])) {
                $year = $_POST[$year_str];
                $desc = $_POST[$desc_str];
                add_position($profile_id, $rank, $year, $desc);
                $rank++;
            }
        }
    }
}

function add_or_edit($operation)
{
    global $pdo;
    $placeholders = array(
        ':uid' => $_SESSION['user_id'],
        ':fn' => $_POST['first_name'],
        ':ln' => $_POST['last_name'],
        ':em' => $_POST['email'],
        ':hl' => $_POST['headline'],
        ':su' => $_POST['summary']
    );
    if ($operation == 'add') {
        $sql = 'INSERT INTO Profile (user_id, first_name, last_name, email, headline, summary) '
            . 'VALUES (:uid, :fn, :ln, :em, :hl, :su)';
        $_SESSION['success'] = 'Profile added';
    } else {
        $placeholders[':pid'] = $_POST['profile_id'];
        $sql = 'UPDATE Profile '
            . 'SET user_id = :uid, first_name = :fn, last_name = :ln, '
            . 'email = :em, headline = :hl, summary = :su '
            . 'WHERE profile_id = :pid';
        $_SESSION['success'] = 'Profile updated';
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($placeholders);
    $profile_id = ($operation == 'add') ? $pdo->lastInsertId() : $_POST['profile_id'];
    add_or_edit_all_positions($profile_id, $operation);
    header('Location: index.php');
    exit;
}

function handle_post_data($operation)
{
    if (have_post_data($operation)) {
        validate_profile_data($operation);
        add_or_edit($operation);
    }
}

function set_count_edu($operation)
{
    if ($operation == 'add') {
        $count_edu = 0;
    } else {
        global $prepared_edu;
        $count_edu = count($prepared_edu);
    }
    echo '<script>count_edu = ' . $count_edu . ";</script>\n";
}

function set_count_pos($operation)
{
    if ($operation == 'add') {
        $count_pos = 0;
    } else {
        global $prepared_positions;
        $count_pos = count($prepared_positions);
    }
    echo '<script>count_pos = ' . $count_pos . ";</script>\n";
}
