<?php
	global $product;
	$resources = $product->redq_get_rental_payable_attributes('resource');
?>

<?php if(isset($resources) && !empty($resources)): ?>
	<div class="payable-extras rq-sldebar-select booking-section-single rnb-component-wrapper">
		<?php
			$labels = reddq_rental_get_settings( get_the_ID(), 'labels', array('resources') );
			$labels = $labels['labels'];
		?>
		<h6><?php echo esc_attr($labels['resource']); ?></h6>
		<?php foreach ($resources as $key => $value) { ?>
			<?php
				$prechecked_resources = '';
				$checked = '';
				if(isset($_GET['tex_resource'])){
					$prechecked_resources = explode(',', $_GET['tex_resource']);
					if(in_array($value['resource_slug'], $prechecked_resources)){
						$checked = 'checked';
					}
				}
			?>
			<div class="attributes">
				<label class="custom-block">
					<?php $dta = array(); $dta['name'] = $value['resource_name']; $dta['cost'] = $value['resource_cost'];  ?>
					<input type="checkbox" name="extras[]" value = "<?php echo esc_attr($value['resource_name']); ?>|<?php echo esc_attr($value['resource_cost']); ?>|<?php echo esc_attr($value['resource_applicable']); ?>|<?php echo esc_attr($value['resource_hourly_cost']); ?>" data-name="<?php echo esc_attr($value['resource_name']); ?>" data-value-in="0" data-applicable="<?php echo esc_attr($value['resource_applicable']); ?>" data-value="<?php echo esc_attr($value['resource_cost']); ?>" data-hourly-rate="<?php echo esc_attr($value['resource_hourly_cost']); ?>" data-currency-before="$" data-currency-after="" class="carrental_extras" <?php echo esc_attr($checked); ?>>
					<?php echo esc_attr($value['resource_name']); ?>

					<?php if($value['resource_applicable'] == 'per_day'){ ?>
						<span class="pull-right show_if_day"><?php //echo wc_price($value['resource_cost']); ?><span><?php esc_html_e(' - Free of Charge', 'turbo'); ?></span></span>
						<span class="pull-right show_if_time"><?php //echo wc_price($value['resource_hourly_cost']); ?><?php esc_html_e(' - Free of Charge','turbo'); ?></span>
					<?php }else{ ?>
						<span class="pull-right"><?php //echo wc_price($value['resource_cost']); ?><?php esc_html_e(' - Free of Charge','turbo'); ?></span>
					<?php } ?>
				</label>
			</div>
		<?php } ?>
	</div>
<?php endif; ?>
