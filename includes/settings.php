<?php
add_action('admin_menu', 'fawp_add_admin_menu');
add_action('admin_init', 'fawp_settings_init');

function fawp_add_admin_menu() {

    add_options_page('fireauth-wp', 'fire auth wp', 'manage_options', 'fireauth-wp', 'fawp_options_page');
}

function fawp_settings_init() {

    register_setting('fawpPage', 'fawp_settings');

    add_settings_section(
            'fawp_fawpPage_section', __('', 'fawp'), 'fawp_settings_section_callback', 'fawpPage'
    );

    add_settings_field(
            'fawp_textarea_field_0', __('Firebase config object', 'fawp'), 'fawp_textarea_field_0_render', 'fawpPage', 'fawp_fawpPage_section'
    );

    add_settings_field(
            'fawp_checkbox_field_1', __('Facebook login', 'fawp'), 'fawp_checkbox_field_1_render', 'fawpPage', 'fawp_fawpPage_section'
    );

    add_settings_field(
            'fawp_checkbox_field_2', __('Google login', 'fawp'), 'fawp_checkbox_field_2_render', 'fawpPage', 'fawp_fawpPage_section'
    );

    add_settings_field(
            'fawp_checkbox_field_3', __('Twitter login', 'fawp'), 'fawp_checkbox_field_3_render', 'fawpPage', 'fawp_fawpPage_section'
    );

    add_settings_field(
            'fawp_checkbox_field_4', __('Email Login', 'fawp'), 'fawp_checkbox_field_4_render', 'fawpPage', 'fawp_fawpPage_section'
    );

    add_settings_field(
            'fawp_select_field_5', __('login page', 'fawp'), 'fawp_select_field_5_render', 'fawpPage', 'fawp_fawpPage_section'
    );

    add_settings_field(
            'fawp_checkbox_field_6', __('override wordpress default login page ?', 'fawp'), 'fawp_checkbox_field_6_render', 'fawpPage', 'fawp_fawpPage_section'
    );
    
     add_settings_field(
            'fawp_checkbox_field_7', __('Enable CORS  ?', 'fawp'), 'fawp_checkbox_field_7_render', 'fawpPage', 'fawp_fawpPage_section'
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
    $val = isset($options['fawp_checkbox_field_1']) ? $options['fawp_checkbox_field_1'] : 0;
    ?>
    <input type='checkbox' name='fawp_settings[fawp_checkbox_field_1]' <?php checked($val, 'facebook.com'); ?> value='facebook.com'>
    <?php
}

function fawp_checkbox_field_2_render() {

    $options = get_option('fawp_settings');
    $val = isset($options['fawp_checkbox_field_2']) ? $options['fawp_checkbox_field_2'] : 0;
    ?>
    <input type='checkbox' name='fawp_settings[fawp_checkbox_field_2]' <?php checked($val, 'google.com'); ?> value='google.com'>
    <?php
}

function fawp_checkbox_field_3_render() {

    $options = get_option('fawp_settings');
    $val = isset($options['fawp_checkbox_field_3']) ? $options['fawp_checkbox_field_3'] : 0;
    ?>
    <input type='checkbox' name='fawp_settings[fawp_checkbox_field_3]' <?php checked($val, 'twitter.com'); ?> value='twitter.com'>
    <?php
}

function fawp_checkbox_field_4_render() {

    $options = get_option('fawp_settings');
    $val = isset($options['fawp_checkbox_field_4']) ? $options['fawp_checkbox_field_4'] : 0;
    ?>
    <input type='checkbox' name='fawp_settings[fawp_checkbox_field_4]' <?php checked($val, 'password'); ?> value='password'>
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
    $val = isset($options['fawp_checkbox_field_6']) ? $options['fawp_checkbox_field_6'] : 0;
    ?>
    <input type='checkbox' name='fawp_settings[fawp_checkbox_field_6]' <?php checked($val, 1); ?> value='1'>
    <?php
}

function fawp_checkbox_field_7_render() {

    $options = get_option('fawp_settings');
    $val = isset($options['fawp_checkbox_field_7']) ? $options['fawp_checkbox_field_7'] : 0;
    ?>
    <input type='checkbox' name='fawp_settings[fawp_checkbox_field_7]' <?php checked($val, 1); ?> value='1'>
    <?php
}

function fawp_settings_section_callback() {

    echo __('TODO include links and tut videos', 'fawp');
}

function fawp_options_page() {
    ?>
    <form action='options.php' method='post'>

        <h2>Firebase Auth WP Settings page</h2>

        <?php
        settings_fields('fawpPage');
        do_settings_sections('fawpPage');
        submit_button();
        ?>

    </form>
    <?php
}
?>