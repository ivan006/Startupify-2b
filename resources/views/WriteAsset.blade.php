@include('includes.menu_post')


<br>
<br>


 <form class="" action="{{ route('index') }}" method="post">
   <input type="submit" name="submit" value="Submit">
   <br>
   {{csrf_field()}}

   <input type="text"  name="name" value=""  placeholder="Enter title">


 </form>

<br>


<div class="json-editor" id="mydiv"></div>

<script src="{{ URL::asset('js/FlexiJsonEditor/jquery.min.js') }}"></script>

<script src="{{ URL::asset('js/FlexiJsonEditor/jquery.jsoneditor.js') }}"></script>

<script type="text/javascript">
<?php
if (isset($ShowAllDeepSmartData['smart'])) {
  $ivan3 = array();
  $ivan3["smart"] = $ShowAllDeepSmartData['smart'];
  $ivan_json =  json_encode($ivan3);
} else {
  $ivan_json =  null;
}
?>
var myjson =
<?php
echo $ivan_json;
?>
;

</script>
<script type="text/javascript">
// var opt = {
//   change: function(data) { /* called on every change */ },
//   propertyclick: function(path) { /* called when a property is clicked with the JS path to that property */ }
// };
// /* opt.propertyElement = '<textarea>'; */ // element of the property field, <input> is default
// /* opt.valueElement = '<textarea>'; */  // element of the value field, <input> is default
// $('#mydiv').jsonEditor(myjson, opt);

</script>


<!-- <script type="text/javascript">

  let thingydo = document.getElementById("mydiv").getElementsByTagName("DIV")[0].getElementsByClassName("value")[0];
  thingydo.onkeyup = function() {myFunctiondd()};


  function myFunctiondd() {  document.getElementById("theLord").value = thingydo.value;}

</script> -->
<script type="text/javascript">
// document.getElementById("theLord").value = myjson.smart.toSource();
// document.getElementById("theLord").value = JSON.stringify(myjson.smart);
document.getElementById("theLord").value = JSON.stringify(myjson);

</script>
