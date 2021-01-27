<?php
/**
 * DB: publications
 * Table: mid2Usertable(name, password)
 * Table mid2Filetable(name, contentName, fileContent, primary key(name))
 */

$conn = new mysqli("localhost", "root", "", "publications");
if($conn->connect_error){
    echo "Connection is failed!!!";
}

$name = mysqli_real_escape_string($conn, $_POST['user']);
$pass = mysqli_real_escape_string($conn, $_POST['password']);

$s = "SELECT * FROM mid2Usertable WHERE name='$name'";
$result = mysqli_query($conn, $s);
if (!$result) {
    echo "Connection is failed!!!";
    die("<p><a href=main.php>Click Here To Continue</a></p>");
}
$num = mysqli_num_rows($result);

if ($num == 1) {
    $row = mysqli_fetch_array($result);
    if (password_verify($pass, $row["password"])) {
        session_start();          
        $_SESSION['username'] = $name;
        header("location:upload.php");
    } else {
        echo "Wrong Password!";
        die("<p><a href=main.php>Click Here To Continue</a></p>");
    }
} else {
    echo "Sign Up First!";
    die("<p><a href=main.php>Click Here To Continue</a></p>");
}


?>