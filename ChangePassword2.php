<?php
    session_start();
    include 'Inc.Connect.php';

    if (!isset($_SESSION['UserLogin']) || $_SESSION['UserLogin'] !== true) {
        header("Location: Login.php");
        exit();
    }

    if (isset($_POST['res'])){

        $currentPassword = $_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];

        $id=$_SESSION['userID'];
        $sql= "SELECT * FROM user WHERE UserID = '$id'";
        $userResult=mysqli_query($conn,$sql);
        $userData=mysqli_fetch_assoc($userResult);

        if ($userData && $userData['Password'] == $currentPassword) {
            if ($newPassword == $confirmPassword){
                $changepassFunction = "UPDATE user SET Password = '$confirmPassword' WHERE UserID = '$id'";
                mysqli_query($conn, $changepassFunction);
            }
            else{
                $updateMessage="Password do not match.";
            }
    }
        else {
            $currentMessage="Password is Incorrect.";
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
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/nprogress@0.2.0/nprogress.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nprogress@0.2.0/nprogress.css">
        <title>Change Password</title>
    </head>
    <style>
        <?php include "ChangePassword2.css"; ?>
    </style>
    <body>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

        <a class="go-back back-page" href="MainPage.php"><i class="bi bi-arrow-left"></i> Go back</a>
        
        <div class="form-container">
            <h2>Change Password</h2>
            
            
            <form method="POST" action="">
                <div class="input-group">
                    <input type="password" id="current-password" placeholder=" " name="currentPassword" required autocomplete="off">
                    <label for="current-password">Current Password</label>              
                </div>
                <div class="message">
                    <?php
                        if (isset($currentMessage)) {
                                echo $currentMessage;
                                        }
                    ?>
                 </div><br> <!-- Kapag mali yung current password-->
                <div class="input-group">
                    <input type="password" id="new-password" placeholder=" " name="newPassword" required autocomplete="off">
                    <label for="new-password">New Password</label>
                </div><br>
                <div class="input-group">
                    <input type="password" id="confirm-password" placeholder=" " name="confirmPassword" required autocomplete="off">
                    <label for="confirm-password">Confirm Password</label>
                    
                </div>
                <div class="message">
                    <?php
                        if (isset($updateMessage)) {
                                echo $updateMessage;
                                        }
                    ?>
                 </div><br> <!-- New and Confirm !=-->
                <button type="submit" class="btn back-page" name="res">Update Password</button> <!--alert na lang din tas balik sa main page-->
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
                /*
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
                */
            });
        </script>
    </body>
</html>