<?php
/**
 * DB: publications
 * Table: mid2Usertable(name, password)
 * Table mid2Filetable(name, contentName, fileContent, primary key(name))
 */

$conn = new mysqli("localhost", "root", "", "publications");
if($conn->connect_error){
    die("Connection is failed!!!");
    die("<p><a href=main.php>Click Here To Continue</a></p>");
}

$name = mysqli_real_escape_string($conn, $_POST['user']);
$pass = mysqli_real_escape_string($conn, $_POST['password']);
$hashedpass = password_hash($pass, PASSWORD_DEFAULT);

$s = "SELECT * FROM mid2Usertable WHERE name = '$name'";
$result = mysqli_query($conn, $s);
if (!$result) {
    echo "Connection is failed!!!";
    die("<p><a href=main.php>Click Here To Continue</a></p>");
}
$num = mysqli_num_rows($result);

if ($num == 1) {
    echo "Username Was Already Taken!";
    die("<p><a href=main.php>Click Here To Continue</a></p>");
} else {
    $reg = "INSERT INTO mid2Usertable(name, password) VALUES ('$name', '$hashedpass')";
    $result = mysqli_query($conn, $reg);
    if (!$result) {
        echo "Connection is failed!!!";
        die("<p><a href=main.php>Click Here To Continue</a></p>");
    } else {
        echo "Registration Successfully! Go Sign In!";
        die("<p><a href=main.php>Click Here To Continue</a></p>");
    }
}

?>