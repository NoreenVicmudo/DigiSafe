<?php
    session_start();
    include 'Inc.Connect.php';

    if (!isset($_SESSION['AdminLogin']) || $_SESSION['AdminLogin'] !== true) {
        header("Location: LoginPage.php");
        exit();
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
    <title>Locker</title>
</head>
<style>
    <?php include "AdminLocker.css" ?>
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
                                <a href="AdminUser.php" class="next-page">User</a>
                            </li>
                            <li>
                                <a href="#" class="next-page">Locker</a>
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
                <a class="sidebar" href="AdminUser.php">User</a>
                <a class="sidebar" href="#">Locker</a>
                <a class="sidebar" href="AdminQRCode">QR Code</a>
                <a class="sidebar" href="AdminCustomerSupport.php">Customer</a>
            </div>
            <a class="logout next-page" href="Inc.Logout.php">Logout</a>
        </div>

        <!--Table-->
        <p class="tagline">LOCKER</p>
        <!-- Assign Locker Pop-up -->
        <div class="overlay assign-overlay">
            <div class="popup">
                <h2>Assign Locker</h2>
                <form class="form">
                    <label>Locker ID:<input class="input" type="number" placeholder="Locker ID" required></label>
                    <label>User ID:<input class="input" type="number" placeholder="User ID" required></label>
                    <br>
                    <button class="submit" type="submit">Submit</button>
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
                            <th>Locker ID</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM locker ORDER BY LockerID DESC";
                            $result = mysqli_query($conn, $sql);

                            while($row = mysqli_fetch_assoc($result)){
                                $lockerID=$row['LockerID'];
                                $location=$row['Location'];
                                $status=$row['Status'];
                            
                            ?>   
                                <tr>
                                    <td><?php echo htmlspecialchars($lockerID); ?></td>
                                    <td><?php echo htmlspecialchars($location); ?></td>
                                    <td><?php echo htmlspecialchars($status); ?></td>
                                    <td>
                                        <button class="edit-btn" onclick="openEditPopup('<?php echo $lockerID; ?>')">Edit</button>

                                        <!-- Edit Locker Pop-up -->
                                        <div class="overlay edit-overlay" id="edit-<?php echo $lockerID; ?>">
                                            <div class="popup">
                                                <h2>Edit Locker</h2>
                                                <form class="form" method="POST" action="Inc.EditLocker.php">
                                                    <!--
                                                    <label>
                                                        Locker ID:<br>
                                                        <input class="input" type="text" name="lockerID" value="<?php echo htmlspecialchars($lockerID); ?>" readonly>
                                                    </label>
                                                    <label>
                                                        User ID:<br>
                                                        <input class="input" type="text" name="userID" value="<?php echo htmlspecialchars($userID); ?>" required>
                                                    </label>
                                                    -->
                                                    <label>
                                                        Location:<br>
                                                        <input class="input" type="text" name="location" value="<?php echo htmlspecialchars($location); ?>" required>
                                                    </label>
                                                    <br>
                                                    <button class="submit" type="submit" name="editRes">Submit</button>
                                                    <button class="submit close-btn" type="button" onclick="closeEditPopup('<?php echo $lockerID; ?>')">Close</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                        <?php } ?>
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

        //pede gamitin tong js code na to, pede ren kayo magsearch ng another code tas alisin nyo to or modify 
        /*
        //adding data
        function addData() {
            // Get input values
            let lockerid = document.getElementById("lockeridInput").value;
            let userid = document.getElementById("useridInput").value;
            let status = document.getElementById("statusInput").value;

            if (lockerid === "" || userid === "" || status === "") {
                alert("Please fill in all fields.")
            }
            else {
                // Get the table and insert a new row at the end
                let table = document.getElementById("outputTable");
                let newRow = table.insertRow(table.rows.length);

                // Insert data into cells of the new row
                newRow.insertCell(0).innerHTML = lockerid;
                newRow.insertCell(1).innerHTML = userid;
                newRow.insertCell(2).innerHTML = status;
                newRow.insertCell(3).innerHTML =
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
            let useridCell = row.cells[1];
            let statusCell = row.cells[2];

            // Prompt the user to enter updated values
            let useridInput =
                prompt("Enter UserID:",
                    useridCell.innerHTML);
            let statusInput =
                prompt("Enter status:",
                    statusCell.innerHTML);

            // Update the cell contents with the new values
            useridCell.innerHTML = useridInput;
            statusCell.innerHTML = statusInput;
        }

        function deleteData(button) {

            // Get the parent row of the clicked button
            let row = button.parentNode.parentNode;

            // Remove the row from the table
            row.parentNode.removeChild(row);
        }

        function clearInputs() {

            // Clear input fields
            document.getElementById("lockeridInput").value = "";
            document.getElementById("useridInput").value = "";
            document.getElementById("statusInput").value = "";
        }

        function clearInputs() {

            // Clear input fields
            document.getElementById("lockeridInput").value = "";
            document.getElementById("useridInput").value = "";
            document.getElementById("statusInput").value = "";
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
                nextPageButtons.forEach(function(button) {
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