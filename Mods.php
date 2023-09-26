<?php
error_reporting(0);
require "Lib/Resources.php";

$Name = "ELL";

// 读取配置文件
$Config = json_decode(file_get_contents($Name . "/config.json"), true);
// 主题色
$ThemeColor = $Config["ThemeColor"];

if (isset($_GET['SourceSelect'])) {
    if ($_GET['SourceSelect'] == 'Modrinth') {
        $select1 = 'selected';
    } else {
        $Html = CurseForge();
        $select2 = 'selected';
    }
} else {
    $Html = CurseForge();
    $select2 = 'selected';
}


function CurseForge()
{
    // 公共的KEY
    $KEY = '$2a$10$ndSPnOpYqH3DRmLTWJTf5Ofm7lz9uYoTGvhSj0OjJWJ8WdO4ZTsr.';
    if (isset($_GET['searchFilter'])) {
        $searchFilter = $_GET['searchFilter'];
    } else {
        $searchFilter = '';
    }
    $CurseforgeModsSearch = json_decode(CurseforgeModsSearch($KEY, 0, '', $searchFilter, '', $_GET['index'], 40), true);
    $Html = '';
    foreach ($CurseforgeModsSearch['data'] as $item1) {
        $Html .= '<div class="ListItem" onclick="ModID(\'' . $item1['id'] . '\')">';
        $Html .= '<div class="Left" style="background: url(\'' . $item1['logo']['url'] . '\') no-repeat 100% 100%/100% 100%;"></div>';
        $Html .= '<div class="Right"><div class="RightLeft">';
        $Html .= '<p class="ItemName">' . $item1['name'] . '</p>';
        $Html .= '<div class="ItemSummary">';
        foreach ($item1['categories'] as $item2) {
            $Html .= '<p class="Categories">' . $item2['name'] . '</p>';
        }
        $Html .= '<p class="Summary" title="' . $item1['summary'] . '">' . $item1['summary'] . '</p>
    </div><div class="ItemElse">';
        $Html .= '<p><i class="icon icon-xiazaidaoru"></i>' . downloadCount($item1['downloadCount']) . '</p>';
        $Html .= '<p><i class="icon icon-anquan"></i>' . date('Y-m-d H:i:s', strtotime($item1['dateModified'])) . '</p>';
        $Html .= '<p><i class="icon icon-huojian"></i>curseforge</p>';
        $Html .= '</div></div><div class="RightRight">';
        $Html .= '<i class="icon icon-tishi" title="curseforge" onclick="window.open(\'' . $item1['links']['websiteUrl'] . '\'); event.stopPropagation();"></i>';
        $Html .= '</div></div></div>';
    }
    return $Html;
}

// 下载量单位换算
function downloadCount($number)
{
    if ($number < 10000) {
        return $number;
    } elseif ($number < 100000000) {
        return round($number / 10000, 2) . ' 万';
    } else {
        return round($number / 100000000, 2) . ' 亿';
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
    <link rel="stylesheet" href="css/Mods.css">
    <link rel="stylesheet" href="css/icon.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <style>
        .ListContainer:hover {
            box-shadow: <?php echo $ThemeColor . ' 0px 0px 0px 3px'; ?>;
        }

        .ListContainer:hover .ListTitle {
            color: <?php echo $ThemeColor; ?>;
        }

        .ListContainer .ListContent .Item1 .NameInput input,
        .ListContainer .ListContent .Item2 .VersionInput select,
        .ListContainer .ListContent .Item1 .SourceSelect select,
        .ListContainer .ListContent .Item2 .TypeSelect select {
            border: <?php echo '2px solid ' . $ThemeColor; ?>;
        }

        .ListContainer .ListContent .Item1 .NameInput input:hover,
        .ListContainer .ListContent .Item2 .VersionInput select:hover,
        .ListContainer .ListContent .Item1 .SourceSelect select:hover,
        .ListContainer .ListContent .Item2 .TypeSelect select:hover {
            background: <?php echo $ThemeColor . 'a4'; ?>;
        }

        .ListContainer .ListContent .ButtonContainer button {
            border: <?php echo '2px solid ' . $ThemeColor; ?>;
        }

        .ListContainer .ListContent .ButtonContainer button:hover {
            background: <?php echo $ThemeColor . '6b'; ?>;
        }

        .ListContainer .ListContent .ListItem {
            border: <?php echo '3px solid ' . $ThemeColor; ?>;
        }

        .ListContainer .ListContent .ListItem:hover {
            background: <?php echo $ThemeColor . '72'; ?>;
        }

        .ListContainer .ListContent .ListItem .Left {
            border: <?php echo '5px solid ' . $ThemeColor; ?>;
        }
    </style>
</head>

<body>
    <div class="ListContainer">
        <div class="ListTitle">搜索Mod</div>
        <div class="ListContent">
            <div class="Item1">
                <label class="NameInput">
                    <span>名称</span>
                    <input type="text" placeholder="请输入关键词" id="NameInput" value="<?php echo $_GET['searchFilter']; ?>">
                </label>
                <label class="SourceSelect">
                    <span>来源</span>
                    <select id="SourceSelect" value="<?php echo $_GET['SourceSelect']; ?>">
                        <option value="CurseForge" <?php echo $select2; ?>>CurseForge</option>
                        <option value="Modrinth" <?php echo $select1; ?>>Modrinth</option>
                    </select>
                </label>
            </div>
            <div class="Item2">
                <label class="VersionInput">
                    <span>版本</span>
                    <select id="VersionInput">
                        <option value="来源1">版本</option>
                        <option value="来源2">来源2</option>
                        <option value="来源3">来源3</option>
                    </select>
                </label>
                <label class="TypeSelect">
                    <span>类型</span>
                    <select id="TypeSelect">
                        <option value="来源1">全部</option>
                        <option value="来源2">来源2</option>
                        <option value="来源3">来源3</option>
                    </select>
                </label>
            </div>
            <div class="ButtonContainer">
                <button class="SearchButton">搜索</button>
                <button class="ResetButton">重置条件</button>
            </div>
        </div>
    </div>
    <div class="ListContainer">
        <div class="ListContent">
            <?php echo $Html; ?>
            <div class="Index">
                <div class="Left">&lt;</div>
                <p class="Num"><?php echo $_GET['index']; ?></p>
                <div class="Right">&gt;</div>
            </div>
        </div>
    </div>
    <script src="js/Mods.js"></script>
    <script src="js/Main.js"></script>
</body>

</html>