<?php

namespace PHPBB\Applications\Install;

use PHPBB\Applications\Library\FrontController;
use PHPBB\Przemo\Core\Routing\Route;

class Step2 extends FrontController
{
    
    public function getIndex($request, $route)
    {
        $l10n = $this->l10n();
        $l10n->load('main');
        $l10n->load('admin');
        $l10n->load('install');
        $l10n->load('profile');
        
        $form = $this->form();
        $form->name = 'install';
        $form->action = new Route('forum', 'index');
        $form->metod = $form::METHOD_GET;
        $this->html('install/step2.html', [
            'messages' => [
                'header' => $l10n->get('Finish_Install'),
                'content' =>  $l10n->get('Inst_Step_2'),
            ],
            'form' => $form,
        ]);
    }
}