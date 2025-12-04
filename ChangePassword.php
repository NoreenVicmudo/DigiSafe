<?php
    session_start();
    include 'Inc.Connect.php';

    if (!isset($_SESSION['EmailExist']) || $_SESSION['EmailExist'] !== true) {
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
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/nprogress@0.2.0/nprogress.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nprogress@0.2.0/nprogress.css">
        <title>Change Password</title>
        <style>
            <?php include "ChangePassword.css"; ?>
        </style>
    </head>
    <body>
        <a class="go-back back-page" href="FindYourAccount.php"><i class="bi bi-arrow-left"></i> Go back</a>
        <div class="form-container">
            <h2>Change Password</h2>
            <h5>New password in this email:</h5>
            <h6>email@gmail.com</h6>
            <br>

            <form method="POST" action="processChangePassword.php">
                <div class="input-group">
                    <input type="password" id="new-password" name="newPassword" placeholder=" " required>
                    <label for="new-password">New Password</label>
                </div>
                <br>
                <div class="input-group">
                    <input type="password" id="confirm-password" name="confirmPassword" placeholder=" " required>
                    <label for="confirm-password">Confirm Password</label>
                </div>

                <div class="message">Passwords do not match.</div>
                <br>

                <button type="submit" class="btn back-page">Continue</button>
            </form>
        </div>
        <script>
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
                // Select all links with the "back-page" class
                const backPageLinks = document.querySelectorAll(".back-page");

                // Add event listener for each back link
                backPageLinks.forEach(function(link) {
                    link.addEventListener("click", function (e) {
                        e.preventDefault(); // Prevent default link behavior to show the loading animation

                        NProgress.start(); // Start the loading bar animation

                        setTimeout(() => {
                            NProgress.set(0.7); // Move the bar to 70%
                        }, 300); // Adjust timing here

                        setTimeout(() => {
                            NProgress.done(); // Finish the loading bar animation
                            window.location.href = link.href; // Redirect after loading bar completes
                        }, 1200); // Ensure the redirect happens after the animation completes
                    });
                });

                // Ensure NProgress finishes when the page loads
                window.onload = function () {
                    NProgress.done();
                };
            });
        </script>
    </body>
</html>