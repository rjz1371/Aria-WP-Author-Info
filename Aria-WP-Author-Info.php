<?php
/*
Plugin Name: Aria WP Author Info
Plugin URI: https://ariapadweb.ir/aria-wp-author-info-plugin-display-wordpress-writer-information/
description: View author information in posts
Version: 1.0
Author: Mr. shemsad amiri khorasani
Author URI: https://ariapadweb.ir/
License: GPL2
*/



//    Bio

function awai_wpb_author_info_box( $content ) {

    global $post;

// Detect if it is a single post with a post author
    if ( is_single() && isset( $post->post_author ) ) {

// Get author's display name
        $display_name = get_the_author_meta( 'display_name', $post->post_author );

// If display name is not available then use nickname as display name
        if ( empty( $display_name ) )
            $display_name = get_the_author_meta( 'nickname', $post->post_author );

// Get author's biographical information or description
        $user_description = get_the_author_meta( 'user_description', $post->post_author );

// Get author's website URL
        $user_website = get_the_author_meta('url', $post->post_author);

// Get link to the author archive page
        $user_posts = get_author_posts_url( get_the_author_meta( 'ID' , $post->post_author));

        if ( ! empty( $display_name ) )

            $author_details = '<p style="direction: rtl" class="awai_author_name">درباره نویسنده پست : ' . $display_name . '</p>';

        if ( ! empty( $user_description ) )
// Author avatar and bio

            $author_details .= '<p class="awai_author_details">' . get_avatar( get_the_author_meta('user_email') , 90 ) . nl2br( $user_description ). '</p>';

        $author_details .= '<p class="awai_author_links"><a href="'. $user_posts .'">نمایش تمام پست های  ' . $display_name . '</a>';

// Check if author has a website in their profile
        if ( ! empty( $user_website ) ) {

// Display author website link
            $author_details .= ' | <a href="' . $user_website .'" target="_blank" rel="nofollow">وبسایت </a></p>';

        } else {
// if there is no author website then just close the paragraph
            $author_details .= '</p>';
        }

// Pass all this info to post content
        $content = $content . '<footer class="awai_author_bio_section" >' . $author_details . '</footer>';
    }
    return $content;
}

// Add our function to the post content filter
add_action( 'the_content', 'awai_wpb_author_info_box' );

// Allow HTML in author bio section
remove_filter('pre_user_description', 'wp_filter_kses');


function awai_add_theme_scripts() {
    wp_enqueue_style( 'style', get_stylesheet_uri() );

    wp_enqueue_style( 'slider', plugin_dir_url( __FILE__ ) . 'assets/style.css', array(), '1.1', 'all');

    // wp_enqueue_script( 'script', get_template_directory_uri() . '/js/script.js', array ( 'jquery' ), 1.1, true);

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'awai_add_theme_scripts' );