<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;
use App\GroupM;
use App\PostM;
use App\SmartDataItemM;




class SmartDataItemM extends Model
{

  public static function ShowActions() {
    $ShowActions["SelectedSmartDataItem"] =   'SelectedSmartDataItem';
    $ShowActions["ShallowSmartDataStore"] =   'ShallowSmartDataStore';
    $ShowActions["RichDataStore"] =   'RichDataStore';
    $ShowActions["DeepSmartDataArrayStoreFromSingleField"] =   'DeepSmartDataArrayStoreFromSingleField';
    return $ShowActions;
  }

  public static function ShowAttributeTypes() {
    $ShowAttributeTypes = array  (
      'SmartDataName',
      'SmartDataType',
      'SmartDataContent'

    );
    // ["/SmartDataName"] =   'SmartDataName';
    // ["/SmartDataContent"] =   'SmartDataContent';
    // $ShowAttributeTypes["/SmartDataLocation"] =   'SmartDataLocation';
    // $ShowAttributeTypes["/SmartDataLocationParent"] =   'SmartDataLocationParent';


    return $ShowAttributeTypes;
  }

  public static function ShowBaseLocation() {
    return "smart";
  }

  public static function ShowAll($ShowID) {

    if(!function_exists('App\ShowHelper')){
      function ShowHelper($ShowLocation) {
        $result = array();
        $shallowList = scandir($ShowLocation);
        // dd($shallowList);
        // echo $ShowLocation."<br>";
        // if ($ShowLocation == "/home/vagrant/code-b/storage/app/public/aaas/smart") {
        //   // code...
        //   dd($shallowList);
        // }

        foreach ($shallowList as $key => $value) {

          if (!in_array($value,array(".","..")))  {
            $DataLocation = $ShowLocation . "/" . $value;

            $Attribute_types = array(
              '1' => 'SmartDataType',
              '2' => 'SmartDataContent'
            );
            if (is_dir($DataLocation)){
              $result[$value] = ShowHelper($DataLocation);
              $result[$value][$Attribute_types['1']] = 'dir';
            } else {
              $result[$value] = SmartDataItemM::Show($DataLocation);
            }
          }
        }
        return  $result;
      }
    }

    // $ShowLocation = PostM::ShowLocation($ShowID)."/".$ShowDataID;
    $ShowLocation = PostM::ShowLocation($ShowID);
    // dd($ShowLocation);
    if (is_dir($ShowLocation)) {
      // $Show[$ShowDataID] =   ShowHelper($ShowLocation);
      $Show =   ShowHelper($ShowLocation);
      // dd($Show);
      return $Show;
    }
  }

  public static function Show($DataLocation) {

    // $result = file_get_contents($DataLocation);
    $Attribute_types = array(
      '1' => 'SmartDataType',
      '2' => 'SmartDataContent'
    );
    if (file_exists($DataLocation)){
      if (mime_content_type($DataLocation) == "image/jpeg") {
        $type = pathinfo($DataLocation, PATHINFO_EXTENSION);
        $data = file_get_contents($DataLocation);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $result[$Attribute_types['2']] = $base64;
        $result[$Attribute_types['1']] = 'img';
      } elseif (mime_content_type($DataLocation) == "text/plain" OR mime_content_type($DataLocation) == "text/html") {

        $result[$Attribute_types['2']] = file_get_contents($DataLocation);
        $result[$Attribute_types['1']] = 'text';
      } else {
        $result[$Attribute_types['2']] = "error dont support this: ".mime_content_type($DataLocation);
        $result[$Attribute_types['1']] = 'text';
      }
      return $result;
    } else {
      $result[$Attribute_types['2']] = "error";
      $result[$Attribute_types['1']] = 'null';

      return $result;
    }

  }
  public static function ShowOld($ShowID, $DataID) {

    // $ShowLocation = PostM::ShowLocation($ShowID)."/".$ShowDataID;

    $ShowLocation = PostM::ShowLocation($ShowID);
    // dd($ShowLocation);
      // $Show[$ShowDataID] =   ShowHelper($ShowLocation);
      $DataLocation = $ShowLocation . "/" . $DataID;
      if (file_exists($DataLocation)){
        $result = file_get_contents($DataLocation);
        return  $result;
      } else {
        return  'error';
      }

  }

  public static function g_base64_decode($value) {
    return base64_decode($value);
    // return $value;
  }

