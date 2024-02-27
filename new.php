<!DOCTYPE html>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crudphp1";

$con = mysqli_connect($servername, $username, $password, $dbname);

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $hobbies = $_POST['hobbies'];
    $states = $_POST['states'];
    $cities = $_POST['cities'];
    $textarea = $_POST['textarea'];

    if ($id != "") {
        $id = $_POST['id'];
        $abc = "UPDATE data SET fullname='$fullname', email='$email', gender='$gender', hobbies='$hobbies', states='$states', cities='$cities', textarea='$textarea' WHERE id='$id'";
        $aaa = mysqli_query($con, $abc);
    } else {
        $sql = "INSERT INTO data(fullname, email, gender, hobbies, states, cities, textarea) VALUES('$fullname', '$email', '$gender', '$hobbies', '$states', '$cities', '$textarea')";
        $bbb = mysqli_query($con, $sql);
    }
    header("Location:new.php");
    exit();
}

if (isset($_GET['id']) && ($_GET['type'] == 'edit')) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM data WHERE id='$id'";
    $aaa = mysqli_query($con, $sql);
    while ($abc = $aaa->fetch_assoc()) {
        $fullname = $abc['fullname'];
        $email = $abc['email'];
        $gender = $abc['gender'];
        $hobbies = $abc['hobbies'];
        $states = $abc['states'];
        $cities = $abc['cities'];
        $textarea = $abc['textarea'];
    }
}

