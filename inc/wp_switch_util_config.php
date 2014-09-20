<?php
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
            //'unregistered' => '0',
            'adminbar' => '0',
    );
}