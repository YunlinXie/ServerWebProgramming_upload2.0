<?php
/**
 * ###################################################################################
 * main.php includes the HTML for main page
 * ###################################################################################
 * Run following queries in your terminal to create a table to store user information:
 * mysql -u root -p
 * CREATE database publications;
 * USE publications;
 * CREATE TABLE mid2Usertable(
 * name VARCHAR(128),
 * password VARCHAR(128),
 * primary key(name)
 * );
 * ###################################################################################
 * Run following queries to create a table to store uploaded information:
 * CREATE TABLE mid2Filetable(
 * name VARCHAR(128),
 * contentName VARCHAR(128),
 * fileContent VARCHAR(128),
 * primary key(name)
 * );
 * (modify fileContent VARCHAR() size and corresponding codes to accept big files)
 * ###################################################################################
 */
echo <<<_END
<html>
<head>
    <title> User Login And Registration </title>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h2> Login Here </h2>
            <form action="signIn.php" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="user" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary"> Login </button>
            </form>
        </div>
        <div class="col-md-6">
            <h2> Register Here </h2>
            <form action="signUp.php" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="user" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary"> Register </button>
            </form>
        </div>
    </div>
</div>
_END;
session_start();
session_destroy();
unset($_SESSION['username']);
echo "</body></html>";


?>