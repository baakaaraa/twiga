<?php
/**
 * Shortcode for help line
 * @author RedQ Team
 * @package Turbowp Helper
 * @since 2.4.0
 */
extract(shortcode_atts(array(
	'heading_title'    		=> esc_html__('Others available cars', 'turbo'),
	'search_text'    		=> esc_html__('Search Name', 'turbo'),
	'search_placeholder'    => esc_html__('Search', 'turbo'),
	'select_text'    		=> esc_html__('Car Model', 'turbo'),
	'select_placeholder'    => esc_html__('Choose Model', 'turbo'),
	'rating_text'    		=> esc_html__('Rating', 'turbo'),
	'select_rating_placeholder'    => esc_html__('Choose Rating', 'turbo'),
	'pricing_text'      => esc_html__('Pricing', 'turbo'),
	'select_pricing_placeholder'    => esc_html__('Choose Pricing', 'turbo'),
 	'all_car_button_text'   => esc_html__('See All', 'turbo'),
	'all_car_button_link'	=> '#',
	'price_type'   			=> esc_html__('/ Day', 'turbo'),
	'post_type'   			=> 'product',
	'posts_per_page'   		=> 9,
), $atts));

$tax_sorting_options = [];
if(taxonomy_exists('product_cat')){
    $tax_sorting_options = get_terms( 'product_cat', array(
        'hide_empty' 		=> false,
        'suppress_filter' 	=> false
    ) );
}

$args = array(
	'post_type' 		=> $post_type,
	'posts_per_page' 	=> $posts_per_page,
);
$products = get_posts( $args );
?>


