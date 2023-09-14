<?php
/**
 * Plugin Name: Projects API
 * Description: This plugin registers API endpoint.
 * Author: Omer Naseem
 * Version: 1.0
 */

// Your plugin code goes here.
function projects_api(){
        register_rest_route('custom/v1','/projects', array(
            'methods'=>'GET',
            'callback'=>'get_projects_api',
        ));

}

add_action('rest_api_init','projects_api');



function get_projects_api($result){
        $args = array(
            'post_type'=>'project',
            'posts_per_page'=> -1,
        );

        $query = new WP_Query($args);

        $data = array();

        if($query->have_posts()){
            while($query->have_posts()){
                $query->the_post();

                $data[] = array(

                    'title'=> get_the_title(),
                    'image'=> get_the_post_thumbnail_url(),
                );
            
            }

            wp_reset_postdata();
        }

        return rest_ensure_response($data);
}