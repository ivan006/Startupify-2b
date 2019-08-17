<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

  protected $primaryKey = 'id';
  protected $fillable = [
    'name',
    'parent_id',
    'parent_type',
  ];
  public function DataChildren() {
    return $this->morphMany('App\Data', 'parent');
  }
  public function PostChildren() {
    return $this->morphMany('App\Post', 'parent');
  }

  public static function ShowActions() {
    if (!empty(func_get_args()[0])) {
      $PostShowSig = Post::ShowRelativeSignature(func_get_args()[0]);
      $GroupShowSig = Group::ShowSignature(func_get_args()[0]);
      $Slug = $GroupShowSig."/".$PostShowSig;
    } else {
      $Slug = null;
    }

    $allURLs['sub_post_read'] =   route('NetworkC.show',$Slug);
    $allURLs['sub_post_edit'] = route('NetworkC.edit',$Slug);
    $allURLs['sub_post_store'] = route('NetworkC.store',$Slug);
    return $allURLs;
  }
  public static function ShowRelativeSignature($routeParameters){
    $arguments = $routeParameters;
    array_shift($arguments);
    $result = null;
    foreach ($arguments as $key => $value) {
      if (isset($result)) {
        $result .= "/".$value;
      } else {
        $result = $value;
      }
    }
    return $result;
  }

  public static function ShowAbsoluteSignature($routeParameters){

    $PostShowSig = Post::ShowRelativeSignature($routeParameters);
    $GroupShowSig = Group::ShowSignature($routeParameters);

    $result = $GroupShowSig."/".$PostShowSig;
    return $result;

  }

  public static function ShowID($GroupShowID,$routeParameters){
    array_shift($routeParameters);
    $ShowID = null;
    $stage = 1;

    foreach ($routeParameters as $key => $value) {
      if ($stage==1) {
        $ShowID = Group::find($GroupShowID)->PostChildren->where('name', $value)->first()->id;
        $stage = 2;
      } else {
        $ShowID = Post::find($ShowID)->PostChildren->where('name', $value)->first()->id;
      }
    }
    return $ShowID;
  }


  public static function ShowBaseIDPlusBaseLocation() {
    return Group::ShowBaseLocation().Post::ShowBaseID(func_get_args()[0]);
  }

  public static function ShowBaseID() {
    $arguments = func_get_args()[0][0];

    return $arguments;
  }

  // public static function ShowLocation($ShowID) {
  //   if (!empty($ShowID)) {
  //     // return  Group::ShowBaseLocation().$ShowID;
  //     return  $ShowID;
  //   } else {
  //     return "now what";
  //   }
  //
  // }

  public static function ShowSubPost($GroupShowID,$routeParameters) {
    // dd($GroupShowID);

    // if(!function_exists('App\ShowSubPostHelper')){

      function ShowSubPostHelper($Entities,$routeParameters) {
        $result = array();
        foreach ($Entities["List"] as $key => $value) {
          $SubEntityList = Post::find($value["id"])->PostChildren->toArray();
          $Slug = $Entities["Slug"]."/".$value["name"];
          $SubEntities = array (
            "List" => $SubEntityList,
            "Slug" => $Slug,
          );
          $result[$value["name"]]["content"] = ShowSubPostHelper($SubEntities,$routeParameters);
          $result[$value["name"]]["url"] = $Slug;
        }
        return $result;
      }
    // }

    $GroupShowID = Group::ShowID($routeParameters);
    $GroupShowAll = Group::find($GroupShowID);

    $SubEntityList = Group::find($GroupShowAll["id"])->PostChildren->toArray();
    $Slug = route('NetworkC.show')."/".$GroupShowAll["name"];
    $SubEntities = array (
      "List" => $SubEntityList,
      "Slug" => $Slug,
    );
    $result[$GroupShowAll["name"]]["content"] = ShowSubPostHelper($SubEntities,$routeParameters);
    $result[$GroupShowAll["name"]]["url"] = $Slug;

    return $result;
  }

  public static function Store($routeParameters, $request) {

    $GroupShowID = Group::ShowID($routeParameters);
    $PostShowID = Post::ShowID($GroupShowID,$routeParameters);

    if (!empty($request->get('Data_Form'))) {
      Data::Store($request, $PostShowID);
    }
  }


}
