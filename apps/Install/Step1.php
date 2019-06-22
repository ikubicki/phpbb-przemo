<?php
namespace PHPBB\Applications\Install;

use PHPBB\Applications\Library\RichController;
use PHPBB\Przemo\Core\Form;
use PHPBB\Przemo\Core\Routing\Route;

class Step1 extends RichController
{

    public function getIndex($request, $route)
    {
        $l10n = $this->l10n();
        $l10n->load('main');
        $l10n->load('admin');
        $l10n->load('install');
        $l10n->load('profile');
        
        $this->loadFormDefaults();
        
        $this->html('install/step1.html', [
            'messages' => [
                'content' => $l10n->get('Inst_Step_0'),
                'header' => $l10n->get('Welcome_install'),
            ],
            'form' => $this->buildForm(),
            'errors' => $this->validateRequest()
        ]);
    }
    
    
    public function getSubmit($request, $route)
    {
        return $this->get('index');
    }

    public function postSubmit($request, $route)
    {
        
        $l10n = $this->l10n();
        $l10n->load('main');
        $l10n->load('admin');
        $l10n->load('install');
        $l10n->load('profile');
        
        if (count($this->validateRequest())) {
            return $this->get('index');
        }
        
        $migration = new Migration;
        $migration->setFormData($request->request->all());
        $databaseErrors = $migration->database();
        if (count($databaseErrors)) {
            return $this->handleDatabaseErrors($databaseErrors);
        }
        try {
            $databaseErrors = $migration->schema();
        }
        catch (\Exception $exception) {
            $this->validation = ['prefix' => $l10n->get('Change_prefix')];
            return $this->get('index');
        }
        if (count($databaseErrors)) {
            return $this->handleDatabaseErrors($databaseErrors);
        }
        $databaseErrors = $migration->data();
        if (count($databaseErrors)) {
            return $this->handleDatabaseErrors($databaseErrors);
        }
        $configurationDump = $migration->config();
        if ($configurationDump) {
            return $this->handleConfigurationError($configurationDump);
        }
        return $this->redirect('step2');
    }
    
    public function postDownload($request)
    {
        $this->response->headers->add([
            'Content-Type' => 'text/x-delimtext; name="config.php"',
            'Content-disposition' => 'attachment; filename="config.php"',
        ]);
        return $this->response->setContent(base64_decode($request->request->get('context')));
    }
    
    /**
     * 
     * @author ikubicki
     * @param array $databaseErrors
     */
    protected function handleDatabaseErrors(array $databaseErrors)
    {
        $l10n = $this->l10n();
        $this->html('install/db_error.html', [
            'errors' => $databaseErrors,
            'messages' => [
                'header' => $l10n->get('Installer_Error'),
                'content' => $l10n->get('Install_db_error'),
            ],
        ]);
        return;
    }
    
    protected function handleConfigurationError($configurationDump)
    {
        
        $l10n = $this->l10n();
        $form = $this->form();
        $form->name = 'install';
        $form->setEncryptionKey(__CLASS__);
        $form->action = $this->getModuleRoute('download');
        $form->addCrfHiddenField();
        $form->addHiddenField('context', base64_encode($configurationDump));
        
        $this->html('install/config_error.html', [
            'messages' => [
                'header' => $l10n->get('Installer_Error'),
                'Go_to_forum' =>  trim($l10n->get('Forum_Index'), ' %s'),
                'File_download_trouble' => sprintf($l10n->get('File_download_trouble'), 'config.php'),
            ],
            'forum_url' => new Route('forum', 'index'),
            'dump' => $configurationDump,
            'form' => $form,
        ]);
        return;
    }
    
