<?php
/**
 * Class baseJustimmoActions
 *
 * @todo: fill in default behaviour for each method and create templates
 */
class baseJustimmoActions extends sfActions
{
    public function preExecute()
    {
        parent::preExecute();

        /** @var Symfony\Component\DependencyInjection\ContainerBuilder $this->container */
        $this->container = $this->getContext()->getConfiguration()->getContainer();
    }

    /**
     * @todo: apply filters?
     *
     * @param sfWebRequest $request
     */
    public function executeRealtyList(sfWebRequest $request)
    {
        /** @var Justimmo\Model\RealtyQuery $query */
        $query = $this->container->get('justimmo.query.realty');

//        $this->realties = $query->filterByFloorArea(array('min' => 10, 'max' => 100))->find();
        $this->realties = $query->find();
    }

    public function executeRealtyDetail(sfWebRequest $request)
    {
        /** @var Justimmo\Model\RealtyQuery $query */
        $query = $this->container->get('justimmo.query.realty');

        $this->forward404Unless($request->getParameter('id', null));
        $this->realty = $query->findPk($request->getParameter('id', null));
        $this->forward404Unless($this->realty);
    }

    public function executeRealtyExpose(sfWebRequest $request)
    {
        /** @var Justimmo\Api\JustimmoApi $api */
        $api = $this->container->get('justimmo.api');
        $id  = $request->getParameter('id');

        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="expose-' . $id . '-' . time() . '.pdf"');

        echo $api->callExpose($id);
        return sfView::NONE;
    }

    public function executeRealtySearch(sfWebRequest $request)
    {

    }

    public function executeRealtyInquiry(sfWebRequest $request)
    {
        /** @var Justimmo\Api\JustimmoApi $api */
        $api = $this->container->get('justimmo.api');

        $inquiry_params = array();

        return $api->postRealtyInquiry($inquiry_params);
    }

    /**
     * @todo: apply filters?
     *
     * @param sfWebRequest $request
     */
    public function executeProjectList(sfWebRequest $request)
    {
        /** @var Justimmo\Model\ProjectQuery $query */
        $query = $this->container->get('justimmo.query.project');

        $this->projects = $query->find();
    }

    public function executeProjectDetail(sfWebRequest $request)
    {
        /** @var Justimmo\Model\ProjectQuery $query */
        $query = $this->container->get('justimmo.query.project');

        $this->forward404Unless($request->getParameter('id', null));
        $this->project = $query->findPk($request->getParameter('id', null));
        $this->forward404Unless($this->project);
    }

    public function executeEmployeeList(sfWebRequest $request)
    {
        /** @var Justimmo\Model\EmployeeQuery $query */
        $query = $this->container->get('justimmo.query.employee');

        $this->employees = $query->find();
        $this->categories = array();

        /** @var Justimmo\Model\Employee $employee */
        foreach ($this->employees as $employee) {
            $this->categories[$employee->getCategory()][] = $employee;
        }
    }

    public function executeEmployeeDetail(sfWebRequest $request)
    {
        /** @var Justimmo\Model\EmployeeQuery $query */
        $query = $this->container->get('justimmo.query.employee');

        $this->forward404Unless($request->getParameter('id', null));
        $this->employee = $query->findPk($request->getParameter('id', null));
        $this->forward404Unless($this->employee);
    }
}
