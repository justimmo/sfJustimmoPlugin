<?php

class RealtyInquiryForm extends BaseForm
{
    public function configure()
    {
        parent::configure();

        /**
         * You can set default error messages on an Application level
         * by setting sfValidatorBase::setDefaultMessage('invalid', 'invalid error message');
         * in apps/yourApp/config/yourAppConfiguration.class.php, inside the configure() method
         */

        $this->setWidgets(array(
            'realty_id'  => new sfWidgetFormInputHidden(),
            'first_name' => new sfWidgetFormInput(),
            'last_name'  => new sfWidgetFormInput(),
            'phone'      => new sfWidgetFormInput(),
            'email'      => new sfWidgetFormInput(),
            'message'    => new sfWidgetFormTextarea(),
//            'captcha' => new sfWidgetFormInput(),
        ));

        $this->setValidators(array(
            'realty_id'  => new sfValidatorNumber(),
            'first_name' => new sfValidatorString(array(), array('required' => 'Bitte geben Sie Ihren Vornamen ein.')),
            'last_name'  => new sfValidatorString(array(), array('required' => 'Bitte geben Sie Ihren Nachnamen ein.')),
            'phone'      => new sfValidatorString(
                array('min_length' => 6),
                array(
                    'required'   => 'Bitte geben Sie Ihre Telefonnummer ein.',
                    'min_length' => 'Die Telefonnummer muss aus min. 6 Zeichen bestehen.',
                )
            ),
            'email'      => new sfValidatorEmail(
                array(),
                array(
                    'invalid'  => 'Bitte geben Sie eine gültige E-Mail Adresse ein.',
                    'required' => 'Bitte geben Sie eine E-Mail Adresse ein.'
                )
            ),
            'message'    => new sfValidatorString( /* global error messages already set */),
//            'captcha' => new sfValidatorSfCryptoCaptcha(
//                array('required' => true, 'trim' => true),
//                array('wrong_captcha' => 'Der Sicherheitscode wurde nicht korrekt eingegeben!', 'required' => 'Bitte geben Sie den Sicherheitscode aus der Grafik in das Textfeld ein!')
//            ),
        ));

        $this->widgetSchema->setNameFormat('inquiry[%s]');
    }
}
