<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  
if ( ! function_exists('css_url'))
{
    function css_url($nom)
    {
        return base_url() . 'assets/css/' . $nom . '.css';
    }
}
  
if ( ! function_exists('js_url'))
{
    function js_url($nom)
    {
        return base_url() . 'assets/javacript/' . $nom . '.js';
    }
}

if ( ! function_exists('img'))
{
    function img($nom, $alt = '', $width = '', $height = '')
    {
        return '<img src="' . img_url($nom) . '" alt="' . $alt . '" width="' . $width . '" height="' . $height . '" />';
    }
}
  
if ( ! function_exists('img_url'))
{
    function img_url($nom)
    {
        return base_url() . 'assets/images/' . $nom;
    }
}