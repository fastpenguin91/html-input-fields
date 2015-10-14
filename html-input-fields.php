<?php
/*
  Plugin Name: html input fields
  Plugin URI: http://wordpress.org/plugins/hello-dolly/
  Description: HTML input fields
  Author: John
  Version: 1.6
  Author URI: http://startupinacar.com
*/



add_action( 'admin_init', 'jc_settings_api_init' );


function jc_settings_api_init(){
  add_settings_section(
    'general_settings_section',
    'jc plugin settings',
    'jc_callback_function',
    'general'
    );

  add_settings_field(
    'filter_explicit_stuff',
    'Censor explicit content',
    'jc_filter_callback',
    'general',
    'general_settings_section',
    array(
      'filter explicit content? If yes, then check the box!'
     )
    );

  add_settings_field(
    'change_text_to_blue',
    'Change Text Color to Blue',
    'jc_change_text_to_blue_callback',
    'general',
    'general_settings_section',
    array(
      'change text to blue'
      )
    );

  add_settings_field(
    'determine_text_color',
    'determine text color',
    'determine_text_color_callback',
    'general',
    'general_settings_section',
    array(
      'determine the text color'
      )
    );

  


  register_setting( 'general', 'filter_explicit_stuff' );
  register_setting( 'general', 'change_text_to_blue' );
  register_setting( 'general', 'determine_text_color' );

}

function jc_callback_function(){
  echo "This is the section for JC settings plugin";
}

function jc_filter_callback($args){
    $html = '<input type="checkbox" id="filter_explicit_stuff" name="filter_explicit_stuff" value="1" ' . checked( 1, get_option( 'filter_explicit_stuff' ), false ) . '/>';
     
    $html .= '<label for="filter_explicit_stuff"> '  . $args[0] . '</label>';
     
    echo $html;
}

function jc_change_text_to_blue_callback($args){

  
  $html = '<input type="checkbox" id="change_text_to_blue" name="change_text_to_blue" value="1" ' . checked(1, get_option( 'change_text_to_blue' ), false ) . '/>';
  $html .= '<label for="change_text_to_blue"> ' . $args[0] . '</label>';

  echo $html;
}

function determine_text_color_callback($args){
  $html = '<input type="checkbox" id="determine_text_color" name="determine_text_color" value="1" ' . checked( 1, get_option( 'determine_text_color' ), false ) . '/>';
     
    $html .= '<label for="determine_text_color"> '  . $args[0] . '</label>';
     
    echo $html;
}


function jc_filter_explicit_content( $content ) {
  
  $content = str_replace( 'badword', 'b*****d', $content );
  return $content;
  
  exit;
}

function add_text_color_change( $content ) {
  $content = str_replace( '<p>', '<p style="color:blue;">', $content );
  return $content;
}

function jc_determine_text_color( $content ) {
  $content = str_replace( '<p>', '<p style="color:red;">', $content );
  return $content;
}


if( get_option( 'filter_explicit_stuff' ) ){
  add_filter( 'the_content', 'jc_filter_explicit_content' );
}

if( get_option( 'change_text_to_blue' ) ){
  add_filter( 'the_content', 'add_text_color_change' );
}

if( get_option( 'determine_text_color' ) ){
  add_filter( 'the_content', 'jc_determine_text_color' );
}