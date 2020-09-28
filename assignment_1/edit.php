<?php
session_start();
require_once 'universal_functions.php';
require_once 'delete_edit_view_functions.php';
delete_edit_redirect();
$operation = 'edit';
if ( isset($_POST[$operation]) ) {
    require_once 'add_edit_functions.php';
    handle_post_data($operation);
} else {
    $prepared_row = retrieve_prepared_data($operation);
}
?>
<!DOCTYPE html>
<html>
<head>
<?php
require_once 'bootstrap.php';
?>
<title>Marcio Woitek Junior | Edit Profile</title>
</head>
<body>
<div class='container'>
<h1>Editing Profile for <?php echo htmlentities($_SESSION['name']) ?></h1>
<?php
print_error_or_success();
?>
<form method='POST'>
<p><label for='first_name'>First Name:</label>
<input type='text' name='first_name' id='first_name' size='60' value="<?php echo $prepared_row['first_name'] ?>"></p>
<p><label for='last_name'>Last Name:</label>
<input type='text' name='last_name' id='last_name' size='60' value="<?php echo $prepared_row['last_name'] ?>"></p>
<p><label for='email'>Email:</label>
<input type='text' name='email' id='email' size='30' value="<?php echo $prepared_row['email'] ?>"></p>
<p><label for='headline'>Headline:</label><br>
<input type='text' name='headline' id='headline' size='80' value="<?php echo $prepared_row['headline'] ?>"></p>
<p><label for='summary'>Summary:</label><br>
<textarea name='summary' id='summary' rows='8' cols='80'><?php echo $prepared_row['summary'] ?></textarea></p>
<p><input type='submit' name='edit' value='Save'>
<input type='submit' name='cancel' value='Cancel'></p>
<input type='hidden' name='profile_id' value="<?php echo $_GET['profile_id'] ?>">
</form>
</div>
</body>
</html>
