<div class='wrap'>
	<h2><?php _e('Paid Memberships Pro - Dynamic Pricing', 'pmpro-dynamic-pricing-for-members'); ?></h2>

	<form method='POST'>

		<table class='form-table striped'>

			<tr>
				<td><?php _e('Enable', 'pmpro-dynamic-pricing-for-members'); ?></td>
				<td><input type='checkbox' name='pmpro_dynamic_pricing_enabled' value='1' <?php checked( $enabled, 1 ); ?>/></td>
			</tr>

			<tr>
				<td><?php _e('Sale Date', 'pmpro-dynamic-pricing-for-members'); ?></td>
				<td><input type='text' id='pmpro_dynamic_sale_date' name='pmpro_dynamic_pricing_sale' value='<?php echo $sale_date; ?>' /></td>
			</tr>

			<tr>
				<td></td>
				<td><input type='submit' name='pmpro_dynamic_pricing_save' class='button button-primary' value='<?php _e('Save', 'pmpro-dynamic-pricing-for-members'); ?>' /></td>
			</tr>

		</table>

	</form>

</div>