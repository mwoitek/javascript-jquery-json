<?php
session_start();
require_once 'universal_functions.php';
not_logged_cancel_redirect();
require_once 'add_edit_functions.php';
$operation = 'add';
handle_post_data($operation);
?>
<!DOCTYPE html>
<html>
<head>
<?php
require_once 'bootstrap.php';
require_once 'jquery.php';
?>
<title>Marcio Woitek Junior | Add Profile</title>
</head>
<body>
<div class='container'>
<h1>Adding Profile for <?php echo htmlentities($_SESSION['name']); ?></h1>
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
<p>Position: <input type='submit' id='addPos' value='+'>
<div id='position_fields'>
</div></p>
<p><input type='submit' value='Add'>
<input type='submit' name='cancel' value='Cancel'></p>
</form>
<?php
require_once 'position_functions.php';
set_count_pos($operation);
?>
<script src='add_position.js'></script>
</div>
</body>
</html>
