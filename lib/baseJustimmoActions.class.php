<?php

/**
 * Class baseJustimmoActions
 *
 * @todo: fill in default behaviour for each method and create templates
 */
class baseJustimmoActions extends sfActions
{
    public function executeRealtyList(sfWebRequest $request)
    {
        $jp    = new sfJustimmoPlugin();
        $query = $jp::getQueryInstance();

        $this->realties = $query->find();
    }

    public function executeRealtyDetail(sfWebRequest $request)
    {
        $jp    = new sfJustimmoPlugin();
        $query = $jp::getQueryInstance();

        $this->forward404Unless($request->getParameter('id', null));

        $this->realty = $query->findPk($request->getParameter('id', null));
        $this->forward404Unless($this->realty);
    }

    public function executeRealtyExpose(sfWebRequest $request)
    {

    }

    public function executeRealtySearch(sfWebRequest $request)
    {

    }

    public function executeRealtyInquiry(sfWebRequest $request)
    {

    }

    public function executeProjectList(sfWebRequest $request)
    {

    }

    public function executeProjectDetail(sfWebRequest $request)
    {

    }

    public function executeEmployeeList(sfWebRequest $request)
    {

    }

    public function executeEmployeeDetail(sfWebRequest $request)
    {

    }
}
