<?php
session_start();
if (isset($_POST['res'])){
    include 'Inc.Connect.php';

    $email= $_POST['email'];
    $sql= "SELECT * FROM user WHERE Email = '$email'";
    $userResult=mysqli_query($conn,$sql);
    $userData=mysqli_fetch_assoc($userResult);

    if ($userData && $userData['Email'] == $email) {
        $_SESSION['EmailExist'] = true;
        header("Location: FindYourAccount.php");
    }
    else{
        $message="Email doesn't exist";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="ForgotPassword.css">
        <script src="https://cdn.jsdelivr.net/npm/nprogress@0.2.0/nprogress.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nprogress@0.2.0/nprogress.css">
        <title>Forgot Password</title>
    </head>
    <style>
    <?php include "ForgotPassword.css"; ?>
    </style>
    <body>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>

        <a class="go-back back-page" href="LoginPage.php"><i class="bi bi-arrow-left"></i> Go back</a>

        <div class="form-container">
            <p class="form-title">Forgot Password</p>

            <form method="POST"> <!--Tangina mo noreen-->
                <div class="input-container">
                    <input id="email" placeholder=" " type="email" name="email" required>
                    <label for="email">Find your email</label>
                    
                    <button class="btn-search" type="submit" id="searchBtn" name="res">
                        Search
                        <div class="loader" id="loader"></div>
                    
                    </button>
                </div>
            <br>
                <div class="message"> <!--If there is no email in the database-->
                    <?php
                    if (isset($message)) {
                        echo $message;
                    }
                    ?>
                    </div>
            </form>

        <script>
            ///////Loader for verification idk kung gagana
            document.querySelector("form").addEventListener("submit", function(event) {
                let searchBtn = document.getElementById("searchBtn");
                let loader = document.getElementById("loader");

                // Show the loader
                loader.style.display = "inline-block";
                searchBtn.classList.add("loading"); 
                //searchBtn.disabled = true; // Disable button to prevent multiple submissions
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
