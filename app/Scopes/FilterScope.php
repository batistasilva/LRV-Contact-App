<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class FilterScope implements Scope {

    protected $filterColums = ["company_id"];

    public function apply(Builder $builder, Model $model) {
        
        $columns = property_exists($model, 'filterColumns') ? $model->filterColumns : $this->filterColums;
       
        foreach ($model->filterColums as $colum) {
            
            if ($value = request($colum)) {
                $builder->where($colum, $value);
            }          
        }
    }

}
