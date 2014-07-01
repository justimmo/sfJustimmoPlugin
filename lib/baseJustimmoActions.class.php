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

        $this->forward404Unless($this->realty);
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

    public function executeRealtyInquiry(sfWebRequest $request)
    {
        return $this->renderComponent('justimmo/realtyInquiry', array('id' => $request->getParameter('id')));
    }

    public function executeRealtyFilter(sfWebRequest $request)
    {
        if ($request->hasParameter('reset')) {
            $this->getUser()->setAttribute($this->filter->getName(), null, 'justimmo');
            $this->getUser()->setAttribute('filter_order', null, 'justimmo');
        }

        if ($request->getMethod() == "POST") {
            $this->filter->bind($request->getParameter($this->filter->getName()));

            if ($this->filter->isValid()) {
                $this->getUser()->setAttribute($this->filter->getName(), $this->filter->getValues(), 'justimmo');
                // use Justimmo.Logger to log any filters that are set
            } else {
                // @todo: use Justimmo.Logger to log any errors
                die('errors - please check your code');
            }
        }

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
