<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Get the values from login.php
    $mail = $_POST['mail'];
    $password = $_POST['password'];

    if (empty($mail) || empty($password)) {
        echo "<script type='text/javascript'>alert('Please fill out all the fields.');</script>";
    } else {
        // Connect to the database
        $sql = mysqli_connect("localhost", "root", "", "apollo_db");

        // Query the db
        $result = mysqli_query($sql, "select * from customer where EMailAddress = '$mail' limit 1");
        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            if ($user_data['Password'] === $password) {
                $_SESSION['customer_id'] = $user_data['CustomerID'];
                header("Location: order.php");
            } else {
                echo "<script type='text/javascript'>alert('Login information is incorrect');</script>";
            }
        } else {
            echo "<script type='text/javascript'>alert('The e-mail is not associated with any account.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg" style="background-image: url('img/background_login.jpg');">

<nav class="navbar transparent">
    <div class="container justify-content-center">
        <a href="index.php"><img class="img-fluid logo" src="img/logo.png" alt=""></a>
        <a class="btn ms-auto d-sm-block button1" href="signup.php">Sign Up</a>
    </div>
</nav>

<div class="container-fluid" style="margin-top: 50px; background-color: rgb(255, 255, 255, 0.7)">
    <div class="container d-flex justify-content-center py-5" id="frm">
        <form method="POST">
            <div class="container">
                <div class="row form-floating">
                    <input class="form-control mb-3" placeholder="." type="email" id="mail" name="mail">
                    <label for="mail">E-Mail:</label>
                </div>
                <div class="row form-floating">
                    <input class="form-control mb-3" placeholder="." type="password" id="password" name="password">
                    <label for="password">Password:</label>
                </div>
                <p class="row">
                    <input class="button1 submit" style="border-color: black" type="submit" id="btn" value="Login">
                </p>
            </div>
        </form>
    </div>
</div>

<footer class="text-center text-lg-start">
    <div class="text-center p-3" style="color: black;background-color: rgba(0, 0, 0, 0.2);">
        © 2021 Copyright:
        <span class="text-dark">Apollo's Coffee <a href="admin.php">Admin Page</a></span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>

</body>
</html>