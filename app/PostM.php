<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;
use App\GroupM;
use App\PostM;
use App\SmartDataItemM;
use App\FileM;




class PostM extends Model
{


  // needed to make  link in subPosts list and to use with "storeAs" function start
  public static function ShowID(){

    // $root= GroupM::ShowBaseLocation();
    $arguments = func_get_args()[0];
    // var_dump($arguments);
    // array_shift($arguments);
    // $VPgLoc = '';


    foreach ($arguments as $key => $value) {
      if (isset($VPgLoc)) {
        $VPgLoc .= "/".$value;
      } else {
        $VPgLoc = $value;
      }
    }


    return $VPgLoc;

  }
  // needed to make  link in subPosts list and to use with "storeAs" function end
  public static function ShowLocation($ShowID) {

    // dd(func_get_args()[0]);
    // echo GroupM::ShowBaseLocation().PostM::ShowID(func_get_args()[0]);



    // array_shift($arguments);
    // var_dump($arguments);
    if (!empty($ShowID)) {

      return  GroupM::ShowBaseLocation().$ShowID;
    } else {
      // return  GroupM::ShowBaseLocation().GroupM::ShowID(func_get_args()[0]);
      return "now what";
    }

  }

  // needed for header call starts
  public static function ShowBaseID() {
    $arguments = func_get_args()[0][0];

    return $arguments;
  }

  public static function ShowBaseIDPlusBaseLocation() {
    return GroupM::ShowBaseLocation().PostM::ShowBaseID(func_get_args()[0]);
  }
  // needed for header call end

  public static function ShowActions() {

    if (!empty(func_get_args()[0])) {
      $ShowID = PostM::ShowID(func_get_args()[0]);
      $allURLs['sub_post_read'] =   route('Network.show',$ShowID);
      $allURLs['sub_post_edit'] = route('Network.edit',$ShowID);
      $allURLs['sub_post_store'] = route('Network.store',$ShowID);
    } else {
      $ShowID = null;
      $allURLs['sub_post_read'] =   route('Network.show',$ShowID);
      $allURLs['sub_post_edit'] = route('Network.edit',$ShowID);
      $allURLs['sub_post_store'] = route('Network.store',$ShowID);
    }
    return $allURLs;
  }

  public static function ShowSubPost() {



    if(!function_exists('App\ShowSubPostHelper')){

      function ShowSubPostHelper($ShowLocation,$staticdir,$ShowID) {
        $result = array();
        // dd ($ShowLocation);
        $dataNameList = scandir($ShowLocation);

        $url = str_replace($staticdir, "", $ShowLocation);
        $result["url"] = route("Network.show")."/".$ShowID.$url;
        foreach ($dataNameList as $key => $value) {
          if (!in_array($value,array(".","..")))  {
            $dataLocation = $ShowLocation . "/" . $value;
            if (is_dir($dataLocation) and basename($dataLocation) !== SmartDataItemM::ShowBaseLocation()){
              $subDataNameList = scandir($dataLocation);
              $blackList = array(".","..",SmartDataItemM::ShowBaseLocation(),"rich.html");
              $whiteList = array_diff_key($subDataNameList,$blackList);
              if (!empty($whiteList)) {
                $result[$value] = ShowSubPostHelper($dataLocation,$staticdir,$ShowID);
                // $url = str_replace($staticdir."/", "", $dataLocation);
                // $result[$value]["url"] = route("Network.show")."/".$ShowID."/".$url;
              } else {
                $url = str_replace($staticdir, "", $dataLocation);
                $result[$value] = route("Network.show")."/".$ShowID.$url;
              }
            }
          }
        }
        return $result;
      }
    }


    $ShowID = PostM::ShowID(func_get_args()[0]);
    $ShowLocation = GroupM::ShowLocation($ShowID);
    $staticdir = GroupM::ShowLocation($ShowID);

    $result[$ShowID] = ShowSubPostHelper($ShowLocation,$staticdir,$ShowID);


    return $result;
  }

  public static function Show() {
    // g
  }

  // public static function ShowAllDeepSmartData($ShowID) {
  //   $SmartDataArrayShowBaseLocation = SmartDataItemM::ShowBaseLocation();
  //   return $ShowAllDeepSmartData = SmartDataItemM::ShowAll($SmartDataArrayShowBaseLocation, $ShowID);
  //
  // }

  public static function ShowAllShallowSmartData() {

    // if (is_dir($ShowLocation)) {

      $result = array();
      $ShowID = PostM::ShowID(func_get_args()[0]);
      $ShowLocation = PostM::ShowLocation($ShowID)."/";
      $shallowList = scandir($ShowLocation);
      // dd($shallowList);
      foreach ($shallowList as $key => $value) {
        $DataLocation = $ShowLocation . $value;
        if (!in_array($value,array(".","..", "rich.html") ) &&   !is_dir($DataLocation))  {
          // dd($DataLocation);
          $result[$value] = file_get_contents($DataLocation);
        }
      }
      return  $result;

    // }
  }

  public static function Store($arguments, $request) {
    // dd($request);
    $SmartDataItemM_ShowActions = SmartDataItemM::ShowActions();
    $ShowID = PostM::ShowID($arguments);

    $ShowLocation = PostM::ShowLocation($ShowID);
    if (!empty($request->get('All_Content'))) {
      // dd(123);

      if (null !== $request->file('zip_file')) {

        $SubLocation = SmartDataItemM::ShowBaseLocation()."/";
        FileM::CreateFromZip($arguments, $request, $SubLocation );
      }

    }
    elseif (!empty($request->get('post_files_create_from_zip'))) {
      // dd(123);

      if (null !== $request->file('zip_file')) {

        $SubLocation = null;
        FileM::CreateFromZip($arguments, $request, $SubLocation );
      }

    }
    elseif (!empty($request->get('SmartDataItemShowFieldValues_Form'))) {

      // if (!empty($request->get($SmartDataItemM_ShowActions['RichDataStore'])) ) {
      //
      //
      //   function StoreRichData($ShowLocation, $request){
      //
      //     $filename =  "rich.html";
      //     $file =  $ShowLocation."/".$filename;
      //     // echo file_get_contents($file);
      //
      //     $contents =  $request->get('contents');
      //     file_put_contents($file,$contents);
      //
      //   }
      //
      //   StoreRichData($ShowLocation, $request);
      // }
      SmartDataItemM::Store($ShowLocation, $request, $ShowID);
    }
  }
}
