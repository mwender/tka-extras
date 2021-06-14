<?php
namespace sfgmedicare\shortcodes;
use function sfgmedicare\utilities\{get_alert};

/**
 * Returns a link to the webinar registration page.
 *
 * @param      array  $atts {
 *   @type  string  $events_page URL of the Events page. Defaults to /events/.
 *   @type  string  $registration_link URL to the webinar registration page. Defaults to /webinar-registration/.
 * }
 *
 * @return     string  The webinar link.
 */
function get_webinar_link( $atts ){
  $args = shortcode_atts([
    'events_page' => site_url() . '/events/',
    'registration_link' => site_url() . '/webinar-registration/',
  ], $atts );

  global $post;

  if( ! function_exists( 'tribe_get_event' ) )
    return get_alert(['title' => 'Missing Plugin', 'description' => 'This shortcode requires <a href="https://wordpress.org/plugins/the-events-calendar/" target="_blank">The Events Calendar</a> plugin.']);

  $event = tribe_get_event( $post );
  $dates = $event->dates;
  $start_date = $dates->start->format('U');
  $current_date = current_time( 'timestamp' );

  $event_details = tribe_events_event_schedule_details( $post->ID );
  $event_details = preg_replace( '/\<div class="recurringinfo"\>.*<\/div>/', '', $event_details );
  $event_details = strip_tags( $event_details );

  if( $start_date < $current_date ){
    return '<p>Registration: This event has already past. Please see our <a href="' . $args['events_page'] . '">events page</a> for upcoming webinars.</p>';
  } else {
    return '<div class="elementor-button-wrapper" style="margin: 1em 0;">
      <a href="' . $args['registration_link'] . '?datetime=' . urlencode( $event_details ) . '" class="elementor-button-link elementor-button elementor-size-md" role="button">
            <span class="elementor-button-content-wrapper">
            <span class="elementor-button-text">Register for this Webinar</span>
    </span>
          </a>
    </div>';
  }
}
add_shortcode( 'webinar_registration_link', __NAMESPACE__ . '\\get_webinar_link'  );