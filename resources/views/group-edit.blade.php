@include('includes.base-dom/general-include-one-of-four')

<link href="{{ asset('css/treeview.css') }}" rel="stylesheet">

@include('includes.base-dom/general-include-two-of-four')



@include('includes.item-menus/SmartDataFileItemMenu')
@include('includes.item-menus/SmartDataFolderItemMenu')
@include('includes.item-menus/ShallowSmartDataMenu')


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

    <h2>Posts</h2>
    <br>
  </div>
  <div class="w3-container w3-card w3-white w3-round w3-margin"><br>
    <h2>Data</h2>


    <!-- $ShowAttributeTypes["0"] =   'SmartDataName';
    $ShowAttributeTypes["2"] =   'SmartDataContent'; -->
    <?php
    // dd( $allURLs['sub_post_store']) ;
    ?>
    <form  id="form" enctype="multipart/form-data" name="" class="" action="{{ $allURLs['sub_post_store'] }}" method="post">
      {{csrf_field()}}
      <input class="g-bor-gre"  style="display: none;" type="text" name="Data_Form" value="1">

      <div class="">


        <?php
        // dd($DataShowAll);
        // dd($DataShowAll);
        if (!empty($DataShowAll)) {
          function list1($Identifier,$DataShowAll,$Attr){


            ?>
            <ul>
              <?php
              $IdentifierSuffix = -1;
              foreach($DataShowAll as $key => $value2){
                // dd($value2);
                $IdentifierSuffix = $IdentifierSuffix+1;
                $CurrentIdentifier = $Identifier."[".$Attr[2]."]"."[".$IdentifierSuffix."]";

                // $SmartDataLocation = $SmartDataLocationParent."[".$Attr[2]."]".'['.g_base64_encode($key).']';

                if (is_array($value2)) {
                  // if (!isset($value2["SmartDataType"])) {
                  // }
                  if ($value2[$Attr[1]] == 'folder') {
                    ?>
                    <li>
                      <?php
                      // dd($CurrentIdentifier);
                      ?>
                      <input class="g-bor-gre"  style="" type="text" name="<?php echo $CurrentIdentifier ?>[<?php echo $Attr[0] ?>]" value="<?php echo $value2[$Attr[0]] ?>">
                      <input class=""  style="display:none;" type="text" name="<?php echo $CurrentIdentifier ?>[<?php echo $Attr[1] ?>]" value="<?php echo $value2[$Attr[1]] ?>">
                      <input class=""  style="display:none;" type="text" name="<?php echo $CurrentIdentifier ?>[<?php echo $Attr[4] ?>]" value="<?php echo $value2[$Attr[4]] ?>">

                      <?php echo SmartDataFolderItemMenu($CurrentIdentifier,$Attr); ?>


                      <?php
                      list1($CurrentIdentifier,$value2[$Attr[2]],$Attr);
                      ?>
                    </li>


                  <?php  } else { ?>
                    <li class="f-leaf">
                      <input class="g-bor-gre"  style="" type="text" name="<?php echo $CurrentIdentifier ?>[<?php echo $Attr[0] ?>]" value="<?php echo $value2[$Attr[0]] ?>">
                      <input class=""  style="display:none;" type="text" name="<?php echo $CurrentIdentifier ?>[<?php echo $Attr[1] ?>]" value="<?php echo $value2[$Attr[1]] ?>">
                      <input class=""  style="display:none;" type="text" name="<?php echo $CurrentIdentifier ?>[<?php echo $Attr[4] ?>]" value="<?php echo $value2[$Attr[4]] ?>">
                      <?php echo SmartDataFileItemMenu($CurrentIdentifier,$Attr); ?>
                      <?php if ($value2[$Attr[1]] == 'image') { ?>
                        <div class="">
                          <?php
                           // dd($value2[$Attr[2]])
                           ?>
                          <img style="max-width: 50%;" alt="Embedded Image" src="<?php echo $value2[$Attr[2]]; ?>" />
                          <textarea class="g-bor-gre "  style="display:none;" name="<?php echo $CurrentIdentifier ?>[<?php echo $Attr[2] ?>]" rows="8" ><?php echo $value2[$Attr[2]]; ?></textarea>
                        </div>
                      <?php } else { ?>

                        <textarea class="g-bor-gre "  style="width:100%;" name="<?php echo $CurrentIdentifier ?>[<?php echo $Attr[2] ?>]" rows="8" ><?php echo $value2[$Attr[2]]; ?></textarea>
                      <?php } ?>
                    </li>

                    <?php
                  }
                }
              }
              ?>
            </ul>
            <?php
          }

          ?>
          <div class="f-treeview" >

                <?php
                $Identifier = "Data";
                list1($Identifier,$DataShowAll,$Attr);
                ?>


          </div>
          <?php

        }
        ?>
      </div>
      <br>
    </form>
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
