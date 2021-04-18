<html>



<head>

    <meta charset="UTF-8">

<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/mdui@1.0.1/dist/css/mdui.min.css"
  integrity="sha384-cLRrMq39HOZdvE0j6yBojO4+1PrHfB7a9l5qLcmRm/fiWXYY+CndJPmyu5FV/9Tw"
  crossorigin="anonymous"
/>
<script
  src="https://cdn.jsdelivr.net/npm/mdui@1.0.1/dist/js/mdui.min.js"
  integrity="sha384-gCMZcshYKOGRX9r6wbDrvF+TcCCswSHFucUzUPwka+Gr+uHgjlYvkABr95TCOz3A"
  crossorigin="anonymous"
></script>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <meta name="viewport" content="width=480, user-scalable=no" />

    <style>

        @media (max-width: 720px) {

            .background {

                position: fixed;

                margin: 0px auto;

                padding: 0px;

                width: 100%;

                height: 100%;

                top: 0;

                z-index: -1;

                background: url(wap.png);

                -moz-background-size: 100% 100%;

                background-size: 100% 100%;

            }

        }



        @media (min-width: 720px) {

            .background {

                position: fixed;

                margin: 0px auto;

                padding: 0px;

                width: 100vw;

                height: 100vh;

                top: 0;

                z-index: -1;

                background: url(PC.png);

                -moz-background-size: 100% 100%;

                background-size: 100% 100%;

            }

        }

    </style>

    <title>

        阳台助手管理系统

    </title>

</head>



