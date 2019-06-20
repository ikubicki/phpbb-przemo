<?php

namespace PHPBB\Applications\Install;

use PHPBB\Przemo\Core\Config;
use PHPBB\Przemo\Core\StaticRegistry;

class Migration
{
    
    protected $formData = [];
    
    public function setFormData($formData)
    {
        $this->formData = $formData;
    }
    
    public function database()
    {
//         print 'database';
        return [];
        return [
            ['query' => md5(microtime()), 'error' => md5(microtime())],
            ['query' => md5(microtime()), 'error' => md5(microtime())],
            ['query' => md5(microtime()), 'error' => md5(microtime())],
            ['query' => md5(microtime()), 'error' => md5(microtime())],
        ];
    }
    
    public function schema()
    {
//         print 'schema';
        return [];
    }
    
    public function data()
    {
//         print 'data';
        return [];
    }
    
    public function config()
    {
        
        $item = '_' . base_convert(crc32(microtime()), 10, 36);
        
        $contents = "<?php " . PHP_EOL;
        $contents .= PHP_EOL;
        $contents .= 'use PHPBB\Przemo\Core\StaticRegistry;' . PHP_EOL;
        $contents .= PHP_EOL;
        $contents .= '$' . $item . ' = StaticRegistry::get("configuration");' . PHP_EOL;
        
        foreach ($this->getConfigProperties() as $property => $value) {
            $this->appendSetter($contents, $property, $value, $item);
        }
        
        $phpbb_dir = StaticRegistry::get('phpbb_dir');
        
        $filename = $phpbb_dir . '/config/config.php';
        file_put_contents($filename, $contents);
        
        if (!file_exists($filename)) {
            return $contents;
        }
        if (filesize($filename) != strlen($contents)) {
            return $contents;
        }
        return $contents;
    }
    
    public function appendSetter(&$contents, $property, $value, $item)
    {
        if (is_array($value)) {
            $subitem = '_' . base_convert(crc32("{$item}_{$property}"), 10, 36);
            $contents .= '$' . $subitem . ' = $' . $item . '->create(' . var_export($property, true) . ');' . PHP_EOL;
            foreach($value as $subproperty => $subvalue) {
                $this->appendSetter($contents, $subproperty, $subvalue, $subitem);
            }
            return;
        }
        $contents .= '$' . $item . '->set(' . var_export($property, true) . ', ' . var_export($value, true) . ');' . PHP_EOL;
    }
    
    /**
     * 
     * @author ikubicki
     * @return array
     */
    protected function getConfigProperties()
    {
        return [
            'installed' => true,
            'key' => substr(base64_encode(md5(microtime())), 2, 24),
            'database' => [
                'dsn' => "mysql:host={$this->getFormParameter('dbhost')};dbname={$this->getFormParameter('dbname')};charset=utf8",
                'user' => $this->getFormParameter('dbuser'),
                'pass' => $this->getFormParameter('dbpasswd'),
                'prefix' => $this->getFormParameter('prefix'),
            ],
        ];
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $parameter
     */
    protected function getFormParameter($parameter)
    {
        return isset($this->formData[$parameter]) ? $this->formData[$parameter] : '';
    }
    
    /**
     *
     * @author ridgerunner
     * @see https://stackoverflow.com/questions/4747808/split-mysql-queries-in-array-each-queries-separated-by
     */
    protected function SplitSQL($sqlQuery)
    {
        $regex = '%\s*((?:\'[^\'\\\\]*(?:\\\\.[^\'\\\\]*)*\'|"[^"\\\\]*(?:\\\\.[^"\\\\]*)*"|/\*[^*]*\*+(?:[^*/][^*]*\*+)*/|\#.*|--.*|[^"\';#])+(?:;|$))%x';
        if (preg_match_all($regex, trim($sqlQuery), $queries)) {
            return $queries[1];
        }
        return [];
    }
}