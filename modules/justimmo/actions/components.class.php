<?php

class justimmoComponents extends sfComponents
{
    public function executeRealtyInquiry(sfWebRequest $request)
    {
        if (!isset($this->id)) {
            return sfView::NONE;
        }
        /** @var Justimmo\Api\JustimmoApi $api */
        $api = $this->container->get('justimmo.api');

        $this->success = false;

        $form = new RealtyInquiryForm();
        $form->bind($request->getParameter($form->getName()));

        if ($form->isValid()) {
            $api_params = array(
                'objekt_id' => $form->getValue('realty_id'),
                // @todo: fill in all params needed by postRealtyInquiry & API
            );
//            $inquiry_status = $api->postRealtyInquiry($api_params);
            $this->success = true;
        }
    }
}
