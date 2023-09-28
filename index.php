<?php
error_reporting(0);
require "Lib/Auxiliary.php";

$Name = "ELL";
$addNotification = '';

// 初始化
if (Initialize($Name) == 1) {
    $addNotification .= "addNotification('Warn', '初始化错误!');";
}

// 配置文件
$filename = $Name . "/config.json";
if (!file_exists($filename)) {
    $configData = array(
        'Name' => $Name,
        'Version' => '1.0.0',
        'Theme' => 'Erhai_lake',
        'ThemeColor' => '#80CEFF',
        'grayscale' => false,
        'Hitokoto' => true,
        'Custom' => true,
        'CustomURL' => 'CustomTest.php',
        'Source' => 3
    );
    $jsonData = json_encode($configData);
    if (!file_put_contents($filename, $jsonData)) {
        $addNotification .= "addNotification('Warn', '配置文件写入失败!');";
    }
}

// 读取配置文件
$Config = json_decode(file_get_contents($Name . "/config.json"), true);
// 启动器版本
$ConfigVersion = $Config["Version"];
// 主题色
$ConfigThemeColor = $Config["ThemeColor"];
// 灰白
if ($Config["grayscale"]) {
    $ConfigGrayscale = '* {filter: grayscale(95%);-webkit-filter: grayscale(95%);-moz-filter: grayscale(95%);-ms-filter: grayscale(95%);-o-filter: grayscale(95%);}';
}
?>
<!DOCTYPE html>
<html lang="zh_CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>洱海启动器</title>
    <link rel="stylesheet" href="css/Main.css">
    <link rel="stylesheet" href="css/Index.css">
    <link rel="stylesheet" href="css/icon.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <style>
        <?php echo $ConfigGrayscale; ?>.Main {
            background: <?php echo $ConfigThemeColor . '30'; ?>;
        }

        .Main .Submenu {
            background: <?php echo $ConfigThemeColor; ?>;
        }

        .Main .Submenu .Selected {
            color: <?php echo $ConfigThemeColor; ?>;
        }
    </style>
</head>

<body>
    <div class="Notification" id="notificationContainer"></div>
    <div class="Main">
        <div class="Submenu">
            <p class="Title">ELL</p>
            <div class="Selected" onclick="Selected(event, 'start')">
                <p><i class="icon icon-dianyuan"></i>启动</p>
            </div>
            <div onclick="Selected(event, 'download')">
                <p><i class="icon icon-xiazaidaoru"></i>下载</p>
            </div>
            <div onclick="Selected(event, 'config')">
                <p><i class="icon icon-shezhi"></i>设置</p>
            </div>
            <div onclick="Selected(event, 'more')">
                <p><i class="icon icon-ziyuanxhdpi"></i>更多</p>
            </div>
        </div>
        <div class="MainIframe">
            <iframe id="MainIframe" src="start.php"></iframe>
        </div>
    </div>
    <script src="js/Index.js"></script>
    <script src="js/Main.js"></script>
    <script>
        <?php echo $addNotification; ?>
    </script>
</body>

</html>