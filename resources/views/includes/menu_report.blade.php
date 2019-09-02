<link href="{{ asset('css/menu-style.css') }}" rel="stylesheet">

<div  class="f-multi-level-dropdown f-bg-col-blu f-fon-18px f-fon-fam-open ">
  <ul>
    <li>
      <a  href="{{ route('NetworkC.show') }}">Home
      </a>
    </li>
    <li>
      <div class="toggle">
        <a href="#">
          Tool
        </a>
        <ul>
          <!-- <li>
          <a  href=""><del>Create</del>
        </a>
      </li> -->
      <li>
        <a  href=" {{ $allURLs['sub_report_read'] }}">Viewer
        </a>
      </li>
      <!-- <li>
      <a  href=""><del>Destroy</del>
    </a>
  </li> -->
  <li>
    <a  href="{{ $allURLs['sub_report_edit'] }}">Editor
    </a>
  </li>
</ul>
</div>
</li>
</ul>
</div>