<body class="mdui-theme-accent-light-blue" onload="choosepotrefresh();situationrefresh();panelrefresh()">

    <div class="background"></div>

    <div class=".mdui-col-md-12 mdui-col-xs-10 mdui-col-lg-6 mdui-col-offset-lg-3 mdui-col-offset-xs-1">

        <div class="mdui-panel-item mdui-panel-item-open">

            <div class="mdui-tab" id="indextab" mdui-tab>

                <a href="#plant" class="mdui-ripple" id="planttab">植物护理</a>

                <a href="#antithief" class="mdui-ripple" id="antithieftab">智能防盗</a>

                <a href="#tips" class="mdui-ripple" id="autotips">智能操作</a>

                <a href="#message" class="mdui-ripple" id="messagetab">消息提示</a>

            </div>

        </div>

        <div id="plant" class="mdui-p-a-2">

            <div class="mdui-panel-item mdui-panel-item-open">

                <div class="mdui-panel-item-header"><h3>主机状态</h3></div>

                <div class="mdui-panel-item-body">

                    <p class="mdui-panel-primary-subtitle" id="isonline">未知</p>

                    <div id=situation></div>

                    <div class="mdui-panel-item-actions">

                        <button class="mdui-btn mdui-ripple mdui-color-theme-accent"

                            Onclick="checkonline()">检测是否在线</button>

                    </div>

                </div>

            </div>

            <div class="mdui-panel-item mdui-panel-item-open">

                <div class="mdui-panel-item-header"><h3>花盆选择</h3></div>

                <div class="mdui-panel-item-body">

                    <div id="choosepot"></div>

                    <div id="panel"></div>

                    <div class="mdui-panel-item-actions">

                        <button id="refreshbutton" class="mdui-btn mdui-ripple mdui-color-theme-accent"

                            onclick="panelrefresh();situationrefresh();choosepotrefresh()">加载花盆列表</button>

                    </div>

                </div>

            </div>

            <div class="mdui-panel-item mdui-panel-item-open">

                <div class="mdui-panel-item-header"><h3>自动浇水设置</h3></div>

                <div class="mdui-panel-item-body">

                    <p>设置自动浇水的阈值为（设置为-1即关闭）</p>

                    <label class="mdui-slider mdui-slider-discrete">

                        <input type="range" step="1" min="-1" max="200" id="setwaterthresholdbox"

                            class="mdui-textfield-input">

                        <div class="mdui-slider-track" style="width: 0%;"></div>

                        <div class="mdui-slider-fill" style="width: 100%;"></div>

                        <div class="mdui-slider-thumb" style="left: 100%;"><span>100</span></div>

                    </label>

                    <div class="mdui-panel-item-actions">

                        <button class="mdui-btn mdui-ripple mdui-color-theme-accent"

                            onclick="setthreshold()">设置</button>

                    </div>

                </div>

            </div>
            <!--
            <div class="mdui-panel-item mdui-panel-item-open">

                <div class="mdui-panel-item-header"><h3>施肥提醒设置</h3></div>

                <div class="mdui-panel-item-body">
                <p>每几秒(86400秒为一日)提醒一次施肥</p>

                    <input id="fertilizebox" class="mdui-textfield-input" placeholder="请输入">

                    <div class="mdui-panel-item-actions">

                        <button class="mdui-btn mdui-ripple mdui-color-theme-accent"

                            onclick="setfertilize()">设置</button>

                    </div>

                </div>

            </div>

            <div class="mdui-panel-item mdui-panel-item-open">

                <div class="mdui-panel-item-header"><h3>音乐播放设置</h3></div>

                <div class="mdui-panel-item-body">
                                    <p>每几秒(86400秒为一日)播放一次音乐</p>
                    <input id="musicbox" class="mdui-textfield-input" placeholder="请输入">

                    <div class="mdui-panel-item-actions">

                        <button class="mdui-btn mdui-ripple mdui-color-theme-accent" onclick="setmusic()">设置</button>

                    </div>

                </div>
            </div>
                                    -->
        </div>

        <div id="antithief" class="mdui-p-a-2">

            <div class="mdui-panel-item mdui-panel-item-open">

                <div class="mdui-panel-item-header">防盗设置</div>

                <div class="mdui-panel-item-body">

                    <div class="mdui-row-md-2">

                        <div class="mdui-col">

                            <label class="mdui-switch">

                                <input type="checkbox" id="antithief_enabled" />

                                <i class="mdui-switch-icon"></i>

                                自动监测前方是否有人经过并记录

                            </label>

                        </div>

                        <div class="mdui-col">

                            <label class="mdui-switch">

                                <input type="checkbox" id="antithief_autoalert" />

                                <i class="mdui-switch-icon"></i>

                                当有人经过时蜂鸣器报警

                            </label>

                        </div>

                        <div class="mdui-col">

                            <label class="mdui-switch">

                                <input type="checkbox" id="antithief_repeatalert" />

                                <i class="mdui-switch-icon"></i>

                                三分钟内有人再次经过不报警

                            </label>

                        </div>

                        <div class="mdui-col">

                            <label class="mdui-switch">

                                <input type="checkbox" id="antithief_quietmode" />

                                <i class="mdui-switch-icon"></i>

                                8：00-23：00自动免打扰

                            </label>

                        </div>

                    </div>

                    <div class="mdui-panel-item-actions">

                        <button class="mdui-btn mdui-ripple mdui-color-theme-accent"

                            Onclick="jsonsave()">保存</button>

                    </div>

                </div>

            </div>

        </div>

        <div id="tips" class="mdui-p-a-2">

            <div class="mdui-panel-item mdui-panel-item-open">

                <div class="mdui-panel-item-header">门窗</div>

                <div class="mdui-panel-item-body">

                    <div class="mdui-row-md-3">

                        <div class="mdui-col">

                            <label class="mdui-switch">

                                <input type="checkbox" id="windows_raintips" />

                                <i class="mdui-switch-icon"></i>

                                下雨时智能关窗

                            </label>

                        </div>

                        <div class="mdui-col">

                            <label class="mdui-switch">

                                <input type="checkbox" id="windows_airtips" />

                                <i class="mdui-switch-icon"></i>

                                每天8：00自动通风

                            </label>

                            <br>


                        </div>

                        <div class="mdui-col">

                            <label class="mdui-switch">

                                <input type="checkbox" id="windows_quietmode" />

                                <i class="mdui-switch-icon"></i>

                                8：00-23：00自动免打扰

                            </label>

                        </div>

                    </div>

                    <div class="mdui-panel-item-actions">

                        <button class="mdui-btn mdui-ripple mdui-color-theme-accent" Onclick="jsonsave()">保存</button>

                        <button class="mdui-btn mdui-ripple mdui-color-theme-accent"

                            Onclick="checkonline()">强行关闭今日提示</button>

                    </div>

                </div>

            </div>

            <div class="mdui-panel-item mdui-panel-item-open">

                <div class="mdui-panel-item-header">晾衣</div>

                <div class="mdui-panel-item-body">

                    <div class="mdui-row-md-3">

                        <div class="mdui-col">

                            <label class="mdui-switch">

                                <input type="checkbox" id="cloth_raintips" />

                                <i class="mdui-switch-icon"></i>

                                下雨时提醒我收衣服

                            </label>

                        </div>

                    </div>

                    <div class="mdui-panel-item-actions">

                        <button class="mdui-btn mdui-ripple mdui-color-theme-accent" Onclick="jsonsave()">保存</button>

                    </div>

                </div>

            </div>
            
            <div class="mdui-panel-item mdui-panel-item-open">

                <div class="mdui-panel-item-header">灯光</div>

                <div class="mdui-panel-item-body">

                    <div class="mdui-row-md-3">

                        <div class="mdui-col">

                            <label class="mdui-switch">

                                <input type="checkbox" id="light_auto" />

                                <i class="mdui-switch-icon"></i>

                                根据日出日落时间智能开关灯

                            </label>
                            <?php
                                echo "<br>";
                                echo "日出时间".date_sunrise(time(),SUNFUNCS_RET_STRING,24,110,90,8)  ;
                                echo "  日落时间".date_sunset(time(),SUNFUNCS_RET_STRING,24,110,90,8);
                            ?>
                            <label class="mdui-switch">

                                <input type="checkbox" id="light_time" />

                                <i class="mdui-switch-icon"></i>

                                每晚19：00-6：00自动亮灯

                            </label>
                            
                        </div>

                    </div>

                    <div class="mdui-panel-item-actions">

                        <button class="mdui-btn mdui-ripple mdui-color-theme-accent" Onclick="jsonsave()">保存</button>

                    </div>

                </div>

            </div>

        </div>

        <div id="message" class="mdui-p-a-2">

            <div class="mdui-panel-item mdui-panel-item-open">

                <div class="mdui-panel-item-header">消息记录</div>

                <div class="mdui-panel-item-body">

                    <div id="getmessage">

                    </div>

                    <div class="mdui-panel-item-actions">

                        <button class="mdui-btn mdui-ripple mdui-color-theme-accent"

                            Onclick="messageload()">刷新</button>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>



