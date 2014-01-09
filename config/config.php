<?php

// Only load the sfJustimmoPlugin routing configuration if the 'justimmo' module is enabled for this application
if (in_array('justimmo', sfConfig::get('sf_enabled_modules'))) {
    $this->dispatcher->connect(
        'routing.load_configuration',
        array('JustimmoPluginRouting', 'listenToRoutingLoadConfigurationEvent')
    );
}

// Load the Justimmo Plugin debug bar for easily viewing what the plugin is doing e.g., requests, logs, etc
$this->dispatcher->connect(
    'debug.web.load_panels',
    array('JustimmoPluginWebDebugPanel', 'listenToLoadDebugWebPanelEvent')
);
