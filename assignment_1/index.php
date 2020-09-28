<?php
session_start();
require_once 'universal_functions.php';
require_once 'index_functions.php';
$is_logged = check_user_logged();
?>
<!DOCTYPE html>
<html>
<head>
<?php
require_once 'bootstrap.php';
?>
<title>Marcio Woitek Junior | Assignment: Profile Database</title>
</head>
<body>
<div class='container'>
<h1>Marcio Woitek's Resume Registry</h1>
<?php
print_error_or_success();
print_login_or_logout($is_logged);
print_profiles_table($is_logged);
print_add_new($is_logged);
?>
</div>
</body>
</html>
