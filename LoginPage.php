<?php
session_start();
include 'Inc.Connect.php';

if (isset($_POST['res'])){
    
    $email= $_POST['email'];
    $password= $_POST['password'];

    //User Query
    $sql= "SELECT * FROM user WHERE Email = '$email'";
    $userResult=mysqli_query($conn,$sql);
    $userData=mysqli_fetch_assoc($userResult);

    //Verify Email
    if ($userData && $userData['Email'] == $email) {
        //Verify Password
         if (password_verify($password, $userData['Password'])) {
         //if ($userData && $userData['Password'] == $password) {
            $_SESSION['userID'] = $userData['UserID'];

            //Check What Role
            if ($userData && $userData['Role']== "Admin"){
                $_SESSION['AdminLogin'] = true;
                header("Location: AdminHomePage.php");
                exit();
            }
            else{
                $_SESSION['UserLogin'] = true;
                header("Location: MainPage.php");
                exit();
            }
        }
        else {
            $message="Incorrect Password";
        }
    }
    else {
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
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
        <title>Sign In</title>
        <style><?php include "LoginPage.css" ?></style>
    </head>
    <body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
                        <form method="POST" class="form" action="">
                            <p class="form-title">Login to your DigiSafe Account</p><br>
                            <div class="input-group custom-input-group">
                                <input type="email" id="username" placeholder=" " name="email" oninput="resetButtonPosition()" required>
                                <label>Enter email</label>
                            </div><br>
                            <div class="input-group custom-input-group">
                                <input type="password" id="password" placeholder=" " name="password" oninput="resetButtonPosition()" required>
                                <label>Enter password</label>
                            </div>
                            <div class="message">
                            <?php
                                if (isset($message)) {
                                echo $message;
                                        }
                            ?>
                            </div><br><!------------------INDICATOR--------------------->
                            <button class="btn custom-btn next-page" id="loginBtn" onmouseover="moveButton()" onclick="handleLogin()" type="submit" name="res">Sign in</button>
                            <p class="forgotpassword-link"><br>
                                <a href="ForgotPassword.php" class="next-page">Forgot Password?</a>
                            </p>
                        </form>
                    </div>
                </div>
                <div class="col-12 col-md-7 d-flex align-items-center justify-content-end custom-col">
                    <div class="title-container text-end">
                        <div class="title">
                            <h1>DigiSafe</h1>
                            <p>A QR-Based Locker System</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            
            
            function resetButtonPosition() {
                let username = document.getElementById("username").value.trim();
                let password = document.getElementById("password").value.trim();
                let loginBtn = document.getElementById("loginBtn");

                if (username !== "" && password !== "") {
                    loginBtn.style.transform = "translate(0, 0)";
                }
            }
            
            
            /* [Renny] Tinangal ko muna kase you have to click the ok button (from the top) in order to proceed.
            Nasainyo naman if mas prefer niyo yon, tangalin niyo lang ung comment.

            function handleLogin() {
                let username = document.getElementById("username").value.trim();
                let password = document.getElementById("password").value.trim();

                if (username !== "" && password !== "") {
                    alert("Logging in...");
                } else {
                    alert("Please enter your login details.");
                }
            }
            */
            //////////For Cursor Trail
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
            
            
            
            /*
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

                        //[1] Eto lang yung error
                        //window.location.href = button.href; // Redirect after the loading bar completes

                    }, 1200); // Adjust the time here based on the animation duration
                });
            });

            // Ensure the progress bar is fully complete when the page is loaded
            window.onload = function () {
                NProgress.done();
            };
            });
            */
        </script>
    </body>
</html>
