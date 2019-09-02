<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
  protected $primaryKey = 'id';
  protected $fillable = [
    'name',
    'parent_id',
    'parent_type',
    'type',
    'content',
  ];

  public function DataChildren()
  {
    return $this->morphMany('App\Data', 'parent');
  }

  public function ReportChildren()
  {
    return $this->morphMany('App\Report', 'parent');
  }

  public static function ShowActions($routeParameters)
  {
    if (!empty($routeParameters)) {
      $ReportShowSig = Report::ShowRelativeSignature($routeParameters);
      $GroupShowSig = Group::ShowSignature($routeParameters);
      $Slug = $GroupShowSig.'/'.$ReportShowSig;
    } else {
      $Slug = null;
    }

    $allURLs['sub_report_read'] = route('NetworkC.show', $Slug);
    $allURLs['sub_report_edit'] = route('NetworkC.edit', $Slug);
    $allURLs['sub_report_store'] = route('NetworkC.store', $Slug);

    return $allURLs;
  }

  public static function ShowRelativeSignature($routeParameters)
  {
    $arguments = $routeParameters;
    array_shift($arguments);
    $result = null;
    foreach ($arguments as $key => $value) {
      if (isset($result)) {
        $result .= '/'.$value;
      } else {
        $result = $value;
      }
    }

    return $result;
  }

  public static function ShowAbsoluteSignature($routeParameters)
  {
    $ReportShowSig = Report::ShowRelativeSignature($routeParameters);
    $GroupShowSig = Group::ShowSignature($routeParameters);

    $result = $GroupShowSig.'/'.$ReportShowSig;

    return $result;
  }

  public static function ShowID($GroupShowID, $routeParameters)
  {
    array_shift($routeParameters);
    $ShowID = null;
    $stage = 1;

    foreach ($routeParameters as $key => $value) {
      if (1 == $stage) {
        $ShowID = Group::find($GroupShowID)->ReportChildren->where('name', $value)->first()->id;
        $stage = 2;
      } else {
        $ShowID = Report::find($ShowID)->ReportChildren->where('name', $value)->first()->id;
      }
    }

    return $ShowID;
  }

  // public static function ShowBaseIDPlusBaseLocation()
  // {
  //   return Group::ShowBaseLocation().Report::ShowBaseID(func_get_args()[0]);
  // }

  // public static function ShowBaseID()
  // {
  //   $arguments = func_get_args()[0][0];
  //
  //   return $arguments;
  // }



  public static function ShowMultiStyledForEdit($routeParameters)
  {
    $EntityType = 'Report';
    $result = Entity::ShowMultiStyledForEdit($EntityType,$routeParameters);
    return $result;
  }

  public static function StoreMultiForEdit($ShowChangesForEdit)
  {
    $EntityType = 'Report';
    Entity::StoreMultiForEdit($ShowChangesForEdit,$EntityType);
  }

  public static function Store($routeParameters, $request)
  {
    switch ($request->get('form')) {
      case 'data':

      $EntityType = 'Data';
      $ShowChangesForEdit = Entity::ShowChangesForEdit($request,$EntityType);
      Data::StoreMultiForEdit($ShowChangesForEdit);
      break;
      case 'reports':

      $EntityType = 'Report';
      $ShowChangesForEdit = Entity::ShowChangesForEdit($request,$EntityType);
      Report::StoreMultiForEdit($ShowChangesForEdit);

      break;

      default:

      break;
    }
  }

}
