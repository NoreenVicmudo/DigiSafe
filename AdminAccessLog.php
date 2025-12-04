    <?php
    session_start();
    include 'Inc.Connect.php';

    if (!isset($_SESSION['AdminLogin']) || $_SESSION['AdminLogin'] !== true) {
        header("Location: LoginPage.php");
        exit();
    }

    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nprogress@0.2.0/nprogress.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
    <title>Access Log</title>
    <style>
        <?php include 'AdminAccessLog.css' ?>
    </style>
</head>

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
                                <a href="#" class="next-page">Access Log</a>
                            </li>
                            <li>
                                <a href="AdminUser.php" class="next-page">User</a>
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
                <a class="sidebar" href="#">Access Log</a>
                <a class="sidebar" href="AdminUser.php">User</a>
                <a class="sidebar" href="AdminLocker.php">Locker</a>
                <a class="sidebar" href="AdminQRCode.php">QR Code</a>
                <a class="sidebar" href="AdminCustomerSupport.php">Customer</a>
            </div>
            <a class="logout next-page" href="Inc.Logout.php">Logout</a>
        </div>

        <p class="tagline">ACCESS LOG</p>
        <div class="container mt-3">
            <div class="table-container"> <!-- Wrapper for scrolling -->
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Access Log ID</th>
                            <th>User ID</th>
                            <th>Locker ID</th>
                            <th>QR Code ID</th>
                            <th>Action Type</th>
                            <th>Time Attempt</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM accesslog ORDER BY TimeAttempt DESC";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['AccessLogID']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['UserID']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['LockerID']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['QRCodeID']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['ActionType']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['TimeAttempt']) . "</td>";
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

        //////////For cursor trailing
        const trailLength = 12;
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