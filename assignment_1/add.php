<?php
session_start();
require_once 'universal_functions.php';
require_once 'add_edit_functions.php';
$is_logged = check_user_logged();
deny_access_if_not_logged($is_logged);
check_clicked_on_cancel();
$operation = 'add';
handle_post_data($operation);
?>
<!DOCTYPE html>
<html>
<head>
<?php
require_once 'bootstrap.php';
?>
<title>Marcio Woitek Junior | Add Profile</title>
</head>
<body>
<div class='container'>
<h1>Adding Profile for <?php echo htmlentities($_SESSION['name']) ?></h1>
<?php
print_error_or_success();
?>
<form method='POST'>
<p><label for='first_name'>First Name:</label>
<input type='text' name='first_name' id='first_name' size='60'></p>
<p><label for='last_name'>Last Name:</label>
<input type='text' name='last_name' id='last_name' size='60'></p>
<p><label for='email'>Email:</label>
<input type='text' name='email' id='email' size='30'></p>
<p><label for='headline'>Headline:</label><br>
<input type='text' name='headline' id='headline' size='80'></p>
<p><label for='summary'>Summary:</label><br>
<textarea name='summary' id='summary' rows='8' cols='80'></textarea></p>
<p><input type='submit' value='Add'>
<input type='submit' name='cancel' value='Cancel'></p>
</form>
</div>
</body>
</html>
