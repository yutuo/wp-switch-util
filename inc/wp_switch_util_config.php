<?php
class WPSwitchUtilConfig {
    /** 保存的KEY */
    const CONFIG_OPTIONS_KEY = 'wp_su_options';

    /** 默认设置 */
    static $DEFAULT_OPTION = array (
            'convtag' => array('pre', 'code'),                              // 要转换的Tag
            'convtype' => array('lang', 'data-wpae', 'data-wpae-lang'),     // 要转换Tag的必要属性
            'inserttag' => 'pre',                                           // 自动插入的Tag
            'inserttype' => 'data-wpae',                                    // 自动插入Tag的属性
            'background' => '#ddd',                                         // 播入代码的背景
            'maxsavecnt' => 10,                                             // 语言最大保存

            'readonly' => true,             // 代码只读
            'theme' => 'monokai',           // 显示样式
            'lang' => 'text',               // 显示语言
            'tabsize' => 4,                 // Tab宽度
            'lineheight' => 120,            // 行高 %
            'fontsize' => 12,               // 文字大小
            'wrap' => false,                // 自动换行
            'print' => 80,                  // 打印边界大小
            'width' => '99%',               // 显示宽度
            'tabtospace' => true,           // Tab转换成空格显示
            'fold' => false,                // 默认收缩
            'indent' => true,               // 缩进边界显示
            'gutter' => true,               // 显示行号
            'active' => true,               // 活动行高亮显示
            'foldstyle' => 'markbegin',     // 代码收缩样式
    );
}