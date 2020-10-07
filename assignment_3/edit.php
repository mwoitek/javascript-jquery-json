<?php
    session_start();
    require_once 'pdo.php';
    require_once 'add_edit_functions.php';
    require_once 'delete_edit_view_functions.php';
    delete_edit_redirect();
    $operation = 'edit';
    if ( isset($_POST[$operation]) ) {
        handle_post_data($operation);
    } else {
        list($prepared_profile, $prepared_positions) = retrieve_prepared_profile_positions($operation);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
            require_once 'bootstrap.php';
            require_once 'jquery.php';
        ?>
        <title>Marcio Woitek Junior | Edit Profile</title>
    </head>
    <body>
        <div class='container'>
            <h1>Editing Profile for <?php echo htmlentities($_SESSION['name']); ?></h1>
            <?php
                print_error_or_success();
            ?>
            <form method='POST'>
                <p>
                    <label for='first_name'>First Name:</label>
                    <input type="text" name="first_name" id="first_name" size="60" value="<?= $prepared_profile['first_name'] ?>">
                </p>
                <p>
                    <label for='last_name'>Last Name:</label>
                    <input type="text" name="last_name" id="last_name" size="60" value="<?= $prepared_profile['last_name'] ?>">
                </p>
                <p>
                    <label for='email'>Email:</label>
                    <input type="text" name="email" id="email" size="30" value="<?= $prepared_profile['email'] ?>">
                </p>
                <p>
                    <label for='headline'>Headline:</label><br>
                    <input type="text" name="headline" id="headline" size="80" value="<?= $prepared_profile['headline'] ?>">
                </p>
                <p>
                    <label for='summary'>Summary:</label><br>
                    <textarea name='summary' id='summary' rows='8' cols='80'><?= $prepared_profile['summary'] ?></textarea>
                </p>
                <p>
                    Position: <input type='submit' id='add_pos' value='+'>
                    <div id='position_fields'>
                        <?php
                            print_positions($prepared_positions, $operation);
                        ?>
                    </div>
                </p>
                <p>
                    <input type='submit' name='edit' value='Save'>
                    <input type='submit' name='cancel' value='Cancel'>
                </p>
                <input type="hidden" name="profile_id" value="<?= $_GET['profile_id'] ?>">
                <input type='hidden' name='used_positions' id='used_positions'>
            </form>
            <?php
                set_count_pos($operation);
            ?>
            <script src='positions.js'></script>
        </div>
    </body>
</html>
