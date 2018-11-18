<?php

namespace App\Http;

class FileBag extends ParameterBag
{
    private static $fileKeys = array('error', 'name', 'size', 'tmp_name', 'type');

    /**
     * @param array $parameters An array of HTTP files
     */
    public function __construct(array $parameters = array())
    {
        $this->replace($parameters);
    }

    /**
     * @param array $files
     */
    public function replace(array $files = array())
    {
        $this->parameters = array();
        $this->add($files);
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        // todo UploadedFile
        if (!is_array($value) && !$value instanceof UploadedFile) {
            throw new Exception('An uploaded file must be an array or an instance of UploadedFile.');
        }

        parent::set($key, $this->convertFileInformation($value));
    }

    /**
     * @param array $files
     */
    public function add(array $files = array())
    {
        foreach ($files as $key => $file) {
            $this->set($key, $file);
        }
    }


}
