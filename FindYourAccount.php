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
        <link rel="stylesheet" href="FindYourAccount.css">
        <script src="https://cdn.jsdelivr.net/npm/nprogress@0.2.0/nprogress.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nprogress@0.2.0/nprogress.css">
        <title>Is This You?</title>
    </head>
    <style>
        <?php include "FindYourAccount.css"; ?> 
    </style>
    <body>
        <!-- Go Back Button -->
        <a class="go-back back-page" href="ForgotPassword.php"><i class="bi bi-arrow-left"></i> Go back</a>

        <div class="form-container">
            <p class="form-title">Is this you?</p>

            <!-- User Info -->
            <div class="user-info">
                <h2>aking pangalan</h2> <!-- Name from DB --><br>
                <h6>email@gmail.com</h6> <!-- Email from DB -->
            </div>

            <!-- OTP Input -->
            <div class="otp-container">
                <input type="text" maxlength="1" class="otp-input" oninput="moveToNext(this, 0)">
                <input type="text" maxlength="1" class="otp-input" oninput="moveToNext(this, 1)">
                <input type="text" maxlength="1" class="otp-input" oninput="moveToNext(this, 2)">
                <input type="text" maxlength="1" class="otp-input" oninput="moveToNext(this, 3)">
                <input type="text" maxlength="1" class="otp-input" oninput="moveToNext(this, 4)">
                <input type="text" maxlength="1" class="otp-input" oninput="moveToNext(this, 5)">
            </div><br>

            <p id="otpMessage" style="display: none; color: green; font-weight: bold;"></p>
            <p id="timerText"><span id="timer"></span></p>

            <!-- Error Message -->
            <div class="message">Invalid OTP Code</div>

            <!-- Send Code Button -->
            <button onclick="startTimer()" class="btn" id="searchBtn">
                Send Code
                <div class="loader" id="loader"></div>
            </button>
            <!-- Confirm Code Button -->
            <button class="btn" id="verifyBtn">
                <a href="SendCode.php">Verify</a>
            </button>

            <!-- Alternative Login Option -->
            <a href="LoginPage.php" class="login">Login with password</a>
        </div>

        <script>
            /////////For 6 textboxes OTP Code
            function moveToNext(input, index) {
                let inputs = document.querySelectorAll('.otp-input');
                if (input.value && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                } else if (!input.value && index > 0) {
                    inputs[index - 1].focus();
                }
            }

            /////////Timer
            let timer;
            const otpDuration = 120; // 2 minutes
            const otpMessage = document.getElementById('otpMessage');
            const timerDisplay = document.getElementById('timer');

            function startTimer() {
                let expiryTime = localStorage.getItem('otpExpiryTime');

                if (!expiryTime || Date.now() > expiryTime) {
                    expiryTime = Date.now() + otpDuration * 1000;
                    localStorage.setItem('otpExpiryTime', expiryTime);
                }

                runTimer();
            }

            function runTimer() {
                clearInterval(timer);
                let expiryTime = localStorage.getItem('otpExpiryTime');
                let countdown = Math.max(0, Math.floor((expiryTime - Date.now()) / 1000));

                if (countdown > 0) {
                    otpMessage.textContent = "You have successfully sent a 6-digit OTP code to your email.";
                    otpMessage.style.display = "block";
                }

                updateTimerDisplay(countdown);

                timer = setInterval(() => {
                    countdown--;
                    updateTimerDisplay(countdown);

                    if (countdown <= 0) {
                        clearInterval(timer);
                        timerDisplay.textContent = "00:00";
                        otpMessage.style.display = "none";
                        localStorage.removeItem('otpExpiryTime');
                    }
                }, 1000);
            }

            function updateTimerDisplay(seconds) {
                let minutes = Math.floor(seconds / 60);
                let remainingSeconds = seconds % 60;
                let formattedTime = `${String(minutes).padStart(2, '0')}:${String(remainingSeconds).padStart(2, '0')}`;
                timerDisplay.textContent = formattedTime;
            }

            document.addEventListener("DOMContentLoaded", function () {
                if (localStorage.getItem('otpExpiryTime')) {
                    runTimer();
                }
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
