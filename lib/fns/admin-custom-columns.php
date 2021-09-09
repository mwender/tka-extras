<?php

namespace tka\customcolumns;

/**
 * Adds columns to the Team Member CPT
 *
 * @param      array  $columns  The columns
 *
 * @return     array  Filtered $columns array
 */
function set_employee_edit_columns($columns) {
  $columns['photo']       = __( 'Photo', 'tka' );
  $columns['email']       = __( 'Email', 'tka' );
  $columns['staff_type']  = __( 'Staff Type(s)', 'tka' );
  $columns['title']       = __( 'Name', 'tka' );

  // Re-order columns
  $columns = [
    'cb' => $columns['cb'],
    'photo' => $columns['photo'],
    'title' => $columns['title'],
    'staff_type' => $columns['staff_type'],
  ];
  return $columns;
}
add_filter( 'manage_employee_posts_columns', __NAMESPACE__ . '\\set_employee_edit_columns' );

/**
 * Populates the custom columns for the Team Member CPT admin listing.
 *
 * @param      string  $column   The column
 * @param      int     $post_id  The post identifier
 */
function custom_employee_column( $column, $post_id ){
  switch( $column ){
    case 'title':
      $title = get_post_meta( $post_id, 'title', true );
      echo $title;
      break;

    case 'photo':
      if( has_post_thumbnail( $post_id ) )
        the_post_thumbnail('thumbnail', ['style' => 'width: 48px; height: 48px;'] );
      break;

    case 'staff_type':
      $staff_types = get_the_term_list( $post_id, 'staff_type' );
      if( is_string( $staff_types ) )
        echo $staff_types;
      break;
  }
}
add_action( 'manage_employee_posts_custom_column', __NAMESPACE__ . '\\custom_employee_column', 10, 2 );