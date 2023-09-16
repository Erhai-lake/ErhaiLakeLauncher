<?php
error_reporting(0);
require "Lib/Auxiliary.php";
require "Lib/Resources.php";

$Name = "ELL";
$addNotification = '';

// 读取配置文件
$Config = json_decode(file_get_contents($Name . "/config.json"), true);
// 主题色
$ThemeColor = $Config["ThemeColor"];

$VersionsFileJson = $Name . '/versions.json';
$VersionsFileText = $Name . '/versions.txt';

// 刷新
if (isset($_GET['type'])) {
    if ($_GET['type'] == 'Refresh') {
        if (file_exists($VersionsFileJson)) {
            unlink($VersionsFileJson);
        }
        if (file_exists($VersionsFileText)) {
            unlink($VersionsFileText);
        }
    }
}

// 初始化变量
$HtmlMain = '';
// 最新正式版
$LatestOfficiaVersionHtml = '';
// 最新快照
$LatestBetaVersionHtml = '';
// 正式版
$OfficialVersionNum = 0;
$OfficialVersionHtml = '';
// 快照版
$BetaVersionNum = 0;
$BetaVersionHtml = '';
// 远古版
$OldVersionNum = 0;
$OldVersionHtml = '';

// 循环取数组
if (file_exists($VersionsFileText)) {
    $HtmlMain = file_get_contents($VersionsFileText);
} else {
    // 初始化源
    $Source = InitializeSource($Config["Source"]);
    if ($Source == 1) {
        $addNotification .= "window.parent.parent.addNotification('Warn', '无法读取下载源文件!');";
    } elseif ($Source == 2) {
        $addNotification .= "window.parent.parent.addNotification('Warn', '下载源文件解析失败!');";
    } elseif ($Source == 3) {
        $addNotification .= "window.parent.parent.addNotification('Warn', '源不存在!');";
    } else {
        // 初始化版本文件
        $VersionFile = InitializeVersionFile($Source);
        if ($VersionFile == 1) {
            $addNotification .= "window.parent.parent.addNotification('Warn', '无法读取版本文件!');";
        } else {
            file_put_contents($VersionsFileJson, $VersionFile);
            // 获取所有版本信息
            $AllVersions = AllVersions($VersionFile);
            if (!is_array($AllVersions)) {
                $addNotification .= "window.parent.parent.addNotification('Warn', '参数不是一个可迭代的对象!');";
            } else {
                foreach ($AllVersions as $item) {
                    $OriginalTime = $item["time"];
                    $DateTime = new DateTime($OriginalTime);
                    $Time = $DateTime->format('Y-m-d H:i:s');
                    // Wiki
                    $WikiLink = '';
                    $link1 = 'https://minecraft.fandom.com/zh/wiki/';
                    $link2 = $link1 . 'Java版';
                    // 正则表达式
                    $patterns = [
                        '/^\d+\.\d+(\.\d+)?$/' => $link2,
                        '/^\d{2}w\d{2}[a-e]?$/' => $link1,
                        '/^(\d+\.\d+(\.\d+)?)\-pre\d+$/' => $link2,
                        '/^(\d+\.\d+(\.\d+)?)\-rc\d+$/' => $link2,
                        '/^(\d+\.\d+(\.\d+)?\s+(Pre-Release|3D Shareware|RV-Pre|b|a|c|r\d+))(\s+\d+)?$/' => 'https://minecraft.fandom.com/wiki/Java_Edition_',
                        '23w13a_or_b'  => $link1 . '23w13a_or_b',
                        '22w13oneblockatatime'  => $link1 . '22w13oneblockatatime',
                        '20w14infinite'  => $link1 . '20w14%E2%88%9E',
                        '3D Shareware v1.34'  => $link1 . '3D_Shareware_v1.34',
                        '1.RV-Pre1' => $link2 . '1.RV-Pre1',
                        'inf-20100618' => $link2 . 'Infdev_20100618',
                        'c0.30_01c' => $link2 . 'Classic_0.30',
                        'c0.0.13a' => $link2 . 'Classic_0.0.14a_08',
                        'c0.0.13a_03' => $link2 . 'Classic_0.0.13a_03',
                        'c0.0.11a' => $link2 . 'Classic_0.0.11a',
                        '/^b(\d+\.\d+(?:\.\d+)*)$/' => $link2 . 'Beta_',
                        '/^a(\d+\.\d+(?:\.\d+)*)$/' => $link2 . 'Alpha_v',
                        '/^b(\d+\.\d+(?:\.\d+)*+_\d+)$/' => $link2 . 'Beta_',
                        '/^a(\d+\.\d+(?:\.\d+)*+_\d+)$/' => $link2 . 'Alpha_v',
                        '/^b(\d+\.\d+(?:\.\d+)*+)[a-z]?$/' => $link2 . 'Beta_',
                        '/^a(\d+\.\d+(?:\.\d+)*+)[a-z]?$/' => $link2 . 'Alpha_v',
                        '/^rd-(\d+)$/' => $link2 . 'Pre-classic_rd-',
                    ];
                    foreach ($patterns as $pattern => $link) {
                        if (@preg_match($pattern, $item["id"]) === false) {
                            $WikiLink = $link;
                        } elseif (preg_match($pattern, $item["id"], $matches)) {
                            if ($link == $link2 . 'Beta_' || $link == $link2 . 'Alpha_v') {
                                $WikiLink = $link . $matches[1];
                            } else {
                                $WikiLink = $link . $matches[0];
                            }
                            break;
                        }
                    }
                    $Html1 = '<div class="ListItem" onclick="Download(\'' . $item["id"] . '\')"><div class="Left" style="background: url(\'img/';
                    if ($WikiLink == "") {
                        $Html2 = '.png\') no-repeat 100% 100%/100% 100%;"></div><div class="Right"><div class="RightLeft"><p class="ItemTitle">' . $item["id"] . '</p><p class="ItemTime">' . $Time . '</p></div></div></div>';
                    } else {
                        $Html2 = '.png\') no-repeat 100% 100%/100% 100%;"></div><div class="Right"><div class="RightLeft"><p class="ItemTitle">' . $item["id"] . '</p><p class="ItemTime">' . $Time . '</p></div><div class="RightRight"><i class="icon icon-tishi" title="Wiki" onclick="window.open(\'' . $WikiLink . '\'); event.stopPropagation();"></i></div></div></div>';
                    }

                    // 获取最新正式版和发布时间
                    if ($item["id"] == LatestOfficiaVersion($VersionFile)) {
                        $LatestOfficiaVersionHtml = $Html1 . 'grass' . $Html2;
                    }
                    // 获取最新快照和发布时间
                    if ($item["id"] == LatestBetaVersion($VersionFile)) {
                        $LatestBetaVersionHtml = $Html1 . 'tnt' . $Html2;
                    }
                    // 获取所有正式版和时间
                    if ($item["type"] == "release") {
                        $OfficialVersionNum++;
                        $OfficialVersionHtml .= $Html1 . 'grass' . $Html2;
                    }
                    // 获取所有快照和时间
                    if ($item["type"] == "snapshot") {
                        $BetaVersionNum++;
                        $BetaVersionHtml .= $Html1 . 'tnt' . $Html2;
                    }
                    // 获取所有远古和时间
                    if ($item["type"] == "old_alpha" || $item["type"] == "old_beta") {
                        $OldVersionNum++;
                        $OldVersionHtml .= $Html1 . 'deepslate' . $Html2;
                    }
                }
                $HtmlMain .= '<div class="ListContainer"><div class="ListTitle" onclick="toggleList(\'List1\')">最新版本</div><div class="ListContent" id="List1">' . $LatestOfficiaVersionHtml . $LatestBetaVersionHtml . '</div></div>';
                $HtmlMain .= '<div class="ListContainer"><div class="ListTitle" onclick="toggleList(\'List2\')">正式版(' . $OfficialVersionNum . ')</div><div class="ListContent" id="List2">' . $OfficialVersionHtml . '</div></div>';
                $HtmlMain .= '<div class="ListContainer"><div class="ListTitle" onclick="toggleList(\'List3\')">快照(' . $BetaVersionNum . ')</div><div class="ListContent" id="List3">' . $BetaVersionHtml . '</div></div>';
                $HtmlMain .= '<div class="ListContainer"><div class="ListTitle" onclick="toggleList(\'List4\')">远古(' . $OldVersionNum . ')</div><div class="ListContent" id="List4">' . $OldVersionHtml . '</div></div>';
                file_put_contents($VersionsFileText, $HtmlMain);
                if (round(filesize($VersionsFileJson) / 1024, 2) <= 100 && round(filesize($VersionsFileText) / 1024, 2) <= 300) {
                    // 刷新失败
                    $addNotification .= "window.parent.parent.addNotification('Warn', '刷新失败!');";
                } else {
                    // 刷新成功
                    $addNotification .= "window.parent.parent.addNotification('Normal', '刷新成功!');";
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="zh_CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>洱海启动器</title>
    <link rel="stylesheet" href="css/Main.css">
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
    <!-- <div class="ListContainer">
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
    </div> -->
    <?php echo $HtmlMain; ?>
    <script src="js/AutomaticInstallation.js"></script>
    <script src="js/Main.js"></script>
    <script>
        <?php echo $addNotification; ?>
    </script>
</body>

</html>