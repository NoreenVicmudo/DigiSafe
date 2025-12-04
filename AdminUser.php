<?php
session_start();
include 'Inc.Connect.php';

if (!isset($_SESSION['AdminLogin']) || $_SESSION['AdminLogin'] !== true) {
    header("Location: LoginPage.php");
    exit();
}

if (isset($_POST['addRes'])) {
    
    $name = $_POST['addName'];
    $email = $_POST['addEmail'];
    $password = $_POST['addPassword'];
    $hashed_password = password_hash($password,PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO user (Name, Email, Password, Role, RegistrationDate)
                VALUES ('$name', '$email', '$hashed_password', 'User', NOW())");
}

if (isset($_POST['editRes'])) {

    $userID = intval($_POST['editUserID']);
    $name = $_POST['editName'];
    $email = $_POST['editEmail'];

    if (!empty($_POST['editPassword'])) {
        $editedpassword = $_POST['editPassword'];
        $hashpassword = password_hash( $editedpassword, PASSWORD_DEFAULT);

        mysqli_query($conn, "UPDATE user SET Name='$name', Email='$email', Password='$hashpassword' WHERE UserID=$userID");

    } else {
        mysqli_query($conn, "UPDATE user SET Name='$name', Email='$email' WHERE UserID=$userID");
    }
    
}

if (isset($_POST['deleteRes'])) {

    $userID = intval($_POST['deleteUserID']);

    if (isset($_SESSION['userID']) && $_SESSION['userID'] == $userID) {
        echo "<script>alert('You cannot delete your own account while logged in.');</script>";
    } else {
        $deleteSQL = "DELETE FROM user WHERE UserID = $userID";
        mysqli_query($conn, $deleteSQL);
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
    <title>User</title>
</head>
<style>
    <?php include "AdminUser.css" ?>
</style>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <div class="content">
        <div class="bg-color">
            <div class="header">
                <a href="#" class="logo">
                    <span>D</span><span>i</span><span>g</span><span>i</span><span>S</span><span>a</span><span>f</span><span>e</span>
                </a>
                <div class="menu-search-container">
                    <!-- Hamburger Menu -->
                    <div class="menu-toggle" id="menu-toggle">
                        <span class="bar" id="bar"></span>
                        <span class="bar" id="bar"></span>
                        <span class="bar" id="bar"></span>
                    </div>
                    <div class="menu-container">
                        <ul id="menu">
                            <li>
                                <a href="AdminHomePage.php" class="dropbtn next-page">Home</a>
                            </li>
                            <li>
                                <a href="AdminAccessLog.php" class="next-page">Access Log</a>
                            </li>
                            <li>
                                <a href="#" class="next-page">User</a>
                            </li>
                            <li>
                                <a href="AdminLocker.php" class="next-page">Locker</a>
                            </li>
                            <li>
                                <a href="AdminQRCode.php" class="next-page">QR Code</a>
                            </li>
                            <li>
                                <a href="AdminCustomerSupport.php" class="next-page">Customer</a>
                            </li>
                            <li>
                                <a href="Inc.Logout.php" class="next-page">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div id="sidebar">
            <div class="sidebar-links">
                <a class="sidebar" href="AdminHomePage.php">Home</a>
                <a class="sidebar" href="AdminAccessLog.php">Access Log</a>
                <a class="sidebar" href="#">User</a>
                <a class="sidebar" href="AdminLocker.php">Locker</a>
                <a class="sidebar" href="AdminQRCode.php">QR Code</a>
                <a class="sidebar" href="AdminCustomerSupport.php">Customer</a>
            </div>
            <a class="logout next-page" href="Inc.Logout.php">Logout</a>
        </div>

        <!--Table-->
        <p class="tagline">User</p>
        <div class="add-info">
            <button class="button assign-btn">Add User</button>
        </div>
        <!-- Assign Locker Pop-up -->
        <div class="overlay assign-overlay">
            <div class="popup">
                <h2>Add User</h2>
                <form class="form" method="POST">
                    <label>Name:<input class="input" type="text" id="nameInput" placeholder="Full Name" name="addName"
                            required></label>
                    <label>Email:<input class="input" type="email" id="emailInput" placeholder="School or work email" name="addEmail"
                            required></label>
                    <label>Password:<input class="input" type="password" id="passwordInput" placeholder="Password" name="addPassword"
                            required></label>
                    <br>
                    <button class="submit" type="submit" name="addRes">Submit</button>
                    <button class="submit close-btn" type="button">Close</button>
                </form>
            </div>
        </div>
        <!--Table Content-->
        <div class="container mt-3">
            <div class="table-container"> <!-- Wrapper for scrolling -->
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Date Registered</th>
                        <th></th>
                        <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM user ORDER BY UserID ASC";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['UserID']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Email']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Role']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['RegistrationDate']) . "</td>";
                                echo "<td>
                                <button class='edit-btn'>Edit</button>
                                <!-- Edit Locker Pop-up -->
                                <div class='overlay edit-overlay'>
                                    <div class='popup'>
                                        <h2>Edit User</h2>
                                        <form class='form' method='POST'>
                                        <input type='hidden' name='editUserID' value='" . htmlspecialchars($row['UserID']) . "'>
                                            <label>
                                                Name:<br>
                                                <input class='input' type='text' placeholder='Name' name='editName' value='" . htmlspecialchars($row['Name']) . "' required>
                                            </label>
                                            <label>
                                                Email:<br>
                                                <input class='input' type='email' placeholder='Email' name='editEmail' value='" . htmlspecialchars($row['Email']) . "' required>
                                            </label>
                                            <label>
                                                Password:<br>
                                                <input class='input' type='password' placeholder='Password' name='editPassword' required>
                                            </label>
                                            <br>
                                            <button class='submit' type='submit' name='editRes'>Submit</button>
                                            <button class='submit close-btn' type='button'>Close</button>
                                        </form>
                                    </div>
                                </div>
                            </td>";
                            echo "<td>
                                <button class='delete-btn'>Delete</button>
                                <!-- Edit Locker Pop-up -->
                                <div class='overlay delete-overlay'>
                                    <div class='popup'>
                                        <h2>Confirm Delete?</h2>
                                        <br>
                                        <form class='form' method='POST'>
                                        <input type='hidden' name='deleteUserID' value='" . htmlspecialchars($row['UserID']) . "'>
                                            <button class='submit' type='submit' name='deleteRes'>Confirm</button>
                                            <button class='submit close-btn' type='button'>Cancel</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>";
                                echo "</tr>";
                            }
                        } else {
                                echo "<tr><td colspan='6'>No access logs found.</td></tr>";
                        }
                        mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        document.body.style.overflow = "auto"; // Or "scroll" if you want always visible

        // Function to open popups
        function openModal(overlay) {
            overlay.style.display = "flex";
        }

        // Function to close popups
        function closeModal(overlay) {
            overlay.style.display = "none";
        }

        // Handle Assign Locker popup
        document.querySelector(".assign-btn").addEventListener("click", function () {
            let assignOverlay = document.querySelector(".assign-overlay");
            openModal(assignOverlay);
        });
        document.querySelector(".assign-overlay .close-btn").addEventListener("click", function () {
            let assignOverlay = document.querySelector(".assign-overlay");
            closeModal(assignOverlay);
        });

        // Handle Edit Locker popups (Multiple rows)
        document.querySelectorAll(".edit-btn").forEach((editButton, index) => {
            editButton.addEventListener("click", function () {
                let editOverlays = document.querySelectorAll(".edit-overlay");
                openModal(editOverlays[index]);
            });
        });

        document.querySelectorAll(".edit-overlay .close-btn").forEach((closeButton, index) => {
            closeButton.addEventListener("click", function () {
                let editOverlays = document.querySelectorAll(".edit-overlay");
                closeModal(editOverlays[index]);
            });
        });

        // Handle Delete Locker popups (Multiple rows)
        document.querySelectorAll(".delete-btn").forEach((deleteButton, index) => {
            deleteButton.addEventListener("click", function () {
                let deleteOverlays = document.querySelectorAll(".delete-overlay");
                openModal(deleteOverlays[index]);
            });
        });

        document.querySelectorAll(".delete-overlay .close-btn").forEach((closeButton, index) => {
            closeButton.addEventListener("click", function () {
                let deleteOverlays = document.querySelectorAll(".delete-overlay");
                closeModal(deleteOverlays[index]);
            });
        });

        // Close modal when clicking outside
        window.addEventListener("click", function (event) {
            document.querySelectorAll(".overlay").forEach((overlay) => {
                if (event.target === overlay) {
                    closeModal(overlay);
                }
            });
        });


        // Sidebar toggle functionality
        document.addEventListener("DOMContentLoaded", function () {
            const menuToggle = document.getElementById("menu-toggle");
            const sidebar = document.getElementById("sidebar");
            const closeBtn = document.getElementById("close-btn");

            menuToggle.addEventListener("click", function (event) {
                sidebar.style.width = "200px";  // Show the sidebar
                event.stopPropagation();  // Prevent click from closing sidebar immediately
            });

            // Close sidebar when clicking outside of it
            document.addEventListener("click", function (event) {
                // Check if the click was outside of the sidebar and menu toggle
                if (!sidebar.contains(event.target) && event.target !== menuToggle) {
                    sidebar.style.width = "0";  // Hide the sidebar
                }
            });

            // Prevent click inside the sidebar or menu toggle from closing the sidebar
            sidebar.addEventListener("click", function (event) {
                event.stopPropagation();  // Prevent click from closing sidebar
            });
        });

        //pede gamitin tong js code na to, pede ren kayo magsearch ng another code tas alisin nyo to (if di nagana) or modify 
        /*
        //adding data
        function addData() {
            // Get input values
            let userid = document.getElementById("useridInput").value;
            let name = document.getElementById("nameInput").value;
            let email = document.getElementById("emailInput").value;
            let password = document.getElementById("passwordInput").value;
            let role = document.getElementById("roleInput").value;
            let registrationdate = document.getElementById("registrationdateInput").value;

            if (userid === "" || name === "" || email === "" || password === "" || role === "" || registrationdate === "") {
                alert("Please fill in all fields.");
            }
            else {
                // Get the table and insert a new row at the end
                let table = document.getElementById("outputTable");
                let newRow = table.insertRow(table.rows.length);

                // Insert data into cells of the new row
                newRow.insertCell(0).innerHTML = userid;
                newRow.insertCell(1).innerHTML = name;
                newRow.insertCell(2).innerHTML = email;
                newRow.insertCell(3).innerHTML = password;
                newRow.insertCell(4).innerHTML = role;
                newRow.insertCell(5).innerHTML = registrationdate;
                newRow.insertCell(6).innerHTML =
                    '<button onclick="editData(this)">Edit</button>&nbsp;' +
                    '<button onclick="deleteData(this)">Delete</button>';

                // Clear input fields
                clearInputs();
            }
        }

        function editData(button) {

            // Get the parent row of the clicked button
            let row = button.parentNode.parentNode;

            // Get the cells within the row
            let nameCell = row.cell[1];
            let emailCell = row.cell[2];
            let roleCell = row.cell[4];

            // Prompt the user to enter updated values
            let nameInput = prompt("Enter updated name:", nameCell.innerHTML);
            let emailInput = prompt("Enter updated email:", emailCell.innerHTML);
            let roleInput = prompt("Enter updated Role", roleCell.innerHTML);

            // Update the cell contents with the new values
            nameCell.innerHTML = nameInput;
            emailCell.innerHTML = emailInput;
            roleCell.innerHTML = roleInput;
        }

        function deleteData(button) {

            // Get the parent row of the clicked button
            let row = button.parentNode.parentNode;

            // Remove the row from the table
            row.parentNode.removeChild(row);
        }

        function clearInputs() {

            // Clear input fields
            document.getElementById("useridInput").value = "";
            document.getElementById("nameInput").value = "";
            document.getElementById("emailInput").value = "";
            document.getElementById("passwordInput").value = "";
            document.getElementById("roleInput").value = "";
            document.getElementById("registrationdateInput").value = "";
        }
        */

        //////////For Cursor Trail
        const trailLength = 12; // Number of points in the trail
        const trails = [];

        for (let i = 0; i < trailLength; i++) {
            const div = document.createElement("div");
            div.classList.add("cursor-trail");
            document.body.appendChild(div);
            trails.push(div);
        }

        let mouseX = 0, mouseY = 0;
        document.addEventListener("mousemove", (e) => {
            mouseX = e.clientX;
            mouseY = e.clientY;
        });

        function animateTrail() {
            for (let i = trails.length - 1; i >= 0; i--) {
                let nextX = i === 0 ? mouseX : parseFloat(trails[i - 1].style.left);
                let nextY = i === 0 ? mouseY : parseFloat(trails[i - 1].style.top);

                trails[i].style.left = `${nextX}px`;
                trails[i].style.top = `${nextY}px`;
                trails[i].style.transform = `translate(-50%, -50%) scale(${1 - i / trails.length})`;
                trails[i].style.opacity = `${1 - i / trails.length}`;
            }
            requestAnimationFrame(animateTrail);
        }

        animateTrail();

        //////////for loading animation
        document.addEventListener('DOMContentLoaded', function () {
            // Select all links with the "next-page" class (which wraps the buttons)
            const nextPageButtons = document.querySelectorAll(".next-page");

            // Add event listener for each button inside the links
            nextPageButtons.forEach(function (button) {
                button.addEventListener("click", function (e) {
                    e.preventDefault(); // Prevent the default link behavior

                    NProgress.start(); // Start the loading bar

                    setTimeout(() => {
                        NProgress.set(0.7); // Move the bar 70% quickly
                    }, 300); // Adjust the speed here

                    setTimeout(() => {
                        NProgress.done(); // Complete the bar animation
                        window.location.href = button.href; // Redirect after the loading bar completes
                    }, 1200); // Adjust the time here based on the animation duration
                });
            });

            // Ensure the progress bar is fully complete when the page is loaded
            window.onload = function () {
                NProgress.done();
            };
        });
    </script>
</body>

</html>