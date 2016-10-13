<?php

namespace Kanboard\Plugin\Contacts;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;

class Plugin extends Base {

    public function initialize() {
        // Admin settings
        $this->template->hook->attach('template:config:sidebar', 'contacts:config/sidebar');

        // Project settings
        $this->template->hook->attach('template:project:sidebar', 'contacts:project/sidebar');

        // 
        $this->template->hook->attach('template:task:sidebar:actions', 'contacts:task/sidebar');

        //Task
        $this->template->hook->attach('template:board:task:footer', 'contacts:task/footer_icon');

        //Task details
        $this->template->hook->attach('template:task:details:first-column', 'contacts:task/footer_icon');

        //User
        $this->template->hook->attach('template:user:sidebar:information', 'metadata:user/sidebar');

        // 
        $this->template->hook->attach('template:task:show:bottom', 'contacts:task/bottom');
    }

    public function onStartup()
    {
        // Translation
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }

    public function getClasses() {
        return array(
            'Plugin\Contacts\Model' => array(
                'ContactsItemsModel',
                'ContactsTaskModel',
                'ContactsModel',
            ),
            'Plugin\Contacts\Validator' => array('ContactsValidator')
        );
    }

    public function getHelpers()
    {
        return array(
            'Plugin\Contacts\Helper' => array(
                'ContactsHelper'
            )
        );
    }

    public function getPluginName() {
        return 'Contacts';
    }

    public function getPluginDescription() {
        return t('Manage Contacts');
    }

    public function getPluginAuthor() {
        return 'Martin Middeke';
    }

    public function getPluginVersion() {
        return '1.0';
    }

    public function getPluginHomepage() {
        return 'https://github.com/Busfreak/plugin-contacts';
    }

}
