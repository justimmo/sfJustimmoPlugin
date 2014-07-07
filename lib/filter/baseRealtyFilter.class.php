<?php

/**
 * The widgets used in the filter form must match the filter mapping of the RealtyMapper class.
 *
 * Class baseRealtyFilter
 */
class baseRealtyFilter extends BaseForm
{
    /** @var Justimmo\Model\Query\BasicDataQuery $basicdata */
    protected $basicdata = null;
    protected $countries = array();
    protected $countries_with_id = array();
    protected $federal_states = array();
    protected $federal_states_validator_values = array();
    protected $realty_types = array();

    public function setup()
    {
        sfApplicationConfiguration::getActive()->loadHelpers(array('I18N'));

        /** @var Symfony\Component\DependencyInjection\ContainerBuilder $this->container */
        $this->container = sfApplicationConfiguration::getActive()->getContainer();
        $this->basicdata = $this->container->get('justimmo.query.basicdata');
        $this->setCountries();
        $this->setFederalStates();
        $this->setRealtyTypes();


        $this->setWidget('kauf', new sfWidgetFormInputCheckbox());
        $this->setValidator('kauf', new sfValidatorBoolean());

        $this->setWidget('miete', new sfWidgetFormInputCheckbox());
        $this->setValidator('miete', new sfValidatorBoolean());

        $this->setWidget('objektnummer_von', new sfWidgetFormInput());
        $this->setValidator('objektnummer_von', new sfValidatorString(array('required' => false)));

        $this->setWidget('objektnummer_bis', new sfWidgetFormInput());
        $this->setValidator('objektnummer_bis', new sfValidatorString(array('required' => false)));

        $this->setWidget('preis_von', new sfWidgetFormInput());
        $this->setValidator('preis_von', new sfValidatorNumber(array('required' => false)));

        $this->setWidget('preis_bis', new sfWidgetFormInput());
        $this->setValidator('preis_bis', new sfValidatorNumber(array('required' => false)));

        $this->setWidget('zimmer_von', new sfWidgetFormInput());
        $this->setValidator('zimmer_von', new sfValidatorNumber(array('required' => false)));

        $this->setWidget('zimmer_bis', new sfWidgetFormInput());
        $this->setValidator('zimmer_bis', new sfValidatorNumber(array('required' => false)));

        $this->setWidget('plz_von', new sfWidgetFormInput());
        $this->setValidator('plz_von', new sfValidatorInteger(array('required' => false)));

        $this->setWidget('plz_bis', new sfWidgetFormInput());
        $this->setValidator('plz_bis', new sfValidatorInteger(array('required' => false)));

        $this->setWidget('wohnflaeche_von', new sfWidgetFormInput());
        $this->setValidator('wohnflaeche_von', new sfValidatorNumber(array('required' => false)));

        $this->setWidget('wohnflaeche_bis', new sfWidgetFormInput());
        $this->setValidator('wohnflaeche_bis', new sfValidatorNumber(array('required' => false)));

        $this->setWidget('nutzflaeche_von', new sfWidgetFormInput());
        $this->setValidator('nutzflaeche_von', new sfValidatorNumber(array('required' => false)));

        $this->setWidget('nutzflaeche_bis', new sfWidgetFormInput());
        $this->setValidator('nutzflaeche_bis', new sfValidatorNumber(array('required' => false)));

        $this->setWidget('grundflaeche_von', new sfWidgetFormInput());
        $this->setValidator('grundflaeche_von', new sfValidatorNumber(array('required' => false)));

        $this->setWidget('grundflaeche_bis', new sfWidgetFormInput());
        $this->setValidator('grundflaeche_bis', new sfValidatorNumber(array('required' => false)));

        $this->setWidget('objektart_id', new sfWidgetFormChoice(array(
            'choices'          => $this->realty_types,
            'multiple'         => true,
            'expanded'         => true,
            'renderer_class'   => 'sfWidgetFormSelectCheckbox',
            'renderer_options' => array('formatter' => array('baseRealtyFilter', 'CheckboxInlineFormatter')),
        )));
        $this->setValidator('objektart_id', new sfValidatorChoice(array(
            'choices'  => array_keys($this->realty_types),
            'multiple' => true,
            'required' => false,
        )));

        $this->setWidget('land_iso2', new sfWidgetFormChoice(array(
            'choices'  => $this->countries,
            'multiple' => false,
            'expanded' => false,
        )));
        $this->setValidator('land_iso2', new sfValidatorChoice(array(
            'choices'  => array_keys($this->countries),
            'multiple' => false,
            'required' => false,
        )));

        $this->setWidget('bundesland_id', new sfWidgetFormChoice(array(
            'choices'  => $this->federal_states,
            'multiple' => false,
            'expanded' => false,
        )));
        $this->setValidator('bundesland_id', new sfValidatorChoice(array(
            'choices'  => $this->federal_states_validator_values,
            'multiple' => false,
            'required' => false,
        )));

        $this->setWidget('stichwort', new sfWidgetFormInput());
        $this->setValidator('stichwort', new sfValidatorString(array('max_length' => 255, 'required' => false)));


        $this->setWidget('balkon', new sfWidgetFormInputCheckbox());
        $this->setWidget('terrasse', new sfWidgetFormInputCheckbox());
        $this->setWidget('loggia', new sfWidgetFormInputCheckbox());

        $this->setValidator('balkon', new sfValidatorBoolean(array('required' => false)));
        $this->setValidator('terrasse', new sfValidatorBoolean(array('required' => false)));
        $this->setValidator('loggia', new sfValidatorBoolean(array('required' => false)));

        $this->getWidgetSchema()->setNameFormat("filter_realty[%s]");

        $this->widgetSchema->setLabels(array(
            'preis_von'        => __('Preis von'),
            'preis_bis'        => __('Preis bis'),
            'zimmer_von'       => __('Zimmer von'),
            'zimmer_bis'       => __('Zimmer bis'),
            'wohnflaeche_von'  => __('Wohnfläche von'),
            'wohnflaeche_bis'  => __('Wohnfläche bis'),
            'nutzflaeche_von'  => __('Nutzfläche von'),
            'nutzflaeche_bis'  => __('Nutzfläche bis'),
            'grundflaeche_von' => __('Grundfläche von'),
            'grundflaeche_bis' => __('Grundfläche bis'),
            'plz_von'          => __('Postleitzahl von'),
            'plz_bis'          => __('Postleitzahl bis'),
            'bundesland_id'    => __('Bundesland'),
        ));
    }

