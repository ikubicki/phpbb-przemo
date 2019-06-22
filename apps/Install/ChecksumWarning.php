<?php

namespace PHPBB\Applications\Install;

use PHPBB\Applications\Library\RichController;

class ChecksumWarning extends RichController
{
    
    public function getIndex($request, $route)
    {
        $l10n = $this->l10n();
        $l10n->load('main');
        $l10n->load('admin');
        $l10n->load('install');
        $l10n->load('profile');

        $l10n = $this->l10n();
        $this->html('install/checksum_warning.html', [
            'messages' => [
                'header' => $l10n->get('Welcome_install'),
                'content' => sprintf(strip_tags($l10n->get('Wrong_checksum'), '<a><b><br>'), $this->getApplicationRoute('Step1', 'index', ['mode' => 'break'])),
            ],
            'files' => !empty($route->parameters['files']) ? $route->parameters['files'] : [],
        ]);
    }
    
    /**
     * 
     * @author ikubicki
     * @return array
     */
    public static function getModifiedFiles()
    {
        return [];
        return [
            ['name' => 'aaaaaaaa', 'summary' => '12345'],
            ['name' => 'bbbbbbbb', 'summary' => '12345'],
        ];
    }
}