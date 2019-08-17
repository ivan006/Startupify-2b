<!-- End Grid -->
</div>

<!-- End Page Container -->
</div>
<br>

<!-- Footer -->


<!-- <footer class="w3-container w3-theme-d5">
<p>Powered by Floral Builder</p>
</footer> -->

<script>
// Accordion
function myFunction(id) {
var x = document.getElementById(id);
if (x.className.indexOf("w3-show") == -1) {
  x.className += " w3-show";
  x.previousElementSibling.className += " w3-theme-d1";
} else {
  x.className = x.className.replace("w3-show", "");
  x.previousElementSibling.className =
  x.previousElementSibling.className.replace(" w3-theme-d1", "");
}
}

// Used to toggle the menu on smaller screens when clicking on the menu button
function openNav() {
var x = document.getElementById("navDemo");
if (x.className.indexOf("w3-show") == -1) {
  x.className += " w3-show";
} else {
  x.className = x.className.replace(" w3-show", "");
}
}
</script>

</body>
</html>
