<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Group extends Model
{
  protected $primaryKey = 'id';
  protected $fillable = [
    'name',
    'type',
  ];

  public function ReportChildren()
  {
    return $this->morphMany('App\Report', 'parent');
  }

  public function DataChildren()
  {
    return $this->morphMany('App\Data', 'parent');
  }

  public static function ShowAll()
  {
    $dataNameList = Group::all();
    $result = array();

    foreach ($dataNameList as $key => $value) {
      $result[$value->name]['url'] = route('NetworkC.show', $value->name);
    }

    return $result;
  }

  public static function ShowSignature($routeParameters)
  {
    $var = $routeParameters[0];

    return $var;
  }

  public static function ShowID($routeParameters)
  {
    $ShowID = Group::where('name', $routeParameters[0])->first()->id;

    return $ShowID;
  }

  public static function Add($request)
  {
    $GroupName = $request['name'];

    $var = new Group();
    $var->name = $GroupName;
    $var->type = 'folder';
    $var->save();

    $GroupId = $var->attributes['id'];



    Data::create([
      'name' => '_data',
      'parent_id' => $GroupId,
      'parent_type' => "App\Group",
      'type' => 'folder',
      'content' => 'null',
    ]);

  }
}
