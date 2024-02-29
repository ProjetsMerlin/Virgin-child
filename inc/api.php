<?php
function virgin_child_api() {
    register_rest_field('post', 'custom_details', array( 'get_callback' => function ( $post_arr ) {
        
        $comments = array();
        if(get_comment( $post_arr['id'] ) ) {
            $comments["comment_author"] = get_comment( $post_arr['id'] )->comment_author;
            $comments["comment_author_email"] = get_comment( $post_arr['id'] )->comment_author_email;
            $comments["comment_content"] = get_comment( $post_arr['id'] )->comment_content;
            $comments["comment_approved"] = get_comment( $post_arr['id'] )->comment_approved;
            $comments["comment_date_gmt"] = get_comment( $post_arr['id'] )->comment_date_gmt;
        }
        else {
            $comments = null;
        }
        
        if( isset($post_arr['featured_media']) && $post_arr['featured_media'] !== 0 ) {
            $image_src_arr = wp_get_attachment_image_src($post_arr['featured_media'], 'medium');
        }
        else {
            $image_src_arr = null;
        }
        
        if($post_arr['categories']) {
            $categories_name = array();
            foreach ($post_arr['categories'] as $key => $value) {
                $categories_name[] = get_the_terms(intval( $post_arr['id'] ), 'category')[$key]->name;
            }
        }
        else {
            $categories_name = null;
        }
        
        if($post_arr['tags']) {
            $tags_name = array();
            foreach ($post_arr['tags'] as $key => $value) {
                $tags_name[] = get_the_terms($post_arr['id'], 'post_tag')[$key]->name;
            }
        }
        else {
            $categories_name = false;
        }
        
        $author_name = get_the_author_meta('display_name', $post_arr['author']);
        
        return array(
            "comments" => $comments,
            "author_display_name" => $author_name,
            "categories_name" => $categories_name,
            "tags_name" => $tags_name,
            "featured_media_medium" => $image_src_arr,
        );
    },
    'update_callback' => null,
    'schema' => null
    )
);
}
add_action('rest_api_init', 'virgin_child_api');