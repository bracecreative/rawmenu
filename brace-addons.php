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

// Enqueue Dog Food Calculator js

function brace_addons_dog_food_calculator_scripts( $hook ) {
    
    if(is_product()){
       $product_id = get_the_ID();
       $order = wc_get_product($product_id);
       $order_title = get_the_title();
       $order_price = $order->get_price();
       $order_weight = $order->get_weight();

        wp_enqueue_script( 'dog_food_calculator', plugins_url( '/js/DogFoodCalculator.js' , __FILE__ ), array(), '', true );
    
        // Localize Script Dog Food Calculator
        wp_localize_script( 'dog_food_calculator', 'DogFoodCalculatorObject',
            array( 
                'product_name' =>  $order_title,
                'product_price' => $order_price,
                'product_weight' => $order_weight,
            )
        );
    }
} 
add_action( 'wp_enqueue_scripts', 'brace_addons_dog_food_calculator_scripts' );

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
    if( !empty( get_post_meta( $order->ID, 'allergy_notes', true ) ) ):
        echo '<p><strong>'.__('Allergies').':</strong> ' . get_post_meta( $order->id, 'allergy_notes', true ) . '</p>';
    endif;
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

// Add Delivery slots to acf select
function brace_acf_delivery_options( $field ) {

    global $woocommerce;

    $field['choices'] = array();
    
    $zones = WC_Shipping_Zones::get_zones();
    $methods = array_column( $zones, 'shipping_methods' );
    
    foreach ( $methods[0] as $key => $class ) {
        $item = [
            "id" => 'flat_rate:'.$class->instance_id,
            "name" => $class->title
        ];
        $choices[] = $item;
    }

    if( is_array($choices) ) {
        foreach( $choices as $choice ) {
            $field['choices'][ $choice['id'] ] = $choice['name'];
        }
    }

    return $field;
}

add_filter('acf/load_field/name=next_day_delivery_class', 'brace_acf_delivery_options');

// Hide NDD if time passed
function brace_nextday_delivery_cutoff( $rates, $package ) {
    
    date_default_timezone_set("Europe/London");
    $current_time = strtotime( date("H:i:s") );
    $cutoff_time = strtotime( get_option('options_next_day_delivery_cut_off_time') );
    
    $delivery_id = get_option('options_next_day_delivery_class');

    if( $current_time > $cutoff_time ):
        unset( $rates[$delivery_id] );
    endif;
    
    return $rates;
}
add_filter( 'woocommerce_package_rates', 'brace_nextday_delivery_cutoff', 10, 2 );

// Awaiting Fulfilment Order Status
function brace_order_status_awaiting_fulfilment() {
    register_post_status( 'wc-awaiting-fulfilment', array(
        'label'                     => 'Awaiting Fulfillment',
        'public'                    => true,
        'show_in_admin_status_list' => true,
        'show_in_admin_all_list'    => true,
        'exclude_from_search'       => false,
        'label_count'               => _n_noop( 'Awaiting Fulfillment <span class="count">(%s)</span>', 'Awaiting Fulfillment <span class="count">(%s)</span>' )
    ) );
}
add_action( 'init', 'brace_order_status_awaiting_fulfilment' );

// Awaiting Pickup Order Status
function brace_order_status_awaiting_pickup() {
    register_post_status( 'wc-awaiting-pickup', array(
        'label'                     => 'Awaiting Pickup',
        'public'                    => true,
        'show_in_admin_status_list' => true,
        'show_in_admin_all_list'    => true,
        'exclude_from_search'       => false,
        'label_count'               => _n_noop( 'Awaiting Pickup <span class="count">(%s)</span>', 'Awaiting Pickup <span class="count">(%s)</span>' )
    ) );
}
add_action( 'init', 'brace_order_status_awaiting_pickup' );

// Awaiting Shipment Order Status
function brace_order_status_awaiting_shipment() {
    register_post_status( 'wc-awaiting-shipment', array(
        'label'                     => 'Awaiting Shipment',
        'public'                    => true,
        'show_in_admin_status_list' => true,
        'show_in_admin_all_list'    => true,
        'exclude_from_search'       => false,
        'label_count'               => _n_noop( 'Awaiting Shipment <span class="count">(%s)</span>', 'Awaiting Shipment <span class="count">(%s)</span>' )
    ) );
}
add_action( 'init', 'brace_order_status_awaiting_shipment' );

// Partially Refunded Order Status
function brace_order_status_partial_refunded() {
    register_post_status( 'wc-partial-refund', array(
        'label'                     => 'Partially Refunded',
        'public'                    => true,
        'show_in_admin_status_list' => true,
        'show_in_admin_all_list'    => true,
        'exclude_from_search'       => false,
        'label_count'               => _n_noop( 'Partially Refunded <span class="count">(%s)</span>', 'Partially Refunded <span class="count">(%s)</span>' )
    ) );
 }
 add_action( 'init', 'brace_order_status_partial_refunded' );

 // Partially Refunded Order Status
function brace_order_status_partial_shipped() {
    register_post_status( 'wc-partial-shipped', array(
        'label'                     => 'Partially Shipped',
        'public'                    => true,
        'show_in_admin_status_list' => true,
        'show_in_admin_all_list'    => true,
        'exclude_from_search'       => false,
        'label_count'               => _n_noop( 'Partially Shipped <span class="count">(%s)</span>', 'Partially Shipped <span class="count">(%s)</span>' )
    ) );
 }
 add_action( 'init', 'brace_order_status_partial_shipped' );

 // Shipped Order Status
function brace_order_status_shipped() {
    register_post_status( 'wc-shipped', array(
        'label'                     => 'Shipped',
        'public'                    => true,
        'show_in_admin_status_list' => true,
        'show_in_admin_all_list'    => true,
        'exclude_from_search'       => false,
        'label_count'               => _n_noop( 'Shipped <span class="count">(%s)</span>', 'Shipped <span class="count">(%s)</span>' )
    ) );
 }
 add_action( 'init', 'brace_order_status_shipped' );

 // Add New Order Statuses to array
 function brace_add_order_statuses( $order_statuses ) {
    $new_order_statuses = array();
    foreach ( $order_statuses as $key => $status ) {
        $new_order_statuses[ $key ] = $status;
        if ( 'wc-processing' === $key ) {
            $new_order_statuses['wc-awaiting-fulfilment'] = 'Awaiting Fulfillment';
            $new_order_statuses['wc-awaiting-pickup'] = 'Awaiting Pickup';
            $new_order_statuses['wc-awaiting-shipment'] = 'Awaiting Shipment';
            $new_order_statuses['wc-partial-refund'] = 'Partially Refunded';
            $new_order_statuses['wc-partial-shipped'] = 'Partially Shipped';
            $new_order_statuses['wc-shipped'] = 'Shipped';
        }
    }
    return $new_order_statuses;
 }
 add_filter( 'wc_order_statuses', 'brace_add_order_statuses' );