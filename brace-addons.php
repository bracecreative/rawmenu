<?php
/*
 * Plugin Name:       Brace Addons
 * Description:       Brace Addons for Raw Menu Website
 * Version:           0.0.1
 * Requires at least: 5.2
 * Author:            Brace Creative
 * Author URI:        https://www.brace.co.uk
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

 // Enqueue Assets
function brace_addons_enqueue( $hook ) {
    if ('profile.php' === $hook) {
        wp_enqueue_script( 'brace_addons', plugins_url( 'scripts.js' , __FILE__ ), array(), '', true );
    }
}
add_action( 'admin_enqueue_scripts', 'brace_addons_enqueue' );

// Create User Roles
add_role( 'wholesale', 'Wholesale', get_role( 'customer' )->capabilities );
add_role( 'breeder', 'Breeder', get_role( 'customer' )->capabilities );

 /** Register private notes for the admin invoices */
function brace_wc_user_private_notes( $user ) {
    ?>
        <h3>Private Notes</h3>

        <table class="form-table" id="private-notes">
            <tr>
                <th><label for="wc_private_notes">Notes are only shown on the admin invoices, not shown to the customer</label></th>
                <td>
                    <?php
                    $notes = array();
                    foreach( get_user_meta($user->id) as $key => $value ):
                        if (strpos($key, 'wc_private_notes_') === 0):
                            $notes[] = array(
                                'key' => $key,
                                'value' => $value
                            );
                        endif;
                    endforeach;

                    if( !empty( $notes ) ):
                        foreach( $notes as $note ): ?>
                            <textarea rows="2" cols="30" name="<?php echo $note['key']; ?>"><?php if( !empty( get_the_author_meta( $note['key'], $user->ID ) ) ): echo get_the_author_meta($note['key'], $user->ID); endif; ?></textarea>
                            <?php
                        endforeach;
                    else:
                    ?>
                        <textarea rows="2" cols="30" name="wc_private_notes_1"><?php if( !empty( get_the_author_meta( 'wc_private_notes_1', $user->ID ) ) ): echo get_the_author_meta('wc_private_notes_1', $user->ID); endif; ?></textarea>
                    <?php
                    endif;
                    ?>

                    <a class="new-private-note" href="#">Add new note</a>
                </td>
            </tr>
        </table>
    <?php
}
//add_action('user_new_form', 'brace_wc_user_private_notes', 9999);
add_action('show_user_profile', 'brace_wc_user_private_notes', 9999);
add_action('edit_user_profile', 'brace_wc_user_private_notes', 9999);

function brace_save_wc_user_private_notes( $user_id ) {
    if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'update-user_' . $user_id ) ) {
        return;
    }
    
    foreach($_POST as $key => $value) {
        if (strpos($key, 'wc_private_notes_') === 0) {
            update_user_meta( $user_id, $key, $value );
        }
    }
    
}
add_action( 'personal_options_update', 'brace_save_wc_user_private_notes' );
add_action( 'edit_user_profile_update', 'brace_save_wc_user_private_notes' );