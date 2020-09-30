<?php
function print_login_or_logout($is_logged) {
    if ( $is_logged ) {
        echo '<p><a href="logout.php">Logout</a></p>' . "\n";
    } else {
        echo '<p><a href="login.php">Please log in</a></p>' . "\n";
    }
}

function query_profiles() {
    require_once 'pdo.php';
    $sql = 'SELECT profile_id, first_name, last_name, headline FROM Profile';
    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}

function print_table_header($is_logged) {
    echo "<tr>\n";
    echo "<th>Name</th>\n";
    echo "<th>Headline</th>\n";
    if ( $is_logged ) {
        echo "<th>Action</th>\n";
    }
    echo "</tr>\n";
}

function print_table_row($is_logged, $row) {
    $first_name = htmlentities($row['first_name']);
    $last_name = htmlentities($row['last_name']);
    $full_name = $first_name . ' ' . $last_name;
    $headline = htmlentities($row['headline']);
    $get_parameter = '?profile_id=' . urlencode($row['profile_id']);
    echo "<tr>\n";
    echo '<td><a href="view.php' . $get_parameter . '">' . $full_name . "</a></td>\n";
    echo '<td>' . $headline . "</td>\n";
    if ( $is_logged ) {
        echo '<td><a href="edit.php' . $get_parameter . '">Edit</a> / ';
        echo '<a href="delete.php' . $get_parameter . '">Delete</a></td>' . "\n";
    }
    echo "</tr>\n";
}

function print_profiles_table($is_logged) {
    $rows = query_profiles();
    if ( !empty($rows) ) {
        echo '<table border="1">' . "\n";
        print_table_header($is_logged);
        foreach ( $rows as $row ) {
            print_table_row($is_logged, $row);
        }
        echo "</table>\n";
    } else {
        echo "<p>No Rows Found</p>\n";
    }
}

function print_add_new($is_logged) {
    if ( $is_logged ) {
        echo '<p><a href="add.php">Add New Entry</a></p>' . "\n";
    }
}
?>
