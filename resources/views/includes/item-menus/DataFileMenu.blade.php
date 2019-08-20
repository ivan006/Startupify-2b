<?php function DataFileMenu($Identifier, $Attr){ ?>
  <span class="" style="  ">


    <?php
    // $gggggg = base64_decode("X2RhdGE="); dd($gggggg)
    ?>

    <button class="w3-button w3-theme-d1 w3-margin-bottom" type="submit" name="<?php echo $Identifier ?>[<?php echo $Attr[3] ?>]" value="update">Store</button>
    <button class="w3-button w3-theme-d1 w3-margin-bottom" type="submit" name="Create" value="1"><del>Create</del></button>
    <button class="w3-button w3-theme-d1 w3-margin-bottom" type="submit" name="Destroy" value="1"><del>Destroy</del></button>

  </span>
<?php } ?>
