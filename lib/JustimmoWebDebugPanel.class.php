<?php

class JustimmoWebDebugPanel extends sfWebDebugPanel
{
    /**
     * The array gets the messages from the JustimmoWebDebugHandler to be displayed in the panel
     *
     * @var array
     */
    private $queries = array();

    public static function listenToLoadDebugWebPanelEvent(sfEvent $event)
    {
        /** @var Symfony\Component\DependencyInjection\ContainerBuilder $container */
        $container = sfContext::getInstance()->getConfiguration()->getContainer();

        $panel = new JustimmoWebDebugPanel($event->getSubject());
        $container->register('justimmo.webdebug.panel', $panel);

        /** @var JustimmoWebDebugHandler $jWDHandler */
        $jWDHandler = $container->get('justimmo.webdebug.handler');
        $jWDHandler->setPanel($panel);

        $event->getSubject()->setPanel('justimmo', $panel);
    }

    /**
     * The returned array has the following keys: channel, level, formatted (message), datetime
     *
     * @param array $v
     */
    public function addQuery($v)
    {
        $this->queries[] = $v;
    }

    public function getTitle()
    {
        return '<img src="/sfJustimmoPlugin/images/debug.png" alt="' . $this->getPanelTitle() . '" height="16" width="16" /> ' . count($this->queries);
    }

    public function getPanelTitle()
    {
        return 'Justimmo';
    }

    public function getPanelContent()
    {
        return '
            <div id="sfWebDebugDatabaseLogs">
                <ol>' . implode("\n", $this->getLogs()) . '</ol>
            </div>';
    }

    public function getLogs()
    {
        $html = array();
        foreach ($this->queries as $i => $query) {
            $toggler = $this->getToggler('justimmo_debug_' . $i, 'Response Text');
            /** @var DateTime $time */
            $time   = $query['datetime'];
            $html[] = sprintf('
                <li>
                    <strong class="sfWebDebugDatabaseQuery">%s %s</strong>
                    <div class="sfWebDebugDatabaseLogInfo">Time: %s</div>
                    <div id="justimmo_debug_%s" style="display:none;">
                        <pre class="pre-scrollable"><code>%s</code></pre>
                    </div>
                </li>',
                $toggler,
                $query['level'],
                $time->format('d/m/y H:i:s'),
                $i,
                $query['formatted']
            );
        }

        return $html;
    }

    public function xml_highlight($s)
    {
        $doc               = new DOMDocument('1.0');
        $doc->formatOutput = true;

        // disable errors displayed on screen
        libxml_use_internal_errors(true);

        $doc->loadXML($s);
        $s = $doc->saveXML();

        $s = htmlspecialchars($s);
        $s = preg_replace("#&lt;([/]*?)(.*)([\s]*?)&gt;#sU",
            "<font color=\"#0000FF\">&lt;\\1\\2\\3&gt;</font>", $s);
        $s = preg_replace("#&lt;([\?])(.*)([\?])&gt;#sU",
            "<font color=\"#800000\">&lt;\\1\\2\\3&gt;</font>", $s);
        $s = preg_replace("#&lt;([^\s\?/=])(.*)([\[\s/]|&gt;)#iU",
            "&lt;<font color=\"#808000\">\\1\\2</font>\\3", $s);
        $s = preg_replace("#&lt;([/])([^\s]*?)([\s\]]*?)&gt;#iU",
            "&lt;\\1<font color=\"#808000\">\\2</font>\\3&gt;", $s);
        $s = preg_replace("#([^\s]*?)\=(&quot;|')(.*)(&quot;|')#isU",
            "<font color=\"#800080\">\\1</font>=<font color=\"#FF00FF\">\\2\\3\\4</font>", $s);
        $s = preg_replace("#&lt;(.*)(\[)(.*)(\])&gt;#isU",
            "&lt;\\1<font color=\"#800080\">\\2\\3\\4</font>&gt;", $s);
        $s = str_replace("><", "><br /><", $s);

        return $s;
    }
}
