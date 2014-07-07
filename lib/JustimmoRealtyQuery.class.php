<?php
use Justimmo\Model\RealtyQuery;

class JustimmoRealtyQuery extends RealtyQuery
{
    /**
     * Force showing ONLY realties from one particular category.
     * The category MUST exist in Justimmo.
     *
     * @var string
     */
    protected $enabled_category = '';

    public function applyFilter($params = array())
    {
        if (!empty($this->enabled_category)) {
            $this->filterByTag($this->enabled_category);
        }
        foreach ($params as $key => $value) {
            $this->filter($key, $value);
        }
    }

    public function applyOrder($order = null)
    {
        $valid_directions = array('asc', 'desc');

        if ($order === null) {
            return;
        }

        $order = explode("-", $order);
        if (isset($order[0]) && isset($order[1]) && in_array($order[1], $valid_directions)) {
            $column    = $order[0];
            $direction = $order[1];

            $this->orderBy($column, $direction);
        } else {
            return;
        }
    }

    /**
     * Fetch all realty Ids from Justimmo and match that against current Realty ID.
     * Calculate page based on $perPage.
     *
     * When a Realty is being displayed, we can navigate to the next or previous
     * in line, or go back to the listing, to the correct page.
     *
     * @param \Justimmo\Model\Realty $realty
     * @param int $perPage
     * @return array Array with 3 keys: next, prev, page
     */
    public function getNeighbours(Justimmo\Model\Realty $realty, $perPage)
    {
        // @todo: fetch Ids and search current realty ID to return neighbours (method not yet implemented in php-sdk)
        return array(
            'next' => false,
            'prev' => false,
            'page' => false,
        );
    }
}
