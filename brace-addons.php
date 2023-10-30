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

// Enqueue CSS styling
function brace_addons_enqueue_css( $hook ) {
     wp_enqueue_style( 'brace_addons_css', plugins_url( 'styles.css' , __FILE__ ), array(), '');
}
add_action( 'wp_enqueue_scripts', 'brace_addons_enqueue_css' );

// Enqueue CSS Food Calculator
function brace_addons_dog_food_calculator( ) {
    include __DIR__ . '/components/dog-food-calculator.php';
}
add_action( 'woocommerce_single_product_summary', 'brace_addons_dog_food_calculator', 35 );

// Create User Roles
add_role( 'wholesale', 'Wholesale', get_role( 'customer' )->capabilities );
add_role( 'breeder', 'Breeder', get_role( 'customer' )->capabilities );

 /** Register private notes for the admin invoices */
function brace_wc_user_private_notes( $user ) {
    ?>
<h3>Private Notes</h3>

<table class="form-table" id="private-notes">
    <tr>
        <th><label for="wc_private_notes">Notes are only shown on the admin invoices, not shown to the customer</label>
        </th>
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
            <textarea rows="2" cols="30"
                name="<?php echo $note['key']; ?>"><?php if( !empty( get_the_author_meta( $note['key'], $user->ID ) ) ): echo get_the_author_meta($note['key'], $user->ID); endif; ?></textarea>
            <?php
                        endforeach;
                    else:
                    ?>
            <textarea rows="2" cols="30"
                name="wc_private_notes_1"><?php if( !empty( get_the_author_meta( 'wc_private_notes_1', $user->ID ) ) ): echo get_the_author_meta('wc_private_notes_1', $user->ID); endif; ?></textarea>
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

// Add Notes to Order Details Page
function brace_notes_order_details( $order ){

    $order_info = $order = new WC_Order( $order->id );
    $user_info = $order_info->get_user();
    if( $user_info ):
        $user_id = $user_info->id;

        $notes = array();
        foreach( get_user_meta($user_id) as $key => $value ):
            if (strpos($key, 'wc_private_notes_') === 0):
                $notes[] = array(
                    'key' => $key,
                    'value' => $value
                );
            endif;
        endforeach;

        if( !empty( $notes ) ):
        
            echo '<h3 style="clear:both; padding-top:15px">Customer Notes</h3>';

            foreach( $notes as $note ): ?>
<p><?php if( !empty( get_the_author_meta( $note['key'], $user_id ) ) ): echo get_the_author_meta($note['key'], $user_id); endif; ?>
</p>
<?php
            endforeach;
        endif;
    endif;
}
add_action( 'woocommerce_admin_order_data_after_order_details', 'brace_notes_order_details', 10, 3 );

// Add notes to packing slips
function brace_notes_packing_slips ($document_type, $order) {
    $document = wcpdf_get_document( $document_type, $order );
    if ($document_type == 'packing-slip'):

        $user_id = $order->get_user_id();
        if ( !empty($user_id) ):
       
            $notes = array();
            foreach( get_user_meta($user_id) as $key => $value ):
                if (strpos($key, 'wc_private_notes_') === 0):
                    $notes[] = array(
                        'key' => $key,
                        'value' => $value
                    );
                endif;
            endforeach;

            if( !empty( $notes ) ):
                echo '<h3 style="clear:both; padding-top:15px">Customer Notes</h3>';

                foreach( $notes as $note ): ?>
<p><?php if( !empty( get_the_author_meta( $note['key'], $user_id ) ) ): echo get_the_author_meta($note['key'], $user_id); endif; ?>
</p>
<?php
                endforeach;
            endif;

        endif;
    endif;
}
add_action( 'wpo_wcpdf_after_order_data', 'brace_notes_packing_slips', 10, 2 );

// Add allergies field to checkout
function brace_allergies_field( $checkout ) {

    echo '<div id="allergy-notes"><h2>' . __('Allergies') . '</h2>';

    woocommerce_form_field( 'allergy_notes', array(
        'type'          => 'textarea',
        'class'         => array('allergy-notes form-row-wide'),
        'label'         => __('Does your dog have any allergies we should be aware of?'),
        ), $checkout->get_value( 'allergy_notes' ));

    echo '</div>';

}
add_action( 'woocommerce_after_order_notes', 'brace_allergies_field' );

// Save allergies field
function brace_allergies_field_save() {
    if ( ! empty( $_POST['allergy_notes'] ) ) {
        update_post_meta( $order_id, 'allergy_notes', sanitize_text_field( $_POST['allergy_notes'] ) );
    }
}
add_action( 'woocommerce_checkout_update_order_meta', 'brace_allergies_field_save' );

// Add allergies information to Order Details Page
function brace_allergies_order_details($order){
    echo '<p><strong>'.__('Allergies').':</strong> ' . get_post_meta( $order->id, 'allergy_notes', true ) . '</p>';
}
add_action( 'woocommerce_admin_order_data_after_billing_address', 'brace_allergies_order_details', 10, 1 );

// Set 10kg min weight for cart
function brace_minimum_cart_weight() {

    $minimum_weight = 10;
	$cart_contents_weight = WC()->cart->get_cart_contents_weight();

    if( $cart_contents_weight < $minimum_weight  ) {
		wc_add_notice( sprintf('<strong>Your order must be at least %s%s before checking out.</strong><br />Current cart weight: %s%s',
			$minimum_weight, get_option( 'woocommerce_weight_unit' ),
			$cart_contents_weight, get_option( 'woocommerce_weight_unit' ) ),
			'error'	);
	}
}
add_action( 'woocommerce_check_cart_items', 'brace_minimum_cart_weight' );

function brace_nextday_delivery_cutoff( $rates, $package ) {
    
    date_default_timezone_set("Europe/London");
    $current_time = strtotime( date("H:i:s") );
    $cutoff_time = strtotime( get_option('options_next_day_delivery_cut_off_time') );
    
    //$cutoff_time = strtotime('13:00:00');

    $delivery_id = 'flat_rate:1';

    if( $current_time > $cutoff_time ):
        unset( $rates[$delivery_id] );
    endif;
    
    return $rates;
}
add_filter( 'woocommerce_package_rates', 'brace_nextday_delivery_cutoff', 10, 2 );