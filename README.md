#sfJustimmoPlugin


__Composer dependencies:__


```
"require": {
    "justimmo/sf-justimmo-plugin":   "dev-master"
}
```

Symfony 1 __ProjectConfiguration.class.php__

```
class ProjectConfiguration extends sfProjectConfiguration
{
    // store a reference to DIC
    protected $container = null;

    public function setup()
    {

        $this->enablePlugins(array(
            // '...',
            'sfJustimmoPlugin',
        ));

        // Register services in DIC
        $container       = new \Symfony\Component\DependencyInjection\ContainerBuilder();
        $loader          = new \Symfony\Component\DependencyInjection\Loader\XmlFileLoader(
            $container,
            new \Symfony\Component\Config\FileLocator(__DIR__)
        );
        $loader->load('services.xml');
        $this->container = $container;
    }

    /**
     * @return \Symfony\Component\DependencyInjection\ContainerBuilder
     */
    public function getContainer()
    {
        return $this->container;
    }
}
```


Make sure the I18N and Api helpers are enabled in apps/frontend/config/settings.yml

```
all
  .settings:
    standard_helpers:       [Partial, Cache, I18N, Api]
```

You can get a reference to the __$container__ inside your actions by calling:

```

/** @var Symfony\Component\DependencyInjection\ContainerBuilder $container */
$container = $this->getContext()->getConfiguration()->getContainer();


// fetch query objects
$realty_query   = $container->get('justimmo.query.realty');
$project_query  = $container->get('justimmo.query.project');
$employee_query = $container->get('justimmo.query.employee');
```

Please check __services.xml__ for the full list of available services.


// @todo: how to overwrite actions and templates after you use the plugin