    protected function loadFormDefaults()
    {
        $request = $this->request;
        
        // language
        
        if (!$request->request->has('lang')) {
            $language = $this->l10n()->getLanguage();
            $request->request->set('lang', $language);
        }
        
        // server name
        if (!$request->request->has('server_name'))
        {
            if ($request->server->get('SERVER_NAME'))
            {
                $server_name = $request->server->get('SERVER_NAME');
            }
            else if ($request->server->get('HTTP_HOST'))
            {
                $server_name = $request->server->get('HTTP_HOST');
            }
            else {
                $server_name = '';
            }
            $request->request->set('server_name', $server_name);
        }
        
        // server port
        if (!$request->request->has('server_port'))
        {
            if ($request->server->get('SERVER_PORT'))
            {
                $server_port = $request->server->get('SERVER_PORT');
            }
            else
            {
                $server_port = '80';
            }
            $request->request->set('server_port', $server_port);
        }
        
        // script path
        if (!$request->request->has('script_path')) {
            $PHP_SELF = $request->server->get('PHP_SELF');
            $board_email = $request->request->get('board_email');
            $script_path = $request->request->get('script_path') ?: str_replace('install', '', dirname($PHP_SELF));
            $request->request->set('script_path', $script_path);
        }
        
        //dbms
        if (!$request->request->has('dbms')) {
            $request->request->set('dbms', 'mysql');
        }
        
        //prefix
        if (!$request->request->has('prefix')) {
            $request->request->set('prefix', 'phpbb_');
        }
    }

    /**
     *
     * @author ikubicki
     * @return Form
     */
    protected function buildForm()
    {
        $form = $this->form();
        $form->name = 'install';
        $form->action = $this->getModuleRoute('submit');
        $form->setEncryptionKey(__CLASS__);
        $dbmsSelect = $form->select();
        $dbmsSelect->addOption('mysql', 'MySQL');
        $langSelect = $form->select();
        $langSelect->addOption('en', 'English');
        $langSelect->addOption('pl', 'Polski');
        
        $form->addHiddenField('install_step', 1);
        $form->addHiddenField('cur_lang', $this->l10n()->getLanguage());
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
        $form->setValidationErrors($this->validateRequest());
        return $form;
    }
    
    protected $validation;

    /**
     *
     * @author ikubicki
     * @return array
     */
    protected function validateRequest()
    {
        if ($this->validation === null) {
            
            $l10n = $this->l10n();
            $request = $this->request;
            $this->validation = [];
            $form = $this->buildForm();
            if (!$form->verifyCrfToken()) {
                $this->validation[] = $l10n->get('TA_Expired');
            }
            if ($this->request->getMethod() != $this->request::METHOD_POST) {
                return $this->validation;
            }
            if ($request->request->get('admin_pass1') != $request->request->get('admin_pass2') || ! $request->request->get('admin_pass1')) {
                $this->validation['admin_pass1'] = $this->validation['admin_pass2'] = $l10n->get('Password_mismatch');
            }
            if (! $request->request->get('server_name')) {
                $this->validation['server_name'] = $l10n->get('Empty_server_name');
            }
            if (! $request->request->get('server_port')) {
                $this->validation['server_port'] = $l10n->get('Empty_port');
            }
            if (! $request->request->get('script_path')) {
                $this->validation['script_path'] = $l10n->get('Empty_path');
            }
            if (! $request->request->get('dbhost')) {
                $this->validation['dbhost'] = $l10n->get('Empty_dbhost');
            }
            if (! $request->request->get('dbname')) {
                $this->validation['dbname'] = $l10n->get('Empty_dbname');
            }
            if (! $request->request->get('dbuser')) {
                $this->validation['dbuser'] = $l10n->get('Empty_dbuser');
            }
            if (! $request->request->get('dbpasswd')) {
                $this->validation['dbpasswd'] = $l10n->get('Empty_dbpasswd');
            }
            if (! $request->request->get('board_email')) {
                $this->validation['board_email'] = $l10n->get('Empty_email');
            }
            if (! $request->request->get('admin_name')) {
                $this->validation['admin_name'] = $l10n->get('Empty_username');
            }
            if (! filter_var($request->request->get('board_email'), FILTER_VALIDATE_EMAIL)) {
                $this->validation['board_email'] = $l10n->get('Email_invalid');
            }
        }
        return $this->validation;
    }
}