<?php if (is_user_logged_in()) : ?>
    <h2><?php _e('you are already looged in as ', 'fawp') ?> <strong> <?php echo wp_get_current_user()->display_name ?></strong></h2>
    <a href="<?php echo wp_logout_url() ?>" class="btn btn-lg fusion-button button-default button-large"><?php _e('logout ??', 'fawp') ?></a>
<?php else : ?>
    <div id="firebaseui-auth-container"></div>   
<?php endif; ?>