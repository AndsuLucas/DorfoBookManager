<?php

namespace App\Filters\Loan\Client;

use App\Filters\Loan\ExactDateFilter;
use App\Filters\Loan\IntervalDateFilter;
use App\Filters\Loan\RecipientFilter;
use App\Filters\Loan\ReturnedFilter;

class FilterLoanClient
{
    private $validParams = [
        "returned",
        "recipient",
        "loan_date",
        "loan_date_end",
        "loan_date_start"
    ];

    public function __construct(
        RecipientFilter $recipientFilter,
        ReturnedFilter $returnedFilter,
        ExactDateFilter $exactDateFilter,
        IntervalDateFilter $intervalDateFilter
    )
    {
        $this->recipientFilter = $recipientFilter;
        $this->returnedFilter = $returnedFilter;
        $this->exactDateFilter = $exactDateFilter;
        $this->intervalDateFilter = $intervalDateFilter;
    }

    private function parseParameters($params)
    {
        $parsedParams = array_filter($params, function($key){
            return in_array($key, $this->validParams);
        }, ARRAY_FILTER_USE_KEY);

        return $parsedParams;
    }

    public function filter(\Illuminate\Database\Eloquent\Model $model, array $params): \Illuminate\Support\Collection
    {
        $parsedParams = $this->parseParameters($params);
        if (empty($parsedParams)) {
            return collect((object)[]);
        }

        $this->returnedFilter->setNextFilter(
            $this->recipientFilter
        );

        $this->recipientFilter->setNextFilter(
            $this->exactDateFilter
        );

        $this->exactDateFilter->setNextFilter(
            $this->intervalDateFilter
        );

        $this->returnedFilter->apply($model, $params);
        $result = $this->intervalDateFilter->getResult();

        return $result->with('book')->get();
    }

}
