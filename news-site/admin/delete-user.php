<?php
include "config.php";

if (isset($_POST['id'])) {
    $user_id = $_POST['id'];

    $sql = "DELETE FROM user WHERE user_id = {$user_id}";
    if (mysqli_query($conn, $sql)) {
        echo "User deleted successfully";
        location.reload(); 
    } else {
        echo "Error deleting user: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
