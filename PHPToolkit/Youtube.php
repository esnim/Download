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
    
    /**
     * Función para obtener el id de un video a partir de su URL.
     * @param string $url
     * @return string
     */
    public function getId($url)
    {        
        $parts = parse_url($url);

        if (!$parts) {
            return '';
        }
        
        $id = '';
        $query = '';
        
        if ($parts['host'] == 'youtu.be') {
            $id = trim($parts['path'], '/');
        } else {

            if ($parts['path'] == '/watch') {
                parse_str($parts['query'], $query);
                $id = $query['v'];
            }

        }
        
        return $id;
    }

    /**
     * Función para obtener las URLs de los thumbnails de un video.
     * "0.jpg" corresponde a una imagen grande de 480 x 360 pixels.
     * Todas las demás son de 120 x 90 pixels.
     * @param string $id
     * @return string
     */
    public function getThumbnails($id)
    {
        $thumbs = array(
            'default' => "https://img.youtube.com/vi/$id/default.jpg",
                    0 => "https://img.youtube.com/vi/$id/0.jpg",
                    1 => "https://img.youtube.com/vi/$id/1.jpg",
                    2 => "https://img.youtube.com/vi/$id/2.jpg",
                    3 => "https://img.youtube.com/vi/$id/3.jpg",
        );
        
        return $thumbs;
    }
}
