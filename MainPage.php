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
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
            rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
        <title>Home</title>
    </head>

    <style>
        <?php include "MainPage.css" ?>
    </style>

    <body>
        <div class="background"></div>
        <!-- Multiple animated glowing lines -->
        <div class="glow-line" style="top: 20%; left: 20%;"></div>
        <div class="glow-line" style="top: 40%; left: 60%;"></div>
        <div class="glow-line" style="top: 70%; left: 30%;"></div>
        <div class="glow-line" style="top: 85%; left: 80%;"></div>
        <div class="container custom-container">
            <div class="row custom-row" style="height: 100vh;">
                <!-- Login Form at the Center of the Left -->
                <div class="col-12 col-md-5 d-flex align-items-center justify-content-start custom-col">
                    <div class="form-container">
                        <div class="button-container">
                            <a href="QRCode.php" class="next-page"><button type="submit" class="btn-qrcode">Generate QR Code</button></a>
                            <a href="AccessLogs.php" class="next-page"><button type="submit" class="btn-viewlogs">View History Logs</button></a>
                            <a href="CustomerSupport.php" class="next-page"><button type="submit" class="btn-changepass">Customer Support</button></a>
                            <a href="FAQ.php" class="next-page"><button type="submit" class="btn-customersupport">FAQs</button></a>
                            <a href="ChangePassword2.php" class="next-page"><button type="submit" class="btn-faq">Change Password</button></a>
                            <a href="LoginPage.php" class="next-page"><button type="submit" class="btn-logout">Log Out</button></a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-7 d-flex align-items-center justify-content-end custom-col">
                    <div class="title-container text-end">
                        <div class="title">
                            <h1>DigiSafe</h1>
                            <p>Welcome to the Home Page</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- For design only-->
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