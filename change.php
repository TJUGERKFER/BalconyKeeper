<?php
$pot=intval($_GET['pot']); 
$temp=intval($_GET['temp']); 
$humi=intval($_GET['humi']); 
$airhumi=intval($_GET['airhumi']); 
$i=0;
include "login.php";
if(! $connect )
{
    die('连接失败: ' . mysqli_error($connent));
}
$sql = "update balcony_table set pot_humi='".$humi."',pot_temp=".$temp." ,air_humi=".$airhumi." where pot_id='".$pot."'";
echo $sql;
$sql2 = "update machine set machine_isonline='online',where machine_id=1";
$retval = mysqli_query( $connect, $sql );
$retval2 = mysqli_query( $connect, $sql2 );
echo "success";


