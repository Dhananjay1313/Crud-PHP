<!DOCTYPE html>
<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "crudphp";
    
    $con = mysqli_connect($servername,$username,$password,$dbname);
    
    $sql = " CREATE DATABASE crudphp";
    
    $sql = "CREATE TABLE data(
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        firstname VARCHAR(20) NOT NULL,
        lastname VARCHAR(20) NOT NULL,
        gender VARCHAR(10) NOT NULL,
        city VARCHAR(10) NOT NULL,  
    )";

    if (isset($_POST['submit'])) {   
        $id = $_POST['id'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $gender = isset($_POST['gender']);
        $city = $_POST['city'];
        $abc = "INSERT INTO data(firstname, lastname, gender, city) VALUES('$firstname', '$lastname', '$gender', '$city')";
        $aaa = mysqli_query($con,$abc);
    }
?>