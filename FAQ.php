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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/nprogress@0.2.0/nprogress.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nprogress@0.2.0/nprogress.css">
    <title>FAQs</title>
    <link rel="stylesheet" href="FAQ.css">
</head>
<style>
    <?php include "FAQ.css"; ?>
</style>

<body>
    <a href="MainPage.php" class="go-back back-page"><i class="bi bi-arrow-left"></i> Go back</a>

    <div class="container">
        <h2 class="faq text-center">FAQs</h2>

        <div class="faq-section">
            <button class="btn btn-toggle" data-bs-toggle="collapse" data-bs-target="#about">
                About <i class="bi bi-chevron-down"></i>
            </button>
            <div id="about" class="collapse">
                <textarea class="txtarea-message" placeholder="Type your concerns" disabled>What is DigiSafe?
A: DigiSafe is a QR-Based Smart Locker System designed to offer secure, convenient, and contactless locker access using modern web technologies and IoT integration. It eliminates the need for physical keys or manual entry, enhancing both security and user experience.

Where is DigiSafe hosted?
A: DigiSafe is hosted online, allowing users to access the system through a web browser on any internet-enabled device, anytime and anywhere.

Who can use DigiSafe?
A: DigiSafe is intended for students, staff, and authorized personnel in academic or institutional settings who require safe and accessible temporary storage.</textarea>
            </div>
        </div>

        <div class="faq-section">
            <button class="btn btn-toggle" data-bs-toggle="collapse" data-bs-target="#howToUse">
                How to use <i class="bi bi-chevron-down"></i>
            </button>
            <div id="howToUse" class="collapse">
                <textarea class="txtarea-message" placeholder="Type your concerns" disabled>How do I register for a DigiSafe locker?
A: Simply visit the DigiSafe website, sign in using your assigned credentials, and follow the instructions to reserve or assign a locker.

How do I access a locker?
A: After successful authentication, the system generates a unique QR code linked to your assigned locker. You scan this QR code on the locker scanner to open it.

What should I do if I lose my QR code?
A: You can log back into the system and regenerate your QR code. For added security, each new code invalidates the previous one.</textarea>
            </div>
        </div>

        <div class="faq-section">
            <button class="btn btn-toggle" data-bs-toggle="collapse" data-bs-target="#scanningLockers">
                Scanning lockers <i class="bi bi-chevron-down"></i>
            </button>
            <div id="scanningLockers" class="collapse">
                <textarea class="txtarea-message" placeholder="Type your concerns" disabled>How does the QR scanner work?
A: The scanner reads the QR code displayed on your phoneand communicates with the DigiSafe server to validate your credentials and unlock the corresponding locker.

What happens if the QR scanner doesn’t recognize my code?
A: Ensure your code is not expired and that your screen is clean and bright. If the problem persists, contact support or use the web portal to regenerate a new code.

Can I access a locker without the QR code?
A: For security reasons, QR code access is the primary method. Backup access methods, such as admin override, may be available under supervision for emergencies.</textarea>
            </div>
        </div>
    </div>


    <script>
        //arrow lang to sa dropdown
        document.querySelectorAll('.btn-toggle').forEach(button => {
            button.addEventListener('click', function () {
                let icon = this.querySelector("i");
                let isOpen = this.getAttribute("aria-expanded") === "true";
                icon.classList.toggle("bi-chevron-down", !isOpen);
                icon.classList.toggle("bi-chevron-up", isOpen);
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
            // Select all links with the "back-page" class
            const backPageLinks = document.querySelectorAll(".back-page");

            // Add event listener for each back link
            backPageLinks.forEach(function (link) {
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