<?php namespace Diveramkt\Floatingbanner\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class CapturaEmails extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController',        'Backend\Behaviors\ReorderController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public $requiredPermissions = [
        'manage_popcaptura' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Diveramkt.Floatingbanner', 'main-menu-floatingbanners', 'side-menu-capturaemail');
    }
}
