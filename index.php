<!DOCTYPE html>
<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crudphp";

$con = mysqli_connect($servername, $username, $password, $dbname);

// $currentPageUrl = 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

if (isset($_POST['submit'])) { 
   
    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $city = $_POST['city'];
    $color = $_POST['color'];

    $image = basename($_FILES['image']['name']);
	$target_dir = "D:/wamp64/www/new/image/";
	$target = $target_dir . $image;
	$is_upload = move_uploaded_file($_FILES['image']['tmp_name'], $target);
    // if (file_exists($image)) {
    //     unlink("D:/wamp64/www/new/image/".$target);
    // } else {
    // $is_upload = move_uploaded_file($_FILES['image']['tmp_name'], $target);
    // }
    
    if ($id != "") {
        $id = $_POST['id'];
        $img = $_POST['img'];
        $img = $_FILES['image']['name'];

        $abc = "UPDATE data SET firstname='$firstname', lastname='$lastname', gender='$gender', city='$city', color='$color', image='$img' WHERE id='$id'";
        // unlink("D:/wamp64/www/new/image/".$target);
        $aaa = mysqli_query($con, $abc);
        
    } else {
        $sql = "INSERT INTO data(firstname, lastname, gender, city, color, image) VALUES('$firstname', '$lastname', '$gender', '$city', '$color', '$image')";
        $bbb = mysqli_query($con, $sql);
    }
    header("Location:index.php");
    exit();
}

if (isset($_GET['id']) && ($_GET['type'] == 'edit')) {
    $id = $_GET['id'];
    // $image = $_FILES['image']['name'];
	// $target_dir = "D:/wamp64/www/new/image/";
	// $target = $target_dir . $image;
    // $img = $_GET['img'];
    //select query for get data
    $sql = "SELECT * FROM data WHERE id='$id'";
    $aaa = mysqli_query($con, $sql);
    while ($abc = $aaa->fetch_assoc()) {
        $firstname = $abc['firstname'];
        $lastname = $abc['lastname'];
        $gender = $abc['gender'];
        $city = $abc['city'];
        $color = $abc['color'];
        $image = $abc['image'];
    }
}

if (isset($_GET['id']) && ($_GET['type'] == 'delete')) {
    $id = $_GET['id'];
    $sql = "DELETE FROM data WHERE id='$id'";
    $aaa = mysqli_query($con, $sql);
    
    // unlink($row['image']);

    if ($aaa == TRUE) {
        header('Location: index.php');
    }
    header('Location: index.php');
}

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$records = 5;
$offset = ($page - 1) * $records;

$total_pages_sql = "SELECT COUNT(*) FROM data";
$eee = mysqli_query($con, $total_pages_sql);
$rows = mysqli_fetch_array($eee)[0];
$pages = ceil($rows / $records);


?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
</head>
<style>
    .container {
        max-width: 1200px;
        border: 4px solid burlywood;
        border-radius: 5px;
        padding: 35px;
        background-color: antiquewhite;
    }
    b {
        font-family: fantasy;
    }
</style>

