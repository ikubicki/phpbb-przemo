<?php

namespace PHPBB\Przemo\Core;

class L10n
{
    
    /**
     * @var string
     */
    protected $language = 'en';
    
    /**
     * @var Registry
     */
    protected $registry;
    
    /**
     * 
     * @author ikubicki
     * @param string $language
     */
    public function __construct($language = null)
    {
        if (!$language) {
            $language = $this->detectClientLanguages();
        }
        $this->language = $language;
        $this->registry = new Registry;
    }
    
    /**
     *
     * @author ikubicki
     * @param string $phrase
     * @return string
     */
    public function __get($phrase)
    {
        return $this->get($phrase);
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $phrase
     * @param mixed $unused
     * @return string
     */
    public function __call($phrase, $unused)
    {
        return $this->get($phrase);
    }
    
    /**
     * 
     * @author ikubicki
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $namespace
     */
    public function load($namespace)
    {
        $lang = [];
        include $this->getFilename($namespace);
        $this->registry->import($lang);
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $phrase
     * @return string
     */
    public function get($phrase)
    {
        return $this->registry->get($phrase, "{{ $phrase }}");
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $namespace
     * @return string
     */
    protected function getFilename($namespace)
    {
        return $this->getPhrasesDirectory() . "/lang_{$this->language}/lang_{$namespace}.php";
    }
    
    /**
     * 
     * @author ikubicki
     * @return string
     */
    protected function detectClientLanguages()
    {
        $languages = explode(',', $this->getHeader());
        foreach ($languages as $language) {
            if (array_search(substr($language, 0, 2), $this->getAvailableLanguages())) {
                return $language;
            }
        }
        return 'en';
    }
    
    /**
     * 
     * @author ikubicki
     * @return string
     */
    protected function getHeader()
    {
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            return $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        }
        return 'en';
    }
    
    /**
     * 
     * @author ikubicki
     * @return Config
     */
    protected function getConfig()
    {
        return StaticRegistry::get('configuration');
    }
    
    /**
     * 
     * @author ikubicki
     * @return array
     */
    protected function getAvailableLanguages()
    {
        return (array) $this->getConfig()->l10n->get('languages', ['en']);
    }
    
    /**
     * 
     * @author ikubicki
     * @return string
     */
    protected function getPhrasesDirectory()
    {
        return (string) $this->getConfig()->l10n->get('dir', '');
    }
}