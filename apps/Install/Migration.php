<?php

namespace PHPBB\Applications\Install;

use PHPBB\Przemo\Core\Config;
use PHPBB\Przemo\Core\StaticRegistry;
use PHPBB\Przemo\Core\Store\SQL;

class Migration
{
    
    protected $sql;
    protected $formData = [];
    
    /**
     * 
     * @author ikubicki
     * @param array $formData
     */
    public function setFormData(array $formData)
    {
        $this->formData = $formData;
    }
    
    /**
     * 
     * @author ikubicki
     * @return array
     */
    public function database()
    {
        $check = $this->sql()
            ->query("SHOW DATABASES LIKE ?")
            ->rows([$this->getFormParameter('dbname')]);
        
        if (count($check)) {
            $this->sql->exec('USE `' . $this->getFormParameter('dbname') . '`;');
            return [];
        }
        
        $dbms = $this->getFormParameter('dbms');
        $phpbb_dir = StaticRegistry::get('phpbb_dir');
        $sqlFilename = $phpbb_dir . '/install/migrations/' . $dbms . '/create_database.sql';
        $sql = file_get_contents($sqlFilename);
        $sql = str_replace('`phpbb`', '`' . $this->getFormParameter('dbname') . '`', $sql);
        
        $queries = $this->splitSql($sql);
        return $this->runQueries($queries);
    }
    
    /**
     * 
     * @author ikubicki
     * @param array $queries
     * @return array
     */
    protected function runQueries(array $queries)
    {
        $errors = [];
        foreach($queries as $query)
        {
            try {
                $this->sql()->exec($query);
            }
            catch(\Throwable $throwable) {
                $errors[] = [
                    'query' => $query,
                    'error' => $throwable->getMessage()
                ];
            }
        }
        return $errors;
    }
    
    public function schema()
    {
        
        $check = $this->sql()
            ->query("SHOW TABLES LIKE ?")
            ->rows([$this->getFormParameter('prefix') . '%']);
        
        if (count($check)) {
            throw new \Exception('TABLES_EXISTS');
        }
        
    }
    
    public function data()
    {
//         print 'data';
        return [];
    }
    
    /**
     * 
     * @author ikubicki
     * @return string|null
     */
    public function config()
    {
        
        // build content
        $item = '_' . base_convert(crc32(microtime()), 10, 36);
        $content = '';
        $this->appendConfigHeader($content, $item);
        foreach ($this->getConfigProperties() as $property => $value) {
            $this->appendConfigSetter($content, $property, $value, $item);
        }
        
        $phpbb_dir = StaticRegistry::get('phpbb_dir');
        
        $filename = $phpbb_dir . '/config/config.php';
        file_put_contents($filename, $content);
        
        if (!file_exists($filename)) {
            return $content;
        }
        if (filesize($filename) != strlen($content)) {
            return $content;
        }
        return null;
    }
    
    protected function sql()
    {
        if (!$this->sql) {
            
            $dsn = "mysql:host={$this->getFormParameter('dbhost')};charset=utf8";
            $this->sql = new SQL;
            $this->sql->setDsn($dsn);
            $this->sql->setPass($this->getFormParameter('dbuser'));
            $this->sql->setPrefix($this->getFormParameter('prefix'));
        }
        return $this->sql;
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $content
     * @param string $item
     */
    protected function appendConfigHeader(&$content, $item)
    {
        $content .= "<?php " . PHP_EOL;
        $content .= PHP_EOL;
        $content .= 'use PHPBB\Przemo\Core\StaticRegistry;' . PHP_EOL;
        $content .= PHP_EOL;
        $content .= '$' . $item . ' = StaticRegistry::get("configuration");' . PHP_EOL;
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $content
     * @param string $property
     * @param mixed $value
     * @param string $item
     */
    protected function appendConfigSetter(&$content, $property, $value, $item)
    {
        if (is_array($value)) {
            $subitem = '_' . base_convert(crc32("{$item}_{$property}"), 10, 36);
            $content .= '$' . $subitem . ' = $' . $item . '->create(' . var_export($property, true) . ');' . PHP_EOL;
            foreach($value as $subproperty => $subvalue) {
                $this->appendConfigSetter($content, $subproperty, $subvalue, $subitem);
            }
            return;
        }
        $content .= '$' . $item . '->set(' . var_export($property, true) . ', ' . var_export($value, true) . ');' . PHP_EOL;
    }
    
    /**
     * 
     * @author ikubicki
     * @return array
     */
    protected function getConfigProperties()
    {
        return [
            'installed' => time(),
            'key' => substr(base64_encode(md5(microtime())), 2, 24),
            'database' => [
                'dsn' => "mysql:host={$this->getFormParameter('dbhost')};dbname={$this->getFormParameter('dbname')};charset=utf8",
                'user' => $this->getFormParameter('dbuser'),
                'pass' => $this->getFormParameter('dbpasswd'),
                'options' => [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
                ],
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
     * @param string $sqlQuery
     * @return array
     * @see https://stackoverflow.com/questions/4747808/split-mysql-queries-in-array-each-queries-separated-by
     */
    protected function splitSql($sqlQuery)
    {
        $regex = '%\s*((?:\'[^\'\\\\]*(?:\\\\.[^\'\\\\]*)*\'|"[^"\\\\]*(?:\\\\.[^"\\\\]*)*"|/\*[^*]*\*+(?:[^*/][^*]*\*+)*/|\#.*|--.*|[^"\';#])+(?:;|$))%x';
        if (preg_match_all($regex, trim($sqlQuery), $queries)) {
            return $queries[1];
        }
        return [];
    }
}