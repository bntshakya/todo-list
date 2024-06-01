<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<form method="post" action="main.php">
    <label for="email">Email</label>
    <input type="email" name = "email" id="email" required/>
    <label for="password">Password</label>
    <input type="password" name="password" id="password" required/>
    <button type="submit">Login</button>
</form>
<?php

if (isset($_POST['email']) and isset($_POST['password'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // connecting to the db

    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'mydb';

    // connection 
    $conn = new mysqli($servername,$username,$password,$dbname);

    if ($conn -> connect_error){
        die('connection error : '. $conn ->connect_error);
    }

    $sql = "SELECT Password FROM UserInfo WHERE Email='$email'";

    $result = $conn -> query($sql);

    if ($result -> num_rows > 0) {
        $row = $result -> fetch_assoc();
        $password_from_table = $row["password"];
        if ($password_from_table === $password){
        }
        else{
            echo 'Incorrect Credentials';
        }
    }
}