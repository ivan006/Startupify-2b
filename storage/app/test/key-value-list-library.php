<html class="mobilesdk-console-app" style="" lang="en">

<head>

  <style media="screen">
  .kv-list-parent {
    list-style: none;
    padding-left: 0;
  }
  .kv-list-parent .kv-list-parent {
    padding-left: 20px;
    border-left: 1px solid whitesmoke;
  }
  .kv-item-container {
    border: 1px DarkGray solid;
    border-radius: 3px;
    padding: 1px 4px;
    background-color: white;
    white-space: nowrap;
    margin-bottom: 3px;
  }
  .kv-mar-top-3 {margin-top: 3px;}
  .kv-di-in {display: inline-block;}
  .kv-name {
    width: 150px;
    box-sizing:inherit;
    vertical-align: top;
  }
  .kv-little-button {
    font-weight: bold;
    width: 20px;
    text-align: center;
    font-size: 100%;
    font-family: inherit;
    border: 0 ;
    padding: 0;
    background-color: rgba(0,0,0,0);
    display: inline-block;
  }
  .kv-popover {
    position: absolute;
    top: 100%;
    right: 0px;
    z-index: 1;
  }
  .kv-di-no {display:none;}
  .kv-po-re {position: relative;}
  .kv-tog-on-bl{
    display:none;
  }
  .kv-tog-on-bl-switch:checked ~ .kv-tog-on-bl {display:block;}
  .kv-tog-on-bl-switch {display:none;}
  .kv-tog-off-ib-switch:checked  ~ .kv-tog-off-ib {display:none;}
  .kv-tog-off-ib {display: inline-block;}
  .kv-tog-off-ib-switch {display:none;}
  .kv-tog-on-ib-switch{display:none;}
  .kv-tog-on-ib-switch:checked ~ .kv-tog-on-ib {display:inline-block;}
  .kv-tog-on-ib {display:none;}
  .kv-field-container {
    border: 1px black solid;
    font: inherit;
    padding: 2px;
  }
  .kv-content-container {
    height: 200px;
    width: 100%;
    resize:vertical;
  }
  .kv-name-unedit {
    border: 1px solid transparent;
    overflow: hidden;
    text-overflow: ellipsis;
    padding: 2px;
  }
  </style>

</head>
<?php $CurrentIdentifier=0; $value2=0; ?>
<body>
  <div class="">
    <ul class="kv-list-parent">
      <li>
        <div class="kv-item-container  kv-di-in ">
          <div class="kv-di-in">📁</div>
          <label style="">
            <input class="kv-tog-on-ib-switch kv-tog-off-ib-switch" type="checkbox" name="checkbox" value="value">
            <input class="kv-field-container kv-name kv-tog-on-ib" type="text" name="<?php echo $CurrentIdentifier; ?>[<?php echo $Attr[0]; ?>]" value="<?php echo $value2[$Attr[0]]; ?>">
            <a href="#" class="kv-name-unedit kv-name kv-tog-off-ib ">php<?php echo $value2[$Attr[0]]; ?></a>
            <span class="kv-little-button ">^</span>
          </label>
          <input class="kv-di-no" type="text" name="<?php echo $CurrentIdentifier; ?>[<?php echo $Attr[1]; ?>]" value="<?php echo $value2[$Attr[1]]; ?>">
          <input class="kv-di-no" type="text" name="<?php echo $CurrentIdentifier; ?>[<?php echo $Attr[4]; ?>]" value="<?php echo $value2[$Attr[4]]; ?>">
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
              <div class="kv-mar-top-3">
                <span>📃</span>
                <input class="kv-field-container kv-name kv-di-in"  type="text" name="<?php echo $CurrentIdentifier; ?>[<?php echo $Attr[6]; ?>][file]">
                <button type="submit" class="kv-little-button" name="<?php echo $CurrentIdentifier; ?>[<?php echo $Attr[3]; ?>]" value="create_folder">+</button>
              </div>
            </div>
          </label>
        </div>
        <ul class="kv-list-parent">
          <li>
            <div class="kv-item-container  kv-di-in  ">
              <div class="kv-di-in">📃</div>
              <label style="">
                <input class="kv-tog-on-ib-switch kv-tog-off-ib-switch" type="checkbox" name="checkbox" value="value">
                <input class="kv-field-container kv-name kv-tog-on-ib" type="text" name="<?php echo $CurrentIdentifier; ?>[<?php echo $Attr[0]; ?>]" value="<?php echo $value2[$Attr[0]]; ?>">
                <a href="#" class="kv-name-unedit kv-name kv-tog-off-ib ">phpdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd<?php echo $value2[$Attr[0]]; ?></a>
                <span class="kv-little-button ">^</span>
              </label>

              <input class="kv-di-no" type="text" name="<?php echo $CurrentIdentifier; ?>[<?php echo $Attr[1]; ?>]" value="<?php echo $value2[$Attr[1]]; ?>">
              <input class="kv-di-no" type="text" name="<?php echo $CurrentIdentifier; ?>[<?php echo $Attr[4]; ?>]" value="<?php echo $value2[$Attr[4]]; ?>">
              <button type="submit" class="kv-little-button" type="submit" name="<?php echo $CurrentIdentifier; ?>[<?php echo $Attr[3]; ?>]" value="update">✓</button>
              <button type="submit" class="kv-little-button" type="submit" name="<?php echo $CurrentIdentifier; ?>[<?php echo $Attr[3]; ?>]" value="delete">×</button>
            </div>
            <ul class="kv-list-parent">
              <li>
                <div class="kv-item-container ">
                  <textarea class="kv-field-container kv-content-container kv-di-in" name="<?php echo $CurrentIdentifier; ?>[<?php echo $Attr[2]; ?>]" rows="8" ><?php echo $value2[$Attr[2]]; ?></textarea>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </li>
    </ul>
  </div>



</body>

</html>
