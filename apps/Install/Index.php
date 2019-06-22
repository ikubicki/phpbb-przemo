<?php

namespace PHPBB\Applications\Install;

use PHPBB\Applications\Library\RichController;

class Index extends RichController
{
    
    public function getIndex($request, $route)
    {
        $l10n = $this->l10n();
        $l10n->load('main');
        $l10n->load('admin');
        $l10n->load('install');
        $l10n->load('profile');
        
        if (defined("PHPBB_INSTALLED")) {
             return $this->go('index','step2');
        }
        
        $modifiedFiles = ChecksumWarning::getModifiedFiles();
        if (count($modifiedFiles)) {
            return $this->go('index', 'ChecksumWarning', ['files' => $modifiedFiles]);
        }
        
        return $this->go('index', 'step1');
    }
    
    public function getStep1($request, $route)
    {
        $l10n = $this->l10n();
        $form = $this->form();
        $form->name = 'install';
        $form->action = $route;
        $form->setEncryptionKey(__CLASS__);
        $messages = [
            'Welcome_install',
            'Inst_Step_0',
            'Initial_config',
            'Default_lang',
            'Server_name',
            'Server_port',
            'Script_path',
            'dbms',
            'DB_config',
            'DB_Host',
            'DB_Name',
            'DB_Username',
            'DB_Password',
            'Table_Prefix',
            'Admin_config',
            'Admin_config_e',
            'Admin_email',
            'Admin_Username',
            'Admin_Password',
            'Admin_Password_confirm',
            'Start_Install',
        ];
        
        foreach ($messages as $message) {
            $messages[$message] = $l10n->get($message);
        }
        
        $messages['welcome'] = $messages['Welcome_install'];
        $errors = [];
        $dbmsSelect = $form->select();
        $dbmsSelect->addOption('mysql', 'MySQL');
        $langSelect = $form->select($l10n->getLanguage());
        $langSelect->addOption('en', 'English');
        $langSelect->addOption('pl', 'Polski');
        
        $form->addHiddenField('install_step', 1);
        $form->addHiddenField('cur_lang', $l10n->getLanguage());
        $form->addCrfHiddenField();
        $form->addField('lang', $langSelect);
        $form->addField('server_name', $form->text());
        $form->addField('server_port', $form->text());
        $form->addField('script_path', $form->text());
        $form->addField('dbms', $dbmsSelect);
        $form->addField('dbhost', $form->text());
        $form->addField('dbname', $form->text());
        $form->addField('dbuser', $form->text());
        $form->addField('dbpasswd', $form->text());
        $form->addField('prefix', $form->text());
        $form->addField('board_email', $form->text());
        $form->addField('admin_name', $form->text());
        $form->addField('admin_pass1', $form->text());
        $form->addField('admin_pass2', $form->text());
        $form->setValidationErrors($errors);
        
        $this->html('install/step1.html', [
            'messages' => $messages,
            'form' => $form,
            'errors' => $errors,
        ]);
    }
}