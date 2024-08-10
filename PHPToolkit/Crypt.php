<?php
namespace PHPToolkit;

class Crypt
{
    /**
     * Configuración para generar las claves.
     * @var array
     */
    private $keys_config;
    
    /**
     * Algoritmo usado para generar firmas de datos.
     * @var type
     */
    private $sign_alg;    
    
    
    public function __construct()
    {
        $this->keys_config = array(
            'private_key_bits' => 2048,
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
        );
        
        $this->sign_alg = OPENSSL_ALGO_SHA256;
    }
    
    /**
     * Generar un par de claves pública y privada.
     * @return array
     */
    public function generateKeys()
    {
        $private_key = '';
        
        // Crear las claves públicas y privadas
        $result = openssl_pkey_new($this->keys_config);

        // Extraer la clave privada y ponerla en $private_key
        openssl_pkey_export($result, $private_key);

        // Extraer la clave pública 
        $details = openssl_pkey_get_details($result);
        $public_key = $details['key'];
        
        return array(
            'public'  => $public_key,
            'private' => $private_key,
        );
    }
    
    /**
     * Encriptar datos usando la clave pública.
     * @param string $data
     * @param string $public_key
     * @return string
     * @throws \Exception
     */
    public function encrypt($data, $public_key)
    {
        if (empty($data)) {
            throw new \InvalidArgumentException('Los datos a encriptar no pueden estar vacíos.');
        }

        $this->validateKey($public_key, 'pública');

        $encrypted = '';

        // Intentar encriptar los datos
        if (!openssl_public_encrypt($data, $encrypted, $public_key)) {
            $error = openssl_error_string();
            throw new \RuntimeException("Error encriptando los datos: $error");
        }

        return $encrypted;
    }
    
    /**
     * Desencriptar datos usando la clave privada.
     * @param string $encrypted
     * @param string $private_key
     * @return string
     * @throws \Exception
     */
    public function decrypt($encrypted, $private_key)
    {
        if (empty($encrypted)) {
            throw new \InvalidArgumentException('Los datos encriptados no pueden estar vacíos.');
        }

        $this->validateKey($private_key, 'privada');

        $decrypted = '';

        // Intentar desencriptar los datos
        if (!openssl_private_decrypt($encrypted, $decrypted, $private_key)) {
            $error = openssl_error_string();
            throw new \RuntimeException("Error desencriptando los datos: $error");
        }

        return $decrypted;
    }
    
    /**
     * Generar una firma usando una clave pública.
     * @param string $data
     * @param string $private_key
     * @return string
     */
    public function sign($data, $private_key)
    {
        $signature = '';
        
        if (!openssl_sign($data, $signature, $private_key, $this->sign_alg)) {
            throw new \Exception('No se pudo firmar los datos.');
        }
        
        return $signature;
    }
    
    /**
     * Verificar la firma usando una clave pública.
     * @param string $data
     * @param string $signature
     * @param string $public_key
     * @return bool
     */
    public function verify($data, $signature, $public_key)
    {
        return openssl_verify($data, $signature, $public_key, $this->sign_alg) === 1;
    }   
    
    /**
     * Validar la clave que se intenta usar.
     * @param string $key
     * @param string $type
     * @throws \InvalidArgumentException
     */
    private function validateKey($key, $type)
    {
        if (empty($key)) {
            throw new \InvalidArgumentException("La clave $type no puede estar vacía.");
        }
    }    
}
