<?php
session_start();
// Connect to the database
$sql = mysqli_connect("localhost", "root", "", "apollo_db");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg" style="background-image: url('img/order.jpg');">
<nav class="navbar transparent sticky">
    <div class="container justify-content-center">
        <a href="index.php"><img class="img-fluid logo" src="img/logo.png" alt=""></a>
        <a class="btn ms-auto d-sm-block button1" href="logout.php">Logout</a>
    </div>
</nav>

<div class="container-fluid" style="margin-top: 150px; background-color: rgb(255, 255, 255, 0.98)">
    <div class="container" style="padding-top: 50px">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Street Address</th>
                <th scope="col">Town</th>
                <th scope="col">Post Code</th>
                <th scope="col">E-Mail</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <?php
                $customer_id = $_SESSION['customer_id'];
                $customer = mysqli_fetch_assoc(mysqli_query($sql, "select * from customer where CustomerID = $customer_id limit 1"));
                echo '<td>' . $customer['FirstName'] . '</td><td>' . $customer['LastName'] . '</td><td>' . $customer['StreetAddress'] . '</td><td>' . $customer['Town'] . '</td><td>' . $customer['PostCode'] . '</td><td>' . $customer['EMailAddress'] . '</td>';
                ?>
            </tr>
            </tbody>
        </table>
        <div class="row">
        </div>
        <table class="table align-middle">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Image</th>
                <th scope="col">Coffee Name</th>
                <th scope="col">Description</th>
                <th scope="col">M Price</th>
                <th scope="col">L Price</th>
                <th scope="col">XL Price</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $coffees = mysqli_query($sql, "select * from coffee order by CoffeeID");
            for ($j = 0; $j < mysqli_num_rows($coffees); $j++) {
                echo '<tr>';
                $coffee = mysqli_fetch_assoc($coffees);
                $m = mysqli_fetch_assoc(mysqli_query($sql, "select * from size where CoffeeID = '" . $coffee['CoffeeID'] . "' and Type = 'm'"))['Cost'];
                $l = mysqli_fetch_assoc(mysqli_query($sql, "select * from size where CoffeeID = '" . $coffee['CoffeeID'] . "' and Type = 'l'"))['Cost'];
                $xl = mysqli_fetch_assoc(mysqli_query($sql, "select * from size where CoffeeID = '" . $coffee['CoffeeID'] . "' and Type = 'xl'"))['Cost'];
                echo '<td class="">' . $coffee['CoffeeID'] . '</td><td>' . '<img class="coffee-img" src="img/' . $coffee['CoffeeID'] . '.png" alt="">' . '</td><td>' . $coffee['Name'] . '</td><td>' . $coffee['Description'] . '</td><td>' . $m . '</td><td>' . $l . '</td><td>' . $xl . '</td>';
                echo '</tr>';
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="container my-4 big">
        <div class="row">
            <h2>Order</h2>
        </div>
        <div class="row my-3">
            <form method="POST">
                <label for="Coffees">How many Coffees do you want?</label>
                <select id="Coffees" name="Coffees">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
                <input class="button1" style="color: black" type="submit" value="Add">
            </form>
        </div>
        <div class="row">
            <!-- Creates the requested number of coffee selection inputs -->
            <?php
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $coffee_count = $_POST['Coffees'];
                echo '<form action="order_summary.php" method="POST">';
                for ($i = 0; $i < $coffee_count; $i++) {
                    echo '<p><label for="Coffee' . $i . '">Coffee Type:</label>
              <select id="Coffee' . $i . '" name="Coffee' . $i . '">';
                    $result = mysqli_query($sql, "select * from coffee");
                    //$coffee_id =
                    for ($x = 0; $x < mysqli_num_rows($result); $x++) {
                        $coffee_name = mysqli_fetch_assoc($result)['Name'];
                        echo '<option value="' . $coffee_name . '">' . $coffee_name . '</option>';
                    }
                    echo '</select>';

                    echo '<label class="offset-1" for="Coffee' . $i . 'Size">Size:</label>
    <select onchange="val(' . $i . ')" id="Coffee' . $i . 'Size" name="Coffee' . $i . 'Size">
        <option value="m">M</option>
        <option value="l">L</option>
        <option value="xl">XL</option>
    </select></p>';
                }
                echo '
        <input class="button1 my-3" style="color: black" type="submit" value="Checkout">
        </form>';
            }
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