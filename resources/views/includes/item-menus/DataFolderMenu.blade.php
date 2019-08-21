<?php
function DataFolderMenu($Identifier, $Attr)
{
  ?>
  <span class="" style="  ">

    <button class="w3-button w3-theme-d1 w3-margin-bottom" type="submit" name="<?php echo $Identifier; ?>[<?php echo $Attr[3]; ?>]" value="update">
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
      <div class="content g-bor-gre g-pad-1em" style="margin-left:6em;">
        <div class="">
          <input class="g-bor-gre f-width-270px"  type="text"   name="<?php echo $Identifier; ?>[<?php echo $Attr[6]; ?>][folder]" >
          <button style="" class="w3-button w3-theme-d1 w3-margin-bottom f-width-200px" type="submit"  name="<?php echo $Identifier; ?>[<?php echo $Attr[3]; ?>]" value="create_folder">
            Folder from scratch
          </button>

        </div>

        <div class="">
          <input class="g-bor-gre f-width-270px"  type="text" name="<?php echo $Identifier; ?>[<?php echo $Attr[6]; ?>][file]">
          <button  class="w3-button w3-theme-d1 w3-margin-bottom f-width-200px" type="submit"  name="<?php echo $Identifier; ?>[<?php echo $Attr[3]; ?>]" value="create_file">
            File from scratch
          </button>

        </div>

      </div>
    </label>



  </span>
  <?php
}
?>
