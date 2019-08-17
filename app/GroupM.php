<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;
use App\PostM;
use App\SubPostM;
use App\SmartDataItemM;






class GroupM extends Model
{


  public static function ShowBaseLocation() {
    // return "storage/app/public/";
    return base_path()."/storage/app/public/";
  }

  public static function ShowAll() {
    $ShowBaseLocation = GroupM::ShowBaseLocation();
    $dataNameList = scandir($ShowBaseLocation);
    $result = array();
    foreach ($dataNameList as $key => $value) {
      $dataLocation = $ShowBaseLocation . "/" . $value;
      if (!in_array($value,array(".","..")) && is_dir($dataLocation) )  {
            $url = str_replace($ShowBaseLocation."/", "", $dataLocation);
            $result[$value]["url"] = route('Network.show', $url);
      }
    }

    return $result;
  }
  public static function ShowLocation() {
    // dd(func_get_args()[0]);
    return GroupM::ShowBaseLocation().func_get_args()[0];
  }

  public static function Create($request) {
    // dd($request);
    mkdir(GroupM::ShowBaseLocation()."/".$request->get('name'));
  }
  // public static function ShowOld() {
  //   $ShowBaseLocation = GroupM::ShowBaseLocation();
  //   $staticdir  = GroupM::ShowBaseLocation();
  //   $result = array();
  //   $dataNameList = scandir($ShowBaseLocation);
  //   // dd($dataNameList);
  //   foreach ($dataNameList as $key => $value) {
  //     if (!in_array($value,array(".","..")))  {
  //       $dataLocation = $ShowBaseLocation . "/" . $value;
  //       if (is_dir($dataLocation) and basename($dataLocation) !== SmartDataItemM::ShowBaseLocation()){
  //         $subDataNameList = scandir($dataLocation);
  //         // dd($dataLocation);
  //         // dd($subDataNameList);
  //         $blackList = array(".","..",SmartDataItemM::ShowBaseLocation(),"rich.html");
  //         $whiteList = array_diff_key($subDataNameList,$blackList);
  //         // dd($whiteList );
  //         if (!empty($whiteList)) {
  //           // $result[$value] = PostM::ShowSubPostHelper($dataLocation,$staticdir);
  //           $url = str_replace($staticdir."/", "", $dataLocation);
  //           $result[$value]["url"] = route('Network.show', $url);
  //         } else {
  //           $url = str_replace($staticdir."/", "", $dataLocation);
  //           $result[$value] = route('Network.show', $url);
  //         }
  //       }
  //     }
  //   }
  //
  //   return $result;
  // }
  // public static function VPgContForAsset($a,$b) {
  //   $result = array();
  //   $VPgContItem = scandir($siteURL);
  //   foreach ($VPgContItem as $key => $value) {
  //     if (!in_array($value,array(".","..")))  {
  //       $DataLocation = $siteURL . DIRECTORY_SEPARATOR . $value;
  //
  //       $result[$value] = file_get_contents($DataLocation);
  //
  //     }
  //   }
  //   return  $result;
  // }
  // public static function ShowLocation($value) {
  //   return GroupM::ShowBaseLocation()."/".$value;
  // }

  // public static function AssetURLs() {
  //   $ShowBaseLocations['post_read'] = "";
  //   $ShowBaseLocations['post_create'] = "add";
  //   $ShowBaseLocations['sub_post_read_suffix'] = "SubPost";
  //
  //   return $ShowBaseLocations;
  // }


  // public static function ShowID(){
  //
  //   // $VPgLoc = '';
  //   // foreach (func_get_args()[0] as $key => $value) {
  //   //   $VPgLoc .= "".$value."/";
  //   // }
  //
  //   return func_get_args()[0][0];
  // }





}
