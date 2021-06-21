<?php
/**
* Template Name: Winery2Home Homepage
*
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Archoda
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php

		//echo 'ACF FIeld Value : ' . var_dump(get_field_object('name', 23));

		//var_dump(get_field('winery'));

		// Get All Featured Wines
		// $posts = get_posts(array(
		// 	'post_type'			=> 'wineries',
		// 	'posts_per_page'	=> -1,
		// 	'order'				=> 'DESC',
		// 	'meta_query' => array(
		// 		'relation' => '&&',
		// 		array(
		// 			'compare_key' => 'LIKE',
		// 			'key' => 'featured',
		// 			'value' => '1',
		// 			'compare' => '=='
		// 		)
		// 	)
		// ));

		// echo print_r($posts[0]->ID);
		// echo print_r(get_fields($posts[0]->ID));

		// WP
		//			https://developer.wordpress.org/reference/classes/wp_query/
		//
		// Examples:
		//          https://wordpress.stackexchange.com/questions/168336/compare-meta-query-in-get-posts-arguments
		//			https://wordpress.org/support/topic/duplicate-post-on-custom-wp_query/
		//
		// CUSTOM FIELDS
		//			https://developer.wordpress.org/reference/classes/wp_query/#custom-field-post-meta-parameters
		// $wpq = new WP_Query([
        //     'post_type' 		=> 'wineries',
        //     'posts_per_page' 	=> -1,
		// 	'paged'          	=> max( 1, get_query_var( 'page' ) ),
		// 	'orderby'			=> 'rand',
		// 	'meta_query' 		=> array(
		// 							'relation' => '&&',
		// 							array(
		// 								'compare_key' => 'LIKE',
		// 								'key' => 'featured',
		// 								'value' => '1',
		// 								'compare' => '=='
		// 							),
		// 						)
		// ]);

		$wpq = new WP_Query([
            'post_type' 		=> 'wineries',
            'posts_per_page' 	=> -1,
			'paged'          	=> max( 1, get_query_var( 'page' ) ),
			'orderby'			=> 'rand',
			'meta_query' 		=> array(
									'relation' => '&&',
									array(
										'key' => 'products',
										'value' => '0',
										'compare' => '>'
									),
									array(
										'compare_key' => 'LIKE',
										'key' => 'featured',
										'value' => '1',
										'compare' => '=='
									),
									array(
										'compare_key' => 'LIKE',
										'key' => 'name',
										'value' => 'Chardonnay Special',
										'compare' => 'LIKE'
									),
								)
		]);
		
		//echo print_r($wpq);
		//echo 'ID = ' . $wpq->posts[0]->ID . '<br />';
		//echo 'ID = ' . $wpq->posts[1]->ID . '<br />';
		echo print_r(get_fields($wpq->posts[0]->ID));
		//echo print_r(get_fields($wpq->posts[1]->ID));

		// while ( have_posts() ) :
		// 	the_post();

		// 	get_template_part( 'template-parts/content', 'page' );

		// endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
