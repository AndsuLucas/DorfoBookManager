<?php 

namespace App\Filters\Loan;

class ReturnedFilter extends \App\Filters\FilterInterface
{
    public function apply(\Illuminate\Database\Eloquent\Model $model, array $params)
    {          
        $hasValidParam = isset($params['returned']) && !empty($params['returned']);
        if (!$hasValidParam){
            $this->executeNextFilter($model, $params);
            return;
        }
        
        $handler = $this->getQueryInstance($model);
        $this->queryInstance = $handler->where('returned', '=', $params['returned']);
        $this->executeNextFilter($model, $params);
    }
}