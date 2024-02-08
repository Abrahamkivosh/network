<?php

// display errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// read
if (!defined('READ_ENV_FILE_INCLUDED')) {
    require_once __DIR__ . '/read_env_file.php';
    define('READ_ENV_FILE_INCLUDED', true);
}

// Connect to your database
$servername = getenv ('CONFIG_DB_HOST');
$username =  getenv ('CONFIG_DB_USER');
$password =getenv ('CONFIG_DB_PASS');
$dbname =  getenv ('CONFIG_DB_NAME');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch records from the userbillinfo table
$sql = "SELECT * FROM userbillinfo ORDER BY id ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Initialize a variable to track the new ID
    $new_id = 1;

    // Iterate through each row and update the ID
    while ($row = $result->fetch_assoc()) {
        $old_id = $row['id'];
        // Update the ID to the new incremented value
        $sql_update = "UPDATE userbillinfo SET id = $new_id WHERE id = $old_id";
        if ($conn->query($sql_update) === TRUE) {
            echo "Record with ID $old_id updated to $new_id successfully<br>";
            $new_id++;
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
} else {
    echo "0 results";
}

// Close the connection
$conn->close();
?>
