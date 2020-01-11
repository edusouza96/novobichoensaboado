<?php

namespace BichoEnsaboado\Repositories;

use BichoEnsaboado\Models\CostCenter;

class CostCenterRepository
{
    private $costCenter;

    public function __construct(CostCenter $costCenter)
    {
        $this->costCenter = $costCenter;
    }

    public function all()
    {
        return $this->costCenter->all();   
    }

    public function find($id)
    {
        return $this->costCenter->find($id);
    }

    public function findByCategory($categoryId)
    {
        return $this->costCenter->where('cost_center_category_id', $categoryId);
    }

    public function findByFilter(array $attributes, $paginate=false)
    {
        $search = $this->costCenter->newQuery();

        if(isset($attributes['name'])){
            $search = $search->where('name', 'like', "%{$attributes['name']}%");
        }
        
        if(isset($attributes['cost_center_category_id'])){
            $search = $search->where('cost_center_category_id', $attributes['cost_center_category_id']);
        }else{
            $search = $search->where('cost_center_category_id', '<>', 1000);
        }

        $search->orderBy('name');
        return $paginate ? $search->paginate(15) : $search->get();
    }
    
    public function newInstance()
    {
        return $this->costCenter->newInstance();
    }

    public function create(array $attributes)
    {
        return $this->costCenter->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->costCenter->whereId($id)
                           ->update($attributes);
    }

    public function destroy($id)
    {
        return $this->costCenter->destroy($id);
    }
}
