<?php

/**
 * The JustimmoWebDebugHandler is registered in the dependency injection container.
 *
 * The $panel is added after the dispatcher sends the event "debug.web.load_panels" as
 * you can see in the config/config.php file.
 *
 * Class JustimmoWebDebugHandler
 */
class JustimmoWebDebugHandler extends Monolog\Handler\AbstractProcessingHandler
{
    /** @var JustimmoWebDebugPanel $panel */
    private $panel = null;

    /**
     * @param JustimmoWebDebugPanel $panel
     */
    function setPanel($panel)
    {
        $this->panel = $panel;
    }


    /**
     * Writes the record down to the log of the implementing handler
     *
     * @param  array $record
     * @return void
     */
    protected function write(array $record)
    {
        $this->panel->addQuery($record);
    }
}
