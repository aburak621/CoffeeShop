<?php
session_start();
$sql = mysqli_connect("localhost", "root", "", "apollo_db");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Apollo's Coffee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body class="">

<div class="parallax"
     style="background-image: linear-gradient(rgb(0, 0, 0, 0.7), rgb(0, 0, 0, 0)); position: absolute; width: 100%; top: 0;">
</div>

<div class="parallax">
    <div class="container d-flex text-light">
        <h1>
            <span style="font-size: 2rem; -webkit-text-stroke: 1px black;">
                Delicious and filled with energy
            </span><br>Start your day with<br>the best Coffee
            <a id="order" class="btn d-block button1 button2" href="login.php">Order Now</a>
        </h1>
    </div>
</div>

<nav class="navbar sticky transparent">
    <div class="container justify-content-center">
        <a href="index.php"><img class="img-fluid logo" src="img/logo.png" alt=""></a>
        <a id="sign_in" class="btn ms-auto d-sm-block button1" href="login.php">Sign In</a>
    </div>
</nav>

<div class="container my-3">
    <h1>Today's Picks</h1>
</div>

<div class="container">
    <table class="table align-middle">
        <tbody>
        <?php
        $coffees = mysqli_query($sql, "select * from coffee order by rand() limit 3");
        for ($j = 0; $j < mysqli_num_rows($coffees); $j++) {
            echo '<tr>';
            $coffee = mysqli_fetch_assoc($coffees);
            echo '<td class=""><td>' . '<img class="coffee-img" src="img/' . $coffee['CoffeeID'] . '.png" alt="">' . '</td><td>' . $coffee['Name'] . '</td><td>' . $coffee['Description'] . '</td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
</div>

<footer class="text-center text-lg-start">
    <div class="text-center p-3" style="color: black;background-color: rgba(0, 0, 0, 0.2);">
        © 2021 Copyright:
        <span class="text-dark">Apollo's Coffee <a href="admin.php">Admin Page</a></span>
    </div>
</footer>

<?php
if (isset($_SESSION['customer_id'])) {
    echo "<script type='text/javascript'>
var sign_in = document.getElementById('sign_in');
sign_in.innerText = 'Logout';
sign_in.href = 'logout.php';
var order = document.getElementById('order');
order.href = 'order.php';
</script>";
}
?>

</body>
</html>