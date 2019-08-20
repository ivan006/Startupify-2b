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

  public static function ShowActions($routeParameters) {
    if (!empty($routeParameters)) {
      $PostShowSig = Post::ShowRelativeSignature($routeParameters);
      $GroupShowSig = Group::ShowSignature($routeParameters);
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
    $GroupShow = Group::find($GroupShowID);

    $SubEntityList = Group::find($GroupShow["id"])->PostChildren->toArray();
    $Slug = route('NetworkC.show')."/".$GroupShow["name"];
    $SubEntities = array (
      "List" => $SubEntityList,
      "Slug" => $Slug,
    );
    $result[$GroupShow["name"]]["content"] = ShowSubPostHelper($SubEntities,$routeParameters);
    $result[$GroupShow["name"]]["url"] = $Slug;

    return $result;
  }
  public static function ShowImmediateSubPost($routeParameters) {

    $GroupShowID = Group::ShowID($routeParameters);
    $PostShowID = Post::ShowID($GroupShowID,$routeParameters);

    if (!empty($PostShowID)) {
      $EntityShow = Post::find($PostShowID);
      $SubEntityList = Post::find($EntityShow["id"])->PostChildren->toArray();

    } elseif (!empty($GroupShowID)) {
      $EntityShow = Group::find($GroupShowID);
      $SubEntityList = Group::find($EntityShow["id"])->PostChildren->toArray();

    }


    $result = array();
    foreach ($SubEntityList as $key => $value) {
      // dd($value);
      $result[$value["name"]]["url"] = Post::ShowActions($routeParameters)["sub_post_edit"]."/".$value["name"];
    }

    return $result;
  }

  public static function Store($routeParameters, $request) {

    // $GroupShowID = Group::ShowID($routeParameters);
    // $PostShowID = Post::ShowID($GroupShowID,$routeParameters);
    // if (!empty($PostShowID)) {
    //   $EntityShow = Post::find($PostShowID);
    // } elseif (!empty($GroupShowID)) {
    //   $EntityShow = Group::find($GroupShowID);
    // }
    // dd($request);

    switch ($request->get('form')) {
      case "data":
        // code...
        Data::Store($request);
        break;
      case "posts":
        // code...
        Post::Add($routeParameters,$request);
        break;

      default:
        // code...
        break;
    }

  }
  public static function Add($routeParameters, $request) {
    $GroupShowID = Group::ShowID($routeParameters);
    $PostShowID = Post::ShowID($GroupShowID,$routeParameters);

    $name = $request->get('name');

    if (!empty($PostShowID)) {
      $parent_id = $PostShowID;
      $parent_type = "App\Post";
    } elseif (!empty($GroupShowID)) {
      $parent_id = $GroupShowID;
      $parent_type = "App\Group";
    }

    $var = Post::create([
      'name'=>$name,
      'parent_id'=>$parent_id,
      'parent_type'=>$parent_type,
    ]);


    $PostShowID = $var->attributes["id"];

    $name = "_data";
    $parent_id = $PostShowID;
    $parent_type = "App\Post";
    $type = "folder";
    $content = "null";

    // Data::Create($name,$parent_id,$parent_type,$type,$content)
    Data::Add($name, $parent_id,$parent_type,$type,$content);
    // mkdir(GroupM::ShowBaseLocation()."/".$request->get('name'));

  }




}
