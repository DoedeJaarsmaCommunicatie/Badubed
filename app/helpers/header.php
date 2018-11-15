<?php
/**
 * Created by PhpStorm.
 * User: Mitch
 * Date: 15-11-2018
 * Time: 20:59
 */

if( ! function_exists('get_header_class' ) ) :
	function get_header_class($class = '' ) : array
	{
		global $wp_query;
		
		$classes = [];
		
		if( is_rtl() )
			$classes [] = 'rlt';
		
		if( is_front_page() )
			$classes [] = 'home';
		
		
		if( is_404() )
			$classes [] = 'error-404';
		
		if ( is_search() ) {
			$classes[] = 'search';
			$classes[] = $wp_query->posts ? 'search-results' : 'search-no-results';
        }
		
        if ( is_paged() )
        	$classes[] = 'paged';
		
		if ( is_singular() ) {
			$post_id = $wp_query->get_queried_object_id();
			$post = $wp_query->get_queried_object();
			$post_type = $post->post_type;
			
			if ( is_page_template() ) {
				$classes[] = "{$post_type}-template";
				
				$template_slug  = get_page_template_slug( $post_id );
				$template_parts = explode( '/', $template_slug );
				
				foreach ( $template_parts as $part ) {
					$classes[] = "{$post_type}-template-" . sanitize_html_class( str_replace( array( '.', '/' ), '-', basename( $part, '.php' ) ) );
				}
				$classes[] = "{$post_type}-template-" . sanitize_html_class( str_replace( '.', '-', $template_slug ) );
			} else {
				$classes[] = "{$post_type}-template-default";
			}
			
			if ( is_single() ) {
				$classes[] = 'single';
				if ( isset( $post->post_type ) ) {
					$classes[] = 'single-' . sanitize_html_class( $post->post_type, $post_id );
					$classes[] = 'postid-' . $post_id;
					
					// Post Format
					if ( post_type_supports( $post->post_type, 'post-formats' ) ) {
						$post_format = get_post_format( $post->ID );
						
						if ( $post_format && !is_wp_error($post_format) )
							$classes[] = 'single-format-' . sanitize_html_class( $post_format );
						else
							$classes[] = 'single-format-standard';
					}
				}
			}
			
			if ( is_attachment() ) {
				$mime_type = get_post_mime_type($post_id);
				$mime_prefix = array( 'application/', 'image/', 'text/', 'audio/', 'video/', 'music/' );
				$classes[] = 'attachmentid-' . $post_id;
				$classes[] = 'attachment-' . str_replace( $mime_prefix, '', $mime_type );
			} elseif ( is_page() ) {
				$classes[] = 'page';
				
				$page_id = $wp_query->get_queried_object_id();
				
				$post = get_post($page_id);
				
				$classes[] = 'page-id-' . $page_id;
				
				if ( get_pages( array( 'parent' => $page_id, 'number' => 1 ) ) ) {
					$classes[] = 'page-parent';
				}
				
				if ( $post->post_parent ) {
					$classes[] = 'page-child';
					$classes[] = 'parent-pageid-' . $post->post_parent;
				}
			}
		} elseif ( is_archive() ) {
			if ( is_post_type_archive() ) {
				$classes[] = 'post-type-archive';
				$post_type = get_query_var( 'post_type' );
				if ( is_array( $post_type ) )
					$post_type = reset( $post_type );
				$classes[] = 'post-type-archive-' . sanitize_html_class( $post_type );
			} elseif ( is_author() ) {
				$author = $wp_query->get_queried_object();
				$classes[] = 'author';
				if ( isset( $author->user_nicename ) ) {
					$classes[] = 'author-' . sanitize_html_class( $author->user_nicename, $author->ID );
					$classes[] = 'author-' . $author->ID;
				}
			} elseif ( is_category() ) {
				$cat = $wp_query->get_queried_object();
				$classes[] = 'category';
				if ( isset( $cat->term_id ) ) {
					$cat_class = sanitize_html_class( $cat->slug, $cat->term_id );
					if ( is_numeric( $cat_class ) || ! trim( $cat_class, '-' ) ) {
						$cat_class = $cat->term_id;
					}
					
					$classes[] = 'category-' . $cat_class;
					$classes[] = 'category-' . $cat->term_id;
				}
			} elseif ( is_tag() ) {
				$tag = $wp_query->get_queried_object();
				$classes[] = 'tag';
				if ( isset( $tag->term_id ) ) {
					$tag_class = sanitize_html_class( $tag->slug, $tag->term_id );
					if ( is_numeric( $tag_class ) || ! trim( $tag_class, '-' ) ) {
						$tag_class = $tag->term_id;
					}
					
					$classes[] = 'tag-' . $tag_class;
					$classes[] = 'tag-' . $tag->term_id;
				}
			} elseif ( is_tax() ) {
				$term = $wp_query->get_queried_object();
				if ( isset( $term->term_id ) ) {
					$term_class = sanitize_html_class( $term->slug, $term->term_id );
					if ( is_numeric( $term_class ) || ! trim( $term_class, '-' ) ) {
						$term_class = $term->term_id;
					}
					
					$classes[] = 'tax-' . sanitize_html_class( $term->taxonomy );
					$classes[] = 'term-' . $term_class;
					$classes[] = 'term-' . $term->term_id;
				}
			}
		}
		
		if ( is_user_logged_in() )
			$classes[] = 'logged-in';
		
		if ( is_admin_bar_showing() ) {
			$classes[] = 'admin-bar';
			$classes[] = 'no-customize-support';
		}
		
		if ( has_custom_logo() ) {
			$classes[] = 'wp-custom-logo';
		}
		
		$page = $wp_query->get( 'page' );
		
		if ( ! $page || $page < 2 )
			$page = $wp_query->get( 'paged' );
		
		if ( $page && $page > 1 && ! is_404() ) {
			$classes[] = 'paged-' . $page;
			
			if ( is_single() )
				$classes[] = 'single-paged-' . $page;
			elseif ( is_page() )
				$classes[] = 'page-paged-' . $page;
			elseif ( is_category() )
				$classes[] = 'category-paged-' . $page;
			elseif ( is_tag() )
				$classes[] = 'tag-paged-' . $page;
			elseif ( is_date() )
				$classes[] = 'date-paged-' . $page;
			elseif ( is_author() )
				$classes[] = 'author-paged-' . $page;
			elseif ( is_search() )
				$classes[] = 'search-paged-' . $page;
			elseif ( is_post_type_archive() )
				$classes[] = 'post-type-paged-' . $page;
		}
		
		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) )
				$class = preg_split( '#\s+#', $class );
			$classes = array_merge( $classes, $class );
		} else {
			// Ensure that we always coerce class to being an array.
			$class = [];
		}
		
		$classes = array_map( 'esc_attr', $classes );
		
		/**
		 * Filters the list of CSS header classes for the current post or page.
		 *
		 * @since 1.0.4
		 *
		 * @param array $classes An array of body classes.
		 * @param array $class   An array of additional classes added to the body.
		 */
		$classes = apply_filters( 'header_class', $classes, $class );
		
		return array_unique( $classes );
		return $classes;
	}
endif;

if( ! function_exists('header_class' ) ) :
	function header_class( $class = '' )
	{
		echo 'class="' . implode( ' ', get_header_class( $class ) ) . '"';
		
		sprintf('class="%s"', implode( ' ', get_header_class( $class ) ) );
	}
endif;