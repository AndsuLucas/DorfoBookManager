<?php 

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use \Illuminate\Database\Eloquent\Model;
abstract class FilterInterface 
{   
    protected $model;
    protected $nextFilter;
    protected $queryInstance;
    
    abstract function apply(Model $model, array $params);

    public function setNextFilter(\App\Filters\FilterInterface $filter) 
    {
        $this->nextFilter = $filter;
    }

    public function getResult()
    {
        return $this->queryInstance;
    }

    protected function getQueryInstance(Model $model)
    {
        if (is_null($this->queryInstance)) {
            return $model;
        }
        
        return $this->queryInstance;
    }

    protected function setQueryInstance(Builder $queryInstance) {
        $this->queryInstance = $queryInstance;
    }

    protected function executeNextFilter(Model $model, array $params)
    {          
        if (is_null($this->nextFilter)) {
            return;
        }
        
        $queryInstance = $this->getQueryInstance($model);
        if ($queryInstance instanceof Builder) {
            $this->nextFilter->setQueryInstance($queryInstance);
        }
        
        $this->nextFilter->apply($model, $params);
    }
}