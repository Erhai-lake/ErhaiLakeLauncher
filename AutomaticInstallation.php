<?php
// error_reporting(0);
require "Lib/Auxiliary.php";
require "Lib/Resources.php";

$Name = "ELL";

// 读取配置文件
$Config = json_decode(file_get_contents($Name . "/config.json"), true);
// 主题色
$ThemeColor = $Config["ThemeColor"];

$fileName = $Name . '/versions.json';

// 刷新
if (isset($_GET['type'])) {
    if ($_GET['type'] == 'Refresh') {
        unlink($fileName);
    }
}

// 版本缓存是否存在
if (file_exists($fileName)) {
    // 初始化版本文件
    $VersionFile = file_get_contents($fileName);
} else {
    // 初始化源
    $Source = InitializeSource($Config["Source"]);
    // 初始化版本文件
    $VersionFile = InitializeVersionFile($Source);
    file_put_contents($fileName, $VersionFile);
}

// 获取所有版本信息
$AllVersions = AllVersions($VersionFile);

// 初始化变量
// 计次
$i = 0;
// 最新正式版
$LatestOfficiaVersionHtml = "";
// 最新快照
$LatestBetaVersionHtml = "";
// 正式版
$OfficialVersionNum = 0;
$OfficialVersionHtml = "";
// 快照版
$BetaVersionNum = 0;
$BetaVersionHtml = "";
// 远古版
$OldVersionNum = 0;
$OldVersionHtml = "";

$dataA = array();
// 循环取数组
if (is_array($AllVersions)) {
    foreach ($AllVersions as $item) {
        $data = array('1' => 'Erhai_lake');
        $dataA[] = $data;


        $OriginalTime = $AllVersions[$i]["time"];
        $DateTime = new DateTime($OriginalTime);
        $Time = $DateTime->format('Y-m-d H:i:s');
        $Html1 = '<div class="ListItem" onclick="Download(\'' . $AllVersions[$i]["id"] . '\')"><div class="Left" style="background: url(\'';
        $Html2 = '\') no-repeat 100% 100%/100% 100%;"></div><div class="Right"><div class="RightLeft"><p class="ItemTitle">' . $AllVersions[$i]["id"] . '</p><p class="ItemTime">' . $Time . '</p></div><div class="RightRight"><i class="icon icon-tishi" title="更新日志" onclick="Download(\'测试:' . $AllVersions[$i]["id"] . '\'); event.stopPropagation();"></i></div></div></div>';
        // 获取最新正式版和发布时间
        if ($AllVersions[$i]["id"] == LatestOfficiaVersion($VersionFile)) {
            $LatestOfficiaVersionHtml = $Html1 . 'img/grass.png' . $Html2;
        }
        // 获取最新快照和发布时间
        if ($AllVersions[$i]["id"] == LatestBetaVersion($VersionFile)) {
            $LatestBetaVersionHtml = $Html1 . 'img/tnt.png' . $Html2;
        }
        // 获取所有正式版和时间
        if ($AllVersions[$i]["type"] == "release") {
            $OfficialVersionNum++;
            $OfficialVersionHtml .= $Html1 . 'img/grass.png' . $Html2;
        }
        // 获取所有快照和时间
        if ($AllVersions[$i]["type"] == "snapshot") {
            $BetaVersionNum++;
            $BetaVersionHtml .= $Html1 . 'img/tnt.png' . $Html2;
        }
        // 获取所有远古和时间
        if ($AllVersions[$i]["type"] == "old_alpha" || $AllVersions[$i]["type"] == "old_beta") {
            $OldVersionNum++;
            $OldVersionHtml .= $Html1 . 'img/deepslate.png' . $Html2;
        }
        $i++;
    }
}
file_put_contents('VersionsWiki.json', $dataA);
?>
<!DOCTYPE html>
<html lang="zh_CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>洱海启动器</title>
    <link rel="stylesheet" href="css/AutomaticInstallation.css">
    <link rel="stylesheet" href="css/icon.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <style>
        .ListContainer:hover {
            box-shadow: <?php echo $ThemeColor . ' 0px 0px 0px 3px'; ?>;
        }

        .ListContainer:hover .ListTitle {
            color: <?php echo $ThemeColor; ?>;
        }

        .ListContainer .ListContent .ListItem {
            border: <?php echo '3px solid ' . $ThemeColor; ?>;
        }

        .ListContainer .ListContent .ListItem:hover {
            background: <?php echo $ThemeColor . '72'; ?>;
        }
    </style>
</head>

<body>
    <div class="ListContainer">
        <div class="ListTitle" onclick="toggleList('List0')">测试</div>
        <div class="ListContent" id="List0">
            <div class="ListItem" onclick="Download('版本号')">
                <div class="Left" style="background: url('img/grass.png') no-repeat 100% 100%/100% 100%;"></div>
                <div class="Right">
                    <div class="RightLeft">
                        <p class="ItemTitle">版本号</p>
                        <p class="ItemTime">时间</p>
                    </div>
                    <div class="RightRight">
                        <i class="icon icon-tishi" title="更新日志" onclick="alert('2333'); event.stopPropagation();"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ListContainer">
        <div class="ListTitle" onclick="toggleList('List1')">最新版本</div>
        <div class="ListContent" id="List1">
            <?php echo $LatestOfficiaVersionHtml; ?>
            <?php echo $LatestBetaVersionHtml; ?>
        </div>
    </div>
    <div class="ListContainer">
        <div class="ListTitle" onclick="toggleList('List2')">正式版 (<?php echo $OfficialVersionNum; ?>)</div>
        <div class="ListContent" id="List2"><?php echo $OfficialVersionHtml; ?></div>
    </div>
    <div class="ListContainer">
        <div class="ListTitle" onclick="toggleList('List3')">快照 (<?php echo $BetaVersionNum; ?>)</div>
        <div class="ListContent" id="List3"><?php echo $BetaVersionHtml; ?></div>
    </div>
    <div class="ListContainer">
        <div class="ListTitle" onclick="toggleList('List4')">远古 (<?php echo $OldVersionNum; ?>)</div>
        <div class="ListContent" id="List4"><?php echo $OldVersionHtml; ?></div>
    </div>
    <script src="js/AutomaticInstallation.js"></script>
    <script src="js/Main.js"></script>
</body>

</html>