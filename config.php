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
    <link rel="stylesheet" href="css/Config.css">
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
            <div class="Item Selected" onclick="Selected(event, 'game')">
                <div class="texe">
                    <p><i class="icon icon-huojian"></i>游戏</p>
                </div>
                <i class="function icon icon-shuaxin" onclick="Refresh('game.php?type=Refresh'); event.stopPropagation();"></i>
            </div>
            <div class="Item" onclick="Selected(event, 'personalization')">
                <div class="texe">
                    <p><i class="icon icon-pifugexinghuazhuti"></i>个性化</p>
                </div>
                <i class="function icon icon-shuaxin" onclick="Refresh('personalization.php?type=Refresh'); event.stopPropagation();"></i>
            </div>
            <div class="Item" onclick="Selected(event)">
                <div class="texe">
                    <p><i class="icon icon-daima"></i>启动器</p>
                </div>
                <i class="function icon icon-shuaxin" onclick="Refresh('c.php?type=Refresh'); event.stopPropagation();"></i>
            </div>
        </div>
        <div class="Right">
            <div class="MainIframe">
                <iframe id="MainIframe" src="a.php"></iframe>
            </div>
        </div>
    </div>
    <script src="js/Config.js"></script>
    <script src="js/Main.js"></script>
</body>

</html>