</html>

<script>

    panelrefresh();situationrefresh();choosepotrefresh()

    window.$$ = mdui.$;
    

    $$(document).on('click', '#autotips',

        e => {

            datagetter();


        })

    $$(document).on('click', '#antithieftab',

        e => {

            datagetter();

        })

    $$(document).on('click', '#messagetab',

        e => {

            messageload();

        })   

    setInterval("situationrefresh()", 1000);

    setInterval("panelrefresh()", 60000);

    setInterval("panelrefresh()", 60000);

    /*function refresh(towhat){

        backtowhat=towhat

        var xmlhttp;

        if (window.XMLHttpRequest)

        {

            xmlhttp=new XMLHttpRequest();

        }

        else

        {

            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

        }

        xmlhttp.onreadystatechange=function()

        {

            if (xmlhttp.readyState==4 && xmlhttp.status==200)

            {

                document.getElementById(backtowhat).innerHTML=xmlhttp.responseText;

            }

        }

            xmlhttp.open("GET","refresh.php?model="+towhat,true);

            xmlhttp.send();

    }*/

    function ajaxsender(data, object) {

        if (typeof object !== "undefined") {

            axios.get(data)

                .then(

                    (data) => { mdui.$(object).html(data.data) }

                )

                .catch(function (error) {

                    console.log(error);

                });

        } else {

            axios.get(data)

                .then(

                    alert("成功！")

                )

                .catch(function (error) {

                    console.log(error);

                });

        }

    }

    function datagetter() {

        axios.get("other.php?mode=get")

            .then(function (response) {

                getjson = JSON.parse(response.data)
                    document.getElementById("windows_raintips").checked = getjson.settings.windows.raintips
                    document.getElementById("windows_airtips").checked = getjson.settings.windows.airtips
                    document.getElementById("windows_quietmode").checked = getjson.settings.windows.quietmode
                    document.getElementById("cloth_raintips").checked = getjson.settings.windows.raintips
                    
                    document.getElementById("light_auto").checked = getjson.settings.lights.auto
                    document.getElementById("light_time").checked = getjson.settings.lights.time
                    
                    document.getElementById("antithief_enabled").checked = getjson.settings.warning.enabled
                    document.getElementById("antithief_repeatalert").checked = getjson.settings.warning.repeatalert
                    document.getElementById("antithief_autoalert").checked = getjson.settings.warning.autoalert
                    document.getElementById("antithief_quietmode").checked = getjson.settings.warning.quietmode
            }

            )

            .catch(function (error) {

                console.log(error);

            });

    }

    function messageload() {

        axios.get("other.php?module=antithief&mode=get")

            .then(function (response) {

                getjson = JSON.parse(response.data)

                messageclear();
                document.getElementById("getmessage").innerHTML = "<ul class='mdui-list'>";
                document.getElementById("windows_raintips").checked = getjson.data.forEach(writemessage)

            })

    }

    function writemessage(message, index) {
        document.getElementById("getmessage").innerHTML = document.getElementById("getmessage").innerHTML + "<li class='mdui-divider'></li>" +message.time +" "+ message.message
    //
    }

    function messageclear(){

        document.getElementById("getmessage").innerHTML =""

    }

    function jsonsave() {

        var snddata = JSON.stringify(
                            {
                  "settings": {
                    "lights": {
                      "auto": document.getElementById("light_auto").checked,
                      "time": document.getElementById("light_time").checked
                    },
                    "warning": {
                      "enabled": document.getElementById("antithief_enabled").checked,
                      "autoalert": document.getElementById("antithief_autoalert").checked,
                      "quietmode": document.getElementById("antithief_quietmode").checked,
                      "repeatalert": document.getElementById("antithief_repeatalert").checked
                    },
                    "cloth": {
                      "raintips": document.getElementById("cloth_raintips").checked
                    },
                    "windows": {
                      "raintips": document.getElementById("windows_raintips").checked,
                      "airtips": document.getElementById("windows_airtips").checked,
                      "quietmode": document.getElementById("windows_quietmode").checked,
                      "tipmode": "positive"
                    }
                  }
                }

        )

        var data = "other.php?mode=set&rcvdata=" + snddata

        ajaxsender(data)

    }



    function panelrefresh() {

        var data = "refresh.php?model=panel"

        ajaxsender(data, document.getElementById("panel"))

    }



    function choosepotrefresh() {

        var data = "refresh.php?model=choosepot"

        ajaxsender(data, document.getElementById("choosepot"))

    }



    function situationrefresh() {

        var data = "refresh.php?model=situation"

        ajaxsender(data, document.getElementById("situation"))

    }

    function sendcommand(pot, command) {

        var pot = document.getElementById("idselector").value

        var data = "command.php?pot=" + pot + "&mode=send&command=" + command

        ajaxsender(data)

    }

    function setthreshold() {

        //var pot = document.getElementById("musicbox").value

        var pot = document.getElementById("idselector").value

        var data = "command.php?pot=" + pot + "&mode=setthreshold&value=" + document.getElementById("setwaterthresholdbox").value

        ajaxsender(data)

    }

    function setfertilize() {

        var pot=1

        var pot = document.getElementById("idselector").value

        var data = "command.php?fertilizedelay=" + document.getElementById("fertilizebox").value + "&mode=setfertilize&pot=" + pot

        ajaxsender(data)

    }

    function setmusic() {

        var pot = document.getElementById("idselector").value

        var data = "command.php?musicdelay=" + document.getElementById("musicbox").value + "&mode=setmusic&pot=" + pot

        ajaxsender(data)

    }

    function checkonline() {

        sendcommand(1, 'testcommand')

        setTimeout(function () {

            var xmlhttp;

            if (window.XMLHttpRequest) {

                xmlhttp = new XMLHttpRequest();

            }

            else {

                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

            }

            xmlhttp.onreadystatechange = function () {

                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                    if (xmlhttp.responseText == "none") {

                        document.getElementById("isonline").innerHTML = "是否在线：在线"

                    }

                    else { document.getElementById("isonline").innerHTML = "是否在线：不在线" }

                }

            }

            xmlhttp.open("GET", "command.php?mode=get&pot=1", true);

            xmlhttp.send();

        }, 2000)

    }

</script>