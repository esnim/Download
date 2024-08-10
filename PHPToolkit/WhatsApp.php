<?php
namespace PHPToolkit;

class WhatsApp
{
    private $url_api = 'https://api.whatsapp.com/send?phone={{ PHONE }}&text={{ TEXT }}';
    private $url_web = 'https://web.whatsapp.com/send?phone={{ PHONE }}&text={{ TEXT }}';
    
    public function getUrlApi($phone, $text)
    {
        return str_replace(
                array('{{ PHONE }}', '{{ TEXT }}'),
                array($this->clearPhone($phone), $text),
                $this->url_api
            );
    }
    
    public function getUrlWeb($phone, $text)
    {
        return str_replace(
                array('{{ PHONE }}', '{{ TEXT }}'),
                array($this->clearPhone($phone), $text),
                $this->url_web
            );
    }
    
    public function clearPhone($phone)
    {
        return str_replace(array(' ', '-', '+', '(', ')'), '', $phone);
    }
}
