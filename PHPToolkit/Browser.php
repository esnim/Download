<?php
namespace PHPToolkit;

/**
 * Clase para obtener datos del navegador que está usando la visita.
 * Basado en:
 * https://gist.github.com/Balamir/4a19b3b0a4074ff113a08a92908302e2
 */
class Browser
{
    /**
     * Obtener el nombre del navegador.
     * @return string
     */
    public function getName()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $browser        = 'unknown';
        $browser_array  = array(
                '/msie/i'       =>  'Internet Explorer',
                '/firefox/i'    =>  'Firefox',
                '/safari/i'     =>  'Safari',
                '/chrome/i'     =>  'Chrome',
                '/edge/i'       =>  'Edge',
                '/opera/i'      =>  'Opera',
                '/netscape/i'   =>  'Netscape',
                '/maxthon/i'    =>  'Maxthon',
                '/konqueror/i'  =>  'Konqueror',
                '/mobile/i'     =>  'Handheld Browser'
        );

        foreach ($browser_array as $regex => $value) { 
            if (preg_match( $regex, $user_agent)) {
                $browser = $value;
            }
        }
        
        return $browser;
    }
    
    /**
     * Obtener nombre y tipo de sistema operativo.
     * @return array
     */
    public function getOperativeSystem()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $os_platform = array(
            'name' => 'unknown', 
            'type' => 'unknown',
        );
        
        $os_array =   array(
            '/windows nt 10/i'      =>  array('name' => 'Windows 10/11', 'type' => 'windows'),
            '/windows nt 6.3/i'     =>  array('name' => 'Windows 8.1', 'type' => 'windows'),
            '/windows nt 6.2/i'     =>  array('name' => 'Windows 8', 'type' => 'windows'),
            '/windows nt 6.1/i'     =>  array('name' => 'Windows 7', 'type' => 'windows'),
            '/windows nt 6.0/i'     =>  array('name' => 'Windows Vista', 'type' => 'windows'),
            '/windows nt 5.2/i'     =>  array('name' => 'Windows Server 2003/XP x64', 'type' => 'windows'),
            '/windows nt 5.1/i'     =>  array('name' => 'Windows XP', 'type' => 'windows'),
            '/windows xp/i'         =>  array('name' => 'Windows XP', 'type' => 'windows'),
            '/windows nt 5.0/i'     =>  array('name' => 'Windows 2000', 'type' => 'windows'),
            '/windows me/i'         =>  array('name' => 'Windows ME', 'type' => 'windows'),
            '/win98/i'              =>  array('name' => 'Windows 98', 'type' => 'windows'),
            '/win95/i'              =>  array('name' => 'Windows 95', 'type' => 'windows'),
            '/win16/i'              =>  array('name' => 'Windows 3.11', 'type' => 'windows'),
            '/macintosh|mac os x/i' =>  array('name' => 'Mac OS X', 'type' => 'mac'),
            '/mac_powerpc/i'        =>  array('name' => 'Mac OS 9', 'type' => 'mac'),
            '/linux/i'              =>  array('name' => 'Linux', 'type' => 'linux'),
            '/ubuntu/i'             =>  array('name' => 'Ubuntu', 'type' => 'linux'),
            '/iphone/i'             =>  array('name' => 'iPhone', 'type' => 'mobile'),
            '/ipod/i'               =>  array('name' => 'iPod', 'type' => 'mobile'),
            '/ipad/i'               =>  array('name' => 'iPad', 'type' => 'mobile'),
            '/android/i'            =>  array('name' => 'Android', 'type' => 'mobile'),
            '/blackberry/i'         =>  array('name' => 'BlackBerry', 'type' => 'mobile'),
            '/webos/i'              =>  array('name' => 'Mobile', 'type' => 'mobile'),
        );

        foreach ($os_array as $regex => $value) { 
            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
            }
        }
        
        return $os_platform;
    }
    
}
