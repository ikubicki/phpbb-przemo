<?php

namespace PhpBB\Data;

use PhpBB\Core\Context;
use PhpBB\Core\File;

class Memoizer
{

    /**
     * @var object $object
     */
    protected $object;

    /**
     * 
     * @author ikubicki
     * @param object
     */
    public function __construct($object)
    {
        $this->object = $object;
    }

    /**
     * 
     * @author ikubicki
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public function __call($method, array $arguments)
    {
        $hash = $this->hash($method, $arguments);
        $result = $this->load($hash);
        if (!$result) {
            $result = $this->save($hash, 
                call_user_func_array([$this->object, $method], $arguments)
            );
        }
        return $result;
    }

    /**
     * 
     * @author ikubicki
     * @param string $method
     * @param array $arguments
     * @return string
     */
    protected function hash($method, array $arguments)
    {
        $class = str_replace('\\', '_', get_class($this->object));
        return $class . '_' . $method . '_' . md5(json_encode($arguments)) . '.php';
    }

    /**
     * 
     * @author ikubicki
     * @param string $hash
     * @return mixed
     */
    protected function load($hash)
    {
        // var_dump('load(' . $hash . ')');
        $file = $this->getFile($hash);
        if ($file->exists()) {
            include $file->getFilename();
            if ($result) {
                return $result;
            }
        }
        return false;
    }

    /**
     * 
     * @author ikubicki
     * @param string $hash
     * @param mixed $result
     * @return mixed
     */
    protected function save($hash, $result)
    {
        // var_dump('save', $result);
        $file = $this->getFile($hash);
        $file->clear();
        $file->writeLine('<?php');
        $file->write('$result = ');
        $file->write(var_export($result, true));
        $file->writeLine(';');
        return $result;
    }

    /**
     * 
     * @author ikubicki
     * @param string $filename
     * @return 
     */
    protected function getFile($filename)
    {
        $path = Context::getValue('cache-path', '/tmp');
        return new File("$path/$filename");
    }
}