<?php
session_start();
// Connect to the database
$sql = mysqli_connect("localhost", "root", "", "apollo_db");
$coffee_count = count($_POST) / 2;
$_SESSION['coffee_count'] = $coffee_count;
$order = $_POST;
$_SESSION['order'] = $order;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Summary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>

<nav class="navbar transparent">
    <div class="container justify-content-center">
        <a href="index.php"><img class="img-fluid logo" src="img/logo.png" alt=""></a>
        <a class="btn ms-auto d-sm-block button1" href="logout.php">Logout</a>
    </div>
</nav>

<div class="container my-4 big">
    <div class="row">
        <h2>Order Summary</h2>
    </div>
</div>

<div class="container">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Coffee Name</th>
            <th scope="col">Size</th>
            <th scope="col">Price</th>
        </tr>
        </thead>
        <tbody>
            <?php
            $total_cost = 0;
            for ($i = 0; $i < $coffee_count; $i++) {
                $coffee = $order['Coffee' . $i];
                $coffee_size = $order['Coffee' . $i . 'Size'];
                $coffee_id = mysqli_fetch_assoc(mysqli_query($sql, "select * from coffee  where Name = '$coffee' limit 1"))['CoffeeID'];
                $price = mysqli_fetch_assoc(mysqli_query($sql, "select * from size where CoffeeID = '$coffee_id' and Type = '$coffee_size' limit 1"))['Cost'];
                $total_cost += $price;
                echo '<tr><td>' . $coffee . '</td><td>' . strtoupper($coffee_size) . '</td><td>' . $price . ' </td></tr>';
            }
            echo '<tr><td>Total Cost:</td><td></td><td>' . $total_cost . '</td></tr>';
            ?>
        </tbody>
    </table>
    <div class="row my-4" id="frm">
        <form action="order_finished.php" method="POST">
            <label class="my-3 big" style="font-weight: 600" for="DeliveryDate">Order Delivery Time:</label><br>
            <input id="DeliveryDate" name="DeliveryDate" type="date">
            <label for="DeliveryTime"></label>
            <input id="DeliveryTime" name="DeliveryTime" type="time">
            <input class="button1" style="color: black" type="submit" value="Place Order">
        </form>
    </div>
</div>

<footer class="text-center text-lg-start">
    <div class="text-center p-3" style="color: black;background-color: rgba(0, 0, 0, 0.2);">
        © 2021 Copyright:
        <span class="text-dark">Apollo's Coffee <a href="admin.php">Admin Page</a></span>
    </div>
</footer>

</body>
</html>