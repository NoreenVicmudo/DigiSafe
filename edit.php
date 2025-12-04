<?php
include 'Inc.Connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editRes'])) {
    // Handle the update request
    $user_id = $_POST['UserID'];
    $name = $_POST['editName'];
    $email = $_POST['editEmail'];
    $password = $_POST['editPassword'];

    $sql = "UPDATE users SET UserName='$name', Email='$email', Password='$password' WHERE UserID='$user_id'";
    if (mysqli_query($conn, $sql)) {
        echo "User updated successfully.<br><a href='index.php'>Back to access log</a>";
        exit;
    } else {
        echo "Error updating user: " . mysqli_error($conn);
    }
} elseif (isset($_GET['user_id'])) {
    // Show the edit form
    $user_id = $_GET['user_id'];
    $sql = "SELECT * FROM user WHERE UserID='$user_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        ?>
        <h2>Edit User</h2>
        <form method="POST">
            <input type="hidden" name="UserID" value="<?php echo htmlspecialchars($row['UserID']); ?>">
            <label>Name:<br>
                <input type="text" name="editName" value="<?php echo htmlspecialchars($row['UserName']); ?>" required>
            </label><br>
            <label>Email:<br>
                <input type="text" name="editEmail" value="<?php echo htmlspecialchars($row['Email']); ?>" required>
            </label><br>
            <label>Password:<br>
                <input type="text" name="editPassword" value="<?php echo htmlspecialchars($row['Password']); ?>" required>
            </label><br><br>
            <button type="submit" name="editRes">Update</button>
        </form>
        <?php
    } else {
        echo "User not found.";
    }
} else {
    echo "Invalid request.";
}

mysqli_close($conn);
?>
