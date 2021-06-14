<?php
namespace sfgmedicare\shortcodes;
use function sfgmedicare\utilities\{get_alert};

function get_webinar_link( $atts ){
  global $post;

  $args = shortcode_atts([
    'foo' => 'bar',
  ], $atts );

  if( ! function_exists( 'tribe_get_event' ) )
    return get_alert(['title' => 'Missing Plugin', 'description' => 'This shortcode requires <a href="https://wordpress.org/plugins/the-events-calendar/" target="_blank">The Events Calendar</a> plugin.']);

  //$event = tribe_get_event( $post );
  //$dates = $event->dates;

  $event_details = tribe_events_event_schedule_details( $post->ID );
  $event_details = preg_replace( '/\<div class="recurringinfo"\>.*<\/div>/', '', $event_details );
  $event_details = strip_tags( $event_details );

  return '<div style="padding: 20px; background-color: #eee;"><a href="' . site_url() . '/webinar-registration/?datetime=' . urlencode( $event_details ) . '">' . $event_details . '</a></div>';
}
add_shortcode( 'webinar_registration_link', __NAMESPACE__ . '\\get_webinar_link'  );