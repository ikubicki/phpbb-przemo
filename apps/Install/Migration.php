<?php

namespace PHPBB\Applications\Install;

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
        $payload = [
            'dbms' => 'pdo',
            'dbhost' => $this->getFormParameter('dbhost'),
            'dbname' => $this->getFormParameter('dbname'),
            'dbuser' => $this->getFormParameter('dbuser'),
            'dbpasswd' => $this->getFormParameter('dbpasswd'),
            'table_prefix' => $this->getFormParameter('table_prefix'),
            'pdo' => [
                'dsn' => "mysql:host={$this->getFormParameter('dbhost')};dbname={$this->getFormParameter('dbname')};charset=utf8",
                'user' => $this->getFormParameter('dbuser'),
                'pass' => $this->getFormParameter('dbpasswd'),
            ],
        ];
        
        $contents = "<?php " . PHP_EOL;
        $contents .= "extract(".var_export($payload, true).");" . PHP_EOL;
        $contents .= "define('PHPBB_INSTALLED', true);" . PHP_EOL;
        
        return $contents;
        
        $filename = $phpbb_root_path . '/config.php';
        file_put_contents($filename, $contents);
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