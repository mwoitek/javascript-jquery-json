<?php
function retrieve_prepared_profile_positions($operation) {
    // $operation = 'edit' or 'view'
    require_once 'pdo.php';
    require_once 'delete_edit_view_functions.php';
    $prepared_profile = retrieve_prepared_profile($operation, $pdo);
    require_once 'position_functions.php';
    $prepared_positions = retrieve_prepared_positions($pdo);
    return array($prepared_profile, $prepared_positions);
}
?>
