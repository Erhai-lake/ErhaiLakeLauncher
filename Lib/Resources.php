<?php
// 资源类

// 初始化源
// 参数:源(0:官方,:BMCLAPI,2:MCBBS;默认:0)
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

    // 检查指定的源是否存在
    if (isset($sources[$Source])) {
        return $sources[$Source];
    } else {
        return 3;
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
