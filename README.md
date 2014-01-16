#sfJustimmoPlugin


__Composer dependencies:__


```
"require": {
    "justimmo/php-sdk":              "1.0.*",
    "symfony/dependency-injection":  "2.4.*",
    "symfony/config":                "2.4.*",
    "monolog/monolog":               "1.7.*"
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

Enable the Api Helper in apps/frontend/config/settings.yml

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

Make sure the I18N standard helper is enabled in project/application/config/settings.yml

```
all:
  .settings:
    standard_helpers:       [Partial, Cache, I18N]
```
