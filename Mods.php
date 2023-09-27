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
        // 分类检索
        if (isset($_GET['categoryId'])) {
            $category = $_GET['categoryId'];
            switch ($_GET['categoryId']) {
                case '0':
                    $categoryHtml1 = 'selected';
                    break;
                case '406|world-generation':
                    $categoryHtml2 = 'selected';
                    $category = explode('|', $_GET['categoryId'])[1];
                    break;
                case '410':
                    $categoryHtml3 = 'selected';
                    break;
                case '408':
                    $categoryHtml4 = 'selected';
                    break;
                case '409':
                    $categoryHtml5 = 'selected';
                    break;
                case '412|technology':
                    $categoryHtml6 = 'selected';
                    $category = explode('|', $_GET['categoryId'])[1];
                    break;
                case '415':
                    $categoryHtml7 = 'selected';
                    break;
                case '4843':
                    $categoryHtml8 = 'selected';
                    break;
                case '417':
                    $categoryHtml9 = 'selected';
                    break;
                case '4558':
                    $categoryHtml10 = 'selected';
                    break;
                case '436|food':
                    $categoryHtml11 = 'selected';
                    $category = explode('|', $_GET['categoryId'])[1];
                    break;
                case '416':
                    $categoryHtml12 = 'selected';
                    break;
                case '411|game-mechanics':
                    $categoryHtml13 = 'selected';
                    $category = explode('|', $_GET['categoryId'])[1];
                    break;
                case '414|transportation':
                    $categoryHtml14 = 'selected';
                    $category = explode('|', $_GET['categoryId'])[1];
                    break;
                case '420|storage':
                    $categoryHtml15 = 'selected';
                    $category = explode('|', $_GET['categoryId'])[1];
                    break;
                case '4473|magic':
                    $categoryHtml16 = 'selected';
                    $category = explode('|', $_GET['categoryId'])[1];
                    break;
                case '4475|adventure':
                    $categoryHtml17 = 'selected';
                    $category = explode('|', $_GET['categoryId'])[1];
                    break;
                case '424|decoration':
                    $categoryHtml18 = 'selected';
                    $category = explode('|', $_GET['categoryId'])[1];
                    break;
                case '434|equipment':
                    $categoryHtml19 = 'selected';
                    $category = explode('|', $_GET['categoryId'])[1];
                    break;
                case '133|optimization':
                    $categoryHtml20 = 'selected';
                    $category = explode('|', $_GET['categoryId'])[1];
                    break;
                case '423':
                    $categoryHtml21 = 'selected';
                    break;
                case '435|social':
                    $categoryHtml22 = 'selected';
                    $category = explode('|', $_GET['categoryId'])[1];
                    break;
                case '5191|utility':
                    $categoryHtml23 = 'selected';
                    $category = explode('|', $_GET['categoryId'])[1];
                    break;
                case '421|library':
                    $categoryHtml24 = 'selected';
                    $category = explode('|', $_GET['categoryId'])[1];
                    break;
            }
        } else {
            $category = '';
            $categoryHtml1 = 'selected';
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

        $Html = Modrinth(json_decode(ModrinthModsSearch($category, $gameVersion, $searchFilter, $modLoaderType, $_GET['index'], 50), true));
    } else {
        $select2 = 'selected';
        // 公共的Key
        $CurseForgeKey = '$2a$10$ndSPnOpYqH3DRmLTWJTf5Ofm7lz9uYoTGvhSj0OjJWJ8WdO4ZTsr.';
        // 分类检索
        if (isset($_GET['categoryId'])) {
            $category = $_GET['categoryId'];
            switch ($_GET['categoryId']) {
                case '0':
                    $categoryHtml1 = 'selected';
                    break;
                case '406|world-generation':
                    $categoryHtml2 = 'selected';
                    $category = explode('|', $_GET['categoryId'])[0];
                    break;
                case '410':
                    $categoryHtml3 = 'selected';
                    break;
                case '408':
                    $categoryHtml4 = 'selected';
                    break;
                case '409':
                    $categoryHtml5 = 'selected';
                    break;
                case '412|technology':
                    $categoryHtml6 = 'selected';
                    $category = explode('|', $_GET['categoryId'])[0];
                    break;
                case '415':
                    $categoryHtml7 = 'selected';
                    break;
                case '4843':
                    $categoryHtml8 = 'selected';
                    break;
                case '417':
                    $categoryHtml9 = 'selected';
                    break;
                case '4558':
                    $categoryHtml10 = 'selected';
                    break;
                case '436|food':
                    $categoryHtml11 = 'selected';
                    $category = explode('|', $_GET['categoryId'])[0];
                    break;
                case '416':
                    $categoryHtml12 = 'selected';
                    break;
                case '411|game-mechanics':
                    $categoryHtml13 = 'selected';
                    $category = explode('|', $_GET['categoryId'])[0];
                    break;
                case '414|transportation':
                    $categoryHtml14 = 'selected';
                    $category = explode('|', $_GET['categoryId'])[0];
                    break;
                case '420|storage':
                    $categoryHtml15 = 'selected';
                    $category = explode('|', $_GET['categoryId'])[0];
                    break;
                case '4473|magic':
                    $categoryHtml16 = 'selected';
                    $category = explode('|', $_GET['categoryId'])[0];
                    break;
                case '4475|adventure':
                    $categoryHtml17 = 'selected';
                    $category = explode('|', $_GET['categoryId'])[0];
                    break;
                case '424|decoration':
                    $categoryHtml18 = 'selected';
                    $category = explode('|', $_GET['categoryId'])[0];
                    break;
                case '434|equipment':
                    $categoryHtml19 = 'selected';
                    $category = explode('|', $_GET['categoryId'])[0];
                    break;
                case '133|optimization':
                    $categoryHtml20 = 'selected';
                    $category = explode('|', $_GET['categoryId'])[0];
                    break;
                case '423':
                    $categoryHtml21 = 'selected';
                    break;
                case '435|social':
                    $categoryHtml22 = 'selected';
                    $category = explode('|', $_GET['categoryId'])[0];
                    break;
                case '5191|utility':
                    $categoryHtml23 = 'selected';
                    $category = explode('|', $_GET['categoryId'])[0];
                    break;
                case '421|library':
                    $categoryHtml24 = 'selected';
                    $category = explode('|', $_GET['categoryId'])[0];
                    break;
            }
        } else {
            $category = '';
            $categoryHtml1 = 'selected';
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
        $Html = CurseForge(json_decode(CurseforgeModsSearch($CurseForgeKey, $category, $gameVersion, $searchFilter, $modLoaderType, $_GET['index'], 50), true));
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
            if ($item2Num != 4) {
                if ($item2 != 'forge' && $item2 != 'fabric' && $item2 != 'quilt') {
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
        }
        $Html .= '<p class="Summary" title="' . $item1['summary'] . '">' . $item1['summary'] . '</p>
    </div><div class="ItemElse">';
        // $Html .= '<p><i class="icon icon-shezhi"></i>' . downloadCount($item1['downloadCount']) . '</p>';
        $Html .= '<p><i class="icon icon-xiazaidaoru"></i>' . downloadCount($item1['downloadCount']) . '</p>';
        $Html .= '<p><i class="icon icon-anquan"></i>' . date('Y-m-d H:i:s', strtotime($item1['dateModified'])) . '</p>';
        $Html .= '<p><i class="icon icon-huojian"></i>CurseForge</p>';
        $Html .= '</div></div><div class="RightRight">';
        $Html .= '<i class="icon icon-tishi" title="CurseForge" onclick="window.open(\'' . $item1['links']['websiteUrl'] . '\'); event.stopPropagation();"></i>';
        $Html .= '</div></div></div>';
    }
    return $Html;
}

function Modrinth($json)
{
    $Html = '';
    foreach ($json['hits'] as $item1) {
        $Html .= '<div class="ListItem" onclick="ModID(\'' . $item1['project_id'] . '\')">';
        $Html .= '<div class="Left" style="background: url(\'' . $item1['icon_url'] . '\') no-repeat 100% 100%/100% 100%;"></div>';
        $Html .= '<div class="Right"><div class="RightLeft">';
        $Html .= '<p class="ItemName">' . $item1['title'] . '</p>';
        $Html .= '<div class="ItemSummary">';
        $item2Num = 0;
        $modLoader = '';
        foreach ($item1['categories'] as $item2) {
            if ($item2Num != 4) {
                if ($item2 != 'forge' && $item2 != 'fabric' && $item2 != 'quilt') {
                    $item2Num++;
                    $replacements = array(
                        '/world-generation/' => '世界元素',
                        '/technology/' => '科技',
                        '/food/' => '食物/烹饪',
                        '/game-mechanics/' => '游戏机制',
                        '/transportation/' => '运输',
                        '/storage/' => '仓储',
                        '/magic/' => '魔法',
                        '/adventure/' => '冒险',
                        '/decoration/' => '装饰',
                        '/mobs/' => '生物',
                        '/equipment/' => '装备/工具',
                        '/optimization/' => '性能优化',
                        '/social/' => '服务器',
                        '/utility/' => '改良',
                        '/library/' => '支持库',
                    );
                    $Html .= '<p class="Categories">' . preg_replace(array_keys($replacements), array_values($replacements), $item2) . '</p>';
                } else {
                    $modLoader .= ' ' . $item2 . ' ';
                }
            }
        }
        $Html .= '<p class="Summary" title="' . $item1['description'] . '">' . $item1['description'] . '</p>
    </div><div class="ItemElse">';
        $Html .= '<p><i class="icon icon-shezhi"></i>' . $modLoader . '</p>';
        $Html .= '<p><i class="icon icon-xiazaidaoru"></i>' . downloadCount($item1['downloads']) . '</p>';
        $Html .= '<p><i class="icon icon-anquan"></i>' . date('Y-m-d H:i:s', strtotime($item1['date_modified'])) . '</p>';
        $Html .= '<p><i class="icon icon-huojian"></i>Modrinth</p>';
        $Html .= '</div></div><div class="RightRight">';
        $Html .= '<i class="icon icon-tishi" title="Modrinth" onclick="window.open(\'https://modrinth.com/mod/' . $item1['slug'] . '\'); event.stopPropagation();"></i>';
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
                                <option value="0" <?php echo $categoryHtml1; ?>>全部</option>
                                <option value="406|world-generation" <?php echo $categoryHtml2; ?>>世界元素</option>
                                <option value="410" <?php echo $categoryHtml3; ?>>维度</option>
                                <option value="408" <?php echo $categoryHtml4; ?>>矿石/资源</option>
                                <option value="409" <?php echo $categoryHtml5; ?>>天然结构</option>
                                <option value="412|technology" <?php echo $categoryHtml6; ?>>科技</option>
                                <option value="415" <?php echo $categoryHtml7; ?>>管道/物流</option>
                                <option value="4843" <?php echo $categoryHtml8; ?>>自动化</option>
                                <option value="417" <?php echo $categoryHtml9; ?>>能源</option>
                                <option value="4558" <?php echo $categoryHtml10; ?>>红石</option>
                                <option value="436|food" <?php echo $categoryHtml11; ?>>食物/烹饪</option>
                                <option value="416" <?php echo $categoryHtml12; ?>>农业</option>
                                <option value="411|game-mechanics" <?php echo $categoryHtml13; ?>>游戏机制</option>
                                <option value="414|transportation" <?php echo $categoryHtml14; ?>>运输</option>
                                <option value="420|storage" <?php echo $categoryHtml15; ?>>仓储</option>
                                <option value="4473|magic" <?php echo $categoryHtml16; ?>>魔法</option>
                                <option value="4475|adventure" <?php echo $categoryHtml17; ?>>冒险</option>
                                <option value="424|decoration" <?php echo $categoryHtml18; ?>>装饰</option>
                                <option value="434|equipment" <?php echo $categoryHtml19; ?>>装备/工具</option>
                                <option value="133|optimization" <?php echo $categoryHtml20; ?>>性能优化</option>
                                <option value="423" <?php echo $categoryHtml21; ?>>信息显示</option>
                                <option value="435|social" <?php echo $categoryHtml22; ?>>服务器</option>
                                <option value="5191|utility" <?php echo $categoryHtml23; ?>>改良</option>
                                <option value="421|library" <?php echo $categoryHtml24; ?>>支持库</option>
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