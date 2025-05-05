<?php
namespace WeDevs;

class Admin_Notices {

    public function __construct() {
        add_action( 'admin_notices', [$this, 'admin_notices'] );
        add_action( 'wp_ajax_test_notice_wd', [$this, 'test_notice_wd'] );
    }

    public function admin_notices() {

        global $pagenow;

        if ( in_array( $pagenow, ['plugins.php'] ) ) {
            if ( isset( $_REQUEST['plugin_status'] ) && 'all' === $_REQUEST['plugin_status'] ) {
                ?>
                    <div class="notice notice-success is-dismissible">
                        <p><?php _e( 'Done!', 'weDevs' ); ?></p>
                    </div>
                <?php
            }

        }

        $clicked = get_option( 'wd_test_notice_close', false );

        if ( $clicked ) {
            return;
        }

        if ( in_array( $pagenow, ['index.php'] ) ) {
            ?>
                <div class="notice notice-success is-dismissible test-notice-dismiss">
                    <p>
                        <?php _e( 'This is dashboard warning!', 'weDevs' ); ?>
                    </p>
                </div>

                <script>
                    jQuery('body').on( 'click', '.test-notice-dismiss .notice-dismiss', function() {
                        
                        jQuery.ajax({
                                url: ajaxurl,
                                method: 'POST',
                                data: {
                                    action: 'test_notice_wd'
                                }
                        });
                    } );
                </script>

            <?php
            
        }

    }

    public function test_notice_wd() {

        update_option( 'wd_test_notice_close', true );
        

        exit;
    }
}