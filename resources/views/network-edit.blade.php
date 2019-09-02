@include('includes.base-dom/general-include-one-of-four')
<link href="{{ asset('css/key-value-list.css') }}" rel="stylesheet">
@include('includes.base-dom/general-include-two-of-four')
@include('includes.menu_report')
@include('includes.base-dom/general-include-three-of-four')

<!-- Left Column -->
<div class="w3-col m2">
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
        To view a group open it by selecting it from the list below.
      </li>
      <li>
        To add a group click the "+" symbol next to the Harmonyville item bellow.
      </li>
      <li>
        To edit a group select the "editor" tool from the menu at the top after opening the group.
      </li>

    </ul>


    <br>

  </div>
  <div class="w3-container w3-card w3-white w3-round w3-margin"><br>
    <h2>
      Groups
    </h2>
    <form  enctype="multipart/form-data" name="1" class="" action="{{ $allURLs['sub_report_store'] }}" method="post">
      <input class="g-bor-gre"  style="display: none;" type="text" name="All_Content" value="1">
      {{csrf_field()}}
      <ul class="kv-list-parent">
        <li>
          <div class="kv-item-container  kv-di-in ">
            <div class="kv-di-in">📁</div>
            <div class="kv-name-unedit kv-name kv-tog-off-ib ">Harmonyville</div>
            <label class="kv-po-re">
              <span class="kv-little-button ">+</span>
              <input class="kv-tog-on-bl-switch" type="checkbox" name="checkbox" value="value">
              <div class="kv-popover kv-tog-on-bl kv-item-container  kv-di-in" style="">
                <div class="" >
                  <span>📁</span>
                  <input class="kv-field-container kv-name kv-di-in "  type="text"   name="name" >
                  <button type="submit" class="kv-little-button" name="create" value="1">+</button>
                </div>
              </div>
            </label>
          </div>

          <ul class="kv-list-parent">
            <?php
            foreach ($ReportList as $key => $value) {
              ?>
              <li>
                <div class="kv-item-container  kv-di-in ">
                  <div class="kv-di-in">📁</div>
                  <label style="">
                    <input class="kv-tog-on-ib-switch kv-tog-off-ib-switch" type="checkbox" name="checkbox" value="value">
                    <input class="kv-field-container kv-name kv-tog-on-ib" type="text" name="" value="{{$key}}">
                    <a href="{{$value['url']}}" class="kv-name-unedit kv-name kv-tog-off-ib ">{{$key}}</a>
                    <span class="kv-little-button ">^</span>
                  </label>

                  <input class="kv-di-no" type="text" name="" value="">
                  <input class="kv-di-no" type="text" name="" value="">
                  <button type="submit" class="kv-little-button" name="" value="update">✓</button>
                  <button type="submit" class="kv-little-button" name="" value="delete">×</button>

                </div>
              </li>
              <?php
            }
            ?>
          </ul>
        </li>
      </ul>
    </form>
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
