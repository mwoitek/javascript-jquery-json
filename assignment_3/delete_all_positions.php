<?php
function delete_all_positions($profile_id) {
    global $pdo;
    $sql = 'DELETE FROM Position WHERE profile_id = :pid';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':pid' => $profile_id));
}
?>
