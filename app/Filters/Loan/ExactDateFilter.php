<?php 

namespace App\Filters\Loan;

class ExactDateFilter extends \App\Filters\FilterInterface
{
    public function apply(\Illuminate\Database\Eloquent\Model $model, array $params)
    {

        $hasValidParam = isset($params['loan_date']) && !empty($params['loan_date']);

        if (!$hasValidParam){
            $this->executeNextFilter($model, $params);
            return;
        }
        
        $handler = $this->getQueryInstance($model);
        $this->queryInstance = $handler->where('loan_date', '=', $params['loan_date']);
        $this->executeNextFilter($model, $params);
    }
}