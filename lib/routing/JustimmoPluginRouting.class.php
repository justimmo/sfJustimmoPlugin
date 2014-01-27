<?php

class JustimmoPluginRouting
{
    /**
     * Listens to the routing.load_configuration event dispatched if the
     * justimmo module is loaded (config/config.php)
     *
     * @param sfEvent sfEvent
     */
    public static function listenToRoutingLoadConfigurationEvent(sfEvent $event)
    {
        $r = $event->getSubject();

        // Realty
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
        $r->prependRoute(
            'justimmo_realty_expose',
            new sfRoute('/:sf_culture/expose/:id/*',
                array(
                    'module' => 'justimmo',
                    'action' => 'realtyExpose'
                ),
                array(
                    'id' => '[0-9]+',
                )
            )
        );
        $r->prependRoute(
            'justimmo_realty_filter',
            new sfRoute('/:sf_culture/realty/filter/*',
                array(
                    'module' => 'justimmo',
                    'action' => 'realtyFilter'
                )
            )
        );
        $r->prependRoute(
            'justimmo_realty_filter_reset',
            new sfRoute('/:sf_culture/realty/filter/reset/yes/*',
                array(
                    'module' => 'justimmo',
                    'action' => 'realtyFilter'
                )
            )
        );

        $r->prependRoute(
            'justimmo_realty_inquiry',
            new sfRoute('/:sf_culture/realty/inquiry/*',
                array(
                    'module' => 'justimmo',
                    'action' => 'realtyInquiry'
                )
            )
        );

        // Projects
        $r->prependRoute(
            'justimmo_project_list',
            new sfRoute('/:sf_culture/projects/*',
                array(
                    'module' => 'justimmo',
                    'action' => 'projectList'
                )
            )
        );
        $r->prependRoute(
            'justimmo_project_detail',
            new sfRoute('/:sf_culture/project/:id/*',
                array(
                    'module' => 'justimmo',
                    'action' => 'projectDetail'
                ),
                array(
                    'id' => '[0-9]+',
                )
            )
        );


        // Employees
        $r->prependRoute(
            'justimmo_employee_list',
            new sfRoute('/:sf_culture/employees/*',
                array(
                    'module' => 'justimmo',
                    'action' => 'employeeList'
                )
            )
        );
        $r->prependRoute(
            'justimmo_employee_detail',
            new sfRoute('/:sf_culture/employee/:id/*',
                array(
                    'module' => 'justimmo',
                    'action' => 'employeeDetail'
                ),
                array(
                    'id' => '[0-9]+',
                )
            )
        );
    }
}
