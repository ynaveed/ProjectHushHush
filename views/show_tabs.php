<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to PHH</title>
	<?php $this->load->view('header');
	
	
	//$val = json_decode($jdays);
	
	
	?>
	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
	<script>
	$(function() {
		$( "#tabs" ).tabs();
	});
	
	$(document).ready(function(){
		$("#show_hum").click(function(){
			$("#show_hum_drama").fadeIn()
			$("#all").fadeOut();
		});
		$("#show_all").click(function(){
			$("#all").fadeIn()
			$("#show_hum_drama").fadeOut();			
		});
		
	/////////////////start/////////////////////////////filling tab 1 - (All channel) td dynamically//////////////////////////////////
		
		$("#all_row_one").html("<img src='<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/demo_wait.gif' />");
		$("#all_row_two").html("<img src='<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/demo_wait.gif' />");
		$("#all_row_three").html("<img src='<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/demo_wait.gif' />");
		
		/*function(){
			for(int i=0;i<3;i++)
			{
				$('<td></td>').html("<img src='"+<?php echo $val->sun->one[0];?>+"' width=200px height=150 alt=sunday>").appendTo("#all_row_one");
			}
		
		}*/

		$.getJSON("http://api.flickr.com/services/feeds/photos_public.gne?jsoncallback=?",
		{
			tags: "ships",
			tagmode: "any",
			format: "json"
		},
		function(data) {
			$("#all_row_two").html('');
			$.each(data.items, function(i,item){
			$('<td></td>').html("<img src='"+item.media.m+"' width=200px height=150 alt=monday>").appendTo("#all_row_two");
			if ( i == 3 ) return false;
			});
		});
	
		
		$.getJSON("http://api.flickr.com/services/feeds/photos_public.gne?jsoncallback=?",
		{
			tags: "burger",
			tagmode: "any",
			format: "json"
		},
		function(data) {
			$("#all_row_three").html('');
			$.each(data.items, function(i,item){
			$('<td></td>').html("<img src='"+item.media.m+"' width=200px height=150 alt=tuesady>").appendTo("#all_row_three");
			if ( i == 3 ) return false;
			});
		});
		
		/////////////////end/////////////////////////////filling tab 1 - (All channel) td dynamically//////////////////////////////////
		
		
	   /////////////////start/////////////////////////////filling tab 2 - (All Drama) td dynamically//////////////////////////////////
		/*
		$("#all_drama_row_one").html("<img src='<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/demo_wait.gif' />");
		$("#all_drama_row_two").html("<img src='<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/demo_wait.gif' />");
		$("#all_drama_row_three").html("<img src='<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/demo_wait.gif' />");
		
		$.getJSON("http://api.flickr.com/services/feeds/photos_public.gne?jsoncallback=?",
		{
			tags: "music",
			tagmode: "any",
			format: "json"
		},
		function(data) {
			$("#all_drama_row_one").html('');
			$.each(data.items, function(i,item){
			$('<td></td>').html("<img src='"+item.media.m+"' width=200px height=150>").appendTo("#all_drama_row_one");
			if ( i == 3 ) return false;
			});
		});
		
		$.getJSON("http://api.flickr.com/services/feeds/photos_public.gne?jsoncallback=?",
		{
			tags: "girls",
			tagmode: "any",
			format: "json"
		},
		function(data) {
			$("#all_drama_row_two").html('');
			$.each(data.items, function(i,item){
			$('<td></td>').html("<img src='"+item.media.m+"' width=200px height=150>").appendTo("#all_drama_row_two");
			if ( i == 3 ) return false;
			});
		});
	
		
		$.getJSON("http://api.flickr.com/services/feeds/photos_public.gne?jsoncallback=?",
		{
			tags: "party",
			tagmode: "any",
			format: "json"
		},
		function(data) {
			$("#all_drama_row_three").html('');
			$.each(data.items, function(i,item){
			$('<td></td>').html("<img src='"+item.media.m+"' width=200px height=150>").appendTo("#all_drama_row_three");
			if ( i == 3 ) return false;
			});
		});
		*/
		/////////////////end/////////////////////////////filling tab 2 - (All Drama) td dynamically//////////////////////////////////
		
		/////////////////start/////////////////////////////filling tab 3 - (All Popular) td dynamically//////////////////////////////////
		/*
		$("#all_popular_row_one").html("<img src='<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/demo_wait.gif' />");
		$("#all_popular_row_two").html("<img src='<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/demo_wait.gif' />");
		$("#all_popular_row_three").html("<img src='<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/demo_wait.gif' />");
		
		$.getJSON("http://api.flickr.com/services/feeds/photos_public.gne?jsoncallback=?",
		{
			tags: "book",
			tagmode: "any",
			format: "json"
		},
		function(data) {
			$("#all_popular_row_one").html('');
			$.each(data.items, function(i,item){
			$('<td></td>').html("<img src='"+item.media.m+"' width=200px height=150>").appendTo("#all_popular_row_one");
			if ( i == 3 ) return false;
			});
		});
		
		$.getJSON("http://api.flickr.com/services/feeds/photos_public.gne?jsoncallback=?",
		{
			tags: "beach",
			tagmode: "any",
			format: "json"
		},
		function(data) {
			$("#all_popular_row_two").html('');
			$.each(data.items, function(i,item){
			$('<td></td>').html("<img src='"+item.media.m+"' width=200px height=150>").appendTo("#all_popular_row_two");
			if ( i == 3 ) return false;
			});
		});
	
		
		$.getJSON("http://api.flickr.com/services/feeds/photos_public.gne?jsoncallback=?",
		{
			tags: "football",
			tagmode: "any",
			format: "json"
		},
		function(data) {
			$("#all_popular_row_three").html('');
			$.each(data.items, function(i,item){
			$('<td></td>').html("<img src='"+item.media.m+"' width=200px height=150>").appendTo("#all_popular_row_three");
			if ( i == 3 ) return false;
			});
		});
		
		/////////////////end/////////////////////////////filling tab 3 - (All Popular) td dynamically//////////////////////////////////
		
		
		$("#show_hum_one").html("<img src='<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/demo_wait.gif' />");
		$.getJSON("http://api.flickr.com/services/feeds/photos_public.gne?jsoncallback=?",
		{
			tags: "dog",
			tagmode: "any",
			format: "json"
		},
		function(data) {
			$("#show_hum_one").html('');
			$.each(data.items, function(i,item){
			$("<img/>").attr("src", item.media.m).appendTo("#show_hum_one");
			if ( i == 0 ) return false;
			});
		});
		
		
		$("#show_popular_one").html("<img src='<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/demo_wait.gif' />");
		$.getJSON("http://api.flickr.com/services/feeds/photos_public.gne?jsoncallback=?",
		{
			tags: "cat",
			tagmode: "any",
			format: "json"
		},
		function(data) {
			$("#show_popular_one").html('');
			$.each(data.items, function(i,item){
			$("<img/>").attr("src", item.media.m).appendTo("#show_popular_one");
			if ( i == 0 ) return false;
			});
		});
		*/
	});
	
	
	</script>
	
