<?php

/**
 * Plugin Name: WP Switch Util
 * Plugin URI: http://yutuo.net/archives/f685d2dbbb176e86.html
 * Description: This plugin can: cache the avatar, format you url, disable the histroy, disable auto save, disable admin bar
 * Version: 1.2.0
 * Author: yutuo
 * Author URI: http://yutuo.net
 * Text Domain: wp_su
 * Domain Path: /wp-switch-util
 * License: GPL v3 - http://www.gnu.org/licenses/gpl.html
 */
class WPSwitchUtilConfig
{
    /** 保存的KEY */
    const CONFIG_OPTIONS_KEY = 'wp_su_options';

    /** 默认设置 */
    static $DEFAULT_OPTION = array(
        'cacheavatar' => '0',
        'cacheday' => '15',
        'mdb5url' => '0',
        'mdb5length' => '16',
		'mdb5typepost' => '1',
		'mdb5typepage' => '0',
        'changeword' => '0',
        'autosave' => '0',
        'hirstroy' => '0',
        'pingback' => '0',
        'adminbar' => '0',
        'linkmanager' => '0',
        'autopcontent' => '0',
        'autopcomment' => '0',
		'reguseronly' => '0',
        'disableemoji' => '0',
    );
	
	/** 注册用户页面 */
    static $REG_USER_ONLY_PAGES = array(
        'wp-login.php',
        'wp-register.php',
    );
}

class WPSwitchUtil
{
    /** 本Plugin文件夹实际目录 */
    var $pluginDir;
    /** 本Plugin的URL路径 */
    var $currentUrl;
    /** 设置 */
    var $options;

    /** 构造函数 */
    function __construct()
    {
        $this->pluginDir = dirname(plugin_basename(__FILE__));
        $this->currentUrl = get_option('siteurl') . '/wp-content/plugins/' . basename(dirname(__FILE__));
        $this->options = get_option(WPSwitchUtilConfig::CONFIG_OPTIONS_KEY);
    }
	
	/** 读取设置值，没有设置值时，读取初始值 */
	function getOption($key) {
		if (array_key_exists($key, $this->options)) {
			return $this->options[$key];
		} else {
			return WPSwitchUtilConfig::$DEFAULT_OPTION[$key];
		}
	}

    /** 启用 */
    function activate()
    {
        update_option(WPSwitchUtilConfig::CONFIG_OPTIONS_KEY, WPSwitchUtilConfig::$DEFAULT_OPTION);
    }

    /** 停用 */
    function deActivate()
    {
        delete_option(WPSwitchUtilConfig::CONFIG_OPTIONS_KEY);
    }


    /** 初始化 */
    function init()
    {
        load_plugin_textdomain('wp_su', false, plugin_basename(dirname(__FILE__)) . '/lang');
    }

    /** 在设置菜单添加链接 */
    function menuLink()
    {
        add_options_page('Wp Switch Util Settings', __('Wp Switch Util', 'wp_su'), 'manage_options', 'wpSwitchUtil',
            array($this, 'optionPage'));
    }

