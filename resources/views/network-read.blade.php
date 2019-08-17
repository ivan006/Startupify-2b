


@include('includes.base-dom/general-include-one-of-four')


<link href="{{ asset('css/treeview.css') }}" rel="stylesheet">


@include('includes.base-dom/general-include-two-of-four')



@include('includes.item-menus/SmartDataFileItemMenu')
@include('includes.item-menus/SmartDataFolderItemMenu')
@include('includes.item-menus/ShallowSmartDataMenu')
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
      Welcome to Harmonyville.
    </p>
    <ul>
      <li>
        To view content just select a group from the list below.
      </li>



      <li>
        To edit the group click "mode", at the top, and select "edit" mode after opeing it.
      </li>

    </ul>


    <br>

  </div>
  <div class="w3-container w3-card w3-white w3-round w3-margin"><br>

    <h2>
      Groups

    </h2>

    <div class="f-treeview">
      <ul>
        <li>
          Network
          <ul>
            <?php foreach($PostList as $key => $value){?>
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
