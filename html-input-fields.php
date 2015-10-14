<?php
/*
  Plugin Name: html-input-fields
  Plugin URI: http://startupinacar.com
  Description: setting up different html input fields using the options array
  Author: Me
  Version: 1.0
  Author URI: http://startupinacar.com
*/

 add_action( 'admin_menu', 'jc_example_add_menu_page');


 function jc_example_add_menu_page(){
  add_menu_page( 'See me in browser', 'toplvlmenu', 'edit_pages', 'hello', 'jc_add_menu_render_admin', 'dashicons-admin-customizer' );
}


function jc_add_menu_render_admin(){
  echo "This is our admin screen"; ?>

  <form method="post" action="options.php">
   <?php do_settings_sections( 'hello' ); ?>
   <?php settings_fields( 'hello' ); ?>
   <?php submit_button(); ?>
   <?php
}



























add_action( 'admin_init', 'jc_settings_api_init' );


function jc_settings_api_init(){

  if( false == get_option( 'hello' ) || '' == get_option( 'hello' ) ) {

    $options = array(
      'filter_explicit_stuff' => '',
      'change_text_to_blue'   => ''
      );

    update_option( 'hello', $options );
  }

  add_settings_section(
    'general_settings_section',
    'jc plugin settings',
    'jc_callback_function',
    'hello'
    );

  add_settings_field(
    'filter_explicit_stuff',
    'Censor explicit content',
    'jc_filter_callback',
    'hello',
    'general_settings_section',
    array(
      'filter explicit content? If yes, then check the box!'
     )
    );

  add_settings_field(
    'change_text_to_blue',
    'Change Text Color to Blue',
    'jc_change_text_to_blue_callback',
    'hello',
    'general_settings_section',
    array(
      'change text to blue'
      )
    );

  register_setting( 'hello', 'hello' );

}

function jc_callback_function(){
  echo "This is the section for JC settings plugin";
}

function jc_filter_callback($args){

  $options = get_option( 'hello' );
//  wp_die(var_dump($options));
    $html = '<input type="checkbox" id="filter_explicit_stuff" name="hello[filter_explicit_stuff]" value="1" ' . checked( 1, $options[ 'filter_explicit_stuff' ], false ) . '/>';
     
    $html .= '<label for="filter_explicit_stuff"> '  . $args[0] . '</label>';
     
    echo $html;
}



function jc_filter_explicit_content( $content ) {
  
  $content = str_replace( 'badword', 'b*****d', $content );
  return $content;
  
  exit;
}

function jc_change_text_to_blue_callback($args){
  $options = get_option( 'hello' );

//  wp_die(var_dump($options));

  $html = '<input type="checkbox" id="change_text_to_blue" name="hello[change_text_to_blue]" value="1" ' . checked(1, $options[ 'change_text_to_blue' ], false ) . '/>';
  $html .= '<label for="change_text_to_blue"> ' . $args[0] . '</label>';

  echo $html;
}

function add_text_color_change( $content ) {
  $content = str_replace( '<p>', '<p style="color:blue;">', $content );
  return $content;
}

add_action( 'the_post', 'apply_changes_to_the_content' );

function apply_changes_to_the_content(){
  $options = get_option( 'hello' );
  if( $options[ 'filter_explicit_stuff' ] ){
    add_filter( 'the_content', 'jc_filter_explicit_content' );
  }
  if( $options[ 'change_text_to_blue' ] ){
    add_filter( 'the_content', 'add_text_color_change' );
  }

}