    /** 插件设置链接 */
    function actionLink($links, $file)
    {
        if ($file != plugin_basename(__FILE__)) {
            return $links;
        }
        $settings_link = '<a href="options-general.php?page=wpSwitchUtil">' . __('Settings') . '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    /** 插件设置页面 */
    function optionPage()
    {
        $current_path = dirname(__FILE__) . '/inc/wp_switch_util_setting.php';
        include $current_path;
    }

    /** 头像缓存 */
    function cacheAvatar($avatar, $id_or_email, $size, $default)
    {
        // URL目录地址
        $current_path = content_url() . '/cache/avatar/';
        // 保存目录
        $out_folder = WP_CONTENT_DIR . '/cache/avatar/';
        if (!file_exists($out_folder)) {
            mkdir($out_folder, 0777, true);
        }
        // 保存日数
        $save_day = array_key_exists('cacheday', $this->options) ? $this->options['cacheday'] : '15';

        $match = array();
        while (preg_match('/([\'"])(http[s]?:\/\/[\w]+\.gravatar\.com\/avatar\/\w*\?s=\d+[^\'" ]+)( \d+x)?\1/i', $avatar, $match)) {
            $url = $match[2];
            $out_file_url = $this->getImageFilesToDisk($url, $out_folder, $save_day);
            if (strlen($out_file_url) === 0) {
                return $avatar;
            } else {
                $avatar = str_replace($url, $current_path . $out_file_url, $avatar);
            }
        }

        return $avatar;
    }

    /** MDB5的URL */
    function mdb5Url($postname)
    {
        $post_title = $_POST['post_title'];
		$post_type = $_POST['post_type'];
		$setting_key = 'mdb5type' . $post_type;
		
		if (array_key_exists($setting_key, $this->options) && $this->options[$setting_key] == '1') {
			$str = mb_convert_encoding($post_title, 'UTF-8');
			$md5_str = md5($str);

			$length = array_key_exists('mdb5length', $this->options) ? intval($this->options['mdb5length']) : 16;

			$md5_str = substr($md5_str, intval((32 - $length) / 2), $length);
			return $md5_str;
		} else {
			return $postname;
		}
    }

    /** 不转换半角到全角 */
    function changeWord()
    {
        $filters_to_remove = array(
            'comment_author', 'term_name', 'link_name', 'link_description', 'link_notes', 'bloginfo', 'wp_title', 'widget_title',
            'single_post_title', 'single_cat_title', 'single_tag_title', 'single_month_title', 'nav_menu_attr_title', 'nav_menu_description',
            'term_description',
            'the_title', 'the_content', 'the_excerpt', 'comment_text', 'list_cats'
        );

        foreach ($filters_to_remove as $a_filter) {
            remove_filter($a_filter, 'wptexturize');
        }
    }

    /** 禁止自动保存 */
    function disableAutoSave()
    {
        wp_deregister_script('autosave');
    }

    /** 阻止站内文章Pingback */
    function disablePingbackSelf(&$links)
    {
        $home = get_option('home');
        foreach ($links as $l => $link) {
            if (0 === strpos($link, $home)) {
                unset($links[$l]);
            }
        }

    }

    /** 不显示AdminBar */
    function hideAdminBar()
    {
        return false;
    }
	
	/** 仅注册用户可以访问 */
	function regUserOnly() {
		if (current_user_can('read')) {
			return;
		}

		if (in_array(basename($_SERVER['PHP_SELF']), WPSwitchUtilConfig::$REG_USER_ONLY_PAGES)) {
			return;
		}

		auth_redirect();
	}
	
	public function loginFormMessage() {
		if ('wp-login.php' != basename($_SERVER['PHP_SELF']) || !empty($_POST) || (!empty($_GET) && empty($_GET['redirect_to']))) {
			return;
		}

		$redirectTo = $_GET['redirect_to'];
		if (strpos($redirectTo, get_admin_url()) === 0) {
			return;
		}
        global $error;
        $error = __('Only registered and logged in users are allowed to view this site. Please log in now.', 'wp_su');
	}

    /** 删除表情 */
    function disableEmojis() {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
        add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
    }
    function disable_emojis_tinymce( $plugins ) {
        if (is_array( $plugins )) {
            return array_diff($plugins, array('wpemoji'));
        } else {
            return array();
        }
    }
    /** 应用插件 */
    function apply()
    {
        // 启用
        register_activation_hook(__FILE__, array($this, 'activate'));
        // 停用
        register_deactivation_hook(__FILE__, array($this, 'deActivate'));
        // 初始化
        add_action('init', array($this, 'init'));
        // 管理页面
        add_action('admin_menu', array($this, 'menuLink'));
        // 插件链接
        add_action('plugin_action_links', array($this, 'actionLink'), 10, 2);

        if (!is_array($this->options)) {
            return;
        }
        // 头像缓存
		if ($this->getOption('cacheavatar') == '1') {
            add_filter('get_avatar', array($this, 'cacheAvatar'), 10, 4);
        }
        // MDB5的URL
		if ($this->getOption('mdb5url') == '1') {
            add_filter('name_save_pre', array($this, 'mdb5Url'));
        }
        // 不转换半角到全角
		if ($this->getOption('changeword') == '1') {
            $this->changeWord();
        }
        // 禁止自动保存
		if ($this->getOption('autosave') == '1') {
            add_action('wp_print_scripts', array($this, 'disableAutoSave'));
        }
        // 禁止历史版本
		if ($this->getOption('hirstroy') == '1') {
            remove_action('post_updated', 'wp_save_post_revision');
        }
        // 阻止站内文章Pingback
		if ($this->getOption('pingback') == '1') {
            add_action('pre_ping', array($this, 'disablePingbackSelf'));
        }
        // 不显示AdminBar
		if ($this->getOption('adminbar') == '1') {
            add_filter('show_admin_bar', array($this, 'hideAdminBar'));
        }
        // 启用友情链接
		if ($this->getOption('linkmanager') == '1') {
            add_filter('pre_option_link_manager_enabled', '__return_true');
        }
        // 禁用文章自动添加
		if ($this->getOption('autopcontent') == '1') {
            remove_filter('the_content', 'wpautop');
        }
        // 禁用评论自动添加
		if ($this->getOption('autopcomment') == '1') {
            remove_filter('comment_text', 'wpautop');
        }
		// 仅注册用户可以访问
        if ($this->getOption('reguseronly') == '1') {
			add_action('wp', array($this, 'regUserOnly'));
            add_action('init', array($this, 'loginFormMessage'));
        }
        // 删除表情
        if ($this->getOption('disableemoji') == '1') {
            add_action('init', array($this, 'disableEmojis'));
        }
    }

    function getImageFilesToDisk($url, $out_folder, $save_day)
    {
        $url = str_replace('&amp;', '&', $url);
        // 图片文件名取得
        if (!preg_match('/\/avatar\/(\w*)\?s=(\d+).*?(r=\w)?/i', $url, $match)) {
            return '';
        }

        $pre_file_name = $match[1];
        $size = $match[2];
        $level = count($match) >= 3 ? $match[3] : 'r=g';
        $out_folder = $out_folder . $size . '/';
        if (!file_exists($out_folder)) {
            mkdir($out_folder, 0777, true);
        }

        if (strlen($pre_file_name) === 0) {
            return $this->getDftImageFilesToDisk($out_folder, $size);
        }

        $file_name = $pre_file_name . '.png';
        $file_path = $out_folder . $file_name;

        $save_time = intval($save_day) * 24 * 60 * 60;
        if (!file_exists($file_path) || ($save_time > 0 && time() - filemtime($file_path)) > $save_time) {
            $url_get = "http://www.gravatar.com/avatar/{$pre_file_name}?s=${size}&${level}";
            $avatarContent = $this->curl_file_get_contents($url_get);
            file_put_contents($file_path, $avatarContent);
            if (filesize($file_path) == 0) {
                unlink($file_path);
                return $this->getDftImageFilesToDisk($out_folder, $size);;
            }
        }

        return $size . '/' . $file_name;
    }

    function getDftImageFilesToDisk($out_folder, $size)
    {
        $url = "http://www.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=${size}&r=g";
        $file_name = 'ad516503a11cd5ca435acc9bb6523536.png';
        $file_path = $out_folder . $file_name;

        if (!file_exists($file_path)) {
            $avatarContent = $this->curl_file_get_contents($url);
            file_put_contents($file_path, $avatarContent);
            if (filesize($file_path) == 0) {
                unlink($file_path);
                return '';
            }
        }

        return $size . '/' . $file_name;
    }

    function curl_file_get_contents($durl)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $durl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_USERAGENT, _USERAGENT_);
        curl_setopt($ch, CURLOPT_REFERER, _REFERER_);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $r = curl_exec($ch);
        curl_close($ch);
        return $r;
    }
}

$switchUtil = new WPSwitchUtil();
$switchUtil->apply();
