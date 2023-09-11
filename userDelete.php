<?php
require_once('conn.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $userid = $_POST['id'];
    $getResult =  mysqli_query($conn,'SELECT * FROM validation where id ="'.$userid.'"');
   if($nre =mysqli_fetch_assoc($getResult)){
    if(file_exists('upload/'.$nre['photo'])){
        unlink('upload/'.$nre['photo']);
        echo 'file deleted';
    }
    }
    $delquery = "delete from validation where id = '$userid'";
    $result = mysqli_query($conn,$delquery);
    $response = "data deleted succesfully";

}
echo json_encode($response);
?>