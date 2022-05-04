<?php
session_start();
$sql = mysqli_connect("localhost", "root", "", "apollo_db");
$coffee_count = $_SESSION['coffee_count'];
$order = $_SESSION['order'];
$order_id = random_int(100000000, 999999999);
date_default_timezone_set("Europe/Istanbul");
$order_date = date("Y-m-d");
$order_time = date("H:i:s");
$order_date_time = $order_date . ' ' . $order_time;
$delivery_date = $_POST["DeliveryDate"];
$delivery_time = $_POST["DeliveryTime"];
$delivery_date_time = $delivery_date . ' ' . $delivery_time;
$customer_id = $_SESSION['customer_id'];
mysqli_query($sql, "insert into customerorder (OrderID, Date, DeliveryTime, CustomerID) 
values ('$order_id', '$order_date_time', '$delivery_date_time', '$customer_id')");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Finished</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg" style="background-image: url('img/complete.jpg'); background-size: cover; background-repeat: repeat-y">

<nav class="navbar transparent">
    <div class="container justify-content-center">
        <a href="index.php"><img class="img-fluid logo" src="img/logo.png" alt=""></a>
        <a class="btn ms-auto d-sm-block button1" href="logout.php">Logout</a>
    </div>
</nav>

<div class="container-fluid" style="margin-top: 150px; background-color: rgb(255, 255, 255, 0.65)">
    <div class="container justify-content-center align-items-center" style="padding-top: 50px">
        <div class="row col-12 container justify-content-center text-centeir">
            <img class="" src="img/checkmark.png" style="max-height: 200px; max-width: 200px" alt="">
            <h2 class="my-4 d-inline-block text-center">Your order is received.<br>Thank you for choosing us!</h2>
        </div>
        <div class="row container text-center">
            <?php
            for ($i = 0; $i < $coffee_count; $i++) {
                $coffee = $order['Coffee' . $i];
                $coffee_size = $order['Coffee' . $i . 'Size'];
                $coffee_id = mysqli_fetch_assoc(mysqli_query($sql, "select * from coffee  where Name = '$coffee' limit 1"))['CoffeeID'];
                $price = mysqli_fetch_assoc(mysqli_query($sql, "select * from size where CoffeeID = '$coffee_id' and Type = '$coffee_size' limit 1"))['Cost'];
                $order_item_id = random_int(100000000, 999999999);
                mysqli_query($sql, "insert into orderitem (OrderItemID, OrderID, CoffeeID, Type) values ('$order_item_id', '$order_id', '$coffee_id', '$coffee_size')");
            }
            echo '<h2 class="mb-5">Your order number is: ' . $order_id . '</h2>';
            ?>
        </div>
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