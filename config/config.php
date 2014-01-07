<?php
if (in_array('justimmo', sfConfig::get('sf_enabled_modules'))) {
    $this->dispatcher->connect(
        'routing.load_configuration',
        array('JustimmoPluginRouting', 'listenToRoutingLoadConfigurationEvent')
    );
}
