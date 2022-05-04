<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Get the values from login.php
    $mail = $_POST['mail'];
    $password = $_POST['password'];
    $password_repeat = $_POST['password_repeat'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $address = $_POST['address'];
    $town = $_POST['town'];
    $post = $_POST['post'];

    if (empty($mail) || empty($password) || empty($name) || empty($surname) || empty($address) || empty($town) || empty($post)) {
        echo "Please fill out all the fields.";
    } elseif ($password != $password_repeat) {
        echo "Passwords do not match!";
    } elseif (!ctype_alnum($password) || !(strlen($password) >= 6)) {
        echo "Please enter an alphanumeric password that has 6 or more characters.";
    } else {
        // Connect to the database
        $sql = mysqli_connect("localhost", "root", "", "apollo_db");

        // Query the db
        $result = mysqli_query($sql, "select * from customer where EMailAddress = '$mail' limit 1");
        if ($result && mysqli_num_rows($result) > 0) {
            echo "This E-Mail is already used.";
        } else {
            $ID = random_int(100000000, 999999999);
            $insert = mysqli_query($sql, "insert into customer (CustomerID, EMailAddress, Password, FirstName, LastName, StreetAddress, Town, PostCode) values ('$ID', '$mail', '$password', '$name', '$surname', '$address', '$town', '$post')");
            if ($insert) {
                echo "<script type='text/javascript'>alert('Successfully created account. Please sign in to your account in Login page.');</script>";
                echo "<script type='text/javascript'>window.location.href = 'login.php';</script>";
                //echo "Successfully created account. Please sign in to your account in Login page.";
            } else {
                echo "Could not create the account.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>

<nav class="navbar transparent">
    <div class="container justify-content-center">
        <a href="index.php"><img class="img-fluid logo" src="img/logo.png" alt=""></a>
        <a class="btn ms-auto d-sm-block button1" href="login.php">Sign In</a>
    </div>
</nav>

<div class="container d-flex justify-content-center" style="padding-top: 50px" id="frm">
    <form method="POST">
        <div class="row form-floating">
            <input class="form-control mb-3" placeholder="." type="email" id="mail" name="mail">
            <label for="mail">E-Mail:</label>
        </div>
        <div class="row">
            <div class="col-md-6 form-floating pe-md-2 p-0">
                <input class="form-control mb-3" placeholder="." type="password" id="password"
                       name="password">
                <label for="password">Password:</label>
            </div>
            <div class="col-md-6 form-floating ps-md-2 p-0">
                <input class="form-control mb-3" placeholder="." type="password" id="password_repeat"
                       name="password_repeat">
                <label class="ms-md-2" for="password_repeat">Repeat Password:</label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-floating pe-md-2 p-0">
                <input class="form-control mb-3" placeholder="." type="text" id="name" name="name">
                <label for="name">First Name:</label>
            </div>
            <div class="col-md-6 form-floating ps-md-2 p-0">
                <input class="form-control mb-3" placeholder="." type="text" id="surname" name="surname">
                <label class="ms-md-2" for="surname">Last Name:</label>
            </div>
        </div>
        <div class="row form-floating">
            <input class="form-control mb-3" placeholder="." type="text" id="address" name="address">
            <label for="address">Street Address:</label>
        </div>
        <div class="row form-floating">
            <input class="form-control mb-3" placeholder="." type="text" id="town" name="town">
            <label for="town">Town:</label>
        </div>
        <div class="row form-floating">
            <input class="form-control mb-3" placeholder="." type="text" id="post" name="post">
            <label for="post">Post Code:</label>
        </div>
        <div>
            <input class="form-control button1" style="color: black; border-radius: 2px; border-color: black" placeholder="." type="submit" id="btn" value="Sign Up">
        </div>
    </form>
</div>

<footer class="text-center text-lg-start">
    <div class="text-center p-3" style="color: black;background-color: rgba(0, 0, 0, 0.2);">
        © 2021 Copyright:
        <span class="text-dark">Apollo's Coffee <a href="admin.php">Admin Page</a></span>
    </div>
</footer>

</body>
</html>