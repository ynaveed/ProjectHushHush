<!DOCTYPE html>
<html>
<head>
  <style>
div { background:#de9a44; margin:3px; width:80px; 
height:40px; display:none; float:left; }
</style>
  <script src="http://code.jquery.com/jquery-latest.js"></script>
</head>
<body>
  <a href="#" id="link">Click me!</a>
<div></div>
<div></div>
<div></div>
<script>
$("#link").click(function () {
if ($("div:first").is(":hidden")) {
$("div").slideDown("slow");
} else {
$("div").hide();
}
});

</script>

</body>
</html>