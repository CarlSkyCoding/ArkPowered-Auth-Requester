# 方块盒子Auth服务简易接入器-PHP


## 介绍
**感谢大家支持方块盒子的服务！** 方块盒子Auth服务简易接入器英文全称为 ```ArkPowered-Auth-Requester``` ，简称 ```APAR``` ，为了优化用户体验，使用户快速接入我们的网络服务，我们推出了简易的接入器，搭配 ```auth.arkpowered.cn``` 使用，目前功能还不算完善，如果可以自己接入还是推荐大家自己接入拓展性更高一些

## 调用方法
在使用工具之前，您需要 ```require``` 工具的地址，例：
```
require("{$_SERVER['DOCUMENT_ROOT']}/{ToolPath}/apar_main.php");
```
十分不建议您更改程序名称，后续添加其他功能时可能会导致程序错误

## 工具的使用
```APAR``` 使用了对象化编程，您可以不用担心先前项目的代码冲突问题，所以在使用工具之前，**您需要检查设置是否完成，您应当检查 ```apar_main.php``` 的头部 ```$List``` 变量信息是否填写完整** ，如果填写完整，您可以使用以下代码初始化 APAR_Checker（APAR 配置检查工具）：
```
$apar_check = new apar_Checker();
$apar_check->check_Setting();
```
至此，您就完成了对于apar的基本初始化，下一步，您需要初始化主进程：
```
$apar = new apar_Main();
```
### 我们提供了以下功能：
#### 1.使用自动化工具跳转到 **验证界面**：
跳转到 CAuth3 Authorize 页面（验证页，CAuth3的第一步操作），使用之前请确保初始化完毕：
```
$apar->goto_authorize();
```
至此，您应该已经跳转到了我们的 ```Authorize``` 服务

#### 2.获取UserData：
获取用户的UserData，您应该已经完成了 ```1``` ，然后使用此工具返回一个 ```Json``` 数据：
```
$return = $apar->require_userdata($name, $token);
```
此时 ```$return``` 应该已经有了 ```Json``` 数据，如果获取成功，```Status``` 键应该为 ```OK``` ***（注意此步只是获取成功，而不是信息正确，内部的response_id为1才算彻底成功）***
此时 userAccessToken 仍未回收，当用户下一次登录方块盒子账户/登入其他网站的时候，该 userAccessToken 会被自动回收掉

#### 3.回收userAccessToken：
如果您比较重视用户信息安全，您可以在 ```2``` 完毕后进行此步：
```
$return = $apar->require_recyclingAccessToken($name, $token);
```
此步可以重置掉用户的 ```userAccessToken``` 确保信息的安全，如果调用成功返回 ```{"Status": "OK"}``` ***（注意此步只是调用成功，而不是信息正确，内部的response_id为1才算彻底成功）***

#### 4.返回非Json信息，验证用户：
此步可以在您不方便使用Json解析工具的情况下验证用户的情况（快速，无需解析）：
```
$return = $apar->getUserStatus_noJson($name, $password);
```
此步可以获取用户输入的账户密码是否正确（方块盒子 Account）正确会返回： ```userVerifyToken```
**感谢您的使用！**
