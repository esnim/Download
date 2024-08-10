<?php
namespace PHPToolkit;

class Vimeo
{
    /**
     * Dominios tomados de esta lista:
     * https://gist.github.com/rodrigoborgesdeoliveira/987683cfbfcc8d800192da1e73adc486
     * @var array
     */
    private $domains = array(
        'vimeo.com',
        'player.vimeo.com',   
    );
    
    /**
     * Formato en que se devolverán los resultados de la API.
     * Valores posibles: array, json.
     * Valor por defecto: array.
     * @var string
     */
    private $return_format;
    
    
    
    public function __construct()
    {
        $this->return_format = 'array';
    }
    
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
     * Función para cambiar el tipo de formato que la clase debe usar para 
     * devolver los datos de la API.
     * @param string $return_format
     */
    public function setReturnFormat($return_format)
    {
        $this->return_format = $return_format;
    }
    
    /**
     * Consultar la API para obtener información de un video a partir de su URL.
     * @param string $video_url
     * @return array|string
     */
    public function getVideoData($video_url)
    {
        $api_url = 'https://vimeo.com/api/oembed.json?url=' . $video_url;
        
        return $this->request($api_url);
    }
    
    /**
     * Acceder la API y devolver el resultado en el formato especificado en la 
     * variable $return_format.
     * @param string $api_url
     * @return array|string
     */
    public function request($api_url)
    {
        $result = false;
        
        $json = file_get_contents($api_url);
        
        if ($json !== false) {
            if ($this->return_format == 'array') {
                $result = json_decode($json, true);
            } else {
                $result = $json;
            }
        }
        
        return $result;
    }
    
    /**
     * A partir de los datos obtenidos de la API, obtener el id del video.
     * @param array $data_from_api
     * @return string
     */
    public function getVideoId($data_from_api)
    {
        $id = '';
        
        if (isset($data_from_api['video_id'])) {
            $id = $data_from_api['video_id'];
        }
        
        return $id;
    }
    
    /**
     * A partir de los datos obtenidos de la API, obtener la URL del video.
     * @param array $data_from_api
     * @return string
     */
    public function getVideoUrl($data_from_api)
    {
        $url = '';
        
        if (isset($data_from_api['video_id'])) {
            $url .= 'https://vimeo.com/';
            $url .= $data_from_api['video_id'];
        }
        
        return $url;
    }
    
    /**
     * A partir de los datos obtenidos de la API, obtener la URL y las dimensiones 
     * del thumbnail.
     * @param array $data_from_api
     * @return array [ url, width, height ]
     */
    public function getVideoThumbnail($data_from_api)
    {
        $thumb = array(
            'url'    => '',
            'width'  => 0,
            'height' => 0,
        );
        
        if (isset($data_from_api['thumbnail_url'])) {
            $thumb['url']    = $data_from_api['thumbnail_url'];
            $thumb['width']  = $data_from_api['thumbnail_width'];
            $thumb['height'] = $data_from_api['thumbnail_height'];
        }
        
        return $thumb;
    }
    
}

/*
Array
(
    [type] => video
    [version] => 1.0
    [provider_name] => Vimeo
    [provider_url] => https://vimeo.com/
    [title] => file_example_MP4_480_1_5MG
    [author_name] => Cristian Nimes
    [author_url] => https://vimeo.com/user207082141
    [is_plus] => 0
    [account_type] => free
    [html] => <iframe src="https://player.vimeo.com/video/870723716?app_id=122963" width="426" height="240" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write" title="file_example_MP4_480_1_5MG"></iframe>
    [width] => 426
    [height] => 240
    [duration] => 30
    [description] => 
    [thumbnail_url] => https://i.vimeocdn.com/video/1732898036-6fc72a7e6ed67ef1418fb11d08ec7251d42c9cb8a27eb6420f7341dc6af15349-d_295x166
    [thumbnail_width] => 295
    [thumbnail_height] => 166
    [thumbnail_url_with_play_button] => https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2F1732898036-6fc72a7e6ed67ef1418fb11d08ec7251d42c9cb8a27eb6420f7341dc6af15349-d_295x166&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png
    [upload_date] => 2023-10-03 11:43:51
    [video_id] => 870723716
    [uri] => /videos/870723716
)
*/
