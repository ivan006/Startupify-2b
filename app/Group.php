<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Group;
use App\Post;
use App\Data;

class Group extends Model
{

  protected $primaryKey = 'id';
  protected $fillable = [
    'name',
  ];

  public function PostChildren() {
    return $this->morphMany('App\Post', 'parent');
  }
  public function DataChildren() {
    return $this->morphMany('App\Data', 'parent');
  }
  // public static function ShowBaseLocation() {
  //   // return "storage/app/public/";
  //   return base_path()."/storage/app/public/";
  // }
  // above is not needed
  public static function ShowAll() {
    // $ShowBaseLocation = Group::ShowBaseLocation();
    // above is not needed
    // $dataNameList = scandir($ShowBaseLocation);
    $dataNameList = Group::all();
    $result = array();
    // dd($dataNameList);
    foreach ($dataNameList as $key => $value) {

      // $dataLocation = $ShowBaseLocation . "/" . $value;
      // above is not needed
      // if (!in_array($value,array(".","..")) && is_dir($dataLocation) )  {
      // above is not needed

            // $url = str_replace($ShowBaseLocation."/", "", $dataLocation);
            // above is not needed
            $result[$value->name]["url"] = route('NetworkC.show', $value->name);
      // }
      // above is not needed
    }

    return $result;
  }

  public static function ShowSignature($routeParameters){
    $var = $routeParameters[0];
    return $var;
  }
  public static function ShowID($routeParameters){
    // dd($routeParameters);
    $ShowID = Group::where('name', $routeParameters[0])->first()->id;

    return $ShowID;

  }
  public static function Add($request) {
    // dd($request);
    $GroupName = $request["name"];
    // dd($GroupName);
    // dd($request);
    // Group::create([
    //   'name'=>$GroupName,
    // ]);
    $var = new Group;
    $var->name = $GroupName;
    $var->save();


    $GroupId = $var->attributes["id"];

    $name = "_data";
    $parent_id = $GroupId;
    $parent_type = "App\Group";
    $type = "folder";
    $content = "null";

    // Data::Create($name,$parent_id,$parent_type,$type,$content)
    Data::Add($name, $parent_id,$parent_type,$type,$content);
    // mkdir(GroupM::ShowBaseLocation()."/".$request->get('name'));
  }
}
