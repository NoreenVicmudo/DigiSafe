<?php
    session_start();
    include 'Inc.Connect.php';

    if (!isset($_SESSION['UserLogin']) || $_SESSION['UserLogin'] !== true) {
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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="AccessLogs.css"> <!-- External CSS Link -->
        <script src="https://cdn.jsdelivr.net/npm/nprogress@0.2.0/nprogress.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nprogress@0.2.0/nprogress.css">
        <title>History</title>
    </head>
    <style>
        <?php include "AccessLogs.css"; ?>
    </style>
    <body>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <a class="go-back back-page" href="MainPage.php"><i class="bi bi-arrow-left"></i> Go back</a>

        <!--Query-->
        <div class="container mt-3">
            <p class="access-log">ACCESS LOG</p>
            <div class="table-container"> <!-- Wrapper for scrolling -->
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Locker ID</th>
                            <th>Result</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $userid=$_SESSION['userID'];
                            $sql = "SELECT * FROM accesslog WHERE UserID='$userid' ORDER BY TimeAttempt DESC";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['LockerID']) . "</td>";
                                    if ($row['ErrorDetails'] == 'N/A') {
                                        echo "<td>Success</td>";
                                    } else {
                                        echo "<td>Failed</td>";
                                    }
                                    echo "<td>" . htmlspecialchars($row['TimeAttempt']) . "</td>";
                                    echo "</tr>";
                                }
                            }
                            else {
                                echo "<tr><td colspan='3'>No access logs found.</td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <script>
            //////////Character Count
            document.addEventListener("DOMContentLoaded", function () {
                const textarea = document.querySelector(".txtarea-message");
                const charCount = document.getElementById("charCount");

                textarea.addEventListener("input", function () {
                    charCount.textContent = `${textarea.value.length}/300`;
                });
            });

            //////////For cursor Trail
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
                const backPageLinks = document.querySelectorAll(".back-page");

                backPageLinks.forEach(function(link) {
                    link.addEventListener("click", function (e) {
                        e.preventDefault(); // Prevent the default link behavior

                        NProgress.start(); // Start the loading bar animation

                        setTimeout(() => {
                            NProgress.set(0.7); // Move the bar to 70%
                        }, 300);

                        setTimeout(() => {
                            NProgress.done(); // Finish the loading bar animation
                            window.location.href = link.href; // Redirect after loading bar completes
                        }, 1200); // Ensure the redirect happens after the animation completes
                    });
                });

                window.onload = function () {
                    NProgress.done();
                };
            });
        </script>
    </body>
</html>
