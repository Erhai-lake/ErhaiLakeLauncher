<?php
$Name = "ELL";
$Config = json_decode(file_get_contents('../' . $Name . '/config.json'), true);


if (isset($_GET['type']) && isset($_GET['value'])) {
    $type = $_GET['type'];
    $value = $_GET['value'];
    switch ($type) {
        case 'theme':
            $Config['Theme'] = $value;
            $Config['grayscale'] = false;
            switch ($value) {
                case "Erhai_lake":
                    $Config['ThemeColor'] = '#80CEFF';
                    break;
                case "Qi_Month":
                    $Config['ThemeColor'] = '#E61D39';
                    break;
                case "cqy":
                    $Config['ThemeColor'] = '#EDB2C9';
                    break;
                case "grayscale":
                    $Config['ThemeColor'] = '#80CEFF';
                    $Config['grayscale'] = true;
                    break;
                default:
                    if (preg_match('/^\d+\|\d+\|\d+$/', $value)) {
                        $rgb = explode("|", $value);
                        $Config['ThemeColor'] = sprintf("#%02x%02x%02x", max(0, min(255, $rgb[0])), max(0, min(255, $rgb[1])), max(0, min(255, $rgb[2])));
                    }
                    break;
            }
            break;
        case 'homepage':
            switch ($value) {
                case 'Hitokoto':
                    if ($Config['Hitokoto']) {
                        $Config['Hitokoto'] = false;
                    } else {
                        $Config['Hitokoto'] = true;
                    }
                    break;
                case 'Custom':
                    if ($Config['Custom']) {
                        $Config['Custom'] = false;
                    } else {
                        $Config['Custom'] = true;
                    }
                default:
                    if (preg_match('/\bhttps?:\/\/\S+\b/i', $value)) {
                        $Config['CustomURL'] = $value;
                    }
            }
    }
}

file_put_contents('../' . $Name . '/config.json', json_encode($Config, JSON_UNESCAPED_UNICODE));
