<?php

//* Add beaver-page body class
add_filter( 'body_class', 'beaver_body_class' );
function beaver_body_class( $classes ) {
    
    $classes[] = 'beaver-page';
    return $classes;
    
}

//* Force full width content
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
 
//* Remove feature top
remove_action( 'wp_head', 'ez_feature_top_structure' );

//* Remove navigation
remove_action( 'genesis_before_header', 'genesis_do_nav' );
remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_before_header', 'genesis_do_subnav' );
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
remove_action( 'genesis_before_header', 'dynamik_mobile_nav_1' );
remove_action( 'genesis_after_header', 'dynamik_mobile_nav_1' );
remove_action( 'genesis_before_header', 'dynamik_mobile_nav_2' );
remove_action( 'genesis_after_header', 'dynamik_mobile_nav_2' );
remove_action( 'genesis_before_header', 'dynamik_dropdown_nav_1' );
remove_action( 'genesis_after_header', 'dynamik_dropdown_nav_1' );
remove_action( 'genesis_before_header', 'dynamik_dropdown_nav_2' );
remove_action( 'genesis_after_header', 'dynamik_dropdown_nav_2' );

//* Remove site header elements
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

//* Remove breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
 
//* Remove entry header
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

//* Remove Dynamik content filler
remove_action( 'genesis_loop', 'dynamik_content_filler' );

//* Remove edit link
add_filter( 'genesis_edit_post_link' , '__return_false' );

//* Remove comments template
remove_action( 'genesis_after_entry', 'genesis_get_comments_template' );

//* Remove fat footer
remove_action( 'wp_head', 'ez_fat_footer_structure' );

//* Remove site footer elements
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

//* Run the Genesis loop
genesis();