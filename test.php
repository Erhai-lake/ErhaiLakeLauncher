<?php
// 获取用户输入的版本号
$InputVersion = $_GET["a"];
$WikiLink = '版本号无效或不支持的格式';
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
    if (@preg_match($pattern, $InputVersion) === false) {
        $WikiLink = $link;
        break;
    } elseif (preg_match($pattern, $InputVersion, $matches)) {
        if ($link == $link2 . 'Beta_' || $link == $link2 . 'Alpha_v') {
            $WikiLink = $link . $matches[1];
        } else {
            $WikiLink = $link . $matches[0];
        }
        break;
    }
}
// 输出结果
echo "Minecraft 版本 $InputVersion 的 Wiki 链接是：$WikiLink";
