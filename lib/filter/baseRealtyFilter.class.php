<?php

/**
 * The widgets used in the filter form must match the filter mapping of the RealtyMapper class.
 *
 * Class baseRealtyFilter
 */
class baseRealtyFilter extends BaseForm
{
    public function setup()
    {
        $this->setWidget('objektnummer_von', new sfWidgetFormInput());
        $this->setValidator('objektnummer_von', new sfValidatorString(array('required' => false)));

        $this->setWidget('objektnummer_bis', new sfWidgetFormInput());
        $this->setValidator('objektnummer_bis', new sfValidatorString(array('required' => false)));

        $this->setWidget('plz_von', new sfWidgetFormInput());
        $this->setValidator('plz_von', new sfValidatorInteger(array('required' => false)));

        $this->setWidget('plz_bis', new sfWidgetFormInput());
        $this->setValidator('plz_bis', new sfValidatorInteger(array('required' => false)));

        $this->setWidget('preis_von', new sfWidgetFormInput());
        $this->setValidator('preis_von', new sfValidatorNumber(array('required' => false)));

        $this->setWidget('preis_bis', new sfWidgetFormInput());
        $this->setValidator('preis_bis', new sfValidatorNumber(array('required' => false)));

        $this->setWidget('zimmer_von', new sfWidgetFormInput());
        $this->setValidator('zimmer_von', new sfValidatorNumber(array('required' => false)));

        $this->setWidget('zimmer_bis', new sfWidgetFormInput());
        $this->setValidator('zimmer_bis', new sfValidatorNumber(array('required' => false)));

        $this->setWidget('kauf', new sfWidgetFormInputCheckbox());
        $this->setValidator('kauf', new sfValidatorBoolean());

        $this->setWidget('miete', new sfWidgetFormInputCheckbox());
        $this->setValidator('miete', new sfValidatorBoolean());
        // for rent/pacht, for sale, both

        // area (flaeche) min, max - wohnflaeche, nutzflaeche, grundflaeche? (baudolino)

        // features such as balkon, terrasse, loggia (baudolino)

        // rooms (zimmer) min, max

        // price min, max

        // postcode (plz) from, to (probably works like a range calculation, e.g. in wien from 1020 to 1110)

        // region (ort) (dropdown or multiple select - some also use input box, but don't think that's a good idea)
        // region in country? check http://donauimmo.at/immobilien/search under Lage -> Bundesland

        // realty type: wohnung, haus, etc (multiple select)

        // search directly by Realty Number (objektnummer: from, to) - input fields

        // searcy by keyword ("stichwort" - this can be postcode, city, etc) - input field

        // sort by: created date, postcode, area (flaeche, which one?), price - ascending, descending

        $this->getWidgetSchema()->setNameFormat("filter_realty[%s]");
    }
}
