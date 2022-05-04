<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Get the values from login.php
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price_m = $_POST['price_m'];
    $price_l = $_POST['price_l'];
    $price_xl = $_POST['price_xl'];

    if (empty($id) || empty($name) || empty($description) || empty($price_m) || empty($price_l) || empty($price_xl)) {
        echo "<script type='text/javascript'>alert('Please fill out all the fields.');</script>";
    } else {
        // Connect to the database
        $sql = mysqli_connect("localhost", "root", "", "apollo_db");

        // Query the db
        $result = mysqli_query($sql, "select * from coffee where CoffeeID = '$id' limit 1");
        if ($result && mysqli_num_rows($result) > 0) {
            echo "<script type='text/javascript'>alert('Coffee ID exists in the DB');</script>";
        } else {
            $insert = mysqli_multi_query($sql,
                "insert into coffee (CoffeeID, Name, Description) values ('$id', '$name', '$description');
                insert into size (CoffeeID, Type, Cost) values ('$id', 'm', '$price_m'),
                                                               ('$id', 'l', '$price_l'),
                                                               ('$id', 'xl', '$price_xl');");
            if ($insert) {

                $target_dir = "img/";
                $target_file = $target_dir . $id . '.png';
                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);

                echo "<script type='text/javascript'>alert('Successfully added coffee to the DB');</script>";
            }
        }
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>

<nav class="navbar transparent">
    <div class="container justify-content-center">
        <a href="index.php"><img class="img-fluid logo" src="img/logo.png" alt=""></a>
        <a class="btn ms-auto d-sm-block button1" href="recent_orders.php">Recent Orders</a>
    </div>
</nav>

<div class="container d-flex justify-content-center" style="padding-top: 50px">
    <form method="POST" enctype="multipart/form-data">
        <div class="row form-floating">
            <input class="form-control mb-3" placeholder="." type="text" id="id" name="id">
            <label for="id">Coffee ID Number:</label>
        </div>
        <div class="row form-floating">
            <input class="form-control mb-3" placeholder="." type="text" id="name" name="name">
            <label for="name">Name:</label>
        </div>
        <div class="row form-floating">
            <input class="form-control mb-3" placeholder="." type="text" id="description" name="description">
            <label for="description">Description:</label>
        </div>
        <div class="row">
            <div class="col-lg-4 form-floating pe-md-2 p-0">
                <input class="form-control mb-3" placeholder="." type="number" step="0.01" id="price_m" name="price_m">
                <label for="price_m">Price for size M:</label>
            </div>
            <div class="col-lg-4 form-floating pe-md-2 p-0">
                <input class="form-control mb-3" placeholder="." type="number" step="0.01" id="price_l" name="price_l">
                <label for="price_l">Price for size L:</label>
            </div>
            <div class="col-lg-4 form-floating pe-md-2 p-0">
                <input class="form-control mb-3" placeholder="." type="number" step="0.01" id="price_xl"
                       name="price_xl">
                <label for="price_xl">Price for size XL:</label>
            </div>
        </div>
        <div class="row">
            <label class="mb-2" for="description">Image:</label>
            <input class="form-control mb-3" placeholder="." type="file" id="fileToUpload" name="fileToUpload">
        </div>
        <div>
            <input class="form-control button1 my-3" style="color: black; border-radius: 2px; border-color: black"
                   type="submit" id="btn" name="submit" value="Add new Coffee to DB">
        </div>
    </form>
</div>

<footer class="text-center text-lg-start">
    <div class="text-center p-3" style="color: black;background-color: rgba(0, 0, 0, 0.2);">
        © 2021 Copyright:
        <span class="text-dark">Apollo's Coffee</span>
    </div>
</footer>

</body>
</html>