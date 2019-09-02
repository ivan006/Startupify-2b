<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Data;
class Entity extends Model
{

  public static function ShowMulti($BaseEntityType,$BaseEntityID, $EntityType,$Slug)
  {
    if (!function_exists('App\ShowMultiHelper')) {
      function ShowMultiHelper($BaseEntityType, $BaseEntityID, $EntityType, $SubIdentifier,$Slug)
      {
        $Attr = Entity::ShowAttributeTypes();

        $BaseEntityTypeClass = "App\\".$BaseEntityType;

        $Entity = $BaseEntityTypeClass::find($BaseEntityID)->toArray();

        $Slug = $Slug."/".$Entity['name'];

        $identityer = base64_encode($Entity['name']);

        $result[$identityer][$Attr[0]] = $Entity['name'];
        $result[$identityer][$Attr[1]] = $Entity['type'];
        if (isset($Entity['content'])) {
          // code...
          $result[$identityer][$Attr[2]] = $Entity['content'];
        }
        $result[$identityer][$Attr[4]] = $Entity['id'];


        if ('folder' == $Entity['type']) {
          $result[$identityer][$Attr[7]] = $Slug;
          $result[$identityer][$Attr[8]] = $BaseEntityTypeClass;

          $EntityChildrenType = $EntityType."Children";

          $SubEntityList = $BaseEntityTypeClass::find($BaseEntityID)->$EntityChildrenType->toArray();


          $result[$identityer][$Attr[2]] = array();

          foreach ($SubEntityList as $key => $value) {


            $BaseEntityID = $value[$Attr[4]];

            $BaseEntityType = $EntityType;
            $ShowMultiHelper = ShowMultiHelper($BaseEntityType, $BaseEntityID, $EntityType, $SubIdentifier,$Slug);

            $result[$identityer][$Attr[2]] = array_merge($result[$identityer][$Attr[2]],$ShowMultiHelper);




          }
        }


        return $result;
      }
    }

    $SubIdentifier = 0;

    $result = ShowMultiHelper($BaseEntityType, $BaseEntityID, $EntityType, $SubIdentifier,$Slug);
    // dd($result);
    return $result;
  }

  public static function ShowAttributeTypes()
  {
    $ShowAttributeTypes = array(
    '0' => 'name',
    '1' => 'type',
    '2' => 'content',
    '3' => 'action',
    '4' => 'id',
    '5' => 'subtype',
    '6' => 'add',
    '7' => 'url',
    '8' => 'entity_type',
    );

    return $ShowAttributeTypes;
  }

  public static function FileExtention($name)
  {
      $explodedName = explode('.', $name);
      $extention = end($explodedName);

      return $extention;
  }

