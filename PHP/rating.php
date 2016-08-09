<?php
include_once 'database_config.php';
$email = $_POST['email'];

$conn=get_connection();

$sql1="SELECT volunteeremailid FROM `request` where `donoremailid` = '$email'";

$result1 = mysqli_query($conn, $sql1);

$array1 = Array();
while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)) 
{
    $array1[] =  $row['volunteeremailid'];  
}

$result = array_unique($array1);

$c = count($array1);
$x = 0;
$y = 0;
$result7 = Array();
while ($x < $c) 
{
    if($result[$x]!= null)
    {
        $result7[$y] = $result[$x];
        $y++;
    } 
       $x++;
} 

$count = count($result7);
$i=0;
$array3 = Array();
$j=0;
while($i < $count)
{
     $sql1="SELECT pickuptime FROM `request` where (`donoremailid` = '$email' AND `volunteeremailid` = '$result7[$i]')";

     $result1 = mysqli_query($conn, $sql1);

     $array2 = Array();
     while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)) 
     {
         $array2[] =  $row['pickuptime'];  
     }
     rsort($array2);
     $array3[$j]=$array2[0];
     $j++;
     $i++;
}

$i=0;
$array4 = Array();
$j=0;
while($i < $count)
{
     $sql1="SELECT volunteername FROM `request` where (`donoremailid` = '$email' AND `volunteeremailid` = '$result7[$i]')";

     $result1 = mysqli_query($conn, $sql1);

     $array5 = Array();
     while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)) 
     {
         $array5[] =  $row['volunteername'];  
     }
     $array4[$j]=$array5[0];
     $j++;
     $i++;
}

$list = array();
$k = 0;
while($k < $count)
{
    $list[] = array('name' => $array4[$k], 'time' => $array3[$k]);
    $k++;
}

$response_data = array("status"=>200, "details"=>$list);
header('Content-Type: application/json');
echo json_encode($response_data);

?>


