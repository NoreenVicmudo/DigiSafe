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

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/nprogress@0.2.0/nprogress.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nprogress@0.2.0/nprogress.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
        <title>QR Code Timer</title>
        <style>
            <?php include "QRCode.css" ?>
        </style>
    </head>
    <body>
        
        <a class="go-back back-page" href="MainPage.php"><i class="bi bi-arrow-left"></i> Go back</a>
        <h1>QR Code</h1>

        <div class="container">
            <div class="qr-code" id="qrContainer">
                <img id="qrCode" src="" alt="QR Code" width="20%">
            </div>
        </div>

        <p id="timerText">Time left: <span id="timer">5:00</span></p>

        
        <script>
            //////////QR Code Generation
            function generateQRCode() {
                let qrContainer = document.getElementById("qrContainer");
                qrContainer.innerHTML = ""; // Clear previous QR
                let storedQRData = localStorage.getItem("qrData");
                let expirationTime = localStorage.getItem("expirationTime");
                
                if (!storedQRData || !expirationTime || Date.now() >= expirationTime) {
                    storedQRData = Math.random().toString(36).substring(7);
                    localStorage.setItem("qrData", storedQRData);
                    localStorage.setItem("expirationTime", Date.now() + 5 * 60 * 1000);
                }
                
                new QRCode(qrContainer, {
                    text: storedQRData,
                    width: 150,
                    height: 150
                });

            //Ajax (Sent to PHP)
            fetch('store_qr.php', {
                method: 'POST',
                body: new URLSearchParams({
                    qrData: storedQRData
                }),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('QR Code stored:', data);
            })
            .catch(error => console.error('Error storing QR code:', error));

            }

            


            /////////QR Code Timer 5 minutes validity
            function startTimer() {
                let timerElement = document.getElementById("timer");
                let expirationTime = localStorage.getItem("expirationTime");
                if (!expirationTime) return;

                function updateTimer() {
                    let timeRemaining = expirationTime - Date.now();
                    if (timeRemaining <= 0) {
                        clearInterval(timerInterval);
                        localStorage.removeItem("qrData");
                        localStorage.removeItem("expirationTime");
                        alert("QR Code has expired!");
                        window.location.href = "MainPage.php";
                        return;
                    }
                    let minutes = Math.floor(timeRemaining / 60000);
                    let seconds = Math.floor((timeRemaining % 60000) / 1000);
                    timerElement.textContent = `${minutes}:${seconds < 10 ? "0" + seconds : seconds}`;
                }
                updateTimer();
                let timerInterval = setInterval(updateTimer, 1000);
            }

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

            //////////For loader
            document.addEventListener('DOMContentLoaded', function () {
                const backPageLinks = document.querySelectorAll(".back-page");
                backPageLinks.forEach(function(link) {
                    link.addEventListener("click", function (e) {
                        e.preventDefault();
                        NProgress.start();
                        setTimeout(() => { NProgress.set(0.7); }, 300);
                        setTimeout(() => {
                            NProgress.done();
                            window.location.href = link.href;
                        }, 1200);
                    });
                });
                
                NProgress.done();
                generateQRCode();
                startTimer();
            });
        </script>
    </body>
</html>
