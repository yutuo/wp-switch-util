<?php
/**
Plugin Name: WP Switch Util
Plugin URI: http://yutuo.net/archives/f685d2dbbb176e86.html
Description: This plugin can: cache the avatar, format you url, disable the histroy, disable auto save, disable admin bar
Version: 1.0.0
Author: yutuo
Author URI: http://yutuo.net
Text Domain: wp_su
Domain Path: /wp-switch-util
License: GPL v3 - http://www.gnu.org/licenses/gpl.html
*/
class WPSwitchUtilConfig {
    /** 保存的KEY */
    const CONFIG_OPTIONS_KEY = 'wp_su_options';

    /** 默认设置 */
    static $DEFAULT_OPTION = array (
            'cacheavatar' => '0',
            'cacheday' => '15',
            'mdb5url' => '0',
            'mdb5length' => '16',   
            'changeword' => '0',
            'autosave' => '0',
            'hirstroy' => '0',
            'pingback' => '0',
            'adminbar' => '0',
			
    );
}

class WPSwitchUtil {
    /** 本Plugin文件夹实际目录 */
    var $pluginDir;
    /** 本Plugin的URL路径 */
    var $currentUrl;
    /** 设置 */
    var $options;
    /** 构造函数 */
    function WPSwitchUtil() {
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
    /** 在设置菜单添加链接 */
    function menuLink() {
        add_options_page('Wp Switch Util Settings', __('Wp Switch Util', 'wp_su'), 'manage_options', 'wpSwitchUtil',
                        array ($this, 'optionPage'));
    }
    /** 插件设置链接 */
    function actionLink($links, $file) {
        if ($file != plugin_basename(__FILE__)) {
            return $links;
        }
        $settings_link = '<a href="options-general.php?page=wpSwitchUtil">' . __('Settings') . '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }
    /** 插件设置页面 */
    function optionPage() {
        $current_path = dirname(__FILE__) . '/inc/wp_switch_util_setting.php';
        include $current_path;
    }
    /** 头像缓存 */
    function cacheAvatar($avatar, $id_or_email, $size, $default) {
        // URL目录地址
        $current_path = get_option('siteurl') . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/caches/' . $size . '/';    
        // 保存目录
        $out_folder = dirname(__FILE__) . '/caches/' . $size . '/'; 
        if (!file_exists($out_folder)) {
            mkdir($out_folder, 0777, true);
        }
        $match = array();
    
        // 默认图片名取得
        if (!preg_match('/\/avatar\/(\w+)\?/i', $default, $match)) {
            $default = "http://www.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=$size&d=monsterid&r=G";
            $match[1] = 'ad516503a11cd5ca435acc9bb6523536';
        }
        
        $pre_dflt_file_name = $match[1];
        $dflt_file_name = $pre_dflt_file_name . '.png';
        $dflt_file_path = $out_folder . $dflt_file_name;
        
        if (!file_exists($dflt_file_path)) {
            $avatarContent = $this->curl_file_get_contents($default);
            file_put_contents($dflt_file_path, $avatarContent);
            if (filesize($dflt_file_path) == 0) {
                unlink($dflt_file_path);
                return $avatar;
            }
        }
        
        // 图片URL地址取得
        if (!preg_match('/src=[\'\"]([^\'\"]+)[\'\"]/i', $avatar, $match)) {
            return $avatar;
        }
        $url = $match[1];
        $url = str_replace('&amp;', '&', $url);
        // 图片文件名取得  
        if (!preg_match('/\/avatar\/(\w+)\?/i', $url, $match)) {
            return $avatar;
        }
        
        $pre_file_name = $match[1];
        $file_name = $pre_file_name . '.png';
        $file_path = $out_folder . $file_name;
        
        // 图片的URL地址
        $output_url = $current_path . $file_name;

        $save_day = array_key_exists('cacheday', $this->options) ? $this->options['cacheday'] : '15';
        $save_time = intval($save_day) * 24 * 60 * 60;
        if (!file_exists($file_path) || ($save_time > 0 && time() - filemtime($file_path)) > $save_time) {
            $avatarContent = $this->curl_file_get_contents($url);
            file_put_contents($file_path, $avatarContent);
            if (filesize($file_path) == 0) {
                unlink($file_path);
                // 默认图片的URL地址
                $output_url = $current_path . $dflt_file_name;
            }
        }
        return preg_replace('/(src=[\'\"])([^\'\"]+)([\'\"])/i', '${1}' . $output_url . '?${3}', $avatar);
    }
    /** MDB5的URL */
    function mdb5Url($postname) {
        $post_title = $_POST['post_title'];
        $str = mb_convert_encoding($post_title, 'UTF-8');
        $md5_str = md5($str);

        $length = array_key_exists('mdb5length', $this->options) ? intval($this->options['mdb5length']) : 16;

        $md5_str = substr($md5_str, intval((32 - $length) / 2), $length);
        return $md5_str;
    }
    /** 不转换半角到全角 */
    function changeWord() {
        $filters_to_remove = array(
            'comment_author', 'term_name', 'link_name', 'link_description', 'link_notes', 'bloginfo', 'wp_title', 'widget_title',
            'single_post_title', 'single_cat_title', 'single_tag_title', 'single_month_title', 'nav_menu_attr_title', 'nav_menu_description',
            'term_description',
            'the_title', 'the_content', 'the_excerpt', 'comment_text', 'list_cats'
        );

        foreach ($filters_to_remove as $a_filter){
            remove_filter($a_filter, 'wptexturize');
        }
    }
    /** 禁止自动保存 */
    function disableAutoSave() {
        wp_deregister_script('autosave');
    }
	/** 阻止站内文章Pingback */
	function disablePingbackSelf(&$links) {
	    $home = get_option('home');
	    foreach ($links as $l => $link) {
		    if (0 === strpos($link, $home)) {
			    unset($links[$l]);
			}
		}
	        
	}
    /** 不显示AdminBar */
    function hideAdminBar() {
        return false;
    }
    /** 应用插件 */
    function apply() {
        // 启用
        register_activation_hook(__FILE__, array ($this, 'activate'));
        // 停用
        register_deactivation_hook(__FILE__, array ($this, 'deActivate'));
        // 初始化
        add_action('init', array ($this, 'init'));
        // 管理页面
        add_action('admin_menu', array ($this, 'menuLink'));
        // 插件链接
        add_action('plugin_action_links', array ($this, 'actionLink'), 10, 2);

        if (!is_array($this->options)) {
            return;
        }
        // 头像缓存
        if (array_key_exists('cacheavatar', $this->options) && $this->options['cacheavatar'] == '1') {
            add_filter('get_avatar', array($this, 'cacheAvatar'), 10, 4);
        }
        // MDB5的URL
        if (array_key_exists('mdb5url', $this->options) && $this->options['mdb5url'] == '1') {
            add_filter('name_save_pre', array ($this, 'mdb5Url'));
        }
        // 不转换半角到全角
        if (array_key_exists('changeword', $this->options) && $this->options['changeword'] == '1') {
            $this->changeWord();
        }
        // 禁止自动保存
        if (array_key_exists('autosave', $this->options) && $this->options['autosave'] == '1') {
            define('AUTOSAVE_INTERVAL', 36000000);
            add_action('wp_print_scripts', array ($this, 'disableAutoSave'));
        }
        // 禁止历史版本
        if (array_key_exists('hirstroy', $this->options) && $this->options['hirstroy'] == '1') {
            define('WP_POST_REVISIONS', false );
        }
        // 阻止站内文章Pingback
		if (array_key_exists('pingback', $this->options) && $this->options['pingback'] == '1') {
            add_action('pre_ping', array ($this, 'disablePingbackSelf'));   
        }
        // 不显示AdminBar
        if (array_key_exists('adminbar', $this->options) && $this->options['adminbar'] == '1') {
            add_filter('show_admin_bar', array ($this, 'hideAdminBar'));
        }
    }

    function curl_file_get_contents($durl) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $durl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_USERAGENT, _USERAGENT_);
        curl_setopt($ch, CURLOPT_REFERER,_REFERER_);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $r = curl_exec($ch);
        curl_close($ch);
        return $r;
    }
}

$switchUtil = new WPSwitchUtil();
$switchUtil->apply();
