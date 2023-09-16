<?php
error_reporting(0);
require "Lib/Auxiliary.php";

$Name = "ELL";

// 读取配置文件
$Config = json_decode(file_get_contents($Name . "/config.json"), true);
// 主题色
$ThemeColor = $Config["ThemeColor"];
// 一言
if ($Config["Hitokoto"]) {
    $Hitokoto = "<div class='Sentence' onclick='SentenceOpen()'><p class='Title'>一言</p><p id='SentenceTitle'>:D 获取中...</p><p id='SentenceSource'>快了快了...</p></div>";
}
// 自定义
if ($Config["Custom"]) {
    $Custom = "<iframe id='iframe' src='" . $Config["CustomURL"] . "'></iframe>";
}
?>
<!DOCTYPE html>
<html lang="zh_CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>洱海启动器</title>
    <link rel="stylesheet" href="css/Main.css">
    <link rel="stylesheet" href="css/Start.css">
    <link rel="stylesheet" href="css/icon.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <style>
        .Main .Left .LoginMethod div {
            color: <?php echo $ThemeColor; ?>;
        }

        .Main .Left .LoginMethod div:hover {
            background: <?php echo $ThemeColor . '2E'; ?>;
        }

        .Main .Left .LoginMethod div:active {
            background: <?php echo $ThemeColor . '6B'; ?>;
        }

        .Main .Left .LoginMethod .Selected {
            background: <?php echo $ThemeColor; ?>;
        }

        .Main .Left .LoginMethod .Selected:hover {
            background: <?php echo $ThemeColor; ?>;
        }

        .Main .Left .StartBut {
            border: <?php echo '2px solid ' . $ThemeColor; ?>;

        }

        .Main .Left .StartBut:hover {
            background: <?php echo $ThemeColor . '56'; ?>;
        }

        .Main .Left .StartBut p {
            color: <?php echo $ThemeColor; ?>;
        }

        .Main .Left .MainBut .But div:hover {
            background: <?php echo $ThemeColor . '56'; ?>;
            border: <?php echo '2px solid ' . $ThemeColor; ?>;
        }

        .Main .Right .Sentence:hover {
            box-shadow: <?php echo $ThemeColor . ' 0px 0px 0px 3px'; ?>;
        }

        .Main .Right .Sentence:hover .Title {
            color: <?php echo $ThemeColor; ?>;
        }

        .Main .Right iframe:hover {
            box-shadow: <?php echo $ThemeColor . ' 0px 0px 0px 3px'; ?>;
        }
    </style>
</head>

<body>
    <div class="Main">
        <div class="Left">
            <div class="LoginMethod">
                <div class="Selected" onclick="Selected(event, 'start')">
                    <p><i class="icon icon-anquan"></i>微软</p>
                </div>
                <div onclick="Selected(event, 'starst')">
                    <p><i class="icon icon-lixian"></i>离线</p>
                </div>
            </div>
            <div class="Skin2D" style="background: url('img/steve2.png') no-repeat 100% 100%/100% 100%;"></div>
            <div class="Skin3D">
                <iframe id="Skin3DIframe" src="/Skin3D.php"></iframe>
            </div>
            <p class="Name">Steve</p>
            <div class="MainBut">
                <div class="StartBut">
                    <p>启动游戏</p>
                    <span>test</span>
                </div>
                <div class="But">
                    <div>
                        <p>版本选择</p>
                    </div>
                    <div>
                        <p>版本设置</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="Right">
            <?php echo $Hitokoto; ?>
            <?php echo $Custom; ?>
        </div>
    </div>
    <script src="js/Start.js"></script>
    <script src="js/Main.js"></script>
</body>

</html>