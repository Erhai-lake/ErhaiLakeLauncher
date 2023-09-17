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
                    echo 'ok';
                    break;
                case "Qi_Month":
                    $Config['ThemeColor'] = '#E61D39';
                    echo 'ok';
                    break;
                case "cqy":
                    $Config['ThemeColor'] = '#EDB2C9';
                    echo 'ok';
                    break;
                case "grayscale":
                    $Config['ThemeColor'] = '#80CEFF';
                    $Config['grayscale'] = true;
                    echo 'ok';
                    break;
                default:
                    if (preg_match('/^\d+\|\d+\|\d+$/', $value)) {
                        $rgb = explode("|", $value);
                        $Config['ThemeColor'] = sprintf("#%02x%02x%02x", max(0, min(255, $rgb[0])), max(0, min(255, $rgb[1])), max(0, min(255, $rgb[2])));
                        echo 'ok';
                    }
                    break;
            }
            break;
        case 'homepage':
            switch ($value) {
                case 'Hitokoto':
                    if ($Config['Hitokoto']) {
                        $Config['Hitokoto'] = false;
                        echo 'ok';
                    } else {
                        $Config['Hitokoto'] = true;
                        echo 'ok';
                    }
                    break;
                case 'Custom':
                    if ($Config['Custom']) {
                        $Config['Custom'] = false;
                        echo 'ok';
                    } else {
                        $Config['Custom'] = true;
                        echo 'ok';
                    }
                default:
                    if (preg_match('/^(https?:\/\/)?([a-z0-9-]+\.)?[a-z0-9-]+\.[a-z]+(\/[^\s]*)?$/i', $value)) {
                        $Config['CustomURL'] = $value;
                        echo 'ok';
                    }
            }
    }
}

file_put_contents('../' . $Name . '/config.json', json_encode($Config, JSON_UNESCAPED_UNICODE));