    protected function setCountries()
    {
        $countries = $this->basicdata->findCountries();

        $this->countries[''] = __('Alle');
        foreach ($countries as $id => $country) {
            $this->countries[$country['iso2']] = $country['name'];
            $this->countries_with_id[$id]      = $country['name'];
        }
        ksort($this->countries);
    }

    /**
     * Federal States can be used in different ways. Below, we group them by country.
     *
     * They can also be displayed individually.
     *
     * Another use case is to do an Ajax request for ->findRegions() and show the
     * regions for each Federal State in another dropdown.
     */
    protected function setFederalStates()
    {
        $federal_states = $this->basicdata->findFederalStates();

        $this->federal_states[''] = __('Alle');
        foreach ($this->countries_with_id as $country_id => $country) {
            foreach ($federal_states as $federal_state_id => $federal_state) {
                if ($country_id == $federal_state['countryId']) {
                    $this->federal_states[$country][$federal_state_id] = $federal_state['name'];
                    $this->federal_states_validator_values[]           = $federal_state_id;
                }
            }
        }
    }

    protected function setRealtyTypes()
    {
        $types = $this->basicdata->findRealtyTypes();

        $realty_types = array();
        foreach ($types as $id => $type) {
            $realty_types[$id] = $type['name'];
        }
        ksort($realty_types, SORT_NUMERIC);

        $this->realty_types = $realty_types;
    }

    /**
     * @param $widget sfWidget
     * @param $choices
     * @return string
     */
    public static function CheckboxInlineFormatter($widget, $choices)
    {
        $result = '<div class="inline-checkboxes">';
        foreach ($choices as $id => $choice) {
            $result .= '<label class="checkbox-inline" ' .
                'for="' . $id . '">' .
                $choice['input'] . ' <span>' . strip_tags($choice['label']) .
                '</span></label>';
        }
        $result .= '</div>';

        return $result;
    }
}
