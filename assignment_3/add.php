<?php
session_start();
require_once 'pdo.php';
require_once 'add_edit_functions.php';
not_logged_cancel_redirect();
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
            <p>
                <label for='first_name'>First Name:</label>
                <input type='text' name='first_name' id='first_name' size='60'>
            </p>
            <p>
                <label for='last_name'>Last Name:</label>
                <input type='text' name='last_name' id='last_name' size='60'>
            </p>
            <p>
                <label for='email'>Email:</label>
                <input type='text' name='email' id='email' size='30'>
            </p>
            <p>
                <label for='headline'>Headline:</label><br>
                <input type='text' name='headline' id='headline' size='80'>
            </p>
            <p>
                <label for='summary'>Summary:</label><br>
                <textarea name='summary' id='summary' rows='8' cols='80'></textarea>
            </p>
            <p>
                Education: <input type='submit' id='add_edu' value='+'>
                <div id='edu_fields'></div>
            </p>
            <p>
                Position: <input type='submit' id='add_pos' value='+'>
                <div id='position_fields'></div>
            </p>
            <p>
                <input type='submit' value='Add'>
                <input type='submit' name='cancel' value='Cancel'>
            </p>
            <input type='hidden' name='used_edu' id='used_edu'>
            <input type='hidden' name='used_positions' id='used_positions'>
        </form>
        <?php
        set_count_edu($operation);
        set_count_pos($operation);
        ?>
        <script src='education.js'></script>
        <script src='positions.js'></script>
    </div>
</body>

</html>
