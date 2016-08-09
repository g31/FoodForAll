<?php
include_once 'database_config.php';
//session_start();
//$email ="p@gmail.com";
//$email = $_SESSION['email'];
//$email = $_POST['email'];
$conn=get_connection();
date_default_timezone_set("America/Los_Angeles");
$date = date("Y-m-d");
$thismonth = date("m",strtotime($date));
$today = date("d",strtotime($date));
$time = date("h:i:sa");

// fetching pickup time for the not accepted requests
$array1 = Array();
$array2 = Array();
$array3 = Array();

$vid = '0';
$j = 0;
$sql1="SELECT * FROM `request` where `volunteeremailid` = '$vid'";

$result1 = mysqli_query($conn, $sql1);
while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC))
{
	if(strtotime($row['pickuptime']) > time())
	{
		$array1[$j] = $row['pickuptime'];
		$array2[$j] = $row['typefood'];
		$array3[$j] = $row['donoraddreess'];
		$array4[$j] = $row['donorphonenumber'];
		$array5[$j] = $row['recepientname'];
		//$array6[$j] = $row['recepientaddress'];
		$j++;
	}
}

$d=0;
while($d<$j)
{
	$array2[$d] = strtr($array2[$d], array('"' => '','[' => '',']' => ''));
	$d++;
}

$list = array();
$k = 0;
while($k < $j)
{
	$list[] = array('donoraddreess' => $array3[$k], 'pickuptime' => $array1[$k],'typefood'=>$array2[$k],'donorphonenumber'=>$array4[$k],'recepientname'=>$array5[$k]);
	$k++;
}

$response_data = array("status"=>200, "data"=>$list);
$response= json_encode($response_data);
echo $response;
?>