<?php
add_action('admin_menu', 'fawp_add_admin_menu');
add_action('admin_init', 'fawp_settings_init');

function fawp_add_admin_menu() {

    add_options_page('fireauth-wp', 'fire auth wp', 'manage_options', 'fireauth-wp', 'fawp_options_page');
}

function fawp_settings_init() {

    register_setting('pluginPage', 'fawp_settings');

    add_settings_section(
            'fawp_pluginPage_section', __('', 'fireauth-wp'), 'fawp_settings_section_callback', 'pluginPage'
    );

    add_settings_field(
            'fawp_textarea_field_0', __('Firebase config object', 'fireauth-wp'), 'fawp_textarea_field_0_render', 'pluginPage', 'fawp_pluginPage_section'
    );

    add_settings_field(
            'fawp_checkbox_field_1', __('Facebook login', 'fireauth-wp'), 'fawp_checkbox_field_1_render', 'pluginPage', 'fawp_pluginPage_section'
    );

    add_settings_field(
            'fawp_checkbox_field_2', __('Google login', 'fireauth-wp'), 'fawp_checkbox_field_2_render', 'pluginPage', 'fawp_pluginPage_section'
    );

    add_settings_field(
            'fawp_checkbox_field_3', __('Twitter login', 'fireauth-wp'), 'fawp_checkbox_field_3_render', 'pluginPage', 'fawp_pluginPage_section'
    );

    add_settings_field(
            'fawp_checkbox_field_4', __('Email Login', 'fireauth-wp'), 'fawp_checkbox_field_4_render', 'pluginPage', 'fawp_pluginPage_section'
    );

    add_settings_field(
            'fawp_select_field_5', __('login page', 'fireauth-wp'), 'fawp_select_field_5_render', 'pluginPage', 'fawp_pluginPage_section'
    );

    add_settings_field(
            'fawp_checkbox_field_6', __('override wordpress default login page ?', 'fireauth-wp'), 'fawp_checkbox_field_6_render', 'pluginPage', 'fawp_pluginPage_section'
    );
    
     add_settings_field(
            'fawp_checkbox_field_7', __('Enable CORS  ?', 'fireauth-wp'), 'fawp_checkbox_field_7_render', 'pluginPage', 'fawp_pluginPage_section'
    );
}

function fawp_textarea_field_0_render() {

    $options = get_option('fawp_settings');
    ?>
    <textarea cols='80' rows='8' name='fawp_settings[fawp_textarea_field_0]'> 
        <?php echo $options['fawp_textarea_field_0']; ?>
    </textarea>
    <?php
}

function fawp_checkbox_field_1_render() {

    $options = get_option('fawp_settings');
    ?>
    <input type='checkbox' name='fawp_settings[fawp_checkbox_field_1]' <?php checked($options['fawp_checkbox_field_1'], 'facebook.com'); ?> value='facebook.com'>
    <?php
}

function fawp_checkbox_field_2_render() {

    $options = get_option('fawp_settings');
    ?>
    <input type='checkbox' name='fawp_settings[fawp_checkbox_field_2]' <?php checked($options['fawp_checkbox_field_2'], 'google.com'); ?> value='google.com'>
    <?php
}

function fawp_checkbox_field_3_render() {

    $options = get_option('fawp_settings');
    ?>
    <input type='checkbox' name='fawp_settings[fawp_checkbox_field_3]' <?php checked($options['fawp_checkbox_field_3'], 'twitter.com'); ?> value='twitter.com'>
    <?php
}

function fawp_checkbox_field_4_render() {

    $options = get_option('fawp_settings');
    ?>
    <input type='checkbox' name='fawp_settings[fawp_checkbox_field_4]' <?php checked($options['fawp_checkbox_field_4'], 'password'); ?> value='password'>
    <?php
}

function fawp_select_field_5_render() {

    $options = get_option('fawp_settings');
    ?>
    <select name='fawp_settings[fawp_select_field_5]'>
        <?php
        $pages = get_pages();
        foreach ($pages as $page) {
            $option = '<option value="' . $page->post_name . '" ';
            $option .= selected($options['fawp_select_field_5'], $page->post_name) . '>';
            $option .= $page->post_title;
            $option .= '</option>';
            echo $option;
        }
        ?>

    </select>

    <?php
}

function fawp_checkbox_field_6_render() {

    $options = get_option('fawp_settings');
    ?>
    <input type='checkbox' name='fawp_settings[fawp_checkbox_field_6]' <?php checked($options['fawp_checkbox_field_6'], 1); ?> value='1'>
    <?php
}

function fawp_checkbox_field_7_render() {

    $options = get_option('fawp_settings');
    ?>
    <input type='checkbox' name='fawp_settings[fawp_checkbox_field_7]' <?php checked($options['fawp_checkbox_field_7'], 1); ?> value='1'>
    <?php
}

function fawp_settings_section_callback() {

    echo __('TODO include links and tut videos', 'fireauth-wp');
}

function fawp_options_page() {
    ?>
    <form action='options.php' method='post'>

        <h2>Firebase Auth WP Settings page</h2>

        <?php
        settings_fields('pluginPage');
        do_settings_sections('pluginPage');
        submit_button();
        ?>

    </form>
    <?php
}
?>