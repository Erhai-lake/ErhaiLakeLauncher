<?php
// 辅助类

/**
 * [辅助类]初始化启动器
 *
 * 此函数用于初始化启动器
 * @author Erhai_lake (fuzixuan0714_0826@163.com)
 * @param string $name 启动器名称
 * @param string $GameCatalog 游戏目录
 * @return int 返回状态码:0 表示成功,1 表示失败。
 */
function Initialize($name = 'ELL', $GameCatalog = '')
{

    if ($GameCatalog == "") {
        // config
        if (!file_exists($name)) {
            if (mkdir($name)) {
            } else {
                return 1;
            }
        }
        // .minecraft
        if (!file_exists(".minecraft")) {
            if (mkdir(".minecraft")) {
                return 0;
            } else {
                return 1;
            }
        }
    } else {
        // config
        if (!file_exists($GameCatalog . "/" . $name)) {
            if (mkdir($GameCatalog . "/" . $name)) {
            } else {
                return 1;
            }
        }
        // .minecraft
        if (!file_exists($GameCatalog . "/" . ".minecraft")) {
            if (mkdir($GameCatalog . "/" . ".minecraft")) {
                return 0;
            } else {
                return 1;
            }
        }
    }
}

/**
 * [辅助类]用户名获取UUID
 *
 * 此函数可以通过用户名,获取UUID
 * @author Erhai_lake (fuzixuan0714_0826@163.com)
 * @param string $name 用户名
 * @return string UUID
 * @return int 返回状态码:1 读取失败,2 解析失败,3 源不存在
 */
function NameUUID($name)
{
    // 读取MCSource.json文件
    $json = file_get_contents("https://api.mojang.com/users/profiles/minecraft/" . $name);
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
    if (isset($sources["id"])) {
        return $sources["id"];
    } else {
        return 3;
    }
}

/**
 * [辅助类]UUID获取用户名
 *
 * 此函数可以通过UUID,获取用户
 * @author Erhai_lake (fuzixuan0714_0826@163.com)
 * @param string $UUID 玩家唯一标识符
 * @return string 用户名
 * @return int 返回状态码:1 读取失败,2 解析失败,3 源不存在
 */
function UUIDName($UUID)
{
    // 读取MCSource.json文件
    $json = file_get_contents("https://sessionserver.mojang.com/session/minecraft/profile/" . $UUID);
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
    if (isset($sources["name"])) {
        return $sources["name"];
    } else {
        return 3;
    }
}

/**
 * 获取皮肤文件
 *
 * 此函数可以通过UUID,获取玩家皮肤
 * @author Erhai_lake (fuzixuan0714_0826@163.com)
 * @param string $UUID 玩家唯一标识符
 * @return string 皮肤文件
 * @return int 回状态码:1 读取失败,2 解析失败,3 源不存在
 */
function Skin($UUID)
{
    // 读取MCSource.json文件
    $json = file_get_contents("https://sessionserver.mojang.com/session/minecraft/profile/" . $UUID);
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
    if (isset($sources["properties"][0]["value"])) {
        $skin = base64_decode($sources["properties"][0]["value"]);
        return json_decode($skin, true)["textures"]["SKIN"]["url"];
    } else {
        return 3;
    }
}
