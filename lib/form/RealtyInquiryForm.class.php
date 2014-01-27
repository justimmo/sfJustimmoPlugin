<?php

class RealtyInquiryForm extends BaseForm
{
    public function configure()
    {
        parent::configure();

        // @todo: set default invalid, required messages for form: array('invalid' => 'Ungültig', 'required' => 'Pflichtfelder')

        $this->setWidgets(array(
            'realty_id'    => new sfWidgetFormInputHidden(),
            'first_name'   => new sfWidgetFormInput(),
            'last_name'    => new sfWidgetFormInput(),
            'phone'        => new sfWidgetFormInput(),
            'email'        => new sfWidgetFormInput(),
            'message'      => new sfWidgetFormTextarea(),
            'contact_back' => new sfWidgetFormChoice(array(
                'choices'  => array(
                    'phone' => 'Rückruf',
                    'email' => 'E-Mail',
                ),
                'multiple' => false,
                'expanded' => true,
            )),
//            'captcha' => new sfWidgetFormInput(),
        ));

        $this->setValidators(array(
            'realty_id'    => new sfValidatorNumber(),
            'first_name'   => new sfValidatorString(array(), array('required' => 'Bitte geben Sie Ihren Vornamen ein!')),
            'last_name'    => new sfValidatorString(array(), array('required' => 'Bitte geben Sie Ihren Nachnamen ein!')),
            'phone'        => new sfValidatorString(array(), array('required' => 'Bitte geben Sie Ihre Telefonnummer ein!')),
            'email'        => new sfValidatorEmail(array(), array('invalid' => 'Bitte geben Sie eine gültige E-Mail Adresse ein!', 'required' => 'Bitte geben Sie eine E-Mail Adresse ein!')),
            'message'      => new sfValidatorString(array(), array('required' => 'Pflichtfelder')),
            'contact_back' => new sfValidatorChoice(array(
                    'choices'  => array('phone', 'email'),
                    'multiple' => false,
                    'min'      => 1,
                ),
                array('required' => 'Bitte wählen Sie aus, wie Sie kontaktiert werden möchten.')
            ),
//            'captcha' => new sfValidatorSfCryptoCaptcha(
//                array('required' => true, 'trim' => true),
//                array('wrong_captcha' => 'Der Sicherheitscode wurde nicht korrekt eingegeben!', 'required' => 'Bitte geben Sie den Sicherheitscode aus der Grafik in das Textfeld ein!')
//            ),
        ));


        /* $this->getValidatorSchema()->setPostValidator(new BgValidatorObjektAnfrage()); this should be done instead of the doBind ... */

        $this->widgetSchema->setNameFormat('inquiry[%s]');
    }


    protected function doBind(array $values)
    {
        // This should not be done in the doBind apparently, not good practice!
        $contact_back = isset($values['contact_back']) ? $values['contact_back'] : null;
        if ($contact_back == "phone") {
            $this->validatorSchema['email']->setOption('required', false);
        } else if ($contact_back == "email") {
            $this->validatorSchema['phone']->setOption('required', false);
        } else {
            $this->validatorSchema['email']->setOption('required', false);
            $this->validatorSchema['phone']->setOption('required', false);
        }
        parent::doBind($values);
    }
}
