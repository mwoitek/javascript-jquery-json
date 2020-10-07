<?php
    require_once 'pdo.php';
    require_once 'delete_edit_view_functions.php';
    $operation = 'view';
    list($prepared_profile, $prepared_positions) = retrieve_prepared_profile_positions($operation);
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
            <p>First Name: <?php echo $prepared_profile['first_name']; ?></p>
            <p>Last Name: <?php echo $prepared_profile['last_name']; ?></p>
            <p>Email: <?php echo $prepared_profile['email']; ?></p>
            <p>Headline:<br><?php echo $prepared_profile['headline']; ?></p>
            <p>Summary:<br><?php echo $prepared_profile['summary']; ?></p>
            <?php
                print_positions($prepared_positions, $operation);
            ?>
            <p><a href='index.php'>Done</a></p>
        </div>
    </body>
</html>
