<?php
session_start();
require_once 'universal_functions.php';
$is_logged = check_user_logged();
$schools = array();
if ($is_logged) {
    require_once 'pdo.php';
    $sql = 'SELECT name FROM Institution WHERE name LIKE :prefix';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':prefix' => $_GET['term'] . '%'));
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $schools[] = $row['name'];
    }
}
echo json_encode($schools, JSON_PRETTY_PRINT);