  public static function Store($ShowLocation, $request, $ShowID) {
    function StoreHelperDestroy($ShowLocation,$ShowDataID, $SelectedSmartDataItem, $SmartDataItemShowFieldValues) {
      // dd($SmartDataItemShowFieldValues);
      foreach ($SmartDataItemShowFieldValues as $key => $value) {
        // dd($SmartDataItemShowFieldValues);
        // dd($SmartDataItemShowFieldValues);
        // dd($SmartDataItemShowFieldValues);
        // dd($SmartDataItemShowFieldValues);

        $String_SelectedSmartDataItem = 'SelectedSmartDataItem';
        $String_SmartDataName = 'SmartDataName';
        $String_SmartDataLocationParent = 'SmartDataLocationParent';
        $String_SmartDataContent = 'SmartDataContent';
        $String_SmartDataLocation = 'SmartDataLocation';
        if (
        $key !== $String_SelectedSmartDataItem
        && $key !== $String_SmartDataName
        && $key !== $String_SmartDataLocationParent
        && $key !== $String_SmartDataContent
        && $key !== $String_SmartDataLocation
        ) {
          $key = SmartDataItemM::g_base64_decode($key);
          if (!array_key_exists($String_SmartDataContent, $value)) {
            // dd(1);
            if (isset($value[$String_SelectedSmartDataItem]) OR $SelectedSmartDataItem == 1) {
              $SelectedSmartDataItemInheritance = 1;
            } else {
              $SelectedSmartDataItemInheritance = 0;
            }
            // dd($key);
            StoreHelperDestroy($ShowLocation,$ShowDataID."/".$key, $SelectedSmartDataItemInheritance, $value);
            if (isset($value[$String_SelectedSmartDataItem]) OR $SelectedSmartDataItem == 1) {
              rmdir($ShowLocation.$ShowDataID."/".$key);
            }
          } else {

            if (isset($value[$String_SelectedSmartDataItem]) OR $SelectedSmartDataItem == 1) {
              // dd($value['SelectedSmartDataItem']);
              unlink($ShowLocation.$ShowDataID."/".$key);
            }
          }
        }
      }

    }
    function StoreHelperStore($ShowLocation,$SelectedSmartDataItem,$ShowDataID,$SmartDataItemShowFieldValues) {
      // dd($SmartDataItemShowFieldValues);
      foreach($SmartDataItemShowFieldValues as $key => $value) {

        $String_SelectedSmartDataItem = 'SelectedSmartDataItem';
        $String_SmartDataName = 'SmartDataName';
        $String_SmartDataLocationParent = 'SmartDataLocationParent';
        $String_SmartDataContent = 'SmartDataContent';
        $String_SmartDataLocation = 'SmartDataLocation';
        if (
        $key !== $String_SelectedSmartDataItem
        && $key !== $String_SmartDataName
        && $key !== $String_SmartDataLocationParent
        && $key !== $String_SmartDataContent
        && $key !== $String_SmartDataLocation
        )  {
          $key = SmartDataItemM::g_base64_decode($key);
          if (!array_key_exists($String_SmartDataContent, $value)){
            if (isset($value[$String_SelectedSmartDataItem]) OR $SelectedSmartDataItem == 1) {
              $SmartDataName = $value[$String_SmartDataName];
              $SmartDataArrayLocation = $ShowLocation . $ShowDataID."/".$SmartDataName;
              $SelectedSmartDataItemInheritance = 1;
              mkdir($SmartDataArrayLocation);
            } else {

              $SmartDataName = $key;
              $SelectedSmartDataItemInheritance = 0;
            }
            StoreHelperStore($ShowLocation,$SelectedSmartDataItemInheritance, $ShowDataID."/".$SmartDataName, $value);
          } else {
            $SmartDataName = $value[$String_SmartDataName];
            $content = $value;
            $SmartDataArrayLocation = $ShowLocation.$ShowDataID."/".$SmartDataName;


            if (isset($value[$String_SelectedSmartDataItem]) OR $SelectedSmartDataItem == 1) {
              file_put_contents($SmartDataArrayLocation,$value[$String_SmartDataContent]);
            }
          }
        }
      }
    }
    // dd($request);
    $String_SelectedSmartDataItem = 'SelectedSmartDataItem';

    $SmartDataItemM_ShowActions = SmartDataItemM::ShowActions();
    $SmartDataRelativeLocation = base64_decode($request->get($SmartDataItemM_ShowActions[$String_SelectedSmartDataItem]));
    // $SmartDataBaseLocation = SmartDataItemM::ShowBaseLocation();
    // $ShowDataID = $SmartDataBaseLocation.$SmartDataRelativeLocation;
    $ShowDataID = $SmartDataRelativeLocation;

    $String_SmartDataItemShowFieldValues = 'SmartDataItemShowFieldValues';
    $SmartDataItemShowFieldValues = $request->get($String_SmartDataItemShowFieldValues);

    $ShowDataLocation = $ShowLocation."/".$ShowDataID;

    StoreHelperDestroy($ShowLocation,null, 0, $SmartDataItemShowFieldValues);

    $SmartDataItemM_ShowAttributeTypes = SmartDataItemM::ShowAttributeTypes();
    $SmartDataItemM_ShowActions = SmartDataItemM::ShowActions();

    StoreHelperStore($ShowLocation, null,null,$SmartDataItemShowFieldValues);
  }


}
