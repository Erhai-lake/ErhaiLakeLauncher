<?php
error_reporting(0);
require "Lib/Resources.php";

$Name = "ELL";

// 读取配置文件
$Config = json_decode(file_get_contents($Name . "/config.json"), true);
// 主题色
$ThemeColor = $Config["ThemeColor"];

// 来源平台
if (isset($_GET['SourceSelect'])) {
    if ($_GET['SourceSelect'] == 'Modrinth') {
        $select1 = 'selected';
        $Html = '<div class="ListTitle">别催啦!!!在研究文档啊!!!</div>';
    } else {
        $select2 = 'selected';

        // 公共的Key
        $CurseForgeKey = '$2a$10$ndSPnOpYqH3DRmLTWJTf5Ofm7lz9uYoTGvhSj0OjJWJ8WdO4ZTsr.';

        // 分类检索
        if (isset($_GET['categoryId'])) {
            $categoryId = $_GET['categoryId'];
            switch ($_GET['categoryId']) {
                case '0':
                    $categoryIdHtml1 = 'selected';
                    break;
                case '406':
                    $categoryIdHtml2 = 'selected';
                    break;
                case '410':
                    $categoryIdHtml3 = 'selected';
                    break;
                case '408':
                    $categoryIdHtml4 = 'selected';
                    break;
                case '409':
                    $categoryIdHtml5 = 'selected';
                    break;
                case '412':
                    $categoryIdHtml6 = 'selected';
                    break;
                case '415':
                    $categoryIdHtml7 = 'selected';
                    break;
                case '4843':
                    $categoryIdHtml8 = 'selected';
                    break;
                case '417':
                    $categoryIdHtml9 = 'selected';
                    break;
                case '4558':
                    $categoryIdHtml10 = 'selected';
                    break;
                case '436':
                    $categoryIdHtml11 = 'selected';
                    break;
                case '416':
                    $categoryIdHtml12 = 'selected';
                    break;
                case '411':
                    $categoryIdHtml13 = 'selected';
                    break;
                case '414':
                    $categoryIdHtml14 = 'selected';
                    break;
                case '420':
                    $categoryIdHtml15 = 'selected';
                    break;
                case '4473':
                    $categoryIdHtml16 = 'selected';
                    break;
                case '4475':
                    $categoryIdHtml17 = 'selected';
                    break;
                case '424':
                    $categoryIdHtml18 = 'selected';
                    break;
                case '434':
                    $categoryIdHtml19 = 'selected';
                    break;
                case '133':
                    $categoryIdHtml20 = 'selected';
                    break;
                case '423':
                    $categoryIdHtml21 = 'selected';
                    break;
                case '435':
                    $categoryIdHtml22 = 'selected';
                    break;
                case '5191':
                    $categoryIdHtml23 = 'selected';
                    break;
                case '421':
                    $categoryIdHtml24 = 'selected';
                    break;
            }
        } else {
            $categoryId = '';
            $categoryIdHtml1 = 'selected';
        }

        // 游戏版本号检索
        if (isset($_GET['gameVersion'])) {
            if ($_GET['gameVersion'] == '全部') {
                $gameVersion = '';
                $gameVersionHtml = '全部';
            } else {
                $gameVersion = $_GET['gameVersion'];
                $gameVersionHtml = $_GET['gameVersion'];
            }
        } else {
            $gameVersion = '';
            $gameVersionHtml = '全部';
        }

        // 关键词检索
        if (isset($_GET['searchFilter'])) {
            $searchFilter = $_GET['searchFilter'];
        } else {
            $searchFilter = '';
        }

        // mod加载器检索
        if (isset($_GET['modLoaderType'])) {
            $modLoaderType = $_GET['modLoaderType'];
            switch ($_GET['modLoaderType']) {
                case '1':
                    $modLoaderTypeHtml2 = 'selected';
                    break;
                case '4':
                    $modLoaderTypeHtml3 = 'selected';
                    break;
                case '5':
                    $modLoaderTypeHtml4 = 'selected';
                    break;
            }
        } else {
            $modLoaderType = '0';
            $modLoaderTypeHtml1 = 'selected';
        }
        $Html = CurseForge(json_decode(CurseforgeModsSearch($CurseForgeKey, $categoryId, $gameVersion, $searchFilter, $modLoaderType, $_GET['index'], 50), true));
    }
}

