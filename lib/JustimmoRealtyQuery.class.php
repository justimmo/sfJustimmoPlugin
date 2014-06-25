<?php
use Justimmo\Model\RealtyQuery;

class JustimmoRealtyQuery extends RealtyQuery
{
    public function applyFilter($params = array())
    {
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
}
