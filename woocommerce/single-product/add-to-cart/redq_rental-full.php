<?php
/**
 * Redq rental product add to cart
 *
 * @author 		redq-team
 * @package 	RedqTeam/Templates
 * @version     1.0.0
 * @since       1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $woocommerce, $product, $post;
$date_format = get_post_meta(get_the_ID(),'redq_calendar_date_format',true);

?>


<?php
	$show_local_pricing_flip_box = get_post_meta(get_the_ID(),'redq_rental_local_show_pricing_flip_box',true);

	if($show_local_pricing_flip_box === 'open'){
		$show_pricing_flip_box = true;
	}else{
		$show_pricing_flip_box = false;
	}
?>

<?php if(isset($show_pricing_flip_box) && !empty($show_pricing_flip_box)) :  ?>
<div class="price-showing" style="margin-bottom: 100px;">
	<div class="front">
		<div class="notice">
			<h3><?php esc_html_e('show pricing','turbo'); ?></h3>
		</div>
	</div>
	<div class="back">
		<div class="item-pricing">
			<h5><?php esc_html_e('Season priceeeeee','turbo'); ?></h5>
			<?php $pricing_type = $product->redq_get_pricing_type(get_the_ID()); ?>

			<?php if($pricing_type === 'days_range'): ?>
				<?php $pricing_plans = $product->redq_get_day_ranges_pricing(get_the_ID()); ?>
				<?php foreach ($pricing_plans as $key => $value) { ?>
					<div class="day-ranges-pricing-plan">
						<span class="range-days"><?php echo esc_attr($value['min_days']); ?> - <?php echo esc_attr($value['max_days']); ?> <?php esc_html_e('days:','turbo'); ?> </span>
						<span class="range-price"><strong><?php echo wc_price($value['range_cost']); ?></strong> <?php esc_html_e('/ day','turbo'); ?></span>
						<?php if(isset($value['discount_type']) && !empty($value['discount_type'])): ?>
						<span>
							<?php esc_html_e('Discount - ','turbo'); ?>
							<?php if($value['discount_type'] === 'percentage'): ?>
								<?php echo esc_attr($value['discount_amount']) ?><?php esc_html_e('percent','turbo'); ?>
							<?php else: ?>
								<?php echo wc_price(esc_attr($value['discount_amount'])); ?>
							<?php endif; ?>
						</span>
						<?php endif; ?>
					</div>
				<?php } ?>
			<?php endif; ?>

			<?php if($pricing_type === 'daily_pricing'): ?>
				<?php $daily_pricing = $product->redq_get_daily_pricing(get_the_ID()); ?>
				<?php foreach ($daily_pricing as $key => $value) { ?>
					<div class="day-ranges-pricing-plan">
						<span class="day"><?php echo ucfirst($key); ?> </span>
						<span class="day-price"><strong> - <?php echo wc_price($value); ?></strong></span>
					</div>
				<?php } ?>
			<?php endif; ?>

			<?php if($pricing_type === 'monthly_pricing'): ?>
				<?php $monthly_pricing = $product->redq_get_monthly_pricing(get_the_ID()); ?>
				<?php foreach ($monthly_pricing as $key => $value) { ?>
					<div class="day-ranges-pricing-plan">
						<span class="month"><?php echo ucfirst($key); ?> </span>
						<span class="month-price"><strong> - <?php echo wc_price($value); ?></strong></span>
					</div>
				<?php } ?>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php endif; ?>

<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="cart" method="post" enctype='multipart/form-data' novalidate>



	<div class="car-search">
		<div class="rq-search-container">

			<!-- Start pickup date -->
			<?php
				$show_local_pickup_date = get_post_meta(get_the_ID(),'redq_rental_local_show_pickup_date',true);
				$show_global_pickup_date = get_option('redq_rental_global_show_pickup_date');

				if($show_local_pickup_date === 'open'){
					$show_pickup_date = true;
				}else{
					$show_pickup_date = false;
				}

				$local_pickup_datetime_title = get_post_meta(get_the_ID(),'redq_pickup_date_heading_title',true);
				$local_pickup_date_placeholder = get_post_meta(get_the_ID(),'redq_pickup_date_placeholder',true);
				$global_pickup_datetime_title = get_option('redq_rental_global_pickup_date_title');

				$pdate = '';
				if(isset($_GET['redq_block_dates_and_times']['start'])){
					$pdate = $_GET['redq_block_dates_and_times']['start'];
					$format = 'Y-m-d';
					$date = DateTime::createFromFormat($format, $pdate);
					$pdate = $date->format($date_format);
				}
			?>

			<?php if(isset($show_pickup_date) && !empty($show_pickup_date)): ?>
			<div class="rq-search-single">
			  	<div class="rq-search-content">
					<div class="date-time-picker">
						<span class="rq-search-heading">
							<?php
								if(isset($local_pickup_datetime_title) && !empty($local_pickup_datetime_title)){
							 		echo esc_attr($local_pickup_datetime_title);
								}elseif(isset($global_pickup_datetime_title) && !empty($global_pickup_datetime_title)){
									echo esc_attr($global_pickup_datetime_title);
								}else{ ?>
									<?php esc_html_e('Pickup Date & Time','turbo'); ?>
								<?php }
							?>
						</span>
						<span class="pick-up-date-picker">
							<i class="fa fa-calendar"></i>
							<input type="text" name="pickup_date" id="pickup-date" placeholder="<?php echo esc_attr($local_pickup_date_placeholder); ?>" value="<?php echo esc_attr($pdate); ?>">
						</span>
					</div>
			  	</div>
			</div>
			<?php endif; ?>
			<!-- End pickup date -->



			<!-- Start pickup time -->

			<?php
				$show_local_pickup_time = get_post_meta(get_the_ID(),'redq_rental_local_show_pickup_time',true);
				$show_global_pickup_time = get_option('redq_rental_global_show_pickup_time');

				if($show_local_pickup_time === 'open'){
					$show_pickup_time = true;
				}else{
					$show_pickup_time = false;
				}

				$local_pickup_datetime_title = get_post_meta(get_the_ID(),'redq_pickup_date_heading_title',true);
				$local_pickup_time_placeholder = get_post_meta(get_the_ID(),'redq_pickup_time_placeholder',true);
				$global_pickup_datetime_title = get_option('redq_rental_global_pickup_date_title');

			?>

			<?php if(isset($show_pickup_time) && !empty($show_pickup_time)): ?>
			<div class="rq-search-single">
			  	<div class="rq-search-content">
					<div class="date-time-picker">
						<span class="rq-search-heading">
							<?php
								if(isset($local_pickup_datetime_title) && !empty($local_pickup_datetime_title)){
							 		echo esc_attr($local_pickup_datetime_title);
								}elseif(isset($global_pickup_datetime_title) && !empty($global_pickup_datetime_title)){
									echo esc_attr($global_pickup_datetime_title);
								}else{ ?>
									<?php esc_html_e('Pickup Date & Time','turbo'); ?>
								<?php }
							?>
						</span>
						<span class="pick-up-time-picker">
							<i class="fa fa-clock-o"></i>
							<input type="text" name="pickup_time" id="pickup-time" placeholder="<?php echo esc_attr($local_pickup_time_placeholder); ?>" value="">
						</span>
					</div>
			  	</div>
			</div>
			<?php endif; ?>
			<!-- End pickup time -->

			<!-- Start dropoff date -->
			<?php
				$show_local_dropoff_date = get_post_meta(get_the_ID(),'redq_rental_local_show_dropoff_date',true);
				$show_global_dropoff_date = get_option('redq_rental_global_show_dropoff_date');

				if($show_local_dropoff_date === 'open'){
					$show_dropoff_date = true;
				}else{
					$show_dropoff_date = false;
				}

				$local_dropoff_datetime_title = get_post_meta(get_the_ID(),'redq_dropoff_date_heading_title',true);
				$local_dropoff_date_placeholder = get_post_meta(get_the_ID(),'redq_dropoff_date_placeholder',true);
				$global_dropoff_datetime_title = get_option('redq_rental_global_return_date_title');


				$ddate = '';
				if(isset($_GET['redq_block_dates_and_times']['start'])){
					$ddate = $_GET['redq_block_dates_and_times']['end'];
					$format = 'Y-m-d';
					$date = DateTime::createFromFormat($format, $ddate);
					$ddate = $date->format($date_format);
				}
			?>

			<?php if(isset($show_dropoff_date) && !empty($show_dropoff_date)): ?>
			<div class="rq-search-single">
					<div class="rq-search-content">
						<div class="date-time-picker">
						<span class="rq-search-heading">
							<?php
								if(isset($local_dropoff_datetime_title) && !empty($local_dropoff_datetime_title)){
									echo esc_attr($local_dropoff_datetime_title);
								}else{ ?>
									<?php esc_html_e('Drop-off Date & Time','turbo'); ?>
								<?php }
							?>
						</span>
						<span class="drop-off-date-picker">
							<i class="fa fa-calendar"></i>
							<input type="text" name="dropoff_date" id="dropoff-date" placeholder="<?php echo esc_attr($local_dropoff_date_placeholder); ?>" value="<?php echo esc_attr($ddate); ?>">
						</span>
					</div>
					</div>
			</div>
			<?php endif; ?>
			<!-- End dropoff date -->




			<!-- Start dropoff date -->

			<?php
				$show_local_dropoff_time = get_post_meta(get_the_ID(),'redq_rental_local_show_dropoff_time',true);
				$show_global_dropoff_time = get_option('redq_rental_global_show_dropoff_time');

				if($show_local_dropoff_time === 'open'){
					$show_dropoff_time = true;
				}else{
					$show_dropoff_time = false;
				}

				$local_dropoff_datetime_title = get_post_meta(get_the_ID(),'redq_dropoff_date_heading_title',true);
				$local_dropoff_time_placeholder = get_post_meta(get_the_ID(),'redq_dropoff_time_placeholder',true);
				$global_dropoff_datetime_title = get_option('redq_rental_global_return_date_title');
			?>

			<?php if(isset($show_dropoff_time) && !empty($show_dropoff_time)): ?>
			<div class="rq-search-single">
			  	<div class="rq-search-content">
				    <div class="date-time-picker">
						<span class="rq-search-heading">
							<?php
								if(isset($local_dropoff_datetime_title) && !empty($local_dropoff_datetime_title)){
							 		echo esc_attr($local_dropoff_datetime_title);
								}else{ ?>
									<?php esc_html_e('Drop-off Date & Time','turbo'); ?>
								<?php }
							?>
						</span>
						<span class="drop-off-time-picker">
							<i class="fa fa-clock-o"></i>
							<input type="text" name="dropoff_time" id="dropoff-time" placeholder="<?php echo esc_attr($local_dropoff_time_placeholder); ?>" value="">
						</span>
					</div>
			  	</div>
			</div>
			<?php endif; ?>
			<!-- End dropoff time -->

		</div>
	</div>





	<div class="car-search">
		<div class="rq-search-container">

			<!-- Start pickup location -->
			<?php
				$local_pickup_location_title = get_post_meta(get_the_ID(),'redq_pickup_location_heading_title',true);
				$global_pickup_location_title = get_option('redq_rental_global_pickup_location_title');

				$pick_up_locations = $product->redq_get_rental_payable_attributes('pickup_location');
			?>
			<?php if(isset($pick_up_locations) && !empty($pick_up_locations)): ?>
			<div class="rq-search-single">
				<div class="rq-search-content">
					<div class="redq-pick-up-location">
						<span class="rq-search-heading">
							<?php
								if(isset($local_pickup_location_title) && !empty($local_pickup_location_title)){
							 		echo esc_attr($local_pickup_location_title);
								}elseif(isset($global_pickup_location_title) && !empty($global_pickup_location_title)){
									echo esc_attr($global_pickup_location_title);
								}else{ ?>
									<?php esc_html_e('Pickup Locations','turbo'); ?>
								<?php }
							?>
						</span>
						<select class="redq-select-boxes pickup_location" name="pickup_location" data-placeholder="<?php echo esc_attr($local_pickup_location_title); ?>">
							<option value=""><?php echo esc_attr($local_pickup_location_title); ?></option>
							<?php foreach ($pick_up_locations as $key => $value) { ?>
								<?php
									$selected = '';
									if(isset($_GET['pickup_location'])){
										if($value['slug'] === $_GET['pickup_location']){
											$selected = 'selected';
										}
									}
								?>
								<option value="<?php echo esc_attr($value['address']); ?>|<?php echo esc_attr($value['title']); ?>|<?php echo esc_attr($value['cost']); ?>" data-pickup-location-cost= "<?php echo esc_attr($value['cost']); ?>" <?php echo esc_attr( $selected ); ?> ><?php echo esc_attr($value['title']); ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
			<?php endif; ?>
			<!-- End pickup location -->

			<!-- Start dropoff location -->
			<?php
				$local_dropoff_location_title = get_post_meta(get_the_ID(),'redq_dropoff_location_heading_title',true);
				$global_dropoff_location_title = get_option('redq_rental_global_return_location_title');
				$drop_off_locations = $product->redq_get_rental_payable_attributes('dropoff_location');
			?>

			<?php if(isset($drop_off_locations) && !empty($drop_off_locations)): ?>
			<div class="rq-search-single">
				<div class="rq-search-content">

					<div class="redq-drop-off-location">
						<span class="rq-search-heading">
							<?php
								if(isset($local_dropoff_location_title) && !empty($local_dropoff_location_title)){
							 		echo esc_attr($local_dropoff_location_title);
								}elseif(isset($global_dropoff_location_title) && !empty($global_dropoff_location_title)){
									echo esc_attr($global_dropoff_location_title);
								}else{ ?>
									<?php esc_html_e('Drop-off Locations','turbo'); ?>
								<?php }
							?>
						</span>
						<select class="dropoff_location redq-select-boxes category-option" name="dropoff_location" data-placeholder="<?php echo esc_attr($local_dropoff_location_title); ?>">
							<option value=""><?php echo esc_attr($local_dropoff_location_title); ?></option>
							<?php foreach ($drop_off_locations as $key => $value) { ?>
								<?php
									$selected = '';
									if(isset($_GET['dropoff_location'])){
										if($value['slug'] === $_GET['dropoff_location']){
											$selected = 'selected';
										}
									}
								?>
								<option value="<?php echo esc_attr($value['address']); ?>|<?php echo esc_attr($value['title']); ?>|<?php echo esc_attr($value['cost']); ?>" data-dropoff-location-cost= "<?php echo esc_attr($value['cost']); ?>" <?php echo esc_attr($selected); ?> ><?php echo esc_attr($value['title']); ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
			<?php endif; ?>
			<!-- End dropoff location -->

			<!-- Start person -->
			<?php
				$local_person_title = get_post_meta(get_the_ID(),'redq_person_heading_title',true);
				$local_person_placeholder = get_post_meta(get_the_ID(),'redq_person_placeholder',true);
				$global_person_title = get_option('redq_rental_global_person_title');

				$person_cost = $product->redq_get_rental_payable_attributes('person');
			?>

			<?php if(isset($person_cost) && !empty($person_cost)): ?>
			<div class="rq-search-single">
			  	<div class="rq-search-content last-child">
					<div class="additional-person">
						<span class="rq-search-heading">
							<?php
								if(isset($local_person_title) && !empty($local_person_title)){
							 		echo esc_attr($local_person_title);
								}elseif(isset($global_person_title) && !empty($global_person_title)){
									echo esc_attr($global_person_title);
								}else{ ?>
									<?php esc_html_e('Additional Person','turbo'); ?>
								<?php }
							?>
						</span>
						<select class="additional_person_info redq-select-boxes category-option" name="additional_person_info" data-placeholder="<?php echo esc_attr($local_person_placeholder); ?>">
							<option value=""><?php echo esc_attr($local_person_placeholder); ?></option>
							<?php foreach ($person_cost as $key => $value) { ?>
								<?php
									$selected = '';
									if(isset($_GET['person'])){
										if($value['person_slug'] === $_GET['person']){
											$selected = 'selected';
										}
									}
								?>
								<?php if($value['person_cost_applicable'] == 'per_day'){ ?>
									<option class="show_person_cost_if_day" <?php echo esc_attr($selected); ?> value="<?php echo esc_attr($value['person_count']); ?>|<?php echo esc_attr($value['person_cost']); ?>|<?php echo esc_attr($value['person_cost_applicable']); ?>|<?php echo esc_attr($value['person_hourly_cost']); ?>" data-person_cost= "<?php echo esc_attr($value['person_cost']); ?>" data-person_count="<?php echo esc_attr($value['person_count']); ?>" data-applicable="<?php echo esc_attr($value['person_cost_applicable']); ?>"><?php esc_html_e('Person - ','turbo'); ?><?php echo esc_attr($value['person_count']); ?><?php if(isset($value['person_cost']) && !empty($value['person_cost'])): ?><?php esc_html_e(' :  Cost - ','turbo'); ?><?php echo wc_price($value['person_cost']); ?><?php esc_html_e(' - Per day','turbo'); ?><?php endif; ?></option>
									<option class="show_person_cost_if_time" <?php echo esc_attr($selected); ?> style="display: none;" value="<?php echo esc_attr($value['person_count']); ?>|<?php echo esc_attr($value['person_cost']); ?>|<?php echo esc_attr($value['person_cost_applicable']); ?>|<?php echo esc_attr($value['person_hourly_cost']); ?>" data-person_cost= "<?php echo esc_attr($value['person_hourly_cost']); ?>" data-person_count="<?php echo esc_attr($value['person_count']); ?>" data-applicable="<?php echo esc_attr($value['person_cost_applicable']); ?>"><?php esc_html_e('Person - ','turbo'); ?><?php echo esc_attr($value['person_count']); ?><?php if(isset($value['person_cost']) && !empty($value['person_cost'])): ?><?php esc_html_e(' :  Cost - ','turbo'); ?><?php echo wc_price($value['person_hourly_cost']); ?><?php esc_html_e(' - Per hour','turbo'); ?><?php endif; ?></option>
								<?php }else{ ?>
									<option <?php echo esc_attr($selected); ?> value="<?php echo esc_attr($value['person_count']); ?>|<?php echo esc_attr($value['person_cost']); ?>|<?php echo esc_attr($value['person_cost_applicable']); ?>|<?php echo esc_attr($value['person_hourly_cost']); ?>" data-person_cost= "<?php echo esc_attr($value['person_cost']); ?>" data-person_count="<?php echo esc_attr($value['person_count']); ?>" data-applicable="<?php echo esc_attr($value['person_cost_applicable']); ?>"><?php esc_html_e('Person - ','turbo'); ?><?php echo esc_attr($value['person_count']); ?><?php if(isset($value['person_cost']) && !empty($value['person_cost'])): ?><?php esc_html_e(' :  Cost - ','turbo'); ?><?php echo wc_price($value['person_cost']); ?><?php esc_html_e(' - One time','turbo'); ?><?php endif; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
					</div>
			  	</div>
			</div>
			<?php endif; ?>
			<!-- End person -->

		</div>
	</div>






	<!-- Start payable attributes section -->

	<div class="booking-details">
		<div class="row">

			<?php $resources = $product->redq_get_rental_payable_attributes('resource');	?>

			<?php if(isset($resources) && !empty($resources)): ?>
			<div class="col-md-5">
				<div class="booking-section-single">
					<div class="section-adding-option">
						<?php
							$local_resources_title = get_post_meta(get_the_ID(),'redq_resources_heading_title',true);
							$global_resources_title = get_option('redq_rental_global_resources_title');
						?>
						<h3 class="section-title">
							<?php
								if(isset($local_resources_title) && !empty($local_resources_title)){
							 		echo esc_attr($local_resources_title);
								}elseif(isset($global_resources_title) && !empty($global_resources_title)){
									echo esc_attr($global_resources_title);
								}else{ ?>
									<?php esc_html_e('Resources','turbo'); ?>
								<?php }
							?>
						</h3>
						<?php foreach ($resources as $key => $value) { ?>
							<?php
								$prechecked_resources = '';
								$checked = '';
								if(isset($_GET['resource'])){
									$prechecked_resources = explode(',', $_GET['resource']);
									if(in_array($value['resource_slug'], $prechecked_resources)){
										$checked = 'checked';
									}
								}
							?>
							<div class="attributes">
								<label class="custom-block">
									<?php $dta = array(); $dta['name'] = $value['resource_name']; $dta['cost'] = $value['resource_cost'];  ?>
									<input type="checkbox" name="extras[]" value = "<?php echo esc_attr($value['resource_name']); ?>|<?php echo esc_attr($value['resource_cost']); ?>|<?php echo esc_attr($value['resource_applicable']); ?>|<?php echo esc_attr($value['resource_hourly_cost']); ?>" data-name="<?php echo esc_attr($value['resource_name']); ?>" data-value-in="0" data-applicable="<?php echo esc_attr($value['resource_applicable']); ?>" data-value="<?php echo esc_attr($value['resource_cost']); ?>" data-hourly-rate="<?php echo esc_attr($value['resource_hourly_cost']); ?>" data-currency-before="$" data-currency-after="" class="carrental_extras" <?php echo esc_attr($checked); ?> >
									<?php echo esc_attr($value['resource_name']); ?>

									<?php if($value['resource_applicable'] == 'per_day'){ ?>
										<span class="pull-right show_if_day"><?php echo wc_price($value['resource_cost']); ?><span><?php esc_html_e(' - Free of charge','turbo'); ?></span></span>
										<span class="pull-right show_if_time"><?php echo wc_price($value['resource_hourly_cost']); ?><?php esc_html_e(' - Free of charge','turbo'); ?></span>
									<?php }else{ ?>
										<span class="pull-right"><?php echo wc_price($value['resource_cost']); ?><?php esc_html_e(' - Free of charge','turbo'); ?></span>
									<?php } ?>
								</label>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
			<?php endif; ?>



			<div class="col-md-1"></div>


			<?php  $security_deposites = $product->redq_get_rental_payable_attributes('deposite');	?>

			<?php if(isset($security_deposites) && !empty($security_deposites)): ?>
			<div class="col-md-6">
				<div class="booking-section-single">
					<div class="section-adding-option">
						<div class="payable-security_deposites">
							<?php
								$local_deposite_title = get_post_meta(get_the_ID(),'redq_security_deposite_heading_title',true);
								$global_deposite_title = get_option('redq_rental_global_deposite_title');
							?>
							<h3 class="section-title">
								<?php
									if(isset($local_deposite_title) && !empty($local_deposite_title)){
								 		echo esc_attr($local_deposite_title);
									}elseif(isset($global_deposite_title) && !empty($global_deposite_title)){
										echo esc_attr($global_deposite_title);
									}else{ ?>
										<?php esc_html_e('Security Deposites','turbo'); ?>
									<?php }
								?>
							</h3>
							<?php foreach ($security_deposites as $key => $value) { ?>
								<?php
									$prechecked_deposits = '';
									$checked = '';
									if(isset($_GET['deposite'])){
										$prechecked_deposits = explode(',', $_GET['deposite']);
										if(in_array($value['security_deposite_slug'], $prechecked_deposits)){
											$checked = 'checked';
										}
									}
								?>
								<div class="attributes">
									<label class="custom-block">
										<?php $dta = array(); $dta['name'] = $value['security_deposite_name']; $dta['cost'] = $value['security_deposite_cost'];  ?>
										<input type="checkbox" <?php if($value['security_deposite_clickable'] === 'no'){ ?> checked onclick="return false" <?php } ?> name="security_deposites[]" value = "<?php echo esc_attr($value['security_deposite_name']); ?>|<?php echo esc_attr($value['security_deposite_cost']); ?>|<?php echo esc_attr($value['security_deposite_applicable']); ?>|<?php echo esc_attr($value['security_deposite_hourly_cost']); ?>" data-name="<?php echo esc_attr($value['security_deposite_name']); ?>" data-value-in="0" data-applicable="<?php echo esc_attr($value['security_deposite_applicable']); ?>" data-value="<?php echo esc_attr($value['security_deposite_cost']); ?>" data-hourly-rate="<?php echo esc_attr($value['security_deposite_hourly_cost']); ?>" data-currency-before="$" data-currency-after="" class="carrental_extras" <?php echo esc_attr($checked); ?> />
										<?php echo esc_attr($value['security_deposite_name']); ?>
										<?php if($value['security_deposite_applicable'] == 'per_day'){ ?>
											<span class="pull-right show_if_day"><?php echo wc_price($value['security_deposite_cost']); ?><span><?php esc_html_e(' - Free of charge','turbo'); ?></span></span>
											<span class="pull-right show_if_time" style="display: none;"><?php echo wc_price($value['security_deposite_hourly_cost']); ?><?php esc_html_e(' - Free of charge','turbo'); ?></span>
										<?php }else{ ?>
											<span class="pull-right"><?php echo wc_price($value['security_deposite_cost']); ?><?php esc_html_e(' - Free of charge','turbo'); ?></span>
										<?php } ?>
									</label>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<?php endif; ?>



			<input type="hidden" name="currency-symbol" class="currency-symbol" value="<?php echo get_woocommerce_currency_symbol(); ?>">



			<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

			<div class="col-md-12">
				<?php
					$book_now_button_text = get_post_meta(get_the_ID(),'redq_book_now_button_text',true);
					$book_now_button_text = isset($book_now_button_text) && !empty($book_now_button_text) ? $book_now_button_text  : esc_html__('Book Now', 'turbo');
				?>
				<div class="book-btn">
					<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />
					<button type="submit" class="rq-btn rq-btn-primary btn-large single_add_to_cart_button redq_add_to_cart_button btn-book-now button alt"><?php echo esc_attr($book_now_button_text); ?><i class="ion-android-car"></i></button>
				</div>
			</div>

			<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>


		</div>
	</div>


	<!-- End payable attributes section -->



























</form>
