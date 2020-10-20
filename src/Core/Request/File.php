<?php

namespace PhpBB\Core\Request;

class File
{

    public $path;
    public $name;
    public $mime;
    public $size;
    public $error = 0;

    public function __construct($data)
    {
        $this->name = $data['name'] ?? null;
        $this->error = $data['error'] ?? 0;
        if (!$this->error) {
            $this->path = $data['tmp_name'] ?? null;
            $this->mime = $data['type'] ?? null;
            $this->size = $data['size'] ?? null;
        }
    }

    public function move($destination, $mkdir = false, $overwrite = false, $chmod = 0755)
    {
        $directory = dirname($destination);
        if (!$this->path || !file_exists($this->path)) {
            throw new \Exception('Uploaded file is missing!');
        }
        if (file_exists($destination) && !$overwrite) {
            throw new \Exception('Destination file already exists!');
        }
        if (!file_exists($directory )) {
            if (!$mkdir) {
                throw new \Exception('Destination directory doesn\'t exists!');
            }
            if (!mkdir($directory, $chmod, true)) {
                throw new \Exception('Unable to create destination directory!');
            }
        }
        else if (!is_writable($directory )) {
            throw new \Exception('Destination directory is not writable!');
        }
        if (move_uploaded_file($this->path, $destination)) {
            $this->path = $destination;
            chmod($destination, $chmod);
            return true;
        }
        return false;
    }
}