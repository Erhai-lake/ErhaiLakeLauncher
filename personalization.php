<?php
error_reporting(0);
require "Lib/Auxiliary.php";

$Name = "ELL";

// 读取配置文件
$Config = json_decode(file_get_contents($Name . "/config.json"), true);

// 主题色
$Theme = $Config["Theme"];
switch ($Theme) {
    case 'Erhai_lake':
        $ThemeErhai_lake = 'checked';
        break;
    case 'Qi_Month':
        $ThemeQi_Month = 'checked';
        break;
    case 'cqy':
        $Themecqy = 'checked';
        break;
    case 'grayscale':
        $grayscale = $Config["grayscale"];
        $Themegrayscale = 'checked';
        break;
    default:
        $rgb = explode("|",  $Config["Theme"]);
        $Themecustom1 = 'style="display: flex;"';
        $Themecustom2 = 'checked';
        break;
}
$ThemeColor = $Config["ThemeColor"];
if (count($rgb) != 3) {
    $rgb = [0, 0, 0];
}

// 自定义主页
if ($Config['Hitokoto']) {
    $Hitokoto = 'checked';
}
if ($Config['Custom']) {
    $Custom1 = 'style="display: block;"';
    $Custom2 = 'checked';
}
$CustomURL = $Config["CustomURL"];
?>
<!DOCTYPE html>
<html lang="zh_CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>洱海启动器</title>
    <link rel="stylesheet" href="css/Main.css">
    <link rel="stylesheet" href="css/Personalization.css">
    <link rel="stylesheet" href="css/icon.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <style>
        .Main:hover {
            box-shadow: <?php echo $ThemeColor; ?> 0px 0px 0px 3px;
        }

        .Main:hover .MainTitle {
            color: <?php echo $ThemeColor; ?>;
        }

        .Main .MainContent .RadioMain div p:before {
            border: <?php echo '2px solid ' . $ThemeColor; ?>;
        }

        #zdy button {
            border: <?php echo '2px solid ' . $ThemeColor; ?>;
        }

        #zdy button:hover {
            background: <?php echo $ThemeColor . '70'; ?>;
        }

        .Main .MainContent .RadioMain .a div .RadioTitle::before,
        .Main .MainContent .RadioMain .a div .RadioTitle::after {
            border: <?php echo '2px solid ' . $ThemeColor; ?>;
        }

        .Main .MainContent .RadioMain .a div .RadioTitle::after {
            border: 2px solid transparent;
        }

        .Main .MainContent .RadioMain .a div input[type="radio"]:checked+.RadioTitle::after,
        .Main .MainContent .RadioMain .a div input[type="checkbox"]:checked+.RadioTitle::after {
            background: <?php echo $ThemeColor; ?>;
        }

        .Main .MainContent .RadioMain .a div:hover .RadioTitle {
            color: <?php echo $ThemeColor; ?>;
        }
    </style>
</head>

<body>
    <div class="Main">
        <div class="MainTitle">基础</div>
        <div class="MainContent">
            <p>主题</p>
            <div class="RadioMain">
                <div id="zdy" <?php echo $Themecustom1; ?>>
                    <div class="color-slider">
                        <label for="redSlider">R:</label>
                        <input type="range" id="redSlider" min="0" max="255" value="<?php echo $rgb[0]; ?>">
                        <label for="redSlider"><span id="redValue"><?php echo $rgb[0]; ?></span></label>
                    </div>
                    <div class="color-slider">
                        <label for="greenSlider">G:</label>
                        <input type="range" id="greenSlider" min="0" max="255" value="<?php echo $rgb[1]; ?>">
                        <label for="greenSlider"><span id="greenValue"><?php echo $rgb[1]; ?></span></label>
                    </div>
                    <div class="color-slider">
                        <label for="blueSlider">B:</label>
                        <input type="range" id="blueSlider" min="0" max="255" value="<?php echo $rgb[2]; ?>">
                        <label for="blueSlider"><span id="blueValue"><?php echo $rgb[2]; ?></span></label>
                    </div>
                    <div class="color-preview" id="colorPreview" style="background: <?php echo $Config['ThemeColor']; ?>;"></div>
                    <button onclick="ajax('/backend/Config.php?type=theme&value=' + document.getElementById('redSlider').value + '|' + document.getElementById('greenSlider').value+ '|' + document.getElementById('blueSlider').value);">保存</button>
                </div>
                <div class="a">
                    <div>
                        <label>
                            <input type="radio" name="theme" value="Erhai_lake" <?php echo $ThemeErhai_lake; ?>>
                            <span class="RadioTitle">洱海蓝</span>
                        </label>
                    </div>
                    <div>
                        <label>
                            <input type="radio" name="theme" value="Qi_Month" <?php echo $ThemeQi_Month; ?>>
                            <span class="RadioTitle">柒月红</span>
                        </label>
                    </div>
                    <div>
                        <label>
                            <input type="radio" name="theme" value="cqy" <?php echo $Themecqy; ?>>
                            <span class="RadioTitle">彼岸粉</span>
                        </label>
                    </div>
                    <div>
                        <label>
                            <input type="radio" name="theme" value="grayscale" <?php echo $Themegrayscale; ?>>
                            <span class="RadioTitle">灰白</span>
                        </label>
                    </div>
                    <div>
                        <label>
                            <input type="radio" name="theme" value="custom" <?php echo $Themecustom2; ?>>
                            <span class="RadioTitle">自定义</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="Main">
        <div class="MainTitle">主页</div>
        <div class="MainContent">
            <div class="RadioMain">
                <div id="zdylj" <?php echo $Custom1; ?>>
                    <div>
                        <label>
                            <span class="InputText">自定义链接:</span>
                            <input type="text" name="CustomPageURL" id="CustomPageURL" value="<?php echo $CustomURL; ?>">
                            <button onclick="ajax('/backend/Config.php?type=homepage&value=' + document.getElementById('CustomPageURL').value)">保存</button>
                        </label>
                    </div>
                </div>
                <div class="a">
                    <div>
                        <label>
                            <input type="checkbox" name="homepage" value="Hitokoto" <?php echo $Hitokoto; ?>>
                            <span class="RadioTitle">一言</span>
                        </label>
                    </div>
                    <div>
                        <label>
                            <input type="checkbox" name="homepage" value="Custom" <?php echo $Custom2; ?>>
                            <span class="RadioTitle">自定义页面</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/Personalization.js"></script>
    <script src="js/Main.js"></script>
</body>

</html>