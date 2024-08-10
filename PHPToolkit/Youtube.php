<?php
namespace PHPToolkit;

class Youtube
{
    /**
     * Dominios tomados de esta lista:
     * https://gist.github.com/rodrigoborgesdeoliveira/987683cfbfcc8d800192da1e73adc486
     * @var array
     */
    private $domains = array(
        'www.youtube.com',
        'youtube.com',
        'm.youtube.com',
        'youtu.be',
        'www.youtube-nocookie.com',        
    );
    
    /**
     * Función para determinar si un dominio es considerado válido.
     * @param string $domain
     * @return bool
     */
    public function validateDomain($domain)
    {
        return in_array($domain, $this->domains);
    }
}
