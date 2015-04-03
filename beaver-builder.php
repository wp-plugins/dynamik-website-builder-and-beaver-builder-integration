<?php

//* Add beaver-page body class
add_filter( 'body_class', 'beaver_body_class' );
function beaver_body_class( $classes ) {
    
    $classes[] = 'beaver-page';
    return $classes;
    
}

//* Force full width content
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
 
//* Remove Feature Top
remove_action( 'wp_head', 'ez_feature_top_structure' );

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

//* Remove Fat Footer
remove_action( 'wp_head', 'ez_fat_footer_structure' );

//* Run the Genesis loop
genesis();