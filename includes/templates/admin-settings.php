<?php 
    if ( isset( $_POST['submit'] ) ) {
        if ( ! wp_verify_nonce( $_POST['admin_settings_nonce'], 'weDevs_admin_settings' ) ) {
            _e( 'Nonce verify has been failed', 'weDevs' );
            return;
        }

        $name    = isset( $_POST['weDevs_name'] ) ? sanitize_text_field( $_POST['weDevs_name'] )      : '';
        $email   = isset( $_POST['weDevs_email'] ) ? sanitize_text_field( $_POST['weDevs_email'] )    : '';
        $options = isset( $_POST['weDevs_options'] ) ? sanitize_text_field( $_POST['weDevs_options'] ): '';

        $post_array = array( 
            'weDevs_name'    => $name,
            'weDevs_email'   => $email,
            'weDevs_options' => $options
         );
        
        update_option( 'admin_settings', $post_array );

    }

    $settings_data = get_option( 'admin_settings', array() );
    $options_value = $settings_data['weDevs_options'] ?? '1';
?>

<div class="wrap">
    <h2><?php _e( 'Admin Settings', 'weDevs' ); ?></h2>
    <form action="<?php echo esc_url( admin_url() ); ?>admin.php?page=admin_settings" method="post">
        <?php wp_nonce_field( 'weDevs_admin_settings', 'admin_settings_nonce' ); ?>
        <table class="form-table">
            <tbody>
                <tr>
                    <th>
                        <label for="name">Name</label>
                    </th>
                    <td>
                        <input type="text" name="weDevs_name" id="name" value="<?php echo isset( $settings_data['weDevs_name'] ) ? esc_attr( wp_unslash( $settings_data['weDevs_name'] ) ) : '' ?>">
                        <?php echo isset( $_POST['submit'] ) && empty( $name ) ? 'Name field is required!' : '';?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="email">Email</label>
                    </th>
                    <td>
                        <input type="text" name="weDevs_email" id="email" value="<?php echo isset( $settings_data['weDevs_email'] ) ? esc_attr( wp_unslash( $settings_data['weDevs_email'] ) ) : '' ?>">
                        <?php echo isset( $_POST['submit'] ) && empty( $email ) ? 'Email field is required!' : '';?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="weDevs_options">Choose One</label>
                    </th>
                    <td>
                        <select name="weDevs_options" id="weDevs_options">
                            <option value="1" <?php echo $options_value == 1 ? 'selected' : '' ?> >1</option>
                            <option value="2" <?php echo $options_value == 2 ? 'selected' : '' ?>>2</option>
                            <option value="3" <?php echo $options_value == 3 ? 'selected' : '' ?>>3</option>
                            <option value="4" <?php echo $options_value == 4 ? 'selected' : '' ?>>4</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <input type="submit" name="submit" class="button button-primary" value="Save Changes">
        </p>
    </form>
</div>