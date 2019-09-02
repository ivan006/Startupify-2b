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
      Groups

    </h2>

    <div class="f-treeview">
      <ul class="kv-list-parent">
        <li>
          <div class="kv-item-container  kv-di-in ">
            <div class="kv-di-in">📁</div>
            <div class="kv-name-unedit kv-name kv-tog-off-ib ">Harmonyville.net</div>
          </div>
          <ul class="kv-list-parent">
            <?php
            foreach ($ReportList as $key => $value) {
              ?>

            <li>
              <div class="kv-item-container  kv-di-in ">
                <div class="kv-di-in">📁</div>
                <a href="{{$value['url']}}" class="kv-name-unedit kv-name kv-tog-off-ib ">{{$key}}</a>
              </div>
            </li>
              <?php
            }
            ?>
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
