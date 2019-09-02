<style>
html, body, h1, h2, h3, h4, h5 {font-family: "Open Sans", sans-serif}
.g-futuristic-indented-list {
  margin-left: 1em;
  margin-top: 1em;
  border-left: 2px whitesmoke solid;
  padding-left: 1em;
}
.g-bor-gre {
  border: 2px whitesmoke solid;
}
.g-bor-top-0 {
  border-top: 0px ;

}


</style>

@include('includes.menu_report')





<div class="" style="background-color: white; padding: 0em; width: 100%; height: 200px;">

  <?php

  if (!empty($RichDataShow)) {
    echo $RichDataShow;
  }

  ?>

</div>
