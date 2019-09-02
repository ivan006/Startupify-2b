<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Data extends Model
{
  protected $primaryKey = 'id';
  protected $fillable = [
    'name',
    'parent_id',
    'parent_type',
    'type',
    'content',
  ];

  public function parent()
  {
    return $this->morphTo();
  }

  public function DataChildren()
  {
    return $this->morphMany('App\Data', 'parent');
  }

  public static function ShowID($routeParameters, $DataSig)
  {
    $GroupShowID = Group::ShowID($routeParameters);
    $ReportShowID = Report::ShowID($GroupShowID, $routeParameters);

    $DataShowSigPref = Data::ShowSignaturePrefix();
    if (!empty($ReportShowID)) {
      $Report = Report::find($ReportShowID);
      if (!empty($Report)) {
        $Data = $Report->DataChildren->where('name', $DataShowSigPref)->first();
        if (!empty($Data)) {
          $ShowParentID = $Data->id;
        }
      }
    } elseif (!empty($GroupShowID)) {
      $Group = Group::find($GroupShowID);
      if (!empty($Group)) {
        $Data = $Group->DataChildren->where('name', $DataShowSigPref)->first();
        if (!empty($Data)) {
          $ShowParentID = $Data->id;
        }
      }
    }

    $DataSigFragments = explode('/', $DataSig);

    // ----------------
    // querie strat
    // ----------------

    if (!empty($ShowParentID)) {
      $ShowID = $ShowParentID;
      foreach ($DataSigFragments as $key => $value) {
        $DataParent = Data::find($ShowID);
        if (!empty($DataParent)) {
          $Data = $DataParent->DataChildren->where('name', $value)->first();
          if (!empty($Data)) {
            $ShowID = $Data->id;
          } else {
            $ShowID = null;
          }
        } else {
          $ShowID = null;
        }

        // $ShowID = DB::select(
        //   'SELECT *
        //   FROM data a, data b
        //   WHERE a.parent_id = b.id
        //   AND a.parent_type = "App\\Data"
        //   ;'
        // );
      }
    }
    // ----------------
    // querie strat
    // ----------------
    if (isset($ShowID)) {
      return $ShowID;
    }
  }

  public static function Show($DataShowID)
  {
    $DataShowAll = Data::find($DataShowID);

    if (!empty($DataShowAll)) {
      $ShowDataContent = $DataShowAll->toArray();

      $Attr = Entity::ShowAttributeTypes();

      $result[$Attr[2]] = $ShowDataContent['content'];
      $result[$Attr[1]] = $ShowDataContent['type'];
      $result[$Attr[0]] = $ShowDataContent['name'];
      $result[$Attr[4]] = $ShowDataContent['id'];

      return $result;
    }
  }

  public static function ShowSignaturePrefix()
  {
    $result = '_data';

    return $result;
  }



  public static function ShowMultiStyledForEdit($routeParameters)
  {

    $EntityType = 'Data';
    $result = Entity::ShowMultiStyledForEdit($EntityType,$routeParameters);
    return $result;
  }

  public static function StoreMultiForEdit($ShowChangesForEdit)
  {
    $EntityType = 'Data';
    Entity::StoreMultiForEdit($ShowChangesForEdit,$EntityType);
  }




}