  public static function StoreMultiForEdit($ShowChangesForEdit,$EntityType)
  {
    // dd($ShowChangesForEdit);
    if (!function_exists('App\StoreHelperStore')) {
      function StoreHelperStore($InheritedAction, $ShowChangesForEdit, $Attr, $EntityType)
      {
        $EntityTypeClass = "App\\".$EntityType;

        if (isset($ShowChangesForEdit[$Attr[2]])) {
          foreach ($ShowChangesForEdit[$Attr[2]] as $key => $value) {
            if ('folder' == $value[$Attr[1]]) {
              if (isset($value[$Attr[3]])) {
                $Action = $value[$Attr[3]];
              } else {
                $Action = $InheritedAction;
              }
              // dd($ShowChangesForEdit);
              switch ($Action) {
                case 'update':
                if (!empty($value[$Attr[4]])) {
                  $EntityTypeClass::find($value[$Attr[4]])
                  ->update([
                    'name' => $value[$Attr[0]],
                  ]);
                }
                break;
                case 'delete':
                if (!empty($value[$Attr[4]])) {
                  if ($EntityType == "Report") {
                    $EntityType2 = 'Data';
                    $BaseEntityType = $EntityType;
                    $BaseEntityID = $value[$Attr[4]];
                    $Slug = null;
                    $ShowImpliedChangesForEdit = Entity::ShowImpliedChangesForEdit($BaseEntityType,$BaseEntityID, $EntityType2,$Slug);

                    $ShowImpliedChangesForEdit2 = $ShowImpliedChangesForEdit[0];
                    $ShowImpliedChangesForEdit2[$Attr[2]][0][$Attr[3]] = 'delete';

                    Data::StoreMultiForEdit($ShowImpliedChangesForEdit2,$EntityType2);
                  }
                  $EntityTypeClass::find($value[$Attr[4]])->delete();
                }
                break;
                case 'create_folder':
                // dd($EntityTypeClass);
                $var = $EntityTypeClass::create([
                  'name' => $value[$Attr[6]]['folder'],
                  'parent_id' => $value[$Attr[4]],
                  'parent_type' => $value[$Attr[8]],
                  'type' => 'folder',
                  'content' => 'null'
                ]);

                if ($EntityType == "Report") {
                  $ReportShowID = $var->id;

                  Data::create([
                  'name' => '_data',
                  'parent_id' => $ReportShowID,
                  'parent_type' => "App\Report",
                  'type' => 'folder',
                  'content' => 'null',
                  ]);
                }

                $Action = $InheritedAction;
                break;
                case 'create_file':

                $var = $EntityTypeClass::create([
                'name' => $value[$Attr[6]]['file'],
                'parent_id' => $value[$Attr[4]],
                'parent_type' => $value[$Attr[8]],
                'type' => 'file',
                'content' => 'null',
                ]);

                $Action = $InheritedAction;
                break;

                default:

                break;
              }
              StoreHelperStore($Action, $value, $Attr, $EntityType);
              // $Action = null;
            } else {
              if (isset($value[$Attr[3]])) {
                $Action = $value[$Attr[3]];
              } else {
                $Action = $InheritedAction;
              }

              switch ($Action) {
                case 'update':
                if (!empty($value[$Attr[4]])) {
                  $EntityTypeClass::find($value[$Attr[4]])
                  ->update([
                  'name' => $value[$Attr[0]],
                  'content' => $value[$Attr[2]],
                  ]);
                }
                break;
                case 'delete':
                if (!empty($value[$Attr[4]])) {
                  $EntityTypeClass::find($value[$Attr[4]])
                  ->delete();
                }
                break;

                default:

                break;
              }
              // $Action = null;
            }
          }
        }
      }
    }

    $Attr = Entity::ShowAttributeTypes();

    // dd($Entity);

    StoreHelperStore(null, $ShowChangesForEdit, $Attr, $EntityType);
  }

