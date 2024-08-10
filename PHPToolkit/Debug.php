<?php
namespace PHPToolkit;

class Debug
{    
    public static function dump($data, $var_dump = false, $exit = false, $exit_text = '', $hide = false, $backtrace = false)
    {   
        $style = 'color: #DD1144;';
        if ($hide) {
            $style .= 'display: none;';
        }
        
        print '<pre class="debug" style="' . $style . '">';
        
        print 'value:';
        print PHP_EOL;
        
        if ($var_dump) {
            var_dump($data);
        } else {
            print_r($data);    
        }
        
        if ($backtrace) {
            print PHP_EOL;
            debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        }
        
        print '</pre>';
        
        if ($exit) {
            exit($exit_text);
        }
    }
    
}
