<?php
/**
 * Class baseJustimmoActions
 *
 * @todo: fill in default behaviour for each method and create templates
 */
class baseJustimmoActions extends sfActions
{
    /** @var baseRealtyFilter $filter */
    private $filter = null;
    private $_perPage = 4;

    public function preExecute()
    {
        parent::preExecute();

        /** @var Symfony\Component\DependencyInjection\ContainerBuilder $this->container */
        $this->container = $this->getContext()->getConfiguration()->getContainer();

        $this->filter = new baseRealtyFilter();
    }

    public function executeRealtyList(sfWebRequest $request)
    {
        $this->filter->setDefaults($this->getUser()->getAttribute($this->filter->getName(), null, 'justimmo'));

        if ($request->getParameter('order')) {
            $this->getUser()->setAttribute('filter_order', $request->getParameter('order'), 'justimmo');
        }

        /** @var JustimmoRealtyQuery $query */
        $query = $this->container->get('justimmo.query.realty');
        $query->applyFilter($this->getUser()->getAttribute($this->filter->getName(), array(), 'justimmo'));
        $query->applyOrder($this->getUser()->getAttribute('filter_order', null, 'justimmo'));

        $this->realty_filter = $this->filter;

        $this->pager = $query->paginate($request->getParameter('page', 1), $this->_perPage);
        $this->getUser()->setAttribute('filter_page', $this->pager->getPage(), 'justimmo');
    }

    public function executeRealtyDetail(sfWebRequest $request)
    {
        /** @var JustimmoRealtyQuery $query */
        $query = $this->container->get('justimmo.query.realty');

        $this->forward404Unless($request->getParameter('id', null));
        try {
            $this->realty = $query->findPk($request->getParameter('id', null));
        } catch (\Justimmo\Exception\NotFoundException $e) {
            $this->forward404();
        }

        $this->form = new RealtyInquiryForm(array('realty_id' => $this->realty->getId()));
        $inquiry_status = $this->processForm($request, $this->form);
        if ($inquiry_status !== null) {
            $this->getUser()->setFlash('inquiry_status', $inquiry_status);
            $this->redirect($this->getController()->genUrl('@justimmo_realty_detail?id=' . $request->getParameter('id') . '#contact-form'));
        }
//        $this->inquiry_status = $request->getParameter('inquiry_status', null);

        /**
         * Get next and previous Realties in the current list.
         * This way we are able to navigate to next / previous Realty
         * from the current detail view.
         */
        $query->applyFilter($this->getUser()->getAttribute($this->filter->getName(), array(), 'justimmo'));
        $query->applyOrder($this->getUser()->getAttribute('filter_order', null, 'justimmo'));
        $neighbours   = $query->getNeighbours($this->realty, $this->_perPage);
        $this->nextId = $neighbours['next'];
        $this->prevId = $neighbours['prev'];
        $this->page   = $neighbours['page'];
    }


    public function executeAjax()
    {
        // instantiate form
        // ->processForm
        // render form partial with correct params set
    }

    /**
     * Returns the status of the inquiry form or NULL if request method is not POST and form is not processed.
     *
     * @param sfWebRequest $request
     * @param RealtyInquiryForm $form
     * @return bool|null Method returns null if the method is not POST, meaning the form is not processed
     */
    protected function processForm(sfWebRequest $request, RealtyInquiryForm $form)
    {
        $inquiry_status = null;

        if ($request->isMethod('POST')) {
            /** @var Justimmo\Api\JustimmoApi $api */
            $api = $this->container->get('justimmo.api');

            $form->bind($request->getParameter($form->getName()));

            if ($form->isValid()) {
                $api_params = array(
                    'objekt_id' => $form->getValue('realty_id'),
                    'vorname'   => $form->getValue('first_name'),
                    'nachname'  => $form->getValue('last_name'),
                    'email'     => $form->getValue('email'),
                    'tel'       => $form->getValue('phone'),
                    'message'   => $form->getValue('message'),
                );

                try {
                    $result         = $api->postRealtyInquiry($api_params);
                    $inquiry_status = true;
                } catch (Justimmo\Exception\StatusCodeException $e) {
                    // @todo: get logger and log message
//                    // print $e->getMessage();
                    $inquiry_status = false;
                }
            }
        }

        return $inquiry_status;
    }

    public function executeRealtyExpose(sfWebRequest $request)
    {
        /** @var Justimmo\Api\JustimmoApi $api */
        $api = $this->container->get('justimmo.api');
        $id  = $request->getParameter('id', null);
        $this->forward404Unless($id);

        header('Content-type: application/pdf');
//        header('Content-Disposition: attachment; filename="expose-' . $id . '-' . time() . '.pdf"');

        echo $api->callExpose($id);
        return sfView::NONE;
    }

    public function executeRealtyFilter(sfWebRequest $request)
    {
        if ($request->hasParameter('reset')) {
            /**
             * The Justimmo API websites require multiple user session parameters
             * to function correctly.
             */
            $this->getUser()->setAttribute($this->filter->getName(), null, 'justimmo');
            $this->getUser()->setAttribute('filter_order', null, 'justimmo');
            $this->getUser()->setAttribute('filter_page', 1, 'justimmo');
        }

        if ($request->getMethod() == "POST") {
            $this->filter->bind($request->getParameter($this->filter->getName()));

            if ($this->filter->isValid()) {
                $this->getUser()->setAttribute($this->filter->getName(), $this->filter->getValues(), 'justimmo');
                // @todo: use Justimmo.Logger to log any filters that are set
            } else {
                // @todo: use Justimmo.Logger to log any errors
                // die('Filter errors - please check your code');
            }
        }

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
