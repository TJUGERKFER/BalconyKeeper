<?php
$mode=$_GET["mode"];
$module=$_GET["module"];
$rcvdata=$_GET["rcvdata"];
if($module=="antithief"){
    if($mode=="write"){
        $i=file_get_contents("antithief.json");
        $i=json_decode($i,true);
        $ii=array('time'=>"<li class=\"mdui-list-item mdui-ripple\">".date("Y/m/d H:i:s"),'message'=>"有人经过阳台");
        $i['data'][]=$ii;
            echo "beep";
        $i=json_encode($i);
        file_put_contents("antithief.json",$i);
    }
    if($mode=="set"){
        $i=file_get_contents("antithief.json");
        $i=json_decode($i,true);
        $i['settings']=json_decode($rcvdata,true);
        $i=json_encode($i);
        file_put_contents("antithief.json",$i);
        exit();
    }
    if($mode=="get"){
        echo json_encode(file_get_contents("antithief.json"));
        exit();
    }
}
if($mode=="set"){
    $i=json_decode($rcvdata,true);
    $i=json_encode($i);
    echo json_encode(file_put_contents("settings.json",$i));
}
if($mode=="get"){
    echo json_encode(file_get_contents("settings.json"));
}
?>