<?php 

namespace App\Filters\Loan;

class IntervalDateFilter extends \App\Filters\FilterInterface
{
    public function apply(\Illuminate\Database\Eloquent\Model $model, array $params)
    {

        $hasValidParam = (
            ( isset($params['loan_date_start']) && !empty($params['loan_date_start']) )
            ||
            ( isset($params['loan_date_end']) && !empty($params['loan_date_end']) )
        );

        $handler = $this->getQueryInstance($model);
    
        if (!$hasValidParam){
            $this->executeNextFilter($model, $params);
            return;
        }
        
        $this->queryInstance = $handler->whereBetween(
            'loan_date', [ $params['loan_date_start'], $params['loan_date_end'] ]
        );
        $this->executeNextFilter($model, $params);
    }
}