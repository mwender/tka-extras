<?php
namespace sfgmedicare\shortcodes;
use function sfgmedicare\utilities\{get_alert};
use function sfgmedicare\templates\{render_template};

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
            <span class="elementor-button-text"><strong>Register for this Webinar</strong> - ' . $event_details . '</span>
    </span>
          </a>
    </div>';
  }
}
add_shortcode( 'webinar_registration_link', __NAMESPACE__ . '\\get_webinar_link'  );

/**
 * Lists Team Member CPTs.
 *
 * @param      array  $atts {
 *   @type  string  $type  Staff Type taxonomy slug.
 * }
 *
 * @return     string  HTML for listing Team Member CPTs.
 */
function team_member_list( $atts ){
  $args = shortcode_atts([
    'type' => null
  ], $atts );

  $query_args = [
    'numberposts' => -1,
    'post_type'   => 'team_member',
    'orderby'     => 'menu_order',
    'order'       => 'ASC',
  ];
  if( ! is_null( $args['type'] ) ){
    $type = get_term_by( 'slug', strtolower( $args['type'] ), 'staff_type' );
    if( ! $type )
      return get_alert( ['title' => 'Staff Type Not Found', 'description' => '<strong>No `' . $args['type'] . '` Staff Type</strong><br>We could not locate the Staff Type you entered. Please check your spelling, and make sure the <code>type</code> you entered matches one of the Staff Types in the admin.'] );

    $query_args['tax_query'] = [
      [
        'taxonomy'  => 'staff_type',
        'field'     => 'slug',
        'terms'     => $args['type'],
      ]
    ];
  }

  $team_members = get_posts( $query_args );
  if( ! $team_members )
    return get_alert( ['title' => 'No Team Members Found', 'description' => '<strong>No Team Members Found</strong><br/>No Team Members found. Please check your shortcode parameters.'] );

  $data = [];
  foreach( $team_members as $team_member ){

    $name = $team_member->post_title;
    $name_array = explode( ' ', $name );
    $lastname = array_pop( $name_array );
    $firstname = implode( ' ', $name_array );
    $meta = get_fields( $team_member->ID, false );

    $data['team_members'][] = [
      'name' => $name,
      'firstname' => $firstname,
      'permalink' => get_permalink( $team_member->ID ),
      'photo'     => get_the_post_thumbnail_url( $team_member->ID, 'large' ),
      'title'     => $meta['title'],
      'bio'       => get_field( 'bio', $team_member->ID ),
      'email'     => $meta['email'],
      'phone'     => $meta['office_phone'],
    ];
  }

  return render_template( 'team-members', $data );
}
add_shortcode( 'team_member_list', __NAMESPACE__ . '\\team_member_list' );