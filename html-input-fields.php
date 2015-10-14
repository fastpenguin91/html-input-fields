<?php
/*
  Plugin Name: html input fields
  Plugin URI: http://startupinacar.com
  Description: add menus for plugin
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


  register_setting( 'hello', 'filter_explicit_stuff' );

}

function jc_callback_function(){
  echo "This is the section for JC settings plugin";
}

function jc_filter_callback($args){
    $html = '<input type="checkbox" id="filter_explicit_stuff" name="filter_explicit_stuff" value="1" ' . checked( 1, get_option( 'filter_explicit_stuff' ), false ) . '/>';
     
    $html .= '<label for="filter_explicit_stuff"> '  . $args[0] . '</label>';
     
    echo $html;
}



function jc_filter_explicit_content( $content ) {
  
  $content = str_replace( 'badword', 'b*****d', $content );
  return $content;
  
  exit;
}



if( get_option( 'filter_explicit_stuff' ) ){
  add_filter( 'the_content', 'jc_filter_explicit_content' );
}