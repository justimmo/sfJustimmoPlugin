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
}
