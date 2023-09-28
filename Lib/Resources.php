<?php
// 资源类

/**
 * [资源类]初始化源
 *
 * 此函数用于初始化下载源
 * @author Erhai_lake (fuzixuan0714_0826@163.com)
 * @param int $Source 0 官方,1 BMCLAPI,2 MCBBS,3 自动选择,默认 0
 * @return array 下载源json,结构如下：
 *   - '版本列表' (string)：版本列表链接
 *   - '版本json文件' (string)：版本json文件链接
 *   - '资源索引文件' (string)：资源索引文件链接
 *   - '资源文件' (string)：资源文件链接
 *   - '游戏主文件' (string)：游戏主文件链接
 *   - '依赖库文件' (string)：依赖库文件链接
 *   - 'natives库文件' (string)：natives库文件链接
 * @return int 返回状态码:1 无法读取下载源文件,2 下载源文件解析失败,3 源不存在
 */
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
            return $sources[0];
        } else if ($fastestWebsite == $sources[1]["版本列表"]) {
            return $sources[1];
        } else if ($fastestWebsite == $sources[2]["版本列表"]) {
            return $sources[2];
        } else {
            return 3;
        }
    }
}

/**
 * [资源类]初始化版本文件
 *
 * 此函数用于初始化版本文件
 * @author Erhai_lake (fuzixuan0714_0826@163.com)
 * @param string $Source 下载源(通过 InitializeSource() 获取)
 * @return string 版本文件
 * @return int 返回状态码:1 无法读取下载源文件
 */
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

/**
 * [资源类]获取最新的正式版本
 *
 * 此函数用于获取最新的正式版本
 * @author Erhai_lake (fuzixuan0714_0826@163.com)
 * @param string $VersionFile 下载源(通过 InitializeVersionFile() 获取)
 * @return string 最新的正式版本
 * @return int 返回状态码:1 版本文件解析失败,2 不存在
 */
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

/**
 * [资源类]获取最新的快照
 *
 * 此函数用于获取最新的快照
 * @author Erhai_lake (fuzixuan0714_0826@163.com)
 * @param string $VersionFile 下载源(通过 InitializeVersionFile() 获取)
 * @return string 最新的快照
 * @return int 返回状态码:1 版本文件解析失败,2 不存在
 */
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

/**
 * [资源类]获取所有版本
 *
 * 此函数用于获取所有版本
 * @author Erhai_lake (fuzixuan0714_0826@163.com)
 * @param string $VersionFile 下载源(通过 InitializeVersionFile() 获取)
 * @return array 所有版本数组,结构如下：
 *   - 'id' (string)：游戏版本号
 *   - 'type' (string):版本类型
 *   - 'url' (string):版本json链接
 *   - 'time' (string):时间
 *   - 'releaseTime' (string):构建时间
 * @return int 返回状态码:1 版本文件解析失败,2 不存在
 */
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

 /**
  * [资源类]Curseforge搜索模组
  *
 * 此函数用于Curseforge搜索模组
 * @author Erhai_lake (fuzixuan0714_0826@163.com)
  * @param string $Key 秘钥
  * @param integer $category 分类ID
  * @param string $gameVersion 游戏版本
  * @param string $searchFilter 关键词
  * @param string $modLoaderType mod加载器
  * @param integer $index 索引
  * @param integer $pageSize 数量(最大50)
  * @return array 结果,结构看官方文档(https://docs.curseforge.com/#search-mods)
  */
function CurseforgeModsSearch($Key = '', $category = 0, $gameVersion = '', $searchFilter = '', $modLoaderType = '', $index = 0, $pageSize = 50)
{
    $curl = curl_init();
    // Api
    $url = 'https://api.curseforge.com/v1/mods/search';
    // 游戏ID
    $url .= '?gameId=432';
    // 排列方式
    $url .= '&sortField=2';
    // 排序字段
    $url .= '&sortOrder=1';
    // 分类ID
    $url .= '&categoryId=' . $category;
    // 游戏版本
    $url .= '&gameVersion=' . $gameVersion;
    // 关键词
    $url .= '&searchFilter=' . $searchFilter;
    // mod加载器
    $url .= '&modLoaderType=' . $modLoaderType;
    // 索引
    $url .= '&index=' . ($pageSize * $index);
    // 数量
    $url .= '&pageSize=' . $pageSize;

    $headers = array('X-API-Key: ' . $Key, 'Accept: application/json');
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_TIMEOUT, 50);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($curl);
    curl_close($curl);
    return $data;
}

 /**
  * [资源类]modrinth搜索模组
  *
 * 此函数用于modrinth搜索模组
 * @author Erhai_lake (fuzixuan0714_0826@163.com)
  * @param integer $category 分类
  * @param string $gameVersion 游戏版本
  * @param string $searchFilter 关键词
  * @param string $modLoaderType mod加载器
  * @param integer $index 索引
  * @param integer $pageSize 数量(最大100)
  * @return array 结果,结构看官方文档(https://docs.modrinth.com/api-spec#tag/projects/operation/searchProjects)
  */
function ModrinthModsSearch($category = '', $gameVersion = '', $searchFilter = '', $modLoaderType = '', $index = 0, $pageSize = 100)
{
    $curl = curl_init();
    // Api
    $url = 'https://api.modrinth.com/v2/search';
    // 关键词
    $url .= '?query=' . $searchFilter;
    $facets = [];
    // 分类
    if (!empty($category)) {
        $facets[] = ["categories = " . $category];
    }
    // 游戏版本
    if (!empty($gameVersion)) {
        $facets[] = ["versions = " . $gameVersion];
    }
    // mod加载器
    if (!empty($modLoaderType)) {
        $facets[] = ["categories = " . $modLoaderType];
    }
    // 过滤器
    if (!empty($facets)) {
        $url .= '&facets=' . json_encode($facets);
    }
    // 排列方式
    $url .= '&index=relevance';
    // 索引
    $url .= '&offset=' . ($pageSize * $index);
    // 数量
    $url .= '&limit=' . $pageSize;

    $headers = array('User-Agent: erhai-lake/ELL/ (Erhai_lake@fuzixuan0714_0826@163.com)', 'Accept: application/json');
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_TIMEOUT, 50);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($curl);
    curl_close($curl);
    return $data;
}