<body>
    <div class="container mt-5">
        <form method="POST" action="index.php" id="formdata" enctype="multipart/form-data">
            <div>
                <input type="hidden" name="id" id="id" value="<?php echo isset($id) ? $id : ""; ?>">
                <input type="hidden" name="img" id="img" value="<?php echo isset($img) ? $img : ""; ?>">
                <b> Firstname:</b> <input type="text" name="firstname" value="<?php echo isset($firstname) ? $firstname : ""; ?>">
                <b> Lastname:</b> <input type="text" name="lastname" value="<?php echo isset($lastname) ? $lastname : ""; ?>">
                <b> Search:</b> <input type="search" name="search" id="search">
                <button name="all">Search</button>
            </div>
            <div class="mt-3">
                <b> Color:</b> <input type="color" name="color" id="color" value="<?php echo isset($color) ? $color : ""; ?>">
            </div>
            <div class="mt-3">
                <b> Gender:</b> <input type="radio" name="gender" value="male" <?php if (isset($gender) && $gender == "male") echo "checked"; ?>> Male
                <input type="radio" name="gender" value="female" <?php if (isset($gender) && $gender == "female") echo "checked"; ?>> Female
            </div>
            <div class="mt-3">
                <b> City: </b> <select name="city" id="city">
                    <option value="Ahmedabad" <?php if (isset($city) && $city == "Ahmedabad") echo "Selected"; ?>>Ahmedabad</option>
                    <option value="Surat" <?php if (isset($city) && $city == "Surat") echo "Selected"; ?>>Surat</option>
                    <option value="Baroda" <?php if (isset($city) && $city == "Baroda") echo "Selected"; ?>>Baroda</option>
                    <option value="Porbandar" <?php if (isset($city) && $city == "Porbandar") echo "Selected"; ?>>Porbandar</option>
                </select>
                <input type="file" id="image" name="image" value="<?php echo isset($image) ? $image : "";?>">
            </div>
            <button class="btn btn-primary mt-3 mb-2" name="submit">Submit</button>
        </form>
        <table class="table table-striped table-dark">
            <tr>
                <th>Firstname<a href="index.php?type=up&value=firstname"><img src="arrow-up.png" style="height:14px;"></a>
                    <a href="index.php?type=down&value=firstname"><img src="caret-down.png" style="height:14px;"></a>
                </th>
                <th>Lastname<a href="index.php?type=up&value=lastname"><img src="arrow-up.png" style="height:14px;"></a>
                    <a href="index.php?type=down&value=lastname"><img src="caret-down.png" style="height:14px;"></a>
                </th>
                <th>Gender</th>
                <th>City</th>
                <th>Color</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
            <tbody>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "crudphp";

                $con = mysqli_connect($servername, $username, $password, $dbname);

                $sql = "SELECT * FROM data";

                if (isset($_GET['type'])) {
                    if ($_GET['type'] == 'up') {
                        $value = isset($_GET['value']);
                        $sql .= " ORDER BY " . $value . " ASC";
                    } else if ($_GET['type'] == 'down') {
                        $value = isset($_GET['value']);
                        $sql .= " ORDER BY " . $value . " DESC";
                    }
                }
                
                if (isset($_POST['all'])) {
                    $search = $_POST['search'];
                    $sql .= " WHERE firstname LIKE '%$search%' OR lastname LIKE '%$search%' OR gender LIKE '%$search%' OR city LIKE '%$search%' OR color LIKE '%$search%'";
                    $total_pages_sql = "SELECT COUNT(*) FROM data WHERE firstname LIKE '%$search%' OR lastname LIKE '%$search%' OR gender LIKE '%$search%' OR city LIKE '%$search%' OR color LIKE '%$search%'";
                    $eee = mysqli_query($con, $total_pages_sql);
                    $rows = mysqli_fetch_array($eee)[0];
                    $pages = ceil($rows / $records);
                }
                if (isset($_GET['page'])) {
                    $sql .= " LIMIT $offset, $records";
                } else {
                    $sql .= " LIMIT 5";
                }
                $aaa = mysqli_query($con, $sql);
                if ($aaa->num_rows > 0) {
                    while ($row = $aaa->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?php echo $row['firstname']; ?></td>
                            <td><?php echo $row['lastname']; ?></td>
                            <td><?php echo $row['gender']; ?></td>
                            <td><?php echo $row['city']; ?></td>
                            <td><input type="color" name="color" id="color" value="<?php echo $row['color'] ?>"></td>
                            <td>
                                <img style="height: 90px;width: 70px;" src='../image/<?php echo $row['image']?>'>
                        </td>
                            <td>
                                <a class="btn btn-info" href="index.php?id=<?php echo $row['id']; ?>&type=edit" target="_self">Edit</a>
                                <a class="btn btn-danger" href="index.php?id=<?php echo $row['id']; ?>&type=delete" target="_self">Delete</a>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <div style="margin-top: 5px;margin-left: 48%;padding: 5px;">
        <?php
        $pages = ceil($rows / $records);
        for ($i = 1; $i <= $pages; $i++) {
            $isActive = isset($_GET['page']) && $_GET['page'] == $i ? "active" : "";
            echo '<ul class="pagination">
            <li class="page-item ' . $isActive . '">
            <a class="page-link" href="index.php?page=' . $i . '">
            ' . $i . '</a></li>';
        }
        ?>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("formdata").reset();
        })
    </script>
</body>

</html>