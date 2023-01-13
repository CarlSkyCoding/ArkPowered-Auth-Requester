<?php
// 方块盒子Auth接入工具 ArkPowered-Auth-Requester
// Alpha v0.0.1
// 23w01a


// 您的accessID_v3信息
$enable_apar = true; //这个设置暂时没啥用

$List = array(
    "accessID_v3" => false,
    "userName" => false,
    "userVerifyToken" => false
);
// 您的accessID_v3信息


class Basic_Function
{
    protected function f_get($url)
    {
        $get_array = file_get_contents($url);
        $out_array = json_decode($get_array, true);
        return $out_array;
    }
}

class apar_Checker extends Basic_Function
{
    public function check_Setting()
    {
        global $List;

        if ($List["accessID_v3"] == false || $List["userName"] == false || $List["userVerifyToken"] == false) {
            echo "您需要到程序顶部设置您的ID和自己的账户信息";
        } else {
            $basic = new Basic_Function();

            $auth_status = $basic->f_get("https://auth.arkpowered.cn/api/checkAPARSetting?accessid={$List['accessID_v3']}&username={$List['userName']}&userVerifyToken={$List['userVerifyToken']}");

            if ($auth_status) {
                if ($auth_status["success"] == true) {
                } else {
                    echo "您的APAR配置不正确！";
                }
            } else {
                echo "目前APAR无法连接到验证服务器，您可以在设置项中暂时取消使用APAR";
            }
        }
    }
}

class apar_Main extends Basic_Function
{
    public function goto_authorize()
    {
        global $List;

        $basic = new Basic_Function();

        $auth_status = $basic->f_get("https://auth.arkpowered.cn");
        $manifest = $basic->f_get("https://api.arkpowered.cn/api/manifest.json");

        if ($auth_status) {
            if ($auth_status["Status"] == "OK") {
                if ($manifest) {
                    $output = array(
                        "Status" => "OK"
                    );
                    header("location: //id.arkpowered.cn/api/public/cauth/v3/authorize?accessid={$List['accessID_v3']}");
                } else {
                    $output = array(
                        "Status" => "Offline",
                        "msg" => "ID Server Down"
                    );
                }
            } else {
                $output = array(
                    "Status" => "Offline",
                    "msg" => "Auth Server Temporary Maintenance"
                );
            }
        } else {
            $output = array(
                "Status" => "Offline",
                "msg" => "Auth Server Down"
            );
        }
        return $output;
    }

    public function require_userdata($name, $token)
    {
        global $List;

        $basic = new Basic_Function();

        $auth_status = $basic->f_get("https://auth.arkpowered.cn");
        $manifest = $basic->f_get("https://api.arkpowered.cn/api/manifest.json");

        if ($auth_status) {
            if ($auth_status["Status"] == "OK") {
                $re_data = $basic->f_get($manifest["protocol"] . "://" . $manifest["apiaddress"]["cauth3"]["get-userdata"] . "?accessid={$List['accessID_v3']}&username={$name}&accesstoken={$token}");
                if ($re_data) {
                    $output = array(
                        "Status" => "OK",
                        "info" => $re_data
                    );
                } else {
                    $output = array(
                        "Status" => "Offline",
                        "msg" => "ID Server Down"
                    );
                }
            } else {
                $output = array(
                    "Status" => "Offline",
                    "msg" => "Auth Server Temporary Maintenance"
                );
            }
        } else {
            $output = array(
                "Status" => "Offline",
                "msg" => "Auth Server Down"
            );
        }
        return $output;
    }

    public function require_recyclingAccessToken($name, $token)
    {
        global $List;

        $basic = new Basic_Function();

        $auth_status = $basic->f_get("https://auth.arkpowered.cn");
        $manifest = $basic->f_get("https://api.arkpowered.cn/api/manifest.json");

        if ($auth_status) {
            if ($auth_status["Status"] == "OK") {
                $re_data = $basic->f_get($manifest["protocol"] . "://" . $manifest["apiaddress"]["cauth3"]["recycling-accesstoken"] . "?accessid={$List['accessID_v3']}&username={$name}&accesstoken={$token}");
                if ($re_data) {
                    $output = array(
                        "Status" => "OK"
                    );
                } else {
                    $output = array(
                        "Status" => "Offline",
                        "msg" => "ID Server Down"
                    );
                }
            } else {
                $output = array(
                    "Status" => "Offline",
                    "msg" => "Auth Server Temporary Maintenance"
                );
            }
        } else {
            $output = array(
                "Status" => "Offline",
                "msg" => "Auth Server Down"
            );
        }
        return $output;
    }

    // 这个接口能不用就不用，因为CA3的get-userdata疑似正在替代他
    public function verify_userInformation($name, $token)
    {
        $basic = new Basic_Function();

        $auth_status = $basic->f_get("https://auth.arkpowered.cn");
        $manifest = $basic->f_get("https://api.arkpowered.cn/api/manifest.json");

        if ($auth_status) {
            if ($auth_status["Status"] == "OK") {
                $re_data = $basic->f_get($manifest["protocol"] . "://" . $manifest["apiaddress"]["verify-user"] . "?username={$name}&token={$token}");
                if ($re_data) {
                    $output = array(
                        "Status" => "OK",
                        "info" => $re_data
                    );
                } else {
                    $output = array(
                        "Status" => "Offline",
                        "msg" => "ID Server Down"
                    );
                }
            } else {
                $output = array(
                    "Status" => "Offline",
                    "msg" => "Auth Server Temporary Maintenance"
                );
            }
        } else {
            $output = array(
                "Status" => "Offline",
                "msg" => "Auth Server Down"
            );
        }
        return $output;
    }
}
