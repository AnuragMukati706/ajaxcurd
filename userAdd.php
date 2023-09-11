<?php

require_once('conn.php');
$nameErr = $passwordErr = $mobileErr = $photoErr = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target_dir = 'upload/';
    $target_file = $target_dir . basename($_FILES['photo']['name']);
    $allowed_extension = pathinfo($target_file, PATHINFO_EXTENSION);

    if (empty($_POST['name'])) {
        $nameErr = "name is required";
    } elseif (!preg_match("/^[a-z A-z]*$/", $_POST['name'])) {
        $nameErr = " Alphabets are allowed";
    } else {
        $name = $_POST['name'];
    }

    if (empty($_POST['password'])) {
        $passwordErr = "password is required";
    } elseif (!preg_match("^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$^", $_POST['password'])) {
        $passwordErr = "password should be in smallcase uppercase number and special characters ";
    } else {
        $password = $_POST['password'];
    }

    if (empty($_POST['mobile'])) {
        $mobileErr = "mobile no. is required";
    } elseif (!preg_match("/^[0-9]*$/", $_POST['mobile'])) {
        $mobileErr = "Only number are allowed";
    } else {
        $mobile = $_POST['mobile'];
    }
    
    if (empty($_FILES["photo"]["name"])) {
        $photoErr = "photo is required";
    } elseif ($_FILES['photo']['size'] > 30000000) {
        $photoErr = "photo should be less than 3MB";
    } else {
        $photo = $_FILES["photo"]["name"];
    }
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
        $photo = $_FILES["photo"]["name"];
        if (empty($nameErr) && empty($passwordErr) && empty($mobileErr) && empty($photoErr)) {
            $ins_Qry = 'INSERT INTO validation (name,password,mobile,photo)VALUES("' . $name . '","' . $password . '","' . $mobile . '","' . $photo . '")';
            if (mysqli_query($conn, $ins_Qry)) {
                $response = 'Data Inserted Into Database Successfully';
            } else {
                $response = 'data insertion failed';
            }
        } else {
            $response = 'Oops! Something Went Wrong';
        }
    } else {
        $response = ["nameErr" => $nameErr, "passwordErr" => $passwordErr, "mobileErr" => $mobileErr, "photoErr" => $photoErr];
    }
    echo json_encode($response);
}
