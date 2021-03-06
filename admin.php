<?php
  add_action('admin_menu', 'bp_psb_plugin_profile_social_buttons_menu');
  add_action( 'network_admin_menu', 'bp_psb_plugin_profile_social_buttons_menu' );

  function bp_psb_plugin_profile_social_buttons_menu() {
    add_submenu_page( 'bp-general-settings', 'BuddyPress Profile Social Buttons', 'BuddyPress Profile Social Buttons', 'manage_options', 'bp-psb', 'bppsb_plugin_profile_social_buttons_options');
    //call register settings function
    add_action( 'admin_init', 'bppsb_register_settings' );
  }

  function bppsb_register_settings() {
    foreach (glob(dirname( __FILE__ ) . '/networks/*-admin-settings.php') as $filename) {
      if (is_file($filename)) {
          require $filename;
      }
    }//register our settings
  }

  function bppsb_plugin_profile_social_buttons_options() {
    if (!current_user_can('manage_options'))  {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }

    if ( !empty( $_GET['settings-updated'] ) ) : ?>
      <div id="message" class="updated">
        <p><strong><?php _e('Buddypress Profile Social Buttons Settings have been saved.' ); ?></strong></p>
      </div>
    <?php endif; ?>
    <div class="wrap">
      <h2>
        <?php _e('BuddyPress Profile Social Buttons Settings', 'bppsb') ?>
      </h2>
      <p><?php _e('The plugin uses Buddypress XProfile Fields and requires you to name the "Mirror Profile Field Title" below the same as your custom Profile Field Title - Please read the <a href="http://wordpress.org/extend/plugins/buddypress-facebook/installation/" target="_blank" title="Opens in a new tab">plugin installation instructions</a> if you are not sure what to do.', 'bppsb') ?></p>
      <form method="post" action="<?php echo admin_url('options.php');?>">
        <?php wp_nonce_field('update-options'); ?>
        <table class="form-table">
          <hr></hr>
          <?php settings_fields( 'bppsb_plugin_profile_social_buttons_options' ); ?>
          <?php do_settings_sections( 'bppsb_plugin_profile_social_buttons_options' ); ?>
          <?php 
          foreach (glob(dirname( __FILE__ ) . '/networks/*-admin.php') as $filename) {
              if (is_file($filename)) {
                  require $filename;
              }
          } ?>
          <p><colored-text style="color: green;">Quick links:</colored-text> Visit <a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=bp-profile-setup&group_id=1&mode=add_field" target="_blank" title="opens in a new tab">Add Field</a> to set up a new XProfile field or <a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=bp-profile-setup" target="_blank" title="opens in a new tab">Extended Profile Fields</a> to edit a existing field</p>
          <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Component Settings') ?>" />
          </p>
        </form>
       
      </form>

    </div>

<?php } ?>