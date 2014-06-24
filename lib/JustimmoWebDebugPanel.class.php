<?php

class JustimmoWebDebugPanel extends sfWebDebugPanel
{
    /**
     * The array contains the messages from the JustimmoWebDebugHandler
     * and are to be displayed in the panel
     *
     * @var array
     */
    private $queries = array();
    private $all_api_calls = 0;
    private $cached_api_calls = 0;

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
     * Fetches messages from the Logger and parses them
     * so they are ready to be displayed in the sfDebugPanel
     *
     * @param array $v
     */
    public function addQuery($v)
    {
        $query = $this->processQuery($v);
        if ($query !== false) {
            $this->queries[] = $query;
        }
    }

    public function getTitle()
    {
        return '<img src="/sfJustimmoPlugin/images/debug.png" alt="' .
        $this->getPanelTitle() . '" height="16" width="16" /> ' .
        $this->cached_api_calls . ' / ' . $this->all_api_calls;
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

        foreach ($this->queries as $i => $log) {
            if ($log['text']) {
                $toggler = $this->getToggler('justimmo_debug_' . $i, 'Response Text');
            } else {
                $toggler = "";
            }
            $html[] = sprintf('<li>
    <strong class="sfWebDebugDatabaseQuery">%s %s</strong>

    <div class="sfWebDebugDatabaseLogInfo">%s</div>
    <div id="justimmo_debug_%s" style="display:none;">
        <pre class="pre-scrollable"><code>%s</code></pre>
    </div>
</li>',
                $toggler,
                $log['title'],
                $log['time'],
                $i,
                $log['text']
            );
        }

        return $html;
    }

    public function xml_highlight($s)
    {
        $doc               = new DOMDocument('1.0');
        $doc->formatOutput = true;

        // disable errors displayed on screen
        // libxml_use_internal_errors(true);

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


    /**
     * @param $query
     * @return array
     */
    private function processQuery($query)
    {
        $title = "";
        $time  = "";
        $text  = "";
        $msg     = $query['message'];
        $context = $query['context'];

        /**
         * We only analyze the logged entries that have 'call end'
         * Here we can check if the response is cached or not,
         * get the response time, response text, etc.
         */
        if (strpos($msg, 'call end') !== false) {
            ++$this->all_api_calls;

            if ($context['cache']) {
                ++$this->cached_api_calls;
                $title .= '<span style="background-color: #B1E7A4;">';
            } else {
                $title .= '<span style="background-color: #FFBABA;">';
            }
            // We use parse_url() because we don't want to show the full URL, just the request path/querystring
            $url = parse_url($context['url']);
            $title .= $url['path'];
            if (isset($url['query'])) {
                $title .= '?' . $url['query'];
            }
            $title .= '</span>';

            $time = "Time: " . number_format($context['time'], 5);

            $text = '<p>URL: <a target="_blank" href="' . $context['url'] . '">' . $context['url'] . '</a></p>';
            $text .= $this->xml_highlight($context['response']);
        }

        if ($title != false) {
            return array(
                'title' => $title,
                'time'  => $time,
                'text'  => $text,
            );
        }

        return false;
    }
}
