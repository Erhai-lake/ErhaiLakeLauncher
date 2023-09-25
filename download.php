<?php
error_reporting(0);
require "Lib/Auxiliary.php";

$Name = "ELL";

// 读取配置文件
$Config = json_decode(file_get_contents($Name . "/config.json"), true);
// 主题色
$ThemeColor = $Config["ThemeColor"];
?>
<!DOCTYPE html>
<html lang="zh_CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>洱海启动器</title>
    <link rel="stylesheet" href="css/Main.css">
    <link rel="stylesheet" href="css/Download.css">
    <link rel="stylesheet" href="css/icon.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <style>
        .Main .Left .Item:hover {
            background: <?php echo $ThemeColor . '2E'; ?>;
        }

        .Main .Left .Item:active {
            background: <?php echo $ThemeColor . '6B'; ?>;
        }

        .Main .Left .Selected {
            border-left: <?php echo '7px solid ' . $ThemeColor; ?>;
            color: <?php echo $ThemeColor; ?>;
        }
    </style>
</head>

<body>
    <div class="Main">
        <div class="Left">
            <p class="Title">Minecraft</p>
            <div class="Item Selected" onclick="Selected(event, 'AutomaticInstallation.php')">
                <div class="texe">
                    <p><i class="icon icon-daima"></i>自动安装</p>
                </div>
                <i class="function icon icon-shuaxin" onclick="Refresh('AutomaticInstallation.php?type=Refresh'); event.stopPropagation();"></i>
            </div>
            <div class="Item" onclick="Selected(event)">
                <div class="texe">
                    <p><i class="icon icon-banshou"></i>手动安装</p>
                </div>
            </div>
            <p class="Title">资源</p>
            <div class="Item" onclick="Selected(event, 'Mods.php?index=0')">
                <div class="texe">
                    <p><i class="icon icon-pintu"></i>Mod</p>
                </div>
            </div>
            <div class="Item" onclick="Selected(event)">
                <div class="texe">
                    <p><i class="icon icon-xiangzi"></i>整合包</p>
                </div>
            </div>
        </div>
        <div class="Right">
            <div class="MainIframe">
                <iframe id="MainIframe" src="AutomaticInstallation.php"></iframe>
            </div>
        </div>
    </div>
    <script src="js/Download.js"></script>
    <script src="js/Main.js"></script>
</body>

</html>