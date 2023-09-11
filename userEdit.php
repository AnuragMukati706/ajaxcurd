<?php
require_once('./conn.php');
$response = array();

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $id = $_GET['id'];

    $result = mysqli_query($conn, "select * from validation where id = $id");
    $result = mysqli_fetch_assoc($result);
    echo json_encode($result);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $target_dir = 'upload/';
    $target_file = $target_dir . basename($_FILES['file']['name']);
    $nameErr = $passwordErr = $mobileErr = $photoErr =  $finalFile = "";


    $id = $_POST['editUser'];
    if (empty($_POST['user'])) {
        $nameErr = "name is required";
    } elseif (!preg_match("/^[a-z A-z]*$/", $_POST['user'])) {
        $nameErr = "Only alphabets and whitespace are allowed.";
    } else {
        $name = $_POST['user'];
    }

    if (empty($_POST['pass'])) {
        $passwordErr = "password is required";
    } else {
        $password = $_POST['pass'];
    }

    if (empty($_POST['phone'])) {
        $mobileErr = "mobile no. is required";
    } elseif (!preg_match("/^[0-9]*$/", $_POST['phone'])) {
        $mobileErr = "Only number are allowed";
    } else {
        $mobile = $_POST['phone'];
    }

    if (empty($_FILES['file']['name'])) {
        $finalFile =  $_POST['current_file'];
    } elseif ($_FILES['file']['size'] > 30000000) {
        $photoErr = "photo should be less than 3MB";
    } else {
        $filename = $_FILES['file']['name'];
        $tmp = $_FILES['file']['tmp_name'];
    }
    if (empty($nameErr) && empty($passwordErr) && empty($mobileErr) && empty($finalFile)) {

        if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
            // $photo = $_FILES['file']['name'];
            if (mysqli_query($conn, 'UPDATE `VALIDATION` SET `name`="' . $name . '",`password`="' . $password . '",`mobile`="' . $mobile . '",`photo`="' . $filename . '" WHERE id = "' . $id . '"')) {

                $response = "successfully updated";
            } else {
                $response = "failed to update";
            }
        } else {
            $response = "sdlfmkosm";
        }
    } else {

        if (isset($name) && isset($password) && isset($mobile) && isset($finalFile)) {
            $query = 'UPDATE `VALIDATION` SET `name`="' . $name . '",`password`="' . $password . '",`mobile`="' . $mobile . '",`photo`="' . $finalFile . '" WHERE id = "' . $id . '"'; 
            if ($query) {
                mysqli_query($conn, $query);
                $response = "data updated succesfull";
            } else {
                $response = "data update failed";
            }
        } else {
            $response = ["nameErr" => $nameErr, "passwordErr" => $passwordErr, "mobileErr" => $mobileErr, "photoErr" => $photoErr];
        }
    }
    echo json_encode($response);
}
