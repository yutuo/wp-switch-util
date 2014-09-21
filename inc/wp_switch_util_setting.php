<?php
if ($_POST[WPSwitchUtilConfig::CONFIG_OPTIONS_KEY]) {
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
                            <?php echo ($this->options['cacheavatar'] == '1') ? 'checked' : '' ?>/>
                        <?php echo __('Cache Days:', 'wp_su') ?>
                        <input type="number" name="wp_su_options[cacheday]" id="wpSuCacheDay" min="0" max="999"
                            value="<?php echo $this->options['cacheday']; ?>" required="required"/>
                        <?php echo __('If you set 0, it\'s will no referce.', 'wp_su') ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php echo __('MDB5 Your Url', 'wp_su') ?></th>
                    <td>
                        <input type="checkbox" name="wp_su_options[mdb5url]" id="wpSuMdb5Url" value="1"
                            <?php echo ($this->options['mdb5url'] == '1') ? 'checked' : '' ?>/>
                        <?php echo __('Length:', 'wp_su') ?>
                        <input type="number" name="wp_su_options[mdb5length]" id="wpSuMdb5Length" min="16" max="32"
                            value="<?php echo $this->options['mdb5length']; ?>" required="required"/>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php echo __('Disable Change The Word', 'wp_su') ?></th>
                    <td>
                        <input type="checkbox" name="wp_su_options[changeword]" id="wpSuChangeWord" value="1"
                            <?php echo ($this->options['changeword'] == '1') ? 'checked' : '' ?>/>
                    </select></td>
                </tr>
                <tr>
                    <th scope="row"><?php echo __('Disable Auto Save', 'wp_su') ?></th>
                    <td>
                        <input type="checkbox" name="wp_su_options[autosave]" id="wpSuAutoSave" value="1"
                            <?php echo ($this->options['autosave'] == '1') ? 'checked' : '' ?>/>
                    </select></td>
                </tr>
                <tr>
                    <th scope="row"><?php echo __('Disable hirstroy', 'wp_su') ?></th>
                    <td>
                        <input type="checkbox" name="wp_su_options[hirstroy]" id="wpSuHirstroy" value="1"
                            <?php echo ($this->options['hirstroy'] == '1') ? 'checked' : '' ?>/>
                    </td>
                </tr>
				<tr>
                    <th scope="row"><?php echo __('Disable pingback in site', 'wp_su') ?></th>
                    <td>
                        <input type="checkbox" name="wp_su_options[pingback]" id="wpSuPingback" value="1"
                            <?php echo ($this->options['pingback'] == '1') ? 'checked' : '' ?>/>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php echo __('Don\'t display the admin bar', 'wp_su') ?></th>
                    <td>
                        <input type="checkbox" name="wp_su_options[adminbar]" id="wpSuAdminBar" value="1"
                            <?php echo ($this->options['adminbar'] == '1') ? 'checked' : '' ?>/>
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
        }
        document.getElementById('wpSuCacheAvatar').onclick = setDisable;
        document.getElementById('wpSuMdb5Url').onclick = setDisable;
        setDisable();
    </script>
</div>
