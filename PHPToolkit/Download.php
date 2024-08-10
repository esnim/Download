<?php
namespace PHPToolkit;

class Download
{
    protected $directory;
    protected $file;
    
    public function __construct($directory = '', $file = '')
    {
        $this->setDirectory($directory);
        $this->setFile($file);
    }
    
    public function setDirectory($directory)
    {
        $this->directory = $directory;
    }

    public function setFile($file)
    {
        $this->file = $file;
    }
    
    /**
     * Ejecutar la descarga del archivo.
     * @throws Exception
     */
    public function down()
    {
        $this->run('attachment');
    }
    
    /**
     * Abrir el archivo en lugar de descargarlo.
     * @throws Exception
     */
    public function open()
    {
        $this->run('inline');
    }
    
    private function run($disposition)
    {
        $dir = rtrim($this->directory, '/');
        $file = $dir . '/' . $this->file;
                
        if (!is_file($file)) {
            throw new Exception;
        }
        
        // Obtener el tipo de archivo
        $file_type = $this->getMimeType($file);
        
        // Obtener el tamaño del archivo
        $file_size = filesize($file);

        // Cabeceras
        header('Content-Description: File Transfer');
        header('Content-Disposition: ' . $disposition . '; filename="' . $this->file . '"');
        header('Content-Type: ' . $file_type);
        header('Content-Length: ' . $file_size);
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        readfile($file);
        exit;
    }
    
    private function getMimeType($file)
    {        
        $result = system("file -bi '$file'");
        list($mime, $charset) = explode(';', $result);
        
        if ($mime == '') {
            $mime = 'application/octet-stream';
        }
        
        return $mime;
    }    
}
