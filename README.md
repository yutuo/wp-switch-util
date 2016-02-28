wp-switch-util
==============

#### Description

This plugin can: 

* Cache avatars
* Set url to title's MDB5 code
* Disable change half to full
* Disable auto save
* Disable hirstroy
* Disable pingback in site
* Disable the admin bar
* Enable the link manager

这个插件实现了以下功能：

* 缓存头像
* Url使用标题的MDB5码
* 禁用半角转换到全角
* 禁用自动保存
* 禁用历史版本
* 禁止站内Pingback
* 不显示admin bar
* 启用友情链接


#### Installation

**Installation**

1. Upload the plugin files to the `/wp-content/plugins/wp-switch-util` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Settings->Wp Switch Util screen to configure the plugin

**安装方法**

1. 上传本插件文件到`/wp-content/plugins/wp-switch-util`目录，或者通过Wordpress插件安装画面自动安装。
2. 在插件管理画面启用本插件。
3. 在设置画面（Settings->Wp Switch Util）设置本插件。


#### Changelog

**0.2.0**

* Add feature "Enable the link manager"
* 添加启用友情链接功能

**0.1.0**

* Fixed the bug that can't disable revision.
* 解决版本更新的问题

**0.0.3**

* Fixed the bug that can't disable auto save.
* 解决自动保存的BUG

**0.0.2**

* Upgrade the bug that the plugin can't cache avatar on HTTPS protocol.
* Change the folder that avatar is cached to `/cache/avatar`.
* 解决HTTPS协议下不能缓存头像的问题。
* 修改缓存头像目录到`/cache/avatar`。

**0.0.1**

* New.