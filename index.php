<?php
/*
FIELDS
    What-> id,title,slug, HOW-> link, WHERE-> categories,tags,status,type, WHEN-> date, WHY-> excerpt,content, WHO-> author
    MORE-> comments ( HOW MUCH )

PAGINATION
    page, per_page, order, orderby
    
FILTER
    exemple : &cat=actus&tag=ia
    https://developer.wordpress.org/rest-api/reference/
*/

$slug_projet = site_url() . "/wp-json/wp/v2";
$fields = "?_fields=id,title,name,slug,link,categories,tags,status,type,date_gmt,excerpt,content,author,custom_details,featured_media";
$pagination = "&page=1&per_page=12&offset=0&orderby=date&order=desc";

if( is_singular() ) {
    $id = get_the_ID();
    $type = get_post_type();
    if( $type === "post") : $type = "posts"; else : $type = "pages"; endif;
    $url_final = $slug_projet. '/' .$type.  '/'.$id . $fields . $pagination;
}

else if( is_archive() && !is_author() ) {
    $taxonomy = get_queried_object()->taxonomy;
    if( $taxonomy === "category") : $taxonomy = "categories"; else : $taxonomy = "tags"; endif;
    $url_final = $slug_projet.'/'.$taxonomy . $fields . $pagination;
}

else if( is_home() ) {
    $url_final = $slug_projet . '/posts' . $fields . $pagination;
}

else if( is_author() ) {
    $url_final = $slug_projet . '/users';
}

else {
    $url_final = site_url() . '/login.php';
}

wp_redirect($url_final);