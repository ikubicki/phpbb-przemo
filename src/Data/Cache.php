<?php

namespace PhpBB\Data;
use PhpBB\Core\File;

class Cache
{

    protected $ttl = 3600;
    protected $directory = '/tmp';
    protected static $files = [];
    
    /**
     * Sets cache TTL
     *
     * @author ikubicki
     * @param integer $ttl
     * @return Cache
     */
    public function ttl($ttl): Cache
    {
        $this->ttl = $ttl;
        return $this;
    }
    
    /**
     * Sets cache directory
     *
     * @author ikubicki
     * @param string $directory
     * @return Cache
     */
    public function directory($directory): Cache
    {
        $this->directory = $directory;
        return $this;
    }
    
    /**
     * Returns cache data if not expired
     *
     * @author ikubicki
     * @param string $name
     * @return mixed
     */
    public function collect($name)
    {
        $file = $this->getFile($name);
        if ($file->exists()) {
            $data = null;
            $expires = 0;
            include $file->getFilename();
            if ($expires > time()) {
                return $data;
            }
        }
        return false;
    }
    
    /**
     * Stores data in cache
     *
     * @author ikubicki
     * @param string $name
     * @param mixed $data
     * @return File
     */
    public function store($name, $data, $ttl = null): File
    {
        $ttl = $ttl ?: $this->ttl;
        $file = $this->getFile($name);
        $file->clear();
        $file->writeLine('<?php');
        $file->write('$expires = ');
        $file->write(var_export(time() + $ttl, true));
        $file->writeLine(';');
        $file->write('$data = ');
        $file->write(var_export($data, true));
        $file->writeLine(';');
        return $file;
    }
    
    /**
     * Deletes cache file
     *
     * @author ikubicki
     * @param string $name
     */
    public function release($name)
    {
        $this->getFile($name)->delete();
    }
    
    /**
     * Returns file object
     *
     * @author ikubicki
     * @param string $name
     * @return File
     */
    protected function getFile($name)
    {
        if (empty(self::$files[$name])) {
            self::$files[$name] = new File($this->getFilename($name));
        }
        return self::$files[$name];
    }
    
    /**
     * Returns filename
     *
     * @author ikubicki
     * @param string $name
     * @return string
     */
    protected function getFilename($name)
    {
        return "$this->directory/$name.php";
    }
}