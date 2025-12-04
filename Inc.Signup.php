<?php
    $dbservername = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "websitedb";

    $conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);
    
	/*
	if($conn){
		echo "you are connected";
	}
	else{
		echo "could not connect";
	}*/

	$lname = $_POST['lastname'];
    $fname = $_POST['firstname'];
	$mname = $_POST['middlename'];
    $birthdate = $_POST['birthdate'];
	$contact = $_POST['contactnumber'];
    $email = $_POST['email'];
	$username = $_POST['username'];
    $password = $_POST['confirmpassword'];
    $program = $_POST['program'];
    $year = $_POST['yearlevel'];
    
    $hashedpass = password_hash($password,PASSWORD_DEFAULT);

	
    $sql = "INSERT INTO applicants (username, passcode, last_name, first_name, middle_name, birthdate, contact, email, program, year_level, exam)
    VALUES ('$username', '$hashedpass', '$lname', '$fname', '$mname', '$birthdate', '$contact', '$email', '$program', '$year', 'Not Taken');";

    mysqli_query($conn, $sql);
    header("Location: Login.php");