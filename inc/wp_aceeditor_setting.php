<?php
if ($_POST[WPSwitchUtilConfig::CONFIG_OPTIONS_KEY]) {
    $postOptions = $_POST[WPSwitchUtilConfig::CONFIG_OPTIONS_KEY];
    $this->options = $postOptions;
    update_option(WPSwitchUtilConfig::CONFIG_OPTIONS_KEY, $this->options);
}
?>

<div class="wrap">
    <h2><?php echo __('Wp-AceEditor', 'wp_ae') ?></h2>
    <div class="narrow">
        <form method="post">
            <p><?php echo __('Ace Editor is a fully functional self-contained code syntax highlighter developed in JavaScript.', 'wp_ae') ?></p>
            <h3><?php echo __('System Settings', 'wp_su') ?></h3>
            <p><?php echo __('Please enter your system config.', 'wp_su') ?></p>

            <table class="form-table">
                <tr>
                    <th scope="row"><?php echo __('Cache The Avatar', 'wp_su') ?></th>
                    <td>
                        <input type="checkbox" name="wp_su_options[cacheavatar]" id="wpSuCacheAvatar" value="1"
                            <?php echo ($this->options['cacheavatar'] == '1') ? 'checked' : '' ?>/>
                        <?php echo __('Cache Days:', 'wp_ae') ?>

                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php echo __('MDB5 Your Url', 'wp_su') ?></th>
                    <td>
                        <input type="checkbox" name="wp_su_options[mdb5url]" id="wpSuMdb5Url" value="1"
                            <?php echo ($this->options['mdb5url'] == '1') ? 'checked' : '' ?>/>
                        <?php echo __('Length:', 'wp_ae') ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php echo __('Disable Change The Word', 'wp_su') ?></th>
                    <td>
                        <input type="checkbox" name="wp_su_options[mdb5url]" id="wpSuMdb5Url" value="1"
                            <?php echo ($this->options['mdb5url'] == '1') ? 'checked' : '' ?>/>
                    </select></td>
                </tr>
                <tr>
                    <th scope="row"><?php echo __('Disable Auto Save', 'wp_su') ?></th>
                    <td>
                        <input type="checkbox" name="wp_su_options[mdb5url]" id="wpSuMdb5Url" value="1"
                            <?php echo ($this->options['mdb5url'] == '1') ? 'checked' : '' ?>/>
                    </select></td>
                </tr>
                <tr>
                    <th scope="row"><?php echo __('Disable hirstroy', 'wp_su') ?></th>
                    <td>
                        <input type="checkbox" name="wp_su_options[mdb5url]" id="wpSuMdb5Url" value="1"
                            <?php echo ($this->options['mdb5url'] == '1') ? 'checked' : '' ?>/>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php echo __('Don\'t display to un reg user', 'wp_su') ?></th>
                    <td>
                        <input type="checkbox" name="wp_su_options[mdb5url]" id="wpSuMdb5Url" value="1"
                            <?php echo ($this->options['mdb5url'] == '1') ? 'checked' : '' ?>/>
                    </td>
                </tr>
            </table>
            <p class="submit">
                <input name="submit" type="submit" class="button-primary"
                    value="<?php echo __('Save Changes', 'wp_ae') ?>" />
            </p>
        </form>
    </div>
</div>
