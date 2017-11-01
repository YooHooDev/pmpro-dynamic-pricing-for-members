<?php
/**
 * Plugin Name: Paid Memberships Pro - Dynamic Pricing
 * Description: Applies the dynamic pricing model to memberships
 * Version: 1.0.0
 * Author: YooHoo Plugins
 */

class PMProDynamicPricing{

	public function __construct(){

		add_filter( 'woocommerce_dynamic_pricing_get_rule_amount', array( $this, 'pmpro_apply_dynamic_pricing_for_members_only' ) );

		add_action( 'admin_menu', array( $this, 'admin_menu' ), 99 );

		add_action( 'admin_head', array( $this, 'save_settings' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );

	}

	public function admin_menu(){

		add_submenu_page( 'woocommerce', 'PMPro Dynamic Pricing', 'PMPro Dynamic Pricing', 'manage_options', 'pmpro-dynamic-pricing', array( $this, 'admin_menu_contents' ) );
	
	}

	public function admin_scripts(){

		wp_enqueue_style( 'pmpro-dynamic-pricing-admin-jqueryui', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css' );

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-datepicker' );

		wp_enqueue_script( 'pmpro-dynamic-pricing-admin-js', plugins_url( 'js/admin.js', __FILE__ ), array( 'jquery', 'jquery-ui-datepicker' ), false, false );
	}

	public function admin_menu_contents(){

		$settings = get_option( 'pmpro_dynamic_pricing_settings' );

		$enabled = ( isset( $settings['enabled'] ) && $settings['enabled'] == '1' ) ? 1 : 0;

		$sale_date = isset( $settings['sale_date'] ) ? $settings['sale_date'] : "";

		include plugin_dir_path( __FILE__ ).'includes/settings.php';

	}

	public function pmpro_apply_dynamic_pricing_for_members_only( $discount_amount ) {

		if( function_exists( 'pmpro_hasMembershipLevel' ) ){

			$settings = get_option( 'pmpro_dynamic_pricing_settings' );

			$enabled = ( isset( $settings['enabled'] ) && $settings['enabled'] == '1' ) ? 1 : 0;

			$sale_date = isset( $settings['sale_date'] ) ? $settings['sale_date'] : "";

			if( $enabled ){

				$today = current_time( 'timestamp' );

			    // Date to check against.
			    $check_date = strtotime( $sale_date.' 23:59:59' ); //change date to next sale date yyyy-mm-dd

			    // if today is before the check date run this code and the user does not have a membership level.
			    if( ( $today < $check_date ) && !pmpro_hasMembershipLevel() ){
			        //if the user's don't have a membership level, set the discount to 0.
			        $discount_amount = 0;
			    }

			}
			

		}
	    
	    return $discount_amount;

	}

	public function save_settings(){

		if( isset( $_POST['pmpro_dynamic_pricing_save'] ) ){

			$settings = array();

			$settings['enabled'] = isset( $_POST['pmpro_dynamic_pricing_enabled'] ) ? $_POST['pmpro_dynamic_pricing_enabled'] : 0;
			$settings['sale_date'] = isset( $_POST['pmpro_dynamic_pricing_sale'] ) ? $_POST['pmpro_dynamic_pricing_sale'] : "";

			update_option( 'pmpro_dynamic_pricing_settings', $settings );

		}

	}
}

new PMProDynamicPricing();