  public static function ShowMultiStyledForEdit($EntityType,$routeParameters)
  {

    if (!function_exists('App\ShowMultiStyledForEditHelper')) {
      function ShowMultiStyledForEditHelper($Identifier, $EntityShowMultiForEdit, $Attr,$EntityType)
      {
        $result = null;
        ob_start();
        ?>
        <ul class="kv-list-parent">
          <?php
          $IdentifierSuffix = -1;
          if (!empty($EntityShowMultiForEdit[$Attr[2]])) {
            foreach ($EntityShowMultiForEdit[$Attr[2]] as $key => $value2) {
              $IdentifierSuffix = $IdentifierSuffix + 1;
              $CurrentIdentifier = $Identifier.'['.$Attr[2].']'.'['.$IdentifierSuffix.']';

              if (is_array($value2)) {
                if ('folder' == $value2[$Attr[1]]) {
                  ?>
                  <li>

                    <div class="kv-item-container  kv-di-in ">
                      <div class="kv-di-in">📁</div>
                      <label style="">
                        <input class="kv-tog-on-ib-switch kv-tog-off-ib-switch" type="checkbox" name="checkbox" value="value">
                        <input class="kv-field-container kv-name kv-tog-on-ib" type="text" name="<?php echo $CurrentIdentifier; ?>[<?php echo $Attr[0]; ?>]" value="<?php echo $value2[$Attr[0]]; ?>">
                        <?php if ($EntityType=='Report') { ?>
                          <a href="<?php echo $value2['url']; ?>" class="kv-name-unedit kv-name kv-tog-off-ib "><?php echo $value2[$Attr[0]]; ?></a>
                        <?php } else { ?>
                          <div class="kv-name-unedit kv-name kv-tog-off-ib "><?php echo $value2[$Attr[0]]; ?></div>
                        <?php }?>
                        <span class="kv-little-button ">∧</span>
                      </label>

                      <input class="kv-di-no" type="text" name="<?php echo $CurrentIdentifier; ?>[<?php echo $Attr[1]; ?>]" value="<?php echo $value2[$Attr[1]]; ?>">
                      <input class="kv-di-no" type="text" name="<?php echo $CurrentIdentifier; ?>[<?php echo $Attr[4]; ?>]" value="<?php echo $value2[$Attr[4]]; ?>">
                      <input class="kv-di-no" type="text" name="<?php echo $CurrentIdentifier; ?>[<?php echo $Attr[8]; ?>]" value="<?php echo $value2[$Attr[8]]; ?>">
                      <button type="submit" class="kv-little-button" name="<?php echo $CurrentIdentifier; ?>[<?php echo $Attr[3]; ?>]" value="update">✓</button>
                      <button type="submit" class="kv-little-button" name="<?php echo $CurrentIdentifier; ?>[<?php echo $Attr[3]; ?>]" value="delete">×</button>


                      <label class="kv-po-re">
                        <span class="kv-little-button ">+</span>
                        <input class="kv-tog-on-bl-switch" type="checkbox" name="checkbox" value="value">
                        <div class="kv-popover kv-tog-on-bl kv-item-container  kv-di-in" style="">
                          <div class="" >
                            <span>📁</span>
                            <input class="kv-field-container kv-name kv-di-in "  type="text"   name="<?php echo $CurrentIdentifier; ?>[<?php echo $Attr[6]; ?>][folder]" >
                            <button type="submit" class="kv-little-button" name="<?php echo $CurrentIdentifier; ?>[<?php echo $Attr[3]; ?>]" value="create_folder">+</button>
                          </div>
                          <?php if ($EntityType!=='Report') { ?>
                            <div class="kv-mar-top-3">
                              <span>📃</span>
                              <input class="kv-field-container kv-name kv-di-in"  type="text" name="<?php echo $CurrentIdentifier; ?>[<?php echo $Attr[6]; ?>][file]">
                              <button type="submit" class="kv-little-button" name="<?php echo $CurrentIdentifier; ?>[<?php echo $Attr[3]; ?>]" value="create_file">+</button>
                            </div>
                          <?php } ?>
                        </div>
                      </label>
                    </div>
                    <?php



                    $result .= ob_get_contents();

                    ob_end_clean();
                    $result .= ShowMultiStyledForEditHelper($CurrentIdentifier, $value2, $Attr,$EntityType);


                    ob_start();
                    ?>
                  </li>


                  <?php
                } else {
                  ?>
                  <li>
                    <div class="kv-item-container  kv-di-in ">
                      <div class="kv-di-in">📃</div>
                      <label style="">
                        <input class="kv-tog-on-ib-switch kv-tog-off-ib-switch" type="checkbox" name="checkbox" value="value">
                        <input class="kv-field-container kv-name kv-tog-on-ib" type="text" name="<?php echo $CurrentIdentifier; ?>[<?php echo $Attr[0]; ?>]" value="<?php echo $value2[$Attr[0]]; ?>">
                        <div class="kv-name-unedit kv-name kv-tog-off-ib "><?php echo $value2[$Attr[0]]; ?></div>
                        <span class="kv-little-button ">∧</span>
                      </label>

                      <input class="kv-di-no" type="text" name="<?php echo $CurrentIdentifier; ?>[<?php echo $Attr[1]; ?>]" value="<?php echo $value2[$Attr[1]]; ?>">
                      <input class="kv-di-no" type="text" name="<?php echo $CurrentIdentifier; ?>[<?php echo $Attr[4]; ?>]" value="<?php echo $value2[$Attr[4]]; ?>">
                      <button type="submit" class="kv-little-button" name="<?php echo $CurrentIdentifier; ?>[<?php echo $Attr[3]; ?>]" value="update">✓</button>
                      <button type="submit" class="kv-little-button" name="<?php echo $CurrentIdentifier; ?>[<?php echo $Attr[3]; ?>]" value="delete">×</button>

                    </div>


                    <ul class="kv-list-parent">
                      <li>



                        <?php
                        $fileExtension = Entity::FileExtention($value2[$Attr[0]]);

                        if ('png' == $fileExtension or 'jpg' == $fileExtension or 'jpeg' == $fileExtension
                        or 'png' == $fileExtension or 'gif' == $fileExtension)
                        {
                          ?>
                          <div class="kv-item-container ">
                            <img  style="width: 300px;" alt="Embedded Image" src="<?php echo $value2[$Attr[2]]; ?>" />
                            <textarea class="kv-field-container kv-content-container kv-di-in kv-di-no" name="<?php echo $CurrentIdentifier; ?>[<?php echo $Attr[2]; ?>]" rows="8" ><?php echo $value2[$Attr[2]]; ?></textarea>
                          </div>
                          <?php
                        } else {
                          ?>

                          <div class="kv-item-container ">
                            <textarea class="kv-field-container kv-content-container kv-di-in" name="<?php echo $CurrentIdentifier; ?>[<?php echo $Attr[2]; ?>]" rows="8" ><?php echo $value2[$Attr[2]]; ?></textarea>
                          </div>

                          <?php
                        } ?>
                      </li>
                    </ul>
                  </li>
                  <?php

                }
              }
            }
          }?>
        </ul>
        <?php



        $result .= ob_get_contents();

        ob_end_clean();

        return $result;
      }
    }





    $Identifier = $EntityType;
    $Attr = Entity::ShowAttributeTypes();
    $EntityTypeClass = "App\\".$EntityType;

    if ($EntityType=='Data') {


      $GroupShowID = Group::ShowID($routeParameters);
      $ReportShowID = Report::ShowID($GroupShowID, $routeParameters);

      // $Identifier = null;
      if (!empty($ReportShowID)) {

        $BaseEntityType = 'Report';
        $BaseEntityID = $ReportShowID;
      } elseif (!empty($GroupShowID)) {
        $BaseEntityType = 'Group';
        $BaseEntityID = $GroupShowID;
      }

      $BaseEntityTypeClass = "App\\".$BaseEntityType;

      $DataList = $BaseEntityTypeClass::find($BaseEntityID)->DataChildren->first()->toArray();

      $BaseEntityID = $DataList['id'];
      $BaseEntityType = 'Data';
      $EntityType = 'Data';

      $Slug = null;

    } else {
      $Slug = route('NetworkC.show');

      $BaseEntityType = 'Group';
      $BaseEntityID = Group::ShowID($routeParameters);
      $EntityType ='Report';


    }

    $EntityShowMultiForEdit[$Attr[2]] = Entity::ShowMulti($BaseEntityType,$BaseEntityID, $EntityType,$Slug);

    $result = ShowMultiStyledForEditHelper($Identifier, $EntityShowMultiForEdit, $Attr,$EntityType);
    return $result;
  }

  public static function ShowChangesForEdit($request,$EntityType)
  {
    $result = $request->get($EntityType);
    return $result;
  }

  public static function ShowImpliedChangesForEdit($BaseEntityType,$BaseEntityID, $EntityType,$Slug)
  {
    $result = Entity::ShowMulti($BaseEntityType,$BaseEntityID, $EntityType,$Slug);
    return $result;
  }


}
