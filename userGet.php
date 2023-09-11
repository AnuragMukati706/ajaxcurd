<?php

require_once('conn.php');
$response = array();

$query = 'select * from validation';
$result = mysqli_query($conn,$query);

if(mysqli_num_rows($result)>0){
    while($row = mysqli_fetch_array($result)){
        $data[] = $row;
    }
}
echo json_encode($data);
?>