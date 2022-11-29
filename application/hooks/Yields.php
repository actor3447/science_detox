<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Yields
{

    function doYield()
    {
        global $OUT;
        $CI =& get_instance();

        $is_mobile = $CI->agent->is_mobile();
        $device = "";
        if ($is_mobile){
            $device = "m_";
        }

        $output = $CI->output->get_output();

        $CI->yield  = isset($CI->yield) ? $CI->yield : TRUE;
        $CI->layout = isset($CI->layout) ? $CI->layout : $device . 'default';


        if (isset($CI->uri->segments[1]) && $CI->uri->segments[1]== 'admin'){
            $CI->layout = 'admin_default';
        }else{
            $CI->layout = '/' . $CI->layout;
        }
        $requested = "";
        if ($CI->yield === TRUE){
            if (!preg_match('/(.+).php$/', $CI->layout)){
                $CI->layout .= '.php';
            }

            $segment    = $CI->router->fetch_class();
            $requested  = APPPATH . 'views/layouts/' . $CI->layout;
            $layout     = $CI->load->file($requested, true);
            $view       = str_replace("{yield}", $output, $layout);

        }else{
            $view = $output;
        }


        $OUT->_display($view);
    }

}
?>