<form method="post" action="todo.php">
    <label>Title</label>
    <input type="text" name="title">
    <label>Details</label>
    <textarea name="details"></textarea>
    <label>Priority</label>
    <input type="radio" name="priority" value="high" checked> High
    <input type="radio" name="priority" value="medium"> medium
    <input type="radio" name="priority" value="low"> Low
    <label>StartDate</label>
    <input type="datetime-local" name="startdate" required>
    <label>EndDate</label>
    <input type="datetime-local" name="enddate" required>
    <input type="submit" value="Add" />
    <input type="hidden" name="email"
        value="<?php echo isset($_GET['email']) ? $_GET['email'] : (isset($_POST['email']) ? $_POST['email'] : ''); ?>">
</form>

<?php

// connecting to the db
if (isset($_POST["title"]) and isset($_POST['details']) and isset($_POST['priority']) and isset($_POST['startdate']) and isset($_POST['enddate'])) {

    $servername = 'localhost';
    $username = 'root';
    $password_db = '';
    $dbname = 'Mydb';

    $conn = new mysqli($servername, $username, $password_db, $dbname);

    if ($conn->connect_error) {
        die('' . $conn->connect_error);
    }

    // adding data to db;

    $title = $_POST['title'];
    $details = $_POST['details'];
    $priority = $_POST['priority'];
    $sdate = $_POST['startdate'];
    $edate = $_POST['enddate'];
    // $email = $_GET['email'];
    // echo $email;
    // $email = $_GET['email'];
    // print_r($_GET);
    // print_r($_POST);
    // echo $email;
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        // echo $email;
    } else {
        echo "Email is not set";
    }

    $sql = 'CREATE TABLE IF NOT EXISTS Todo (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            Email VARCHAR(50) NOT NULL,
            Title VARCHAR(50) NOT NULL,
            Details VARCHAR(50) NOT NULL,
            Priority VARCHAR(20) NOT NULL ,
            Sdate VARCHAR(50) NOT NULL,
            Edate VARCHAR(50) NOT NULL)';

    $conn->query($sql);

    $sql = "INSERT INTO Todo(Email,Title,Details,Priority,Sdate,Edate) VALUES ('$email','$title','$details','$priority','$sdate','$edate')";

    $conn->query($sql);

    $sql = "SELECT * FROM Todo WHERE Email='$email'";

    $result = $conn->query($sql);

    ?>
    <table border="1px solid black">
        <tr>
            <td>Title</td>
            <td>Details</td>
            <td>Start Date</td>
            <td>End date</td>
            <td>Completed</td>
        </tr>
        <?php
        // $priority = 'red';
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $priority = $row['Priority'];
                switch ($priority) {
                    case 'high':
                        $color = 'red';
                        break;
                    case 'medium':
                        $color = 'blue';
                        break;
                    case 'low':
                        $color = 'green';
                        break;
                    default:
                        $color = 'black'; // Default color if priority is not recognized
                        break;
                } ?>

                <tr>
                    <td style="color:<?php echo $color . ';' ?><?php echo $row['Completed'] ? 'text-decoration:line-through;' : '' ?>">
                        <?php echo $row['Title'] ?>
                    </td>
                    <td><?php echo $row['Details'] ?></td>
                    <td><?php echo $row['Sdate'] ?></td>
                    <td><?php echo $row['Edate'] ?></td>
                    <td>
                        <form method="post" action="todo.php">
                            <input type="checkbox" value="<?php echo $row['id'] ?>" name="completed">
                            <input type="submit" value="update">
                        </form>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
        }
}

if (isset($_POST['completed'])) {
    $servername = 'localhost';
    $username = 'root';
    $password_db = '';
    $dbname = 'Mydb';

    $conn = new mysqli($servername, $username, $password_db, $dbname);

    if ($conn->connect_error) {
        die('' . $conn->connect_error);
    }
    $id = $_POST['completed'];
    echo $id;
    // $sql = "DESCRIBE todo";
    // $result = $conn ->query($sql);
    // while($row = $result -> fetch_assoc()){
    //     echo $row['Field'];
    // }
    $sql = "UPDATE todo SET Completed = 1 WHERE id = '$id'";
    $conn->query($sql);


}

