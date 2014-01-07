<?php

class JustimmoPluginRouting
{
    /**
     * Listens to the routing.load_configuration event in config/config.php
     *
     * @param sfEvent sfEvent
     */
    public static function listenToRoutingLoadConfigurationEvent(sfEvent $event)
    {
        $r              = $event->getSubject();
        $enabledModules = sfConfig::get('sf_enabled_modules', array());

        $r->prependRoute(
            'justimmo_realty_list',
            new sfRoute('/:sf_culture/realty/*',
                array(
                    'module' => 'justimmo',
                    'action' => 'realtyList'
                )
            )
        );

        $r->prependRoute(
            'justimmo_realty_detail',
            new sfRoute('/:sf_culture/realty/:id/*',
                array(
                    'module' => 'justimmo',
                    'action' => 'realtyDetail'
                ),
                array(
                    'id' => '[0-9]+',
                )
            )
        );
    }
}
