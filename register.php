<form action="register.php" method="post">
    <label>Name</label>
    <input type="text" name="name" required>
    <label>Email</label>
    <input type="email" name="email" required>
    <label>Password</label>
    <input type="password" name="password" required>
    <label>Confirm Password</label>
    <input type="password" name="confirm_password" required>
    <input type="submit" value="Register">
    Have an account ? <a href="main.php">Sign in </a>
</form>

<?php

if (isset($_POST['email']) and isset($_POST['name']) and isset($_POST['password']) and isset($_POST['confirm_password'])) {
    // catching the form values

    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $name = $_POST['name'];

    // check for password;
    if ($password !== $confirm_password) {
        die('passwords dont match ');
    }

    // connecting to the db; 

    $servername = 'localhost';
    $username = 'root';
    $password_db = '';
    $dbname = 'mydb';


    $conn = new mysqli($servername, $username, $password_db, $dbname);

    if ($conn->connect_error) {
        die('error ' . $conn->connect_error);
    }

    $sql = 'CREATE TABLE IF NOT EXISTS MyUsers(
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        Name VARCHAR(50) NOT NULL,
        Email VARCHAR(50) NOT NULL,
        Password VARCHAR(50) NOT NULL)';

    $conn->query($sql);

    $sql = "INSERT INTO MyUsers(Name,Email,Password) VALUES ('$name','$email','$password')";

    $conn->query($sql);
}
