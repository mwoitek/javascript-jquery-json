<?php
session_start();
require_once 'delete_edit_view_functions.php';
delete_edit_redirect();
$operation = 'delete';
if ( isset($_POST[$operation]) ) {
    delete();
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
<title>Marcio Woitek Junior | Delete Profile</title>
</head>
<body>
<div class='container'>
<h1>Deleting Profile</h1>
<form method='POST'>
<p>First Name: <?php echo $prepared_row['first_name'] ?></p>
<p>Last Name: <?php echo $prepared_row['last_name'] ?></p>
<p><input type='submit' name='delete' value='Delete'>
<input type='submit' name='cancel' value='Cancel'></p>
<input type='hidden' name='profile_id' value="<?php echo $_GET['profile_id'] ?>">
</form>
</div>
</body>
</html>
