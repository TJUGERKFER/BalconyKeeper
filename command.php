<?php
$pot=($_GET['pot']); 
$mode=($_GET['mode']); 
$command=($_GET['command']); 
include "login.php";
if(! $connect )
{
    die('连接失败: ' . mysqli_error($connent));
}
$autochangesql = 'SELECT waterthreshold, pot_humi, fertilizedelay, lastfertilizetime,musicdelay,lastmusictime FROM balcony_table';
$autochangeretval = mysqli_query( $connect, $autochangesql );
$targetpot=0;
while($row = mysqli_fetch_array($autochangeretval, MYSQLI_NUM)){ //触发定时任务
	$targetpot++;
	if($row[0]>$row[1]){
		$autodosql = "update balcony_table set autocommand='water' where pot_id=".$targetpot."";
		mysqli_query( $connect, $autodosql );
		$i=file_get_contents("antithief.json");
        $i=json_decode($i,true);
        $ii=array('time'=>"<li class=\"mdui-list-item mdui-ripple\">".date("Y/m/d H:i:s"),'message'=>"自动浇水任务启动</li>");
        $i['data'][]=$ii;
        $i=json_encode($i);
        file_put_contents("antithief.json",$i);
	}
	if($row[2]+$row[3]<time()){ //盖就盖自动指令吧 不差这一轮浇水
		$autodosql = "update balcony_table set autocommand='tipfertilize' where pot_id=".$targetpot."";
		$nowtime=time();
		mysqli_query( $connect, $autodosql );
		$changefertilizetime = "update balcony_table set lastfertilizetime=".$nowtime." where pot_id=".$targetpot.""; //网络连接不好的话可能会漏 不理他
		mysqli_query( $connect, $changefertilizetime );
	}
	if($row[4]+$row[5]<time()){
		$autodosql = "update balcony_table set autocommand='music' where pot_id=".$targetpot."";
		$nowtime=time();
		mysqli_query( $connect, $autodosql );
		$changemusictime = "update balcony_table set lastmusictime=".$nowtime." where pot_id=".$targetpot.""; //网络连接不好的话可能会漏 不理他
		mysqli_query( $connect, $changemusictime );
		        $i=file_get_contents("antithief.json");
        $i=json_decode($i,true);
        $ii=array('time'=>"<li class=\"mdui-list-item mdui-ripple\">".date("Y/m/d H:i:s"),'message'=>"定时音乐播放任务启动</li>");
        $i['data'][]=$ii;
        $i=json_encode($i);
        file_put_contents("antithief.json",$i);
	}
}
if ($mode=="get"){
	$sql = "SELECT pot_command FROM balcony_table where pot_id=".$pot."";
	$retval = mysqli_query( $connect, $sql );
	$row = mysqli_fetch_array($retval, MYSQLI_NUM);
	echo $row[0];
	$sql = "update balcony_table set pot_command=\"none\" where pot_id=".$pot."";
	$retval = mysqli_query( $connect, $sql );
//}
}
if ($mode=="autoget"){
	$sql = "SELECT autocommand FROM balcony_table where pot_id=".$pot."";
	$retval = mysqli_query( $connect, $sql );
	$row = mysqli_fetch_array($retval, MYSQLI_NUM);
	echo $row[0];
	if ($row[0]=="fertilize"){
	$changeferttime = "update balcony_table set lastfertilizetime=".$nowtime." where pot_id=".$targetpot.""; //网络连接不好的话可能会漏 不理他
	mysqli_query( $connect, $changeferttime );
	}
	$sql = "update balcony_table set autocommand=\"none\" where pot_id=".$pot."";
	$retval = mysqli_query( $connect, $sql );
//}
}
if($mode=="send") {
    $i=file_get_contents("antithief.json");
        $i=json_decode($i,true);
            if ($command=="music"){
            $ii=array('time'=>"<li class=\"mdui-list-item mdui-ripple\">".date("Y/m/d H:i:s"),'message'=>"用户通过控制面板播放音乐</li>");
            }
            if ($command=="water"){
            $ii=array('time'=>"<li class=\"mdui-list-item mdui-ripple\">".date("Y/m/d H:i:s"),'message'=>"用户通过控制面板给花浇水</li>");
            }
            if ($command=="beep"){
            $ii=array('time'=>"<li class=\"mdui-list-item mdui-ripple\">".date("Y/m/d H:i:s"),'message'=>"用户通过控制面板报警</li>");
            }
            if ($command=="onlight"){
            $ii=array('time'=>"<li class=\"mdui-list-item mdui-ripple\">".date("Y/m/d H:i:s"),'message'=>"用户通过控制面板开灯</li>");
            }
            if ($command=="offlight"){
            $ii=array('time'=>"<li class=\"mdui-list-item mdui-ripple\">".date("Y/m/d H:i:s"),'message'=>"用户通过控制面板关灯</li>");
            }
            if ($command=="openwindow"){
            $ii=array('time'=>"<li class=\"mdui-list-item mdui-ripple\">".date("Y/m/d H:i:s"),'message'=>"用户通过控制面板开窗</li>");
            }
            if ($command=="closewindow"){
            $ii=array('time'=>"<li class=\"mdui-list-item mdui-ripple\">".date("Y/m/d H:i:s"),'message'=>"用户通过控制面板关窗</li>");
            }
        $i['data'][]=$ii;
        $i=json_encode($i);
        file_put_contents("antithief.json",$i);
        
        
$sql = "update balcony_table set pot_command=\"$command\" where pot_id=".$pot."";
$retval = mysqli_query( $connect, $sql );
echo "success";
}
if($mode=="setthreshold"){
	$value=$_GET['value'];
	$sql = "update balcony_table set waterthreshold=\"$value\" where pot_id=".$pot."";
	$retval = mysqli_query( $connect, $sql );
	    $i=file_get_contents("antithief.json");
        $i=json_decode($i,true);
        $ii=array('time'=>"<li class=\"mdui-list-item mdui-ripple\">".date("Y/m/d H:i:s"),'message'=>"用户将浇水阈值设置为".$value."</li>");
        $i['data'][]=$ii;
        $i=json_encode($i);
        file_put_contents("antithief.json",$i);
}
if($mode=="setfertilize"){
	echo "success";
	$value=$_GET['fertilizedelay'];
	$sql = "update balcony_table set fertilizedelay=\"$value\" where pot_id=".$pot."";
	$retval = mysqli_query( $connect, $sql );
}
if($mode=="setmusic"){
	echo "success";
	$value=$_GET['musicdelay'];
	$sql = "update balcony_table set musicdelay=\"$value\" where pot_id=".$pot."";
	$retval = mysqli_query( $connect, $sql );
}
if($mode=="loadsetting"){
    $i=file_get_contents("settings.json");
    $i=json_decode($i,true);
    $comlist=array("none");
        if($i['settings']['warning']['repeatalert']==true){
            $pluset="true";
        }else{
            $pluset="false";
        }
        if($i['settings']['warning']['autoalert']==true){
            if($i['settings']['warning']['quietmode']==true){
                if (date('H')<23&&date('H')>8){
                    array_push($comlist,"alerton".$pluset);
                    //echo ("alerton".$pluset);
                } else {
                    //echo ("alertoff".$pluset);
                    array_push($comlist,"alertoff".$pluset);
                }
            }else {
                //echo ("alerton".$pluset);
                array_push($comlist,"alerton".$pluset);
            }
        }else {
            //echo ("alertoff".$pluset);
            array_push($comlist,"alertoff".$pluset);
        }
        if($i['settings']['lights']['auto']==true){
            if(date_sunrise(time(),SUNFUNCS_RET_STRING,24,110,90,8)==date("H:i")){
                //echo "lighton";
                array_push($comlist,"lighton");
            }
            if(date_sunset(time(),SUNFUNCS_RET_STRING,24,110,90,8)==date("H:i")){
                //echo "lightoff";
                array_push($comlist,"lightoff");
            }
        }
        if($i['settings']['lights']['time']==true){
            if("19:00"==date("H:i")){
                //echo "lighton";
                array_push($comlist,"lighton");
            }
            if("06:00"==date("H:i")){
                //echo "lightoff";
                array_push($comlist,"lightoff");
            }
        }
        if($i['settings']['windows']['raintips']==true){
            array_push($comlist,"canclosewindow");
        }
        if($i['settings']['windows']['airtips']==true && "08:00"==date("H:i")){
            array_push($comlist,"canclosewindow");
        }
        if($i['settings']['cloth']['raintips']==true){
            array_push($comlist,"cantipcloth");
        }
        foreach ($comlist as $tmp)
        {
            echo $tmp . "&";
        }
}
?>