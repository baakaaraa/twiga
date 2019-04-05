<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see       http://docs.woothemes.com/document/template-structure/
 * @author    WooThemes
 * @package   WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

/**
* woocommerce_before_single_product hook.
*
* @hooked wc_print_notices - 10
*/
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
    echo get_the_password_form();
    return;
}

global $woocommerce, $product, $post;

$product_id = $product->get_id();
$gallery = get_post_meta($product_id, '_product_image_gallery', true);

extract(turbo_extract_option_data(array(
    'show_related' => array('', 'show_related_product' ),
    'show_upsell' => array('', 'show_horizontal_upsell_products' ),
    'show_tab' => array('', 'show_product_tab_section' ),
    'book_now_heading' => array('From', 'book_now_heading' ),
    'unit_label' => array(__('/day', 'turbo'), 'unit_label' ),
    'show_gallery' => array('on', 'turbo_show_gallery_in_container' ),
)));

?>

<div itemscope id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="rq-product-page-right">
        <div class="rq-listing-details">

            <div class="rq-content-block2">
                <div class="row">

                    <div class="col-sm-8">

                        <?php if(isset($show_gallery) && $show_gallery === 'on' && !empty($gallery)) : ?>
                        <div class="rq-listing-single turbo-content-listing-gallery">
                            <div class="rq-change-button">
                                <span class="slide active"><i class="fa fa-picture-o" aria-hidden="true"></i></span>
                                <span class="map "><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                            </div>
                            <div class="rq-custom-map" id="listing-map"></div>
                            <div class="rq-listing-gallery-post">
                                <div class="rq-gallery-content">
                                    <div class="details-slider owl-carousel">
                                        <?php $gallery_img_id = explode(',', $gallery); ?>
                                        <?php if(isset($gallery_img_id) && is_array($gallery_img_id)) : ?>
                                            <?php foreach($gallery_img_id as $key=>$value) : ?>
                                                <?php $large_image = wp_get_attachment_image_src( $value ,'car-gallery'); ?>
                                                <div class="item">
                                                    <img src="<?php echo esc_url($large_image[0]); ?>" alt="">
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="rq-title-container bredcrumb-title">
                            <h2 class="rq-title light"><?php the_title(); ?></h2>
                            <?php $price = $product->get_price(); ?>
                            <h2 class="rq-product-sidebar-heading"><?php echo esc_attr($book_now_heading); ?><span class="car-price"> <?php echo wc_price($price); ?><?php echo esc_attr($unit_label); ?></span></h2>
                            <?php
                            	$show_local_pricing_flip_box = get_post_meta(get_the_ID(),'redq_rental_local_show_pricing_flip_box',true);

                            	if($show_local_pricing_flip_box === 'open'){
                            		$show_pricing_flip_box = true;
                            	}else{
                            		$show_pricing_flip_box = false;
                            	}
                            ?>

                            <?php if(isset($show_pricing_flip_box) && !empty($show_pricing_flip_box)) :  ?>
                            <div class="price-showing" style="margin-bottom:100px;">
                            	<div class="front">
                            		<div class="notice">
                            			<h3><?php esc_html_e('Show pricing','turbo'); ?></h3>
                            		</div>
                            	</div>
                            	<div class="back">
                            		<div class="item-pricing">
                            			<h5><?php esc_html_e('Season price','turbo'); ?></h5>
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

                        <div class="seasonal-prices">
                            <?php if(get_field('season_price')): ?>
                              <div class="seasonal-half">
                                <h3>Season price</h3>
                                <?php the_field('season_price'); ?>
                              </div>
                            <?php endif; ?>

                            <?php if(get_field('out_of_season_price')): ?>
                              <div class="seasonal-half">
                                <h3>Out of season price</h3>
                                <?php the_field('out_of_season_price'); ?>
                              </div>
                            <?php endif; ?>
                        </div>

                            <span class="car-avarage-rating"><?php woocommerce_template_single_rating(); ?></span>
                        </div>

                        <div class="car-desc">
                            <?php the_content(); ?>
                        </div>

                        <?php $item_attributes = WC_Product_Redq_Rental::redq_get_rental_non_payable_attributes('attributes'); ?>

                        <?php if(isset($item_attributes) && !empty($item_attributes)): ?>
                        <div class="rq-listing-promo-wrapper rq-custom">
                            <div class="row"> <!-- start of listing promo -->
                                <div class="col-md-12">
                                    <div class="rq-listing-promo-content">
                                        <?php foreach ($item_attributes as $key => $value): ?>
                                        <div class="rq-listing-item">
                                            <?php if(isset($value['selected_icon']) && $value['selected_icon'] !== 'image'): ?>
                                            <span class="attribute-icon" style="float:left"><i class="fa <?php echo esc_attr($value['icon']); ?>"></i></span>
                                            <?php else: ?>
                                            <?php $attribute_image = wp_get_attachment_image_src( $value['image']); ?>
                                            <img src="<?php echo esc_url($attribute_image['0']); ?>" alt="">
                                            <?php endif; ?>
                                            <h6 class="rq-listing-item-title"><?php echo esc_attr($value['name']); ?></h6>
                                            <h4 class="rq-listing-item-number"><?php echo esc_attr($value['value']); ?></h4>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>


                        <?php if(isset($show_tab) && !empty($show_tab)) : ?>
                        <div class="rq-feature-tab">
                            <div class="rq-blog-listing">
                                <?php
                                    /**
                                    * woocommerce_after_single_product_summary hook.
                                    *
                                    * @hooked woocommerce_output_product_data_tabs - 10
                                    */
                                    woocommerce_output_product_data_tabs();
                                ?>
                            </div>
                        </div>  <!-- ./edn feature tab -->

                        <div class="turbo-comment-template">
                            <div id="reviews">
                                <?php wc_get_template( 'single-product/turbo-comment-template.php'); ?>
                            </div>
                        </div>
                        <?php endif; ?>

                    </div><!--col-sm-8  -->

                    <div class="col-sm-4">
                        <div class="sidebar rq-content-block-right">
                            <?php $price = $product->get_price(); ?>
                            <!-- <h2 class="rq-title rq-product-sidebar-heading"><?php echo esc_attr($book_now_heading); ?><span class="car-price"> <?php echo wc_price($price); ?><?php echo esc_attr($unit_label); ?></span></h2> -->
                            <div class="rq-title-container bredcrumb-title">
                                <?php
                                  /**
                                   * woocommerce_single_product_summary hook.
                                   *
                                   * @hooked woocommerce_template_single_title - 5
                                   * @hooked woocommerce_template_single_rating - 10
                                   * @hooked woocommerce_template_single_price - 10
                                   * @hooked woocommerce_template_single_excerpt - 20
                                   * @hooked woocommerce_template_single_add_to_cart - 30
                                   * @hooked woocommerce_template_single_meta - 40
                                   * @hooked woocommerce_template_single_sharing - 50
                                   */
                                    woocommerce_template_single_add_to_cart();
                                ?>
                            </div>
                        </div>
                    </div>

                </div><!--row-->


                <?php if(isset($show_upsell) && !empty($show_upsell)) : ?>
                <div class="row">
                    <div class="turbo-upsell-products">
                        <?php woocommerce_upsell_display(); ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(isset($show_related) && !empty($show_related)) : ?>
                <div class="row">
                    <div class="turbo-related-products">
                        <?php woocommerce_output_related_products(); ?>
                    </div>
                </div>
                <?php endif; ?>

            </div> <!-- .end rq-content-block rq-content-block2-->

        </div>
    </div>

    <meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
