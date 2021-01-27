<?php
/**
 * ###################################################################################
 * upload.php can input a string and upload a .text files after signing in.
 * It can also show inputed strings and uploaded files after signing in.
 * ###################################################################################
 * DB: publications
 * Table: mid2Usertable(name, password)
 * Table mid2Filetable(name, contentName, fileContent)
 */

session_start();
$conn = new mysqli("localhost","root","","publications");
if($conn->connect_error){
    echo "Connection is failed!!!";
    die("<p><a href=main.php>Click Here To Continue</a></p>");
}

if (!isset($_SESSION['username'])) {
    echo "Please login first!!!";
    die("<p><a href=main.php>Click Here To Continue</a></p>");
} else {
echo <<<_END
    <html>
    <head>
        <title>File Upload</title>
    </head>
    <body>
        <h1>You Can Upload File Now!</h1>
        <form action = "upload.php" method = "POST" enctype = "multipart/form-data">
            <p><input type="submit" name="logout" value="logout"></p>
            <label for="text">File Name:</label>
            <input type = "text" name="filename" id="filename">
            <p>
            <label for="file">File Upload:</label>
            <input type="file" name="file"/>
            </p>
            <p><input type="submit" name="submit" value="submit"></p>
        </form>
_END;
if (isset($_POST['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header('location: main.php');
}

$username = $_SESSION['username'];
$select_sql = "SELECT * FROM mid2Filetable WHERE name = '".$username."'";
$select = mysqli_query($conn, $select_sql);
echo '<table border="1"><tr><th>Name</th><th>Content</th>';
while($row=mysqli_fetch_assoc($select)){
        echo '<tr><td>'.$row['contentName'].'</td><td>'.$row['fileContent'].'</td>';
}
echo '</table>';

if ($_FILES) {
    // File properties
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    // File extension
    $fileExt = explode('.', $fileName);
    $fileExt = strtolower(end($fileExt));
    // Allowed file type
    $allowed = array('txt');

    if (empty($_POST['filename']) || !file_exists($fileTmpName) || !is_uploaded_file($fileTmpName)) {
        echo "<br>Both areas are required!<br>";
    } else {
        if ($fileError === 0) {// Check file error
            if (in_array($fileExt, $allowed)) {// Check file type
                if ($fileSize < 1000000) {// Check file size
                    $fileData = "";
                        $fp = fopen($fileTmpName, 'rb');
                        // Store file content in a string without whitespaces and line breaks
                        while ( ($line = fgets($fp)) !== false) {
                            $line = preg_replace("/[ \t]+/", "", preg_replace("/\s*/m", "", $line));
                            $fileData = $fileData.$line;
                        }
                    
                        $filename = $_POST['filename'];
                        $filename = sanitizeMySQL($conn, $filename);
                        $filecontent = $fileData;
                        $filecontent = sanitizeMySQL($conn, $filecontent);
                
                        $insert_sql = "INSERT INTO mid2Filetable(name, contentName, fileContent) VALUES ('".$username."','".$filename."', '".$filecontent."')";
                        $insert = mysqli_query($conn, $insert_sql);
                        echo "<br><br>The following is newly inserted file:<br>";
                        echo '<table border="1"><tr><th>Name</th><th>Content</th>';
                        echo '<tr><td>'.$filename.'</td><td>'.$filecontent.'</td></table>';
                
                        $conn->close();
                } else {echo "Your file is too big!";}
            } else {echo "You cannot upload files of this type!";}
        } else {echo "There was an error uploading your file!";}
    }
}
}// Logined In
echo "</body></html>";

####################################################################################
function sanitizeString($var)
{
    $var = stripslashes($var);
    $var = strip_tags($var);
    $var = htmlentities($var);
    return $var;
}

function sanitizeMySQL($conn, $var)
{
    $var = $conn->real_escape_string($var);
    $var = sanitizeString($var);
    return $var;
}

?>