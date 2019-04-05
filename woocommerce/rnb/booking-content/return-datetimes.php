<div class="redq-date-time-picker rq-sldebar-select rnb-component-wrapper" style="display:none;">
	<?php
		$displays = reddq_rental_get_settings( get_the_ID(), 'display' );
		$displays = $displays['display'];
	 ?>
	<?php if(isset($displays['return_date']) && $displays['return_date'] !== 'closed' ) : ?>
		<?php

			$labels = reddq_rental_get_settings( get_the_ID(), 'labels', array('return_date') );
			$conditions = reddq_rental_get_settings( get_the_ID(), 'conditions' );
			$labels = $labels['labels'];
			$conditions = $conditions['conditions'];

			$end_date = '';
			if(isset($_GET['datepickerrange'])){
				$date_format = $conditions['date_format'];
				$format = 'Y-m-d';
				$exp_date = explode('-', $_GET['datepickerrange']);
				if(isset($exp_date[1])){
					$exp_edate = explode('_', $exp_date[1]);
					$edate = $exp_edate[2].'-'.$exp_edate[0].'-'.$exp_edate[1];
					$date = DateTime::createFromFormat($format, $edate);
					$end_date = $date->format($date_format);
				}
			}
		?>
		<h6 class="rq-mt-0"><?php echo esc_attr($labels['return_datetime']); ?></h6>
		<div class="col-md-7 rm-pad-first">
			<span class="drop-off-date-picker">
				<i class="fa fa-calendar"></i>
				<input type="text" name="dropoff_date" class="rq-form-control small" id="dropoff-date" placeholder="<?php echo esc_attr($labels['return_date']); ?>" value="<?php echo esc_attr($end_date); ?>" readonly>
			</span>
		</div>
	<?php endif; ?>

	<?php if(isset($displays['return_time']) && $displays['return_time'] !== 'closed' ): ?>
		<div class="col-md-5 rm-pad">
			<span class="drop-off-time-picker">
				<i class="fa fa-clock-o"></i>
				<input type="text" name="dropoff_time" class="rq-form-control small" id="dropoff-time" placeholder="<?php echo esc_attr($labels['return_time']); ?>" value="" readonly>
			</span>
		</div>
	<?php endif; ?>
</div>

<div id="dropoff-modal-body" style="display: none;">
	<h5 class="drop-modal-title"><?php echo esc_attr($labels['return_datetime']); ?></h5>
	<div id="drop-mobile-datepicker"></div>
	<span id="drop-cal-close-btn">
		<i class="fa fa-times"></i>
	</span>
	<button type="button" id="drop-cal-submit-btn">
		<i class="fa fa-check-circle"></i>
		<?php echo esc_html__('Submit', 'turbo'); ?>
	</button>
</div>
