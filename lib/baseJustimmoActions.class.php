<?php
/**
 * Class baseJustimmoActions
 *
 * @todo: fill in default behaviour for each method and create templates
 */
class baseJustimmoActions extends sfActions
{
    private $_perPage = 4;

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

        $this->filter_realty = new baseRealtyFilter();
        $this->filter_realty->buildQuery($query, $this->getUser()->getAttribute($this->filter_realty->getName(), null, 'justimmo'));

        $this->pager = $query->paginate($request->getParameter('page', 1), $this->_perPage);
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
//        header('Content-Disposition: attachment; filename="expose-' . $id . '-' . time() . '.pdf"');

        echo $api->callExpose($id);
        return sfView::NONE;
    }

    public function executeRealtyInquiry(sfWebRequest $request)
    {
        /** @var Justimmo\Api\JustimmoApi $api */
        $api = $this->container->get('justimmo.api');

        // @todo: use user session for the values? so we can fetch them in the detail view and see the fields with errors?

        $form = new RealtyInquiryForm();
        $form->bind($request->getParameter($form->getName()));

        if ($form->isValid()) {
            $api_params = array(
                'objekt_id' => $form->getValue('realty_id'),
                // @todo: fill in all params needed by postRealtyInquiry & API
            );
//            $inquiry_status = $api->postRealtyInquiry($api_params);
            $this->getUser()->setFlash('success', 'Success!');
        } else {
            $this->getUser()->setFlash('error', 'Error');
        }

        $this->redirect($request->getReferer() . '#contact-form');
    }

    public function executeRealtyFilter(sfWebRequest $request)
    {
        if ($request->hasParameter('reset')) {
            // @todo: reset filters
        }
        if ($request->getMethod() == "POST") {
            // validate
            $filter_realty = new baseRealtyFilter();
            $filter_realty->bind($request->getParameter($filter_realty->getName()));

            if ($filter_realty->isValid()) {
                // save to session
                $this->getUser()->setAttribute($filter_realty->getName(), $filter_realty->getValues(), 'justimmo');
                // use Justimmo.Logger to log any filters that are set
            }
            // use Justimmo.Logger to log any errors
        }

        // redirect to list
        // @todo: should we add GET params to be able to bookmark/send links with search filters in URL?
        $this->redirect("@justimmo_realty_list");
    }

    /**
     * @param sfWebRequest $request
     */
    public function executeProjectList(sfWebRequest $request)
    {
        /** @var Justimmo\Model\ProjectQuery $query */
        $query = $this->container->get('justimmo.query.project');

        $this->pager = $query->paginate($request->getParameter('page', 1), $this->_perPage);
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

        $this->employees  = $query->find();
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
