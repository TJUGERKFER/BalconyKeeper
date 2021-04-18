<?php
$model=$_GET['model'];
$i=0;
include "login.php";
$connect2=mysqli_connect($address,$username,$password,$dbname);
if(! $connect )
{
    die('连接失败: ' . mysqli_error($connent));
}
$sql = 'SELECT waterthreshold, pot_humi , pot_temp , air_humi
        FROM balcony_table';
$retval = mysqli_query( $connect, $sql );
$sql2 ='SELECT machine_isonline FROM machine';
$retval2 = mysqli_query( $connect2, $sql2 );
if ($model=="situation"){
echo "<strong>仪表盘</strong><br>";
echo "上次刷新时间: " . date("h:i:sa")."<br>";
//$row2 = mysqli_fetch_array($retval2, MYSQLI_NUM));	
while($row = mysqli_fetch_array($retval, MYSQLI_NUM)){
    if($row[1]==0){
		$shidu="未检测到数据";
		$color="color:#FF0000";
	}
	if($row[1]>0){
		$shidu="极为干旱";
		$color="color:#FF0000";
	}
	if($row[1]>300){
		$shidu="干旱";
		$color="color:#ff6600";
	}
	if($row[1]>500){
		$shidu="适中";
		$color="color:#00cc00";
	}
	if($row[1]>800){
		$shidu="湿润";
		$color="color:#0099cc";
	}
	$i++;
	echo "<div>";
	echo "<ul class='mdui-list'>";
	echo "<li class=\"mdui-list-item mdui-ripple\">浇水阈值:$row[0]</li>";
	echo "<li class=\"mdui-list-item mdui-ripple\" style=\"$color\">土壤湿度:$row[1] $shidu</li>";
	echo "<li class=\"mdui-list-item mdui-ripple\" >空气湿度:$row[3]%</li>";
	echo "<li class=\"mdui-list-item mdui-ripple\" >温度:$row[2] </li>";
	echo "<li class=\"mdui-list-item mdui-ripple\" >降水:未降水</li>";
	echo "</div>";
}
}
if ($model=="panel"){
	echo "<center>";
	echo "<h3>控制面板</h3>";
	    echo "<h4>花盆管理<h4><br>";
    while($row = mysqli_fetch_array($retval, MYSQLI_NUM)){
		$i++;
		echo "<strong>花盆$i</strong><br>";
		echo "<botton class=\"mdui-btn  mdui-ripple mdui-color-theme-accent\" Onclick=\"sendcommand($i,'water')\">立即浇水</button>";
		echo "</botton>";
	}
	echo "<h4>总体控制<h4>";
	echo "<botton class=\"mdui-btn  mdui-ripple mdui-color-theme-accent\" Onclick=\"sendcommand(1,'openwindow')\">开窗</button>";
	echo "</botton>";
	echo "<botton class=\"mdui-btn  mdui-ripple mdui-color-theme-accent\" Onclick=\"sendcommand(1,'closewindow')\">关窗</button>";
	echo "</botton>";
	echo "<botton class=\"mdui-btn  mdui-ripple mdui-color-theme-accent\" Onclick=\"sendcommand(1,'music')\">播放音乐</button>";
	echo "</botton>";
	echo "<botton class=\"mdui-btn  mdui-ripple mdui-color-theme-accent\" Onclick=\"sendcommand(1,'beep')\">蜂鸣器报警</button>";
	echo "</botton>";
	echo "</br>";
	echo "<botton class=\"mdui-btn  mdui-ripple mdui-color-theme-accent\" Onclick=\"sendcommand(1,'onlight')\">开灯</button>";
	echo "</botton>";
	echo "<botton class=\"mdui-btn  mdui-ripple mdui-color-theme-accent\" Onclick=\"sendcommand(1,'offlight')\">关灯</button>";
	echo "</center>";
}
if ($model=="choosepot"){
	echo "<select id=\"idselector\" onchange=\"function(){pot=document.getElementById('idselector').value}\" class=\"mdui-select\" mdui-select=\"{position: 'bottom'}\">";
	while($row = mysqli_fetch_array($retval, MYSQLI_NUM)){
		$i++;
		echo "<option value=\"$i\">花盆$i</option>";
	}
	echo "</select>";
}
mysqli_free_result($retval);
?>