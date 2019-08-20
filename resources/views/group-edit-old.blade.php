@include('includes.base-dom/general-include-one-of-four')

<link href="{{ asset('css/treeview.css') }}" rel="stylesheet">

@include('includes.base-dom/general-include-two-of-four')



@include('includes.item-menus/DataFileMenu')
@include('includes.item-menus/DataFolderMenu')

@include('includes.encode_decode')

@include('includes.menu_post')

@include('includes.base-dom/general-include-three-of-four')


<!-- Left Column -->
<div class="w3-col m2">


  <!-- Alert Box -->
  <br>

  <!-- End Left Column -->
</div>

<!-- Middle Column -->
<div class="w3-col m8">
  <div class="w3-container w3-card w3-white w3-round w3-margin"><br>

    <h2>
      Guide

    </h2>
    <p>
      Well done!
    </p>
    <ul>
      <li>
        Please explore the below options!
      </li>



    </ul>


    <br>

  </div>
  <div class="w3-container w3-card w3-white w3-round w3-margin"><br>
    <h2>Data</h2>

    <?php $Attribute_types = array(
    '1' => 'SmartDataType',
    '2' => 'SmartDataContent'
    ); ?>
    <?php
    // dd( $allURLs['sub_post_store']) ;
    ?>
    <form  id="form" enctype="multipart/form-data" name="" class="" action="{{ $allURLs['sub_post_store'] }}" method="post">
      {{csrf_field()}}
      <input class="g-bor-gre"  style="display: none;" type="text" name="Data_Form" value="1">

      <div class="">


        <?php
        // dd($DataShowAll);
        if (!empty($DataShowAll)) {
          function list1(
          $SmartDataArrayShowBaseLocation,
          $smartData,
          $SmartDataLocation,
          $SmartDataLocationParent,
          $SmartDataItemM_ShowActions,
          $SmartDataItemM_ShowAttributeTypes,
          $Attribute_types
          ){
            $SmartDataArrayShowBaseLocationEncoded = g_base64_encode($SmartDataArrayShowBaseLocation);
            ?>
            <ul>
              <?php
              // dd($smartData);
              foreach($smartData as $key => $value2){
                // dd($SmartDataLocationParent);
                $SmartDataLocation = $SmartDataLocationParent."[".$SmartDataItemM_ShowAttributeTypes['/SmartDataContent']."]".'['.g_base64_encode($key).']';
                $SmartDataID = "Data".$SmartDataLocation;
                ?>

                <?php

                if (is_array($value2)) {
                  // dd($value2);
                  if (!isset($value2["SmartDataType"])) {
                    // dd($value2);
                  }
                  if ($value2[$Attribute_types['1']] == 'folder') {
                    ?>
                    <li>
                      <?php
                      // dd($SmartDataID);
                      ?>
                      <input class="g-bor-gre"  style="" type="text" name="<?php echo $SmartDataID ?>[<?php echo $SmartDataItemM_ShowAttributeTypes['/SmartDataName'] ?>]" value="<?php echo $key ?>">
                      <?php echo DataFolderMenu($SmartDataID,$SmartDataItemM_ShowActions); ?>


                      <?php
                      // dd($SmartDataArrayShowBaseLocationEncoded);
                      list1(
                      $SmartDataArrayShowBaseLocationEncoded,
                      $value2,
                      $SmartDataLocation,
                      $SmartDataLocation,
                      $SmartDataItemM_ShowActions,
                      $SmartDataItemM_ShowAttributeTypes,
                      $Attribute_types
                      );
                      ?>
                    </li>


                  <?php  } else {?>
                    <li class="f-leaf">
                      <input class="g-bor-gre"  style="" type="text" name="<?php echo $SmartDataID ?>[<?php echo $SmartDataItemM_ShowAttributeTypes['/SmartDataName'] ?>]" value="<?php echo $key ?>">
                      <?php echo DataFileMenu($SmartDataID,$SmartDataItemM_ShowActions); ?>
                      <?php if ($value2[$Attribute_types['1']] == 'img') { ?>
                        <div class="">

                          <img style="max-width: 50%;" alt="Embedded Image" src="<?php echo $value2[$Attribute_types['2']]; ?>" />
                        </div>
                      <?php } else { ?>

                        <textarea class="g-bor-gre "  style="width:100%;" name="<?php echo $SmartDataID ?>[<?php echo $SmartDataItemM_ShowAttributeTypes['/SmartDataContent'] ?>]" rows="8" ><?php echo $value2[$Attribute_types['2']]; ?></textarea>
                      <?php } ?>
                    </li>

                    <?php
                  }
                }
                ?>



                <?php
              }
              ?>
            </ul>
            <?php
          }

          // dd($DataShowAll);
          ?>
          <div class="f-treeview" >


            <?php
            // dd($DataShowAll);
            // dd($SmartDataArrayShowBaseLocation);
            $DataShowAllSmart = $DataShowAll;
            // dd($DataShowAllSmart);
            // $DataShowAllSmart = $DataShowAll;
            // $DataShowAll = $DataShowAllSmart;
            list1(
            $SmartDataArrayShowBaseLocation,
            $DataShowAllSmart,
            null,
            null,
            $SmartDataItemM_ShowActions,
            $SmartDataItemM_ShowAttributeTypes,
            $Attribute_types
            );
            ?>
          </div>
          <?php

        }
        ?>
      </div>
      <br>
    </form>
  </div>

  <div class="w3-container w3-card w3-white w3-round w3-margin"><br>

    <h2>Sub-posts</h2>
    <br>
  </div>


  <br>






  <!-- End Middle Column -->
</div>

<!-- Right Column -->
<div class="w3-col m2">

  <br>

  <!-- End Right Column -->
</div>



@include('includes.base-dom/general-include-four-of-four')
