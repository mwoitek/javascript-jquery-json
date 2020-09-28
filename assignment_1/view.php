<?php
require_once 'delete_edit_view_functions.php';
$operation = 'view';
$prepared_row = retrieve_prepared_data($operation);
?>
<!DOCTYPE html>
<html>
<head>
<?php
require_once 'bootstrap.php';
?>
<title>Marcio Woitek Junior | View Profile</title>
</head>
<body>
<div class='container'>
<h1>Profile information</h1>
<p>First Name: <?php echo $prepared_row['first_name'] ?></p>
<p>Last Name: <?php echo $prepared_row['last_name'] ?></p>
<p>Email: <?php echo $prepared_row['email'] ?></p>
<p>Headline:<br><?php echo $prepared_row['headline'] ?></p>
<p>Summary:<br><?php echo $prepared_row['summary'] ?></p>
<p><a href='index.php'>Done</a></p>
</div>
</body>
</html>
