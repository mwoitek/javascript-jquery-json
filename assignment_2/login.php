<?php
session_start();
require_once 'universal_functions.php';
check_clicked_on_cancel();
require_once 'login_functions.php';
check_password();
?>
<!DOCTYPE html>
<html>
<head>
<?php
require_once 'bootstrap.php';
?>
<title>Marcio Woitek Junior | Login Page</title>
</head>
<body>
<div class='container'>
<h1>Please Log In</h1>
<?php
print_error_or_success();
?>
<form method='POST'>
<p><label for='email'>Email</label>
<input type='text' name='email' id='email'></p>
<p><label for='pw'>Password</label>
<input type='password' name='pass' id='pw'></p>
<p><input type='submit' onclick='return doValidate();' value='Log In'>
<input type='submit' name='cancel' value='Cancel'></p>
</form>
<script src='doValidate.js'></script>
</div>
</body>
</html>