<div class="rq-content-block">
    <div class="container">
		<div class="rq-isotope-header">
			<h3><?php echo esc_attr( $heading_title ); ?></h3>
		</div>

    <div class="rq-isotope-filter-area">
			<ul id="filters" class="button-groups rq-isotope-filters">
				<li>
					<span class="rq-label"><?php echo esc_attr( $search_text ); ?></span>
					<div class="rq-filter-item">
						<div class="rq-input-wrapper">
							<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 512 512">
								<g>
									<path d="M495,466.2L377.2,348.4c29.2-35.6,46.8-81.2,46.8-130.9C424,103.5,331.5,11,217.5,11C103.4,11,11,103.5,11,217.5   S103.4,424,217.5,424c49.7,0,95.2-17.5,130.8-46.7L466.1,495c8,8,20.9,8,28.9,0C503,487.1,503,474.1,495,466.2z M217.5,382.9   C126.2,382.9,52,308.7,52,217.5S126.2,52,217.5,52C308.7,52,383,126.3,383,217.5S308.7,382.9,217.5,382.9z"/>
								</g>
							</svg>
							<input type="text" id="quicksearch" placeholder="Search" />
						</div>
					</div>
				</li>
				<li>
					<span class="rq-label"><?php echo esc_attr( $select_text ); ?></span>
					<?php if(isset($tax_sorting_options) && !empty($tax_sorting_options)): ?>
					<div class="rq-filter-item rq-isotope-model">
						<div class="rq-select-wrapper">
							<select name="car-model" id="category-option" class="category-option car-model">
								<option value=""><?php echo esc_attr( $select_placeholder ); ?></option>
								<?php foreach ($tax_sorting_options as $key => $value): ?>
									<option value="<?php echo esc_attr($value->slug); ?>"><?php echo esc_attr(ucwords($value->name)); ?></option>
								<?php endforeach; ?>
							</select>
							<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
								width="292.362px" height="292.362px" viewBox="0 0 292.362 292.362" style="enable-background:new 0 0 292.362 292.362;"
								xml:space="preserve">
								<g>
									<path d="M286.935,69.377c-3.614-3.617-7.898-5.424-12.848-5.424H18.274c-4.952,0-9.233,1.807-12.85,5.424
									C1.807,72.998,0,77.279,0,82.228c0,4.948,1.807,9.229,5.424,12.847l127.907,127.907c3.621,3.617,7.902,5.428,12.85,5.428
									s9.233-1.811,12.847-5.428L286.935,95.074c3.613-3.617,5.427-7.898,5.427-12.847C292.362,77.279,290.548,72.998,286.935,69.377z"/>
								</g>
							</svg>
						</div>
					</div>
					<?php endif; ?>
				</li>
				<li>
					<span class="rq-label"><?php echo esc_attr( $rating_text ); ?></span>
					<div class="rq-filter-item">
						<div class="rq-select-wrapper">
							<select name="rating" id="car-rating">
								<option value=""><?php echo esc_attr( $select_rating_placeholder ); ?></option>
								<option value="1">1 star</option>
								<option value="2">2 star</option>
								<option value="3">3 star</option>
								<option value="4">4 star</option>
								<option value="5">5 star</option>
							</select>
							<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
								width="292.362px" height="292.362px" viewBox="0 0 292.362 292.362" style="enable-background:new 0 0 292.362 292.362;"
								xml:space="preserve">
								<g>
									<path d="M286.935,69.377c-3.614-3.617-7.898-5.424-12.848-5.424H18.274c-4.952,0-9.233,1.807-12.85,5.424
									C1.807,72.998,0,77.279,0,82.228c0,4.948,1.807,9.229,5.424,12.847l127.907,127.907c3.621,3.617,7.902,5.428,12.85,5.428
									s9.233-1.811,12.847-5.428L286.935,95.074c3.613-3.617,5.427-7.898,5.427-12.847C292.362,77.279,290.548,72.998,286.935,69.377z"/>
								</g>
							</svg>
						</div>
					</div>
				</li>

			</ul>

			<div class="row rq-car-grid">
				<?php
					if( isset( $products) && !empty( $products) ) :
						foreach ($products as $key => $product) :
							$product_id 		= $product->ID;
							$title 				= $product->post_title;
							$permalink 			= get_permalink( $product_id );
							$feature_img_url 	= get_the_post_thumbnail_url( $product_id,'full' );
							$average_rating 	= get_post_meta( $product_id, '_wc_average_rating', true);
							$price 				= get_post_meta( $product_id, '_price', true );
							$star 				= floor( $average_rating ).'star';
							$seats 				= get_post_meta( $product_id, '_turbowp_car_nice_image_seat', true);
							$selected_cat 		= wp_get_post_terms($product_id, 'product_cat', array("fields" => "all"));

                            $cat_slugs = array_map(function($cat) {
                                return $cat->slug;
                            }, $selected_cat);

							$cat_slug_classes 	= !empty( $cat_slugs ) ? implode( ' ', $cat_slugs ) : '';
							$all_css_classes 	= $star.' '.$cat_slug_classes;


                        ?>
						<div class="col-md-4 rq-filter-grid-item <?php echo esc_attr($all_css_classes); ?>">
							<div class="rq-filter-inner-wrapper wow fadeInLeft" data-wow-duration="500ms">
                <div class="image-container">
									<div class="hover-btn">
										<a href="<?php echo esc_url($permalink); ?>">Book Now</a>
									</div>
									<a href="<?php echo esc_url($permalink); ?>">
										<img src="<?php echo esc_url($feature_img_url); ?>" alt="">
									</a>
								</div>
								<div class="rq-filter-item-content">
                  <div class="footer-content">
										<span class="price"><?php echo wc_price($price); ?><?php echo esc_attr( $price_type ); ?></span>
									</div>
									<h4><a href="<?php echo esc_url($permalink); ?>"><?php echo esc_attr($title); ?></a></h4>
									<span class="seats"><?php echo esc_attr( $seats ) ?></span>
									<div class="footer-content">
										<span class="rating"><i class="fa fa-star"></i> <?php echo esc_attr($average_rating); ?></span>
									</div>
								</div>
							</div>
						</div>
						<?php
						endforeach;
					endif;
				?>
			</div>

		</div>
		<div class="rq-isotope-filter-footer">
			<a class="rq-filter-all-btn" href="<?php echo esc_url( $all_car_button_link ); ?>"><span class="btn-text"> <?php echo esc_attr( $all_car_button_text ); ?></span> <i class="ion-arrow-right-c"></i></a>
		</div>
	</div>
</div>
