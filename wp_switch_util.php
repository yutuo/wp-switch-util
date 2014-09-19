<?php
/**
Plugin Name: WP Switch Util
Plugin URI: http://yutuo.net/archives/f685d2dbbb176e86.html
Description: This plugin is code syntax highlighter based on <a href="http://ace.ajax.org/">Ace Editor</a> V1.0.3. Supported languages: Bash, C++, CSS, Delphi, Java, JavaScript, Perl, PHP, Python, Ruby, SQL, VB, XML, XHTML and HTML etc.
Version: 1.0.0
Author: yutuo
Author URI: http://yutuo.net
Text Domain: wp_su
Domain Path: /wp-switch-util
License: GPL v3 - http://www.gnu.org/licenses/gpl.html
*/

require_once (dirname(__FILE__) . '/inc/wp_switch_util_config.php');
class WPSwitchUtil {
    /** 本Plugin文件夹实际目录 */
    var $pluginDir;
    /** 本Plugin的URL路径 */
    var $currentUrl;
    /** 设置 */
    var $options;
    /** 构造函数 */
    function __construct() {
        $this->pluginDir = dirname(plugin_basename(__FILE__));
        $this->currentUrl = get_option('siteurl') . '/wp-content/plugins/' . basename(dirname(__FILE__));
        $this->options = get_option(WPSwitchUtilConfig::CONFIG_OPTIONS_KEY);
    }
    /** 启用 */
    function activate() {
        update_option(WPSwitchUtilConfig::CONFIG_OPTIONS_KEY, WPSwitchUtilConfig::$DEFAULT_OPTION);
    }
    /** 停用 */
    function deActivate() {
        delete_option(WPSwitchUtilConfig::CONFIG_OPTIONS_KEY);
    }
    /** 初始化 */
    function init() {
        load_plugin_textdomain('wp_su', false, $this->pluginDir . '/lang');
    }
    /** 应用插件 */
    function apply() {

    }

}

$switchUtil = new WPSwitchUtil();
$switchUtil->apply();