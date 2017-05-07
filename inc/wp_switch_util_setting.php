<?php
if (isset($_POST) && array_key_exists(WPSwitchUtilConfig::CONFIG_OPTIONS_KEY, $_POST)) {
    $postOptions = $_POST[WPSwitchUtilConfig::CONFIG_OPTIONS_KEY];
    $this->options = $postOptions;
    update_option(WPSwitchUtilConfig::CONFIG_OPTIONS_KEY, $this->options);
}
?>

<div class="wrap">
    <h2><?php echo __('Wp Switch Util', 'wp_su') ?></h2>
    <div class="narrow">
        <form method="post">
            <p><?php echo __('This plugin can: cache the avatar, format you url, disable the histroy, disable auto save, disable admin bar', 'wp_su') ?></p>
            <h3><?php echo __('System Settings', 'wp_su') ?></h3>
            <p><?php echo __('Please enter your system config.', 'wp_su') ?></p>

            <table class="form-table">
                <tr>
                    <th scope="row"><?php echo __('Cache The Avatar', 'wp_su') ?></th>
                    <td>
                        <input type="checkbox" name="wp_su_options[cacheavatar]" id="wpSuCacheAvatar" value="1"
                            <?php echo ($this->getOption('cacheavatar') == '1') ? 'checked' : '' ?>/>
                        <?php echo __('Cache Days:', 'wp_su') ?>
                        <input type="number" name="wp_su_options[cacheday]" id="wpSuCacheDay" min="0" max="999"
                            value="<?php echo $this->getOption('cacheday'); ?>" required="required"/>
                        <?php echo __('If you set 0, it\'s will no referce.', 'wp_su') ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php echo __('MDB5 Your Url', 'wp_su') ?></th>
                    <td>
                        <input type="checkbox" name="wp_su_options[mdb5url]" id="wpSuMdb5Url" value="1"
                            <?php echo ($this->getOption('mdb5url') == '1') ? 'checked' : '' ?>/>
                        <?php echo __('Length:', 'wp_su') ?>
                        <input type="number" name="wp_su_options[mdb5length]" id="wpSuMdb5Length" min="16" max="32"
                            value="<?php echo $this->getOption('mdb5length'); ?>" required="required"/>
						
						<label><?php echo __('MDB5 Type', 'wp_su') ?></label>
						<input type="checkbox" name="wp_su_options[mdb5typepost]" id="wpSuMdb5TypePost" value="1"
                            <?php echo ($this->getOption('mdb5typepost') == '1') ? 'checked' : '' ?>/>
						<label for="wpSuMdb5TypePost"><?php echo __('Post', 'wp_su') ?></label>
						<input type="checkbox" name="wp_su_options[mdb5typepage]" id="wpSuMdb5TypePage" value="1"
                            <?php echo ($this->getOption('mdb5typepage') == '1') ? 'checked' : '' ?>/>
						<label for="wpSuMdb5TypePage"><?php echo __('Page', 'wp_su') ?></label>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php echo __('Disable Change The Word', 'wp_su') ?></th>
                    <td>
                        <input type="checkbox" name="wp_su_options[changeword]" id="wpSuChangeWord" value="1"
                            <?php echo ($this->getOption('changeword') == '1') ? 'checked' : '' ?>/>
                    </select></td>
                </tr>
                <tr>
                    <th scope="row"><?php echo __('Disable Auto Save', 'wp_su') ?></th>
                    <td>
                        <input type="checkbox" name="wp_su_options[autosave]" id="wpSuAutoSave" value="1"
                            <?php echo ($this->getOption('autosave') == '1') ? 'checked' : '' ?>/>
                    </select></td>
                </tr>
                <tr>
                    <th scope="row"><?php echo __('Disable hirstroy', 'wp_su') ?></th>
                    <td>
                        <input type="checkbox" name="wp_su_options[hirstroy]" id="wpSuHirstroy" value="1"
                            <?php echo ($this->getOption('hirstroy') == '1') ? 'checked' : '' ?>/>
                    </td>
                </tr>
				<tr>
                    <th scope="row"><?php echo __('Disable pingback in site', 'wp_su') ?></th>
                    <td>
                        <input type="checkbox" name="wp_su_options[pingback]" id="wpSuPingback" value="1"
                            <?php echo ($this->getOption('pingback') == '1') ? 'checked' : '' ?>/>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php echo __('Don\'t display the admin bar', 'wp_su') ?></th>
                    <td>
                        <input type="checkbox" name="wp_su_options[adminbar]" id="wpSuAdminBar" value="1"
                            <?php echo ($this->getOption('adminbar') == '1') ? 'checked' : '' ?>/>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php echo __('Enable the link manager', 'wp_su') ?></th>
                    <td>
                        <input type="checkbox" name="wp_su_options[linkmanager]" id="wpSuLinkManager" value="1"
                            <?php echo ($this->getOption('linkmanager') == '1') ? 'checked' : '' ?>/>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php echo __('Disable auto p', 'wp_su') ?></th>
                    <td>
                        <input type="checkbox" name="wp_su_options[autopcontent]" id="wpAutoPContent" value="1"
                            <?php echo ($this->getOption('autopcontent') == '1') ? 'checked' : '' ?>/>
						<label for="wpAutoPContent"><?php echo __('Content', 'wp_su') ?></label>
                        <input type="checkbox" name="wp_su_options[autopcomment]" id="wpAutoPComment" value="1"
                            <?php echo ($this->getOption('autopcomment') == '1') ? 'checked' : '' ?>/>
						<label for="wpAutoPComment"><?php echo __('Comment', 'wp_su') ?></label>
                    </td>
                </tr>
				<tr>
                    <th scope="row"><?php echo __('Registered user only', 'wp_su') ?></th>
                    <td>
                        <input type="checkbox" name="wp_su_options[reguseronly]" id="wpRegUserOnly" value="1"
                            <?php echo ($this->getOption('reguseronly') == '1') ? 'checked' : '' ?>/>
                    </td>
                </tr>
            </table>
            <p class="submit">
                <input name="submit" type="submit" class="button-primary"
                    value="<?php echo __('Save Changes', 'wp_su') ?>" />
            </p>
        </form>
    </div>
    <script type="text/javascript">
        function setDisable() {
            document.getElementById('wpSuCacheDay').disabled = !document.getElementById('wpSuCacheAvatar').checked;
            document.getElementById('wpSuMdb5Length').disabled = !document.getElementById('wpSuMdb5Url').checked;
			document.getElementById('wpSuMdb5TypePost').disabled = !document.getElementById('wpSuMdb5Url').checked;
			document.getElementById('wpSuMdb5TypePage').disabled = !document.getElementById('wpSuMdb5Url').checked;			
        }
        document.getElementById('wpSuCacheAvatar').onclick = setDisable;
        document.getElementById('wpSuMdb5Url').onclick = setDisable;
        setDisable();
    </script>
</div>
