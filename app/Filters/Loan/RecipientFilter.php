<?php 

namespace App\Filters\Loan;

class RecipientFilter extends \App\Filters\FilterInterface
{
    public function apply(\Illuminate\Database\Eloquent\Model $model, array $params)
    {
        $hasValidParam = isset($params['recipient']) && !is_null($params['recipient']);
        if (!$hasValidParam){
            $this->executeNextFilter($model, $params);
            return;
        }
        
        $handler = $this->getQueryInstance($model);
        $this->queryInstance = $handler->where('recipient', 'like', $params['recipient'] . '%');
        $this->executeNextFilter($model, $params);
    }
}