<?php
session_start();
$sql = mysqli_connect("localhost", "root", "", "apollo_db");
// Get the recent orders up to 10
$recent_order_count = mysqli_num_rows(mysqli_query($sql, "select * from customerorder"));
$recent_order_count = $recent_order_count >= 10 ? 10 : $recent_order_count;
$recent_orders = mysqli_query($sql, "select * from customerorder order by Date desc limit 10");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Recent Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
          crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>

<nav class="navbar transparent">
    <div class="container justify-content-center">
        <a href="index.php"><img class="img-fluid logo" src="img/logo.png" alt=""></a>
        <a class="btn ms-auto d-sm-block button1" href="admin.php">Admin Page</a>
    </div>
</nav>

<div class="container d-flex" style="padding-top: 50px">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Order ID</th>
            <th scope="col">Date</th>
            <th scope="col">Delivery Time</th>
            <th scope="col">Customer</th>
            <th scope="col">Coffee</th>
            <th scope="col">Size</th>
            <th scope="col">Price</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($recent_orders)) {
            $customer_id = $row['CustomerID'];
            $customer_name = mysqli_fetch_assoc(mysqli_query($sql, "select * from customer where CustomerID = $customer_id limit 1"))['FirstName']
                . ' '
                . mysqli_fetch_assoc(mysqli_query($sql, "select * from customer where CustomerID = $customer_id limit 1"))['LastName'];
            $order_id = $row['OrderID'];
            $order_items = mysqli_query($sql, "select * from orderitem where OrderID = $order_id");
            $item_num_plus_two = mysqli_num_rows($order_items) + 2;
            echo '<tr>' . '<td rowspan="' . $item_num_plus_two . '">' . $row['OrderID'] . '</td>' . '<td rowspan="' . $item_num_plus_two . '">' . $row['Date'] . '</td>' . '<td rowspan="' . $item_num_plus_two . '">' . $row['DeliveryTime'] . '</td>' . '<td rowspan="' . $item_num_plus_two . '">' . $customer_name . '</td></tr>';
            $subtotal = 0;
            while ($current_item = mysqli_fetch_assoc($order_items)) {
                $coffee_id = $current_item['CoffeeID'];
                $coffee_size = $current_item['Type'];
                $coffee_name = mysqli_fetch_assoc(mysqli_query($sql, "select * from coffee where CoffeeID = '$coffee_id' limit 1"))['Name'];
                $coffee_price = mysqli_fetch_assoc(mysqli_query($sql, "select * from size where CoffeeID = '$coffee_id' and Type = '$coffee_size' limit 1"))['Cost'];
                $subtotal += $coffee_price;
                echo '<tr>' . '<td>' . $coffee_name . '</td><td>' . $coffee_size . '</td><td>' . $coffee_price . '</td>' . "</tr>";
            }
            echo '<tr><td colspan="3" style="text-align: center">Subtotal: ' . $subtotal . '</td></tr>';
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

</body>
</html>
