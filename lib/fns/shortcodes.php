<?php
namespace sfgmedicare\shortcodes;
use function sfgmedicare\utilities\{get_alert};

/**
 * Returns a link to the webinar registration page.
 *
 * @param      array  $atts {
 *   @type  string  $registration_link URL to the webinar registration page. Defaults to /webinar-registration/.
 * }
 *
 * @return     string  The webinar link.
 */
function get_webinar_link( $atts ){
  $args = shortcode_atts([
    'registration_link' => site_url() . '/webinar-registration/',
  ], $atts );

  global $post;

  if( ! function_exists( 'tribe_get_event' ) )
    return get_alert(['title' => 'Missing Plugin', 'description' => 'This shortcode requires <a href="https://wordpress.org/plugins/the-events-calendar/" target="_blank">The Events Calendar</a> plugin.']);

  //$event = tribe_get_event( $post );
  //$dates = $event->dates;

  $event_details = tribe_events_event_schedule_details( $post->ID );
  $event_details = preg_replace( '/\<div class="recurringinfo"\>.*<\/div>/', '', $event_details );
  $event_details = strip_tags( $event_details );

  return '<div style="padding: 20px; background-color: #eee;"><a href="' . $args['registration_link'] . '?datetime=' . urlencode( $event_details ) . '">' . $event_details . '</a></div>';
}
add_shortcode( 'webinar_registration_link', __NAMESPACE__ . '\\get_webinar_link'  );