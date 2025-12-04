<?php
    session_start();
    include 'Inc.Connect.php';

    if (!isset($_SESSION['UserLogin']) || $_SESSION['UserLogin'] !== true) {
        header("Location: LoginPage.php");
        exit();
    }

    

$message = "";
$error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['message'])) {
        $message = trim($_POST['message']);
        
        // Validate message length
        if (strlen($message) > 300) {
            $error = "Error: Your message exceeds the 300-character limit.";
        } else {
            $userid=$_SESSION['userID'];
            mysqli_query($conn, "INSERT INTO support (UserID, Concern, TimeSent)
                VALUES ('$userid', '$message', NOW())");
            
            echo "<script>alert('Message submitted successfully!');</script>";
            $message = ""; // Clear the textarea after submission
        }
    }
} //Di ko alam kung gumagana pero pang character limit lang to 0/300
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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <script src="https://cdn.jsdelivr.net/npm/nprogress@0.2.0/nprogress.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nprogress@0.2.0/nprogress.css">
        <link rel="stylesheet" href="CustomerSupport.css">
        <title>Customer Support</title>
    </head>
    <style>
        <?php include "CustomerSupport.css" ?>
    </style>
    <body>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>

        <a class="go-back back-page" href="MainPage.php"><i class="bi bi-arrow-left"></i> Go back</a>

        <div class="form-container">
            <h2>Customer Support</h2>

            <?php if (!empty($error)) : ?>
                <p class="error-message"><?= $error; ?></p>
            <?php endif; ?>

            <form method="POST">
                <textarea class="txtarea-message" name="message" placeholder="Type your concerns"
                    maxlength="300"><?= htmlspecialchars($message); ?></textarea>
                <p id="charCount"><?= strlen($message); ?>/300</p>
                <button class="btn-submit" type="submit" name="res">Submit</button> <!--alert na lang dito after makapag submit tas balik sa homepage after 3 secs-->
            </form>
        </div>

        <!-- Character count-->
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
