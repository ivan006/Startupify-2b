@include('includes.base-dom/general-include-one-of-four')

<link href="{{ asset('css/treeview.css') }}" rel="stylesheet">

@include('includes.base-dom/general-include-two-of-four')



@include('includes.item-menus/DataFileMenu')
@include('includes.item-menus/DataFolderMenu')
@include('includes.item-menus/PostAndGroupMenu')

@include('includes.item-menus/functions')


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
    <form  enctype="multipart/form-data" name="1" class="" action="{{ $allURLs['sub_post_store'] }}" method="post">

      <input class="g-bor-gre"  style="display: none;" type="text" name="form" value="posts">

      {{csrf_field()}}
      <div class="f-treeview">
        <ul>
          <li>
            Posts

            <?php echo PostAndGroupMenu(); ?>

            <ul>
              <?php //dd($PostList) ?>
              <?php foreach($PostShowImSubPosts as $key => $value){?>
                <li class="f-leaf">
                  <a href="{{$value['url']}}">
                    {{$key}}
                  </a>
                </li>
              <?php }?>

            </ul>
          </li>
        </ul>
      </div>

    </form>

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
      <input class="g-bor-gre"  style="display: none;" type="text" name="form" value="data">

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
              foreach($DataShowAll[$Attr[2]] as $key => $value2){
                // dd($value2);
                $IdentifierSuffix = $IdentifierSuffix+1;
                $CurrentIdentifier = $Identifier."[".$Attr[2]."]"."[".$IdentifierSuffix."]";

                // $SmartDataLocation = $SmartDataLocationParent."[".$Attr[2]."]".'['.g_base64_encode($key).']';

                if (is_array($value2)) {
                  // if (!isset($value2["SmartDataType"])) {
                  // }
                  // dd($value2);
                  if ($value2[$Attr[1]] == 'folder') {
                    ?>
                    <li>
                      <?php
                      // dd($CurrentIdentifier);
                      ?>
                      <div class="g-bor-lig-gre g-pad-2px g-mar-4px">

                        <input class="g-bor-gre"  style="" type="text" name="<?php echo $CurrentIdentifier ?>[<?php echo $Attr[0] ?>]" value="<?php echo $value2[$Attr[0]] ?>">
                        <input class=""  style="display:none;" type="text" name="<?php echo $CurrentIdentifier ?>[<?php echo $Attr[1] ?>]" value="<?php echo $value2[$Attr[1]] ?>">
                        <input class=""  style="display:none;" type="text" name="<?php echo $CurrentIdentifier ?>[<?php echo $Attr[4] ?>]" value="<?php echo $value2[$Attr[4]] ?>">
                        <?php echo DataFolderMenu($CurrentIdentifier,$Attr); ?>
                      </div>



                      <?php
                      list1($CurrentIdentifier,$value2,$Attr);
                      ?>
                    </li>


                  <?php  } else { ?>
                    <li class="f-leaf">
                      <div class="g-bor-lig-gre g-pad-2px g-mar-4px">

                        <input class="g-bor-gre"  style="" type="text" name="<?php echo $CurrentIdentifier ?>[<?php echo $Attr[0] ?>]" value="<?php echo $value2[$Attr[0]] ?>">
                        <input class=""  style="display:none;" type="text" name="<?php echo $CurrentIdentifier ?>[<?php echo $Attr[1] ?>]" value="<?php echo $value2[$Attr[1]] ?>">
                        <input class=""  style="display:none;" type="text" name="<?php echo $CurrentIdentifier ?>[<?php echo $Attr[4] ?>]" value="<?php echo $value2[$Attr[4]] ?>">
                        <?php echo DataFileMenu($CurrentIdentifier,$Attr); ?>
                        <?php
                        $fileExtension = FileExtention($value2[$Attr[0]]);
                        // dd($extention);

                        // if ($value2[$Attr[1]] == 'image') {
                        if (
                          $fileExtension=="png"
                          or $fileExtension=="jpg"
                          or $fileExtension=="jpeg"
                          or $fileExtension=="png"
                          or $fileExtension=="gif"
                        ) {
                        ?>
                          <div class="">
                            <?php
                            // dd($value2[$Attr[2]])
                            ?>
                            <img style="max-width: 50%;" alt="Embedded Image" src="<?php echo $value2[$Attr[2]]; ?>" />
                            <textarea class="g-bor-gre "  style="display:none;" name="<?php echo $CurrentIdentifier ?>[<?php echo $Attr[2] ?>]" rows="8" ><?php echo $value2[$Attr[2]]; ?></textarea>
                          </div>
                        <?php } else { ?>

                          <textarea class="g-bor-gre f-res-ver"  style="width:100%;" name="<?php echo $CurrentIdentifier ?>[<?php echo $Attr[2] ?>]" rows="8" ><?php echo $value2[$Attr[2]]; ?></textarea>
                        <?php } ?>
                      </div>
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
                // dd($DataShowAll);
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