function CurseForge($json)
{
    $Html = '';
    foreach ($json['data'] as $item1) {
        $Html .= '<div class="ListItem" onclick="ModID(\'' . $item1['id'] . '\')">';
        $Html .= '<div class="Left" style="background: url(\'' . $item1['logo']['url'] . '\') no-repeat 100% 100%/100% 100%;"></div>';
        $Html .= '<div class="Right"><div class="RightLeft">';
        $Html .= '<p class="ItemName">' . $item1['name'] . '</p>';
        $Html .= '<div class="ItemSummary">';
        $item2Num = 0;
        foreach ($item1['categories'] as $item2) {
            if ($item2Num != 40) {
                $item2Num++;
                $replacements = array(
                    '/World Gen/' => '世界元素',
                    '/Biomes/' => '生物群系',
                    '/Dimensions/' => '维度',
                    '/Ores and Resources/' => '矿石/资源',
                    '/Structures/' => '天然结构',
                    '/Technology/' => '科技',
                    '/Energy, Fluid, and Item Transport/' => '管道/物流',
                    '/Automation/' => '自动化',
                    '/Energy/' => '能源',
                    '/Redstone/' => '红石',
                    '/Food/' => '食物/烹饪',
                    '/Farming/' => '农业',
                    '/Mobs/' => '游戏机制',
                    '/Player Transport/' => '运输',
                    '/Storage/' => '仓储',
                    '/Magic/' => '魔法',
                    '/Adventure and RPG/' => '冒险',
                    '/Cosmetic/' => '装饰',
                    '/Armor, Tools, and Weapons/' => '装备/工具',
                    '/Miscellaneous/' => '性能优化',
                    '/Map and Information/' => '信息显示',
                    '/Server Utility/' => '服务器',
                    '/Utility & QoL/' => '改良',
                    '/API and Library/' => '支持库',
                );
                $Html .= '<p class="Categories">' . preg_replace(array_keys($replacements), array_values($replacements), $item2['name']) . '</p>';
            }
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

        .ListContainer .ListContent .SearchMain .SearchLeft .NameInput input,
        .ListContainer .ListContent .SearchMain .SearchLeft .SourceSelect select,
        .ListContainer .ListContent .SearchMain .SearchLeft .TypeSelect select,
        .ListContainer .ListContent .SearchMain .SearchLeft .VersionInput input,
        .ListContainer .ListContent .SearchMain .SearchLeft .LoaderSelect select {
            border: <?php echo '2px solid ' . $ThemeColor; ?>;
        }

        .ListContainer .ListContent .SearchMain .SearchLeft .NameInput input:hover,
        .ListContainer .ListContent .SearchMain .SearchLeft .SourceSelect select:hover,
        .ListContainer .ListContent .SearchMain .SearchLeft .TypeSelect select:hover,
        .ListContainer .ListContent .SearchMain .SearchLeft .VersionInput input:hover,
        .ListContainer .ListContent .SearchMain .SearchLeft .LoaderSelect select:hover {
            background: <?php echo $ThemeColor . 'a4'; ?>;
        }

        .ListContainer .ListContent .SearchMain .SearchRight .SearchButton {
            border: <?php echo '2px solid ' . $ThemeColor; ?>;
        }

        .ListContainer .ListContent .SearchMain .SearchRight .SearchButton:hover {
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

        .ListContainer .ListContent .ListItem .Right .RightRight i:hover {
            color: <?php echo $ThemeColor; ?>;
        }

        .ListContainer .ListContent .Index div {
            color: <?php echo $ThemeColor; ?>;
        }

        .ListContainer .ListContent .Index div:hover {
            background: <?php echo $ThemeColor; ?>;
        }

        #BackTo {
            background: <?php echo $ThemeColor; ?>;
        }
    </style>
</head>

<body>
    <div class="ListContainer" name="Top">
        <div class="ListTitle">搜索Mod</div>
        <div class="ListContent">
            <div class="SearchMain">
                <div class="SearchLeft">
                    <div class="SearchTop">
                        <label class="NameInput">
                            <span>名称</span>
                            <input type="text" placeholder="请输入关键词" id="NameInput" value="<?php echo $_GET['searchFilter']; ?>">
                        </label>
                        <label class="SourceSelect">
                            <span>来源</span>
                            <select id="SourceSelect">
                                <option value="CurseForge" <?php echo $select2; ?>>CurseForge</option>
                                <option value="Modrinth" <?php echo $select1; ?>>Modrinth</option>
                            </select>
                        </label>
                        <label class="TypeSelect">
                            <span>类型</span>
                            <select id="TypeSelect">
                                <option value="0" <?php echo $categoryIdHtml1; ?>>全部</option>
                                <option value="406" <?php echo $categoryIdHtml2; ?>>世界元素</option>
                                <option value="410" <?php echo $categoryIdHtml3; ?>>维度</option>
                                <option value="408" <?php echo $categoryIdHtml4; ?>>矿石/资源</option>
                                <option value="409" <?php echo $categoryIdHtml5; ?>>天然结构</option>
                                <option value="412" <?php echo $categoryIdHtml6; ?>>科技</option>
                                <option value="415" <?php echo $categoryIdHtml7; ?>>管道/物流</option>
                                <option value="4843" <?php echo $categoryIdHtml8; ?>>自动化</option>
                                <option value="417" <?php echo $categoryIdHtml9; ?>>能源</option>
                                <option value="4558" <?php echo $categoryIdHtml10; ?>>红石</option>
                                <option value="436" <?php echo $categoryIdHtml11; ?>>食物/烹饪</option>
                                <option value="416" <?php echo $categoryIdHtml12; ?>>农业</option>
                                <option value="411" <?php echo $categoryIdHtml13; ?>>游戏机制</option>
                                <option value="414" <?php echo $categoryIdHtml14; ?>>运输</option>
                                <option value="420" <?php echo $categoryIdHtml15; ?>>仓储</option>
                                <option value="4473" <?php echo $categoryIdHtml16; ?>>魔法</option>
                                <option value="4475" <?php echo $categoryIdHtml17; ?>>冒险</option>
                                <option value="424" <?php echo $categoryIdHtml18; ?>>装饰</option>
                                <option value="434" <?php echo $categoryIdHtml19; ?>>装备/工具</option>
                                <option value="133" <?php echo $categoryIdHtml20; ?>>性能优化</option>
                                <option value="423" <?php echo $categoryIdHtml21; ?>>信息显示</option>
                                <option value="435" <?php echo $categoryIdHtml22; ?>>服务器</option>
                                <option value="5191" <?php echo $categoryIdHtml23; ?>>改良</option>
                                <option value="421" <?php echo $categoryIdHtml24; ?>>支持库</option>
                            </select>
                        </label>
                    </div>
                    <div class="SearchBottom">
                        <label class="VersionInput">
                            <span>版本</span>
                            <input type="text" list="sourceList" id="VersionInput" value="<?php echo $gameVersionHtml; ?>">
                            <datalist id="sourceList">
                                <option value="全部">可以自行输入</option>
                                <option value="1.20.1">1.20.1</option>
                                <option value="1.20">1.20</option>
                                <option value="1.19.4">1.19.4</option>
                                <option value="1.18.2">1.18.2</option>
                                <option value="1.17.1">1.17.1</option>
                                <option value="1.16.5">1.16.5</option>
                                <option value="1.15.2">1.15.2</option>
                                <option value="1.14.4">1.14.4</option>
                                <option value="1.13.2">1.13.2</option>
                                <option value="1.12.2">1.12.2</option>
                                <option value="1.11.2">1.11.2</option>
                                <option value="1.10.2">1.10.2</option>
                                <option value="1.9.4">1.9.4</option>
                                <option value="1.8.9">1.8.9</option>
                                <option value="1.7.10">1.7.10</option>
                            </datalist>
                        </label>
                        <label class="LoaderSelect">
                            <select id="LoaderSelect">
                                <option value="" <?php echo $modLoaderTypeHtml1; ?>>任意 Mod 加载器</option>
                                <option value="1" <?php echo $modLoaderTypeHtml2; ?>>Forge</option>
                                <option value="4" <?php echo $modLoaderTypeHtml3; ?>>Fabric</option>
                                <option value="5" <?php echo $modLoaderTypeHtml4; ?>>Quilt</option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="SearchRight">
                    <button class="SearchButton">搜索</button>
                    <button class="ResetButton">重置条件</button>
                </div>
            </div>
        </div>
    </div>
    <div class="ListContainer" id="Search" style="display: none;">
        <div class="ListContent">
            <div class="ModsLoading"></div>
        </div>
    </div>
    <div class="ListContainer" id="Mods">
        <div class="ListContent">
            <div class="Index">
                <div class="Left" onclick="Up()">&lt;</div>
                <p class="Num" id="IndexNum"><?php echo $_GET['index']; ?></p>
                <div class="Right" onclick="Down()">&gt;</div>
            </div>
            <?php echo $Html; ?>
            <div class="Index">
                <div class="Left" onclick="Up()">&lt;</div>
                <p class="Num" id="IndexNum"><?php echo $_GET['index']; ?></p>
                <div class="Right" onclick="Down()">&gt;</div>
            </div>
        </div>
    </div>
    <div id="BackTo" style="display: none;"><a href="#Top">↑</a></div>
    <script src="js/Mods.js"></script>
    <script src="js/Main.js"></script>
</body>

</html>