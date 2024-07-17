<?php
session_start();
if (isset($_SESSION['userdata'])) {
    echo "<pre>";
    print_r($_SESSION['userdata']);
    echo "</pre>";
} else {
    echo "No userdata found.";
}

// Add a link to go back to the login page or continue
echo '<a href="../index.php">Back to Login</a>';
?>
