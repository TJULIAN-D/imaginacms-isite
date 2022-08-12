<?php

namespace Modules\Isite\Repositories\Eloquent;

use Modules\Isite\Repositories\OrganizationRepository;
use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;

class EloquentOrganizationRepository extends EloquentCrudRepository implements OrganizationRepository
{
  
  /**
   * Filter names to replace
   * @var array
   */
  protected $replaceFilters = [];
  
  /**
   * Relation names to replace
   * @var array
   */
  protected $replaceSyncModelRelations = [];
  
  /**
   * Filter query
   *
   * @param $query
   * @param $filter
   * @return mixed
   */
  public function filterQuery($query, $filter)
  {
    //
    if (\Auth::id() && isset($filter->params->setting->fromAdmin) && $filter->params->setting->fromAdmin) {
      if (!isset($filter->params->permissions["isite.organizations.index-all"]) || !$filter->params->permissions["isite.organizations.index-all"]) {
        $query->whereHas("users", function ($query) {
          $query->where("users.id", \Auth::id());
        });
      }
    }
   // dd($query->toSql(),$query->getBindings());
    
    /**
     * Note: Add filter name to replaceFilters attribute before replace it
     *
     * Example filter Query
     * if (isset($filter->status)) $query->where('status', $filter->status);
     *
     */

      //Filter Category Id
      if (isset($filter->category) && !empty($filter->category))
        $query->where('category_id', $filter->category);
        
    
    //Response
    return $query;
  }
  
  /**
   * Method to sync Model Relations
   *
   * @param $model ,$data
   * @return $model
   */
  public function syncModelRelations($model, $data)
  {
    //Get model relations data from attribute of model
    $modelRelationsData = ($model->modelRelations ?? []);
    
    /**
     * Note: Add relation name to replaceSyncModelRelations attribute before replace it
     *
     * Example to sync relations
     * if (array_key_exists(<relationName>, $data)){
     *    $model->setRelation(<relationName>, $model-><relationName>()->sync($data[<relationName>]));
     * }
     *
     */
    
    //Response
    return $model;
  }
  
}
