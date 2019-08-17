<?php function SmartDataFolderItemMenu($Identifier, $Attr){ ?>
  <span class="" style="  ">

    <button class="w3-button w3-theme-d1 w3-margin-bottom" type="submit" name="<?php echo $Identifier ?>[<?php echo $Attr[3] ?>]" value="1">
      Update
    </button>
    <button class="w3-button w3-theme-d1 w3-margin-bottom" type="submit" name="Destroy" value="1">
      <del>Delete</del>
    </button>
    <label>
      <input class="f-toggle" type="checkbox" name="checkbox" value="value" style="display:none;" >
      <span class="f-toggle w3-button w3-theme-d1 w3-margin-bottom" >
        Create
      </span>
      <!-- <div class="content g-bor-gre g-pad-1em" style="margin-left:6em;">
        <div class="">
          <input class="g-bor-gre f-width-270px"  type="text" name="" value="">
          <button style="" class="w3-button w3-theme-d1 w3-margin-bottom f-width-200px" type="submit" name="Destroy" value="1">
            Folder from scratch
          </button>

        </div>
        <div class="">
          <input class="g-bor-gre f-width-135px"  type="text" name="" value="">
          <input class="g-bor-gre f-width-135px f-fon-siz-8px" type="file" name="zip_file" />

          <button  class="w3-button w3-theme-d1 w3-margin-bottom f-width-200px" type="submit" name="Destroy" value="1">
            Folder from zip upload
          </button>

        </div>
        <div class="">
          <input class="g-bor-gre f-width-270px"  type="text" name="" value="">
          <button  class="w3-button w3-theme-d1 w3-margin-bottom f-width-200px" type="submit" name="Destroy" value="1">
            File from scratch
          </button>

        </div>
        <div class="">

          <input class="g-bor-gre f-width-135px"  type="text" name="" value="">
          <input class="g-bor-gre f-width-135px f-fon-siz-8px"  type="file" name="zip_file" />

          <button class="w3-button w3-theme-d1 w3-margin-bottom f-width-200px" type="submit" name="Destroy" value="1">
            File from upload
          </button>

        </div>
      </div> -->
    </label>



  </span>
<?php } ?>