</head>
<body>
<div id="container">
	<h1>Welcome to PHH</h1>

	<div id="body">
	

<div class="demo">

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Episodes aired this week</a></li>
		<li><a href="#tabs-2">All Drama</a></li>
		<li><a href="#tabs-3">Popular Clips</a></li>
	</ul>
    
    
    
	<div id="tabs-1">
	
	<table width="100%"  border="0" align="center" cellpadding="3" cellspacing="0" >
		<tr bgcolor="#CCCCCC">
			<td width="190px"><a  href="#">All Week</a></td>
			<td ><a  href="#" >Sunday</a></td>
			<td ><a  href="#">Monday</a></td>
			<td ><a  href="#">Tuesday</a></td>
			<td ><a  href="#">Wednesday</a></td>
			<td ><a  href="#">Thursday</a></td>
			<td ><a  href="#">Friday</a></td>
			<td ><a  href="#">Saturday</a></td>
		</tr>
	</table>
	<br>
	<table width="100%"  border="0" align="center" cellpadding="3" cellspacing="0" >
		<tr bgcolor="#CCCCCC">
			<td width="190px" id="show_all"><a  href="#">All Channels</a></td>
			<td ><a  href="#" id="show_hum">Hum</a></td>
			<td ><a  href="#">GEO</a></td>
			<td ><a  href="#">ARY</a></td>
			<td ><a  href="#">ATV</a></td>
			<td ><a  href="#">PTV</a></td>
		</tr>
	</tr>
	</table>
	<br>
	<table id="all" width="100%"  align="center" cellpadding="2"  >
		<tr id="all_row_one"></tr>
		<tr id="all_row_two"></tr>
		<tr id="all_row_three"></tr>
	</tr>
	</table>
	
	
	<table id="show_hum_drama" width="100%"  align="center" cellpadding="2" style="display:none;" >
		<tr>
			<td ><img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/all_channel/bbl.jpg" width="200px" height="150px"><br>Bulbulay<br><a  href="#" target="_parent" >30-05-2011</a></td>
			<td height="17" valign="top"><img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/all_channel/sndl.jpg" width="200px" height="150px"><br>Sandal<br>24-05-2011</td>
			<td height="17" valign="top"><img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/all_channel/kaurm.jpg" width="200px" height="150px"><br>Khudaaur Muhabbat<br>03-06-2011</td>
			<td ><img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/all_channel/hmsfr.jpg" width="200px" height="150px"><br>Humsafar<br /><a  href="#" target="_parent" >For detail click here</a></td>
		</tr>
		<tr>
			<td ><img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/all_channel/bbl.jpg" width="200px" height="150px"><br>Bulbulay<br><a  href="#" target="_parent" >30-05-2011</a></td>
			<td height="17" valign="top"><img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/all_channel/sndl.jpg" width="200px" height="150px"><br>Sandal<br>24-05-2011</td>
			<td height="17" valign="top"><img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/all_channel/kaurm.jpg" width="200px" height="150px"><br>Khudaaur Muhabbat<br>03-06-2011</td>
			<td ><img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/all_channel/hmsfr.jpg" width="200px" height="150px"><br>Humsafar<br /><a  href="#" target="_parent" >For detail click here</a></td>
		</tr>
		<tr>
			<td ><img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/all_channel/bbl.jpg" width="200px" height="150px"><br>Bulbulay<br><a  href="#" target="_parent" >30-05-2011</a></td>
			<td height="17" valign="top"><img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/all_channel/sndl.jpg" width="200px" height="150px"><br>Sandal<br>24-05-2011</td>
			<td height="17" valign="top"><img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/all_channel/kaurm.jpg" width="200px" height="150px"><br>Khudaaur Muhabbat<br>03-06-2011</td>
			<td ><img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/all_channel/hmsfr.jpg" width="200px" height="150px"><br>Humsafar<br /><a  href="#" target="_parent" >For detail click here</a></td>
		</tr>
	</tr>
	</table>
	
	
	
	<table id="geo" width="100%"  align="center" cellpadding="2"  style="display:none;">
		<tr>
			<td height="17" valign="top">Sandal 1 (GEO)<br>24-05-2011</td>
			<td >This is nice drama<br><a  href="#" target="_parent" >For detail click here</a></td>
		</tr>
		<tr>
			<td height="17" valign="top">Bulbulay 1 (GEO)<br>03-06-2011</td>
			<td > Comedy Drama<br /><a  href="#" target="_parent" >For detail click here</a></td>
		</tr>
	</tr>
	</table>

	<table id="ary" width="100%"  align="center" cellpadding="2" style="display:none;">
		<tr>
			<td height="17" valign="top">Sandal 1 (ARY)<br>24-05-2011</td>
			<td >This is nice drama<br><a  href="#" target="_parent" >For detail click here</a></td>
		</tr>
		<tr>
			<td height="17" valign="top">Bulbulay 1 (ARY)<br>03-06-2011</td>
			<td > Comedy Drama<br /><a  href="#" target="_parent" >For detail click here</a></td>
		</tr>
	</tr>
	</table>

	<table id="atv" width="100%"  align="center" cellpadding="2" style="display:none;">
		<tr>
			<td height="17" valign="top">Sandal 1 (ATV)<br>24-05-2011</td>
			<td >This is nice drama<br><a  href="#" target="_parent" >For detail click here</a></td>
		</tr>
		<tr>
			<td height="17" valign="top">Bulbulay 1 (ATV)<br>03-06-2011</td>
			<td > Comedy Drama<br /><a  href="#" target="_parent" >For detail click here</a></td>
		</tr>
	</tr>
	</table>
	
	<table id="ptv" width="100%"  align="center" cellpadding="2" style="display:none;">
		<tr>
			<td height="17" valign="top">Sandal 1 (PTV)<br>24-05-2011</td>
			<td >This is nice drama<br><a  href="#" target="_parent" >For detail click here</a></td>
		</tr>
		<tr>
			<td height="17" valign="top">Bulbulay 1 (PTV)<br>03-06-2011</td>
			<td > Comedy Drama<br /><a  href="#" target="_parent" >For detail click here</a></td>
		</tr>
	</tr>
	</table>
	</div>

	
	
	
	
	<!-- ----------------------------------------Tab 2 --------------------------------------------- -->
	
	
	
	
	
	<div id="tabs-2">
	<table width="100%"  border="0" align="center" cellpadding="3" cellspacing="0" >
		<tr bgcolor="#CCCCCC">
			<td ><a  href="#">All</a></td>
			<td ><a  href="#">A</a></td>
			<td ><a  href="#">B</a></td>
			<td ><a  href="#">C</a></td>
			<td ><a  href="#">D</a></td>
			<td ><a  href="#">E</a></td>
		</tr>
	</table>
	<br>
    <table width="100%"  border="0" align="center" cellpadding="3" cellspacing="0" >
    <tr id="all_drama_row_one"></tr>
	<tr id="all_drama_row_two"></tr>
	<tr id="all_drama_row_three"></tr>
    </table>
	</div>
    
	
	
	<!-- ----------------------------------------Tab 3 --------------------------------------------- -->
	
	
    
	<div id="tabs-3">
	<table width="100%"  border="0" align="center" cellpadding="3" cellspacing="0" >
		<tr id="all_popular_row_one"></tr>
		<tr id="all_popular_row_two"></tr>
		<tr id="all_popular_row_three"></tr>
    </table>
	</div>
    
</div>

</div>


	</div>

	
</div>

</body>
</html>