if (isset($_GET['id']) && ($_GET['type'] == 'delete')) {
    $id = $_GET['id'];
    $sql = "DELETE FROM data WHERE id='$id'";
    $aaa = mysqli_query($con, $sql);
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
</head>

<body>
    <div class="container mt-5" style="border: 4px solid cornflowerblue;border-radius: 18px;padding: 40px;">
        <form action="new.php" method="post" id="formdata" enctype="multipart/form-data">
            <div>
                <b> Fullname:</b> <input type="text" name="fullname" id="fullname" value="<?php echo isset($fullname) ? $fullname : ""; ?>">
                <b> E-Mail:</b> <input type="email" name="email" id="email" value="<?php echo isset($email) ? $email : ""; ?>">
                <input type="hidden" name="id" id="id" value="<?php echo isset($id) ? $id : ""; ?>">
                <b> Search:</b> <input type="search" name="search" id="search">
                <button name="all">Search</button>
            </div>
            <div class="mt-2">
                <b> Gender:</b>
                <input type="radio" id="male" name="gender" value="male" <?php if (isset($gender) && $gender == "male") echo "checked"; ?>>
                <label>Male</label>
                <input type="radio" id="female" name="gender" value="female" <?php if (isset($gender) && $gender == "female") echo "checked"; ?>>
                <label>Female</label>
            </div>
            <div class="mt-2">
                <b>Hobbies:</b>
                <input type="checkbox" id="cricket" name="hobbies" value="cricket" <?php if (isset($hobbies) && $hobbies == "cricket") echo "checked"; ?>>
                <label>Cricket</label>
                <input type="checkbox" id="football" name="hobbies" value="football" <?php if (isset($hobbies) && $hobbies == "football") echo "checked"; ?>>
                <label>Football</label>
                <input type="checkbox" id="tennis" name="hobbies" value="tennis" <?php if (isset($hobbies) && $hobbies == "tennis") echo "checked"; ?>>
                <label>Tennis</label>
                <input type="checkbox" id="boxing" name="hobbies" value="boxing" <?php if (isset($hobbies) && $hobbies == "boxing") echo "checked"; ?>>
                <label>Boxing</label>
                <input type="checkbox" id="cycling" name="hobbies" value="cycling" <?php if (isset($hobbies) && $hobbies == "cycling") echo "checked"; ?>>
                <label>Cycling</label>
            </div>
            <div class="mt-2">
                <b> States:</b>
                <select name="states" id="states">
                    <option value="Gujarat" <?php if (isset($states) && $states == "Gujarat") echo "Selected"; ?>>Gujarat</option>
                    <option value="Maharastra" <?php if (isset($states) && $states == "Maharastra") echo "Selected"; ?>>Maharastra</option>
                    <option value="Himachal Pradesh" <?php if (isset($states) && $states == "Himachal Pradesh") echo "Selected"; ?>>Himachal Pradesh</option>
                    <option value="Uttar Pradesh" <?php if (isset($states) && $states == "Uttar Pradesh") echo "Selected"; ?>>Uttar Pradesh</option>
                    <option value="Madhya Pradesh" <?php if (isset($states) && $states == "Madhya Pradesh") echo "Selected"; ?>>Madhya Pradesh</option>
                </select>
                <b>Cities:</b>
                <select name="cities" id="cities">
                    <option value="Ahmedabad" <?php if (isset($cities) && $cities == "Ahmedabad") echo "Selected"; ?>>Ahmedabad</option>
                    <option value="Delhi" <?php if (isset($cities) && $cities == "Delhi") echo "Selected"; ?>>Delhi</option>
                    <option value="Mumbai" <?php if (isset($cities) && $cities == "Mumbai") echo "Selected"; ?>>Mumbai</option>
                    <option value="Bihar" <?php if (isset($cities) && $cities == "Bihar") echo "Selected"; ?>>Bihar</option>
                    <option value="Indore" <?php if (isset($cities) && $cities == "Indore") echo "Selected"; ?>>Indore</option>
                </select>
            </div>
            <div class="mt-3 mb-3">
                <b>Textarea:</b>
                <textarea id="textarea" name="textarea" rows="4" cols="50" value=""><?php echo isset($textarea) ? $textarea : ""; ?></Textarea>
            </div>
            <button class="btn btn-warning mt-3 mb-3" name="submit">Submit</button>
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Fullname <a href="new.php?type=up&value=fullname"><img src="arrow-up.png" style="height:14px;"></a>
                        <a href="new.php?type=down&value=fullname"><img src="caret-down.png" style="height:14px;"></a>
                    </th>
                    <th>E-Mail <a href="new.php?type=up&value=email"><img src="arrow-up.png" style="height:14px;"></a>
                        <a href="new.php?type=down&value=email"><img src="caret-down.png" style="height:14px;"></a>
                    </th>
                    <th>Gender</th>
                    <th>Hobbies</th>
                    <th>States</th>
                    <th>Cities</th>
                    <th>Textarea</th>
                    <th>Actions</th>
                </tr>
                <tbody>
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "crudphp1";

                    $con = mysqli_connect($servername, $username, $password, $dbname);

                    $sql = "SELECT * FROM data";

                    // if (isset($_POST['all'])) {
                    //     $search = $_POST['search'];
                    //     $sql .= " WHERE fullname LIKE '%$search%' OR email LIKE '%$search%' OR gender LIKE '%$search%' OR hobbies LIKE '%$search%' OR states LIKE '%$search%' OR cities LIKE '%$search%' OR textarea LIKE '%$search%'";
                    // }
                    // $eee = mysqli_query($con, $sql);
                    // $rows = mysqli_fetch_array($eee)[0];
                    // $pages = ceil($rows / $records);
                    // if (isset($_GET['type'])) {
                    //     if ($_GET['type'] == 'up') {
                    //         $value = isset($_GET['value']);
                    //         $sql .= " ORDER BY " . $value . " ASC";
                    //     } else if ($_GET['type'] == 'down') {
                    //         $value = isset($_GET['value']);
                    //         $sql .= " ORDER BY " . $value . " DESC";
                    //     }
                    // }

                    // if (isset($_GET['page'])) {
                    //     $sql .= " LIMIT $offset, $records";
                    // } else {
                    //     $sql .= " LIMIT 5";
                    // }
                    $aaa = mysqli_query($con, $sql);
                    if ($aaa->num_rows > 0) {
                        while ($row = $aaa->fetch_assoc()) {
                    ?>
                            <tr>
                                <td><?php echo $row['fullname']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['gender']; ?></td>
                                <td><?php echo $row['hobbies']; ?></td>
                                <td><?php echo $row['states']; ?></td>
                                <td><?php echo $row['cities']; ?></td>
                                <td><?php echo $row['textarea']; ?></td>
                                <td>
                                    <a class="btn btn-info" href="new.php?id=<?php echo $row['id']; ?>&type=edit" target="_self">Edit</a>
                                    <a class="btn btn-danger" href="new.php?id=<?php echo $row['id']; ?>&type=delete" target="_self">Delete</a>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </form>
    </div>
    <div style="margin-top: 5px;margin-left: 48%;padding: 5px;">
        <?php
        $pages = ceil($rows / $records);
        for ($i = 1; $i <= $pages; $i++) {
            $isActive = isset($_GET['page']) && $_GET['page'] == $i ? "active" : "";
            echo '<ul class="pagination">
            <li class="page-item ' . $isActive . '">
            <a class="page-link" href="new.php?page=' . $i . '">
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