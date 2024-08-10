<?php
namespace PHPToolkit;

class InfoSSL
{
    /**
     * Obtener los datos del certificado SSL a partir de una URL.
     * @param string $url
     * @return false|array
     */
    public function getInfo($url)
    {
        $parsed = parse_url($url, PHP_URL_HOST);
        $get = stream_context_create(array(
            'ssl' => array(
                'capture_peer_cert' => true
            )
        ));
        $read = stream_socket_client('ssl://' . $parsed . ':443', $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $get);
        
        if (!$read) {
            return false;
        }
        
        $cert = stream_context_get_params($read);
        $cert_info = openssl_x509_parse($cert['options']['ssl']['peer_certificate']);
        
        return $cert_info;
    }
    
    /**
     * Obtener la fecha desde la cual el certificado es válido.
     * @param array $info
     * @return string Fecha en formato "Y-m-d H:i:s"
     */
    public function getValidFrom($info)
    {
        return date('Y-m-d H:i:s', $info['validFrom_time_t']);
    }
    
    /**
     * Obtener la fecha hasta la cual el certificado es válido.
     * @param array $info
     * @return string Fecha en formato "Y-m-d H:i:s"
     */
    public function getValidTo($info)
    {
        return date('Y-m-d H:i:s', $info['validTo_time_t']);
    }
}
