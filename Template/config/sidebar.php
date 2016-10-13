        <li <?= $this->app->checkMenuSelection('ContactsItemsController', 'config') ?>>
            <?= $this->url->link(t('Contacts'), 'ContactsItemsController', 'config', array('plugin' => 'contacts')) ?>
        </li>