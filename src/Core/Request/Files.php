<?php

namespace PhpBB\Core\Request;

class Files
{
    public function __get($parameter)
    {
        return $this->get($parameter);
    }

    public function get($parameter, $alternative = null)
    {
        $file = $_FILES[$parameter] ?? [];
        if (count($file)) {
            $files = $file;
            if (array_key_exists('tmp_name', $file)) {
                if (is_array($file['tmp_name'])) {
                    $files = [];
                    foreach($file['tmp_name'] as $i => $tmp_name) {
                        $files[] = [
                            'tmp_name' => $file['tmp_name'][$i],
                            'type' => $file['type'][$i],
                            'name' => $file['name'][$i],
                            'size' => $file['size'][$i],
                            'error' => $file['error'][$i],
                        ];
                    }
                }
                else {
                    return new File($file);
                }
            }
            $collection = [];
            foreach ($files as $file) {
                if (array_key_exists('tmp_name', $file)) {
                    $collection[] = new File($file);
                }
            }
            return $collection;
        }
        return $alternative;
    }
}