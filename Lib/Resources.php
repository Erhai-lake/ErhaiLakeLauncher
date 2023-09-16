<?php
// 资源类

// 初始化源
// 参数:源(0:官方,1:BMCLAPI,2:MCBBS,3:自动选择;默认:0)
// 返回:下载源json,1:无法读取下载源文件,2:下载源文件解析失败,3:源不存在
function InitializeSource($Source = 0)
{
    // 读取MCSource.json文件
    $json = file_get_contents("MCSource.json");

    // 检查文件是否成功读取
    if ($json === false) {
        return 1;
    }

    // 解析JSON内容
    $sources = json_decode($json, true);
    // 检查JSON解析是否成功
    if ($sources === null) {
        return 2;
    }

    if ($Source != 3) {
        // 检查指定的源是否存在
        if (isset($sources[$Source])) {
            return $sources[$Source];
        } else {
            return 3;
        }
    } else if ($Source == 3) {
        // 初始化结果数组
        $latencyResults = array();
        // 遍历每个网站并测试连接延迟
        foreach ($sources as $website) {
            $startTime = microtime(true);
            // 使用cURL初始化连接
            $ch = curl_init($website["版本列表"]);
            // 设置cURL选项，以便仅获取头部信息，不下载页面内容
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); // 设置超时时间
            // 执行cURL请求
            curl_exec($ch);
            // 获取cURL请求的总时间（毫秒）
            $totalTime = (microtime(true) - $startTime) * 1000;
            // 关闭cURL连接
            curl_close($ch);
            // 将结果存储到数组中
            $latencyResults[$website["版本列表"]] = $totalTime;
        }
        // 找到最低延迟的网站
        $minLatency = min($latencyResults);
        $fastestWebsite = array_search($minLatency, $latencyResults);
        if ($fastestWebsite == $sources[0]["版本列表"]) {
            echo '0';
            return $sources[0];
        } else if ($fastestWebsite == $sources[1]["版本列表"]) {
            echo '1';
            return $sources[1];
        } else if ($fastestWebsite == $sources[2]["版本列表"]) {
            echo '2';
            return $sources[2];
        }else{
            return 3;
        }
    }
}

// 初始化版本文件
// 参数:下载源(通过 InitializeSource() 获取)
// 返回:版本文件,1:无法读取版本文件
function InitializeVersionFile($Source)
{
    // 读取版本文件
    $json = file_get_contents($Source["版本列表"]);
    // 检查文件是否成功读取
    if ($json === false) {
        return 1;
    }

    // 检查JSON解析是否成功
    if ($json === null) {
        return 2;
    } else {
        return $json;
    }
}

// 获取最新的正式版本
// 参数:版本文件(通过 InitializeVersionFile() 获取)
// 返回:最新的正式版本,1:版本文件解析失败,2:不存在
function LatestOfficiaVersion($VersionFile)
{
    // 解析JSON内容
    $sources = json_decode($VersionFile, true);
    // 检查JSON解析是否成功
    if ($sources === null) {
        return 1;
    }

    // 检查指定的源是否存在
    if (isset($sources["latest"]["release"])) {
        return $sources["latest"]["release"];
    } else {
        return 2;
    }
}

// 获取最新的快照
// 参数:版本文件(通过 InitializeVersionFile() 获取)
// 返回:最新的快照,1:版本文件解析失败,2:不存在
function LatestBetaVersion($VersionFile)
{
    // 解析JSON内容
    $sources = json_decode($VersionFile, true);
    // 检查JSON解析是否成功
    if ($sources === null) {
        return 1;
    }

    // 检查指定的源是否存在
    if (isset($sources["latest"]["snapshot"])) {
        return $sources["latest"]["snapshot"];
    } else {
        return 3;
    }
}

// 获取所有版本
// 参数:版本文件(通过 InitializeVersionFile() 获取)
// 返回:所有版本数组,1:版本文件解析失败,2:不存在
function AllVersions($VersionFile)
{
    // 解析JSON内容
    $sources = json_decode($VersionFile, true);
    // 检查JSON解析是否成功
    if ($sources === null) {
        return 1;
    }

    // 检查指定的源是否存在
    if (isset($sources["versions"])) {
        return $sources["versions"];
    } else {
        return 2;
    }
}
