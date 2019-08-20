<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

// use App\Post;

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
  public function parent() {
    return $this->morphTo();
  }
  public function children() {
    return $this->morphMany('App\Data', 'parent');
  }

  // public static function ShowID($GroupSig,$PostSig, $DataSig) {
  public static function ShowID($routeParameters,$DataSig) {
    // code...
    $GroupShowID = Group::ShowID($routeParameters);
    $PostShowID = Post::ShowID($GroupShowID,$routeParameters);

    $DataShowSigPref = Data::ShowSignaturePrefix();
    if (!empty($PostShowID)) {


      // code...
      $Post = Post::find($PostShowID);
      if (!empty($Post)) {
        // code...
        $Data = $Post->DataChildren->where('name', $DataShowSigPref)->first();
        if (!empty($Data)) {
          // code...
          $ShowParentID = $Data->id;

        }
      }

    } elseif (!empty($GroupShowID)) {

      // code...

      $Group = Group::find($GroupShowID);
      if (!empty($Group)) {
        // code...
        $Data = $Group->DataChildren->where('name', $DataShowSigPref)->first();
        if (!empty($Data)) {
          // code...
          $ShowParentID = $Data->id;

        }
      }

    }

    $DataSigFragments = explode("/", $DataSig);

    // ----------------
    // querie strat
    // ----------------

    // $stage = 1;
    if (!empty($ShowParentID)) {
      // code...
      $ShowID = $ShowParentID;
      foreach ($DataSigFragments as $key => $value) {
        // array_shift($DataSigFragments);
        // $Data = Data::find($ShowID)->children->where('name', $value)->first();
        //
        // if (!empty($Data)) {
        //   $ShowID = $Data->id;
        // }
        $DataParent = Data::find($ShowID);
        if (!empty($DataParent)) {
          $Data = $DataParent->children->where('name', $value)->first();
          if (!empty($Data)) {
            // if ($value == "Rich.txt") {
            //   dd(10);
            // }
            // dd($DataParent);
            $ShowID = $Data->id;
          } else {
            $ShowID = null;
          }
        } else {
          // dd(123114);
          // dd(1);
          $ShowID = null;
        }

          // if ($DataSig == "code/w3.css") {
          //   dd($ShowID);
          //   // code...
          // }




        // $ShowID = DB::select(
        //   'SELECT *
        //   FROM data a, data b
        //   WHERE a.parent_id = b.id
        //   AND a.parent_type = "App\\Data"
        //   ;'
        // );

        // ----------------
        // querie strat
        // ----------------
      }
      // dd($ShowID);
    }
    // if ($ShowID==32) {
    //   dd(443);
    //   // code...
    // }
    if (isset($ShowID)) {
      return $ShowID;
    }



  }

  public static function Show($DataShowID) {
    $DataShowAll = Data::find($DataShowID);

    // dd($dd);
    if (!empty($DataShowAll)) {
      $ShowDataContent = $DataShowAll->toArray();
      // code...

      $Attr = Data::ShowAttributeTypes();

      // $fileExtension = Data::FileExtention($ShowDataContent["name"]);
      // // dd(122);
      // // $fileExtension = Data::FileExtention("dddd.aa");
      // // dd($fileExtension);
      // if (
      //   $fileExtension=="png"
      //   or $fileExtension=="jpg"
      //   or $fileExtension=="jpeg"
      //   or $fileExtension=="png"
      //   or $fileExtension=="gif"
      // ) {
      //   $result[$Attr[2]] = $ShowDataContent["content"];
      //   $result[$Attr[1]] = $ShowDataContent["type"];
      //   $result[$Attr[0]] = $ShowDataContent["name"];
      //   $result[$Attr[4]] = $ShowDataContent["id"];
      // } else {
      //   $result[$Attr[2]] = $ShowDataContent["content"];
      //   $result[$Attr[1]] = $ShowDataContent["type"];
      //   $result[$Attr[0]] = $ShowDataContent["name"];
      //   $result[$Attr[4]] = $ShowDataContent["id"];
      // }
      // // else {
      // //   $result[$Attr[2]] = "unknown data type \"".$ShowDataContent["type"]."\"";
      // //   $result[$Attr[1]] = 'unknown';
      // //   $result[$Attr[0]] = $ShowDataContent["name"];
      // //   $result[$Attr[4]] = $ShowDataContent["id"];
      // // }


      $result[$Attr[2]] = $ShowDataContent["content"];
      $result[$Attr[1]] = $ShowDataContent["type"];
      $result[$Attr[0]] = $ShowDataContent["name"];
      $result[$Attr[4]] = $ShowDataContent["id"];

      return $result;
    }


  }
  // public static function ShowRelativeSignature($arg) {
  //     $result = Data::ShowSignaturePrefix()."/".$arg;
  //     return $result;
  //
  // }
  public static function ShowSignaturePrefix() {

      $result = "_data";
      return $result;

  }
  public static function ShowAll($routeParameters) {

    if(!function_exists('App\ShowHelper')){
      function ShowHelper($Data,$Identifier) {
        $result = array();
        $Attr = Data::ShowAttributeTypes();

        $Identifier = -1;
        foreach ($Data as $key => $value) {

          $Identifier = $Identifier+1;

          $SubData = Data::find($value["id"])->children->toArray();

          // $DataLocation = $PostShowID . "/" . $value;
          // $result[$value["name"]]["?"] = "?";
          // dd($value);
          if ($value["type"] == "folder") {
            // dd($SubData);


            $result[$Identifier][$Attr[2]] = ShowHelper($SubData,$Identifier);
            $result[$Identifier][$Attr[1]] = $value["type"];
            $result[$Identifier][$Attr[0]] = $value["name"];
            $result[$Identifier][$Attr[4]] = $value["id"];
          } else {
            $result[$Identifier] = Data::Show($value["id"]);
          }

        }
        return  $result;
      }
    }
    // dd(1);
    // $PostShowID = PostM::ShowLocation($PostShowID)."/".$ShowDataID;

    $GroupShowID = Group::ShowID($routeParameters);
    $PostShowID = Post::ShowID($GroupShowID,$routeParameters);
    // dd($PostShowID);
    // $PostShowID = Post::ShowID($PostShowID,$routeParameters);
    // dd($PostShowID);
    $Identifier = null;
    if (!empty($PostShowID)) {
      $BaseData = Post::find($PostShowID)->DataChildren->toArray();
    } elseif (!empty($GroupShowID)) {
      $BaseData = Group::find($GroupShowID)->DataChildren->toArray();
    }
    $Show =   ShowHelper($BaseData,$Identifier);
    // dd($Show);
    return $Show;
  }

  public static function ShowAttributeTypes() {
    $ShowAttributeTypes = array  (
      '0'=>'name',
      '1'=>'type',
      '2'=>'content',
      '3'=>'action',
      '4'=>'id',
      '5'=>'subtype',
      '6'=>'add',

    );
    // ["/SmartDataName"] =   'SmartDataName';
    // ["/SmartDataContent"] =   'SmartDataContent';

    return $ShowAttributeTypes;
  }
  public static function ShowActions() {
    $ShowActions["SelectedSmartDataItem"] =   'Selected';
    return $ShowActions;
  }


  public static function Store($request) {
    // dd($request);
    function StoreHelperStore($Action,$Data,$Attr) {
      if (isset($Data[$Attr[2]])) {
        // code...

        foreach($Data[$Attr[2]] as $key => $value) {
          // $key = SmartDataItemM::g_base64_decode($key);
          if ($value[$Attr[1]]=="folder"){
            if (isset($value[$Attr[3]]) ) {
              $Action = $value[$Attr[3]];
            }

            switch ($Action) {
              case 'update':
              if (!empty($value[$Attr[4]])) {
                // code...
                Data::find($value[$Attr[4]])
                ->update([
                  'name'=>$value[$Attr[0]],
                ]);
              }
              break;
              case 'create_folder':

              // $name = "_data";
              $name = $value[$Attr[6]]["folder"];
              $parent_id = $value[$Attr[4]];
              $parent_type = "App\Data";
              $type = "folder";
              $content = "null";

              // Data::Create($name,$parent_id,$parent_type,$type,$content)
              Data::Add($name, $parent_id,$parent_type,$type,$content);
              $Action = null;
              break;
              case 'create_file':

              // $name = "_data";
              $name = $value[$Attr[6]]["file"];
              $parent_id = $value[$Attr[4]];
              $parent_type = "App\Data";
              $type = "file";
              $content = "null";

              // Data::Create($name,$parent_id,$parent_type,$type,$content)
              Data::Add($name, $parent_id,$parent_type,$type,$content);

              $Action = null;
              break;

              default:
              // code...
              break;
            }
            StoreHelperStore($Action, $value,$Attr);
          } else {

            if (isset($value[$Attr[3]])) {
              $Action = $value[$Attr[3]];
            }

            switch ($Action) {
              case 'update':
              if (!empty($value[$Attr[4]])) {
                Data::find($value[$Attr[4]])
                ->update([
                  'name'=>$value[$Attr[0]],
                  'content'=>$value[$Attr[2]],
                ]);
              }
              break;

              default:
              // code...
              break;
            }
          }
        }
      }
    }
    $Attr = Data::ShowAttributeTypes();
    // $Data[$Attr[2]][0] = $request->get("Data");
    $Data = $request->get("Data");
    // dd($Data);

    StoreHelperStore(null,$Data,$Attr);
  }
  public static function Add ($name, $parent_id,$parent_type,$type,$content){
    // dd($type);
    Data::create([
      'name'=>$name,
      'parent_id'=>$parent_id,
      'parent_type'=>$parent_type,
      'type'=>$type,
      'content'=>$content,
    ]);
  }
  // public static function FileExtention($name){
  //   $explodedName = explode(".", $name);
  //   $extention = end($explodedName);
  //   return $extention;
  // }


}
