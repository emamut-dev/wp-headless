<?php
add_action( 'rest_api_init', function () {
  register_rest_route( 'slider/v1', '/get', array(
    'methods' => 'GET',
    'callback' => 'get_slider'
  ));
});

function get_slider()
{
  $args = array(
    'post_type' => 'slider',
  );
  $post_array = new WP_Query($args);

  $slide_array = array();
  if($post_array->post_count == 0)
    return array( 'http://via.placeholder.com/1200x600', 'http://via.placeholder.com/1200x600' );

  $post_array = $post_array->posts;

  foreach ($post_array as $post)
  {
    $post->custom_fields = get_post_custom($post->ID);
    $image = wp_get_attachment_image_src( $post->custom_fields['slide_slide'][0] , 'large' );

    $slide_array[] = $image[0];
  }

  return $slide_array;
}