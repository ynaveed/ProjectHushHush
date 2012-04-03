<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to PHH</title>
	<?php $this->load->view('header');
	$json_val=$jdays;
	$val = json_decode($jdays);
	print_r($json_val);
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
	<script type="text/javascript">
	var week='';
	var chanel='';
	var data = eval('(<?php echo $json_val; ?>)');
	//alert(data.sun.hum.one[0]);
	$.each(data,function(i,el)
	{
		//if(week == i || week == "all weak"){
		//	$.each(data,function(i,el)
		//}
		
	});

	
	
	
	$(function() {
		$( "#tabs" ).tabs();
		$( "#channel_tabs" ).tabs();
	});


	$(document).ready(function(){

	//////////////////////////////////mapping php json to javascript//////////////////////////
	var js_days_arr = new Array();
	var js_channel_arr = new Array();
	
		//////////////////////////////////////////////all week///////////////////////////////////////////////
		$("#search_all_week").click(function(){

		
				$("#channel_tabs a[href=#tabs-2]").click(function(){
					//alert('Hello');
					$("#channel_tabs #tabs-2 #hum_dramas").html('<?php 
					foreach ($val as $key=>$all_val) {
						echo "<img src=".$all_val->hum->one[0]." width=140 height=90/>";
						echo "<img src=".$all_val->hum->two[0]." width=140 height=90/>";
						echo "<br>";
					}			
				?>');
				});
		
			});
		//////////////////////////////////////////////////////sunday/////////////////////////////////////////	
		$("#search_sun").click(function(){
				
		});
		/////////////////////////////////////////////////////monday//////////////////////////////////////////
		$("#search_mon").click(function(){
		
		});
		///////////////////////////////////////////////////Tuesday//////////////////////////////////////////////
		$("#search_tue").click(function(){
			
		});	
		///////////////////////////////////////////////////Wednesday//////////////////////////////////////////////
		$("#search_wed").click(function(){
							
		});
		///////////////////////////////////////////////////Thursday//////////////////////////////////////////////
		$("#search_thu").click(function(){
				
		});
		///////////////////////////////////////////////////Friday//////////////////////////////////////////////
		$("#search_fri").click(function(){
				
		});
		////////////////////////////////////////////////////Saturday/////////////////////////////////////////	
		$("#search_sat").click(function(){
		
		});
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
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
				<td width="190px" id="search_all_week"><a  href="#">All Week</a></td><td id="search_sun"><a  href="#" >Sunday</a></td>
				<td id="search_mon"><a  href="#">Monday</a></td><td id="search_tue"><a  href="#">Tuesday</a></td><td id="search_wed"><a  href="#">Wednesday</a></td>
				<td id="search_thu"><a  href="#">Thursday</a></td><td id="search_fri"><a  href="#">Friday</a></td><td id="search_sat"><a  href="#">Saturday</a></td>
			</tr>
		</table>
		<div id="channel_tabs">
				<ul>
					<li><a href="#tabs-1">All Channels</a></li>
					<li><a href="#tabs-2"><img src="<?php echo base_url()."application/images/icons/hum_icon.jpeg"?>" width="30px" height="16px"/>Hum </a></li>
					<li><a href="#tabs-3"><img src="<?php echo base_url()."application/images/icons/geo_icon.jpeg"?>" width="30px" height="16px"/>GEO</a></li>
					<li><a href="#tabs-4"><img src="<?php echo base_url()."application/images/icons/ary_icon.jpeg"?>" width="30px" height="16px"/>ARY</a></li>
					<li><a href="#tabs-5"><img src="<?php echo base_url()."application/images/icons/atv_icon.jpeg"?>" width="30px" height="16px"/>ATV</a></li>
					<li><a href="#tabs-6"><img src="<?php echo base_url()."application/images/icons/ptv_icon.jpeg"?>" width="30px" height="16px"/>PTV</a></li>
				</ul>
				<div id="tabs-1">
					<div id="all_dramas">
					<?php
					foreach ($val as $key=>$all_val) {
						echo "<img src=".$all_val->hum->one[0]." width=140 height=90/>";
						echo "<img src=".$all_val->geo->one[0]." width=140 height=90/>";
						echo "<img src=".$all_val->ary->one[0]." width=140 height=90/>";
						echo "<img src=".$all_val->atv->one[0]." width=140 height=90/>";
						echo "<img src=".$all_val->ptv->one[0]." width=140 height=90/>";
						echo "<img src=".$all_val->hum->two[0]." width=140 height=90/>";
						echo "<img src=".$all_val->geo->two[0]." width=140 height=90/>";
						echo "<img src=".$all_val->ary->two[0]." width=140 height=90/>";
						echo "<img src=".$all_val->ptv->two[0]." width=140 height=90/>";
						echo "<br>";
					}
					?>
					</div>
				</div>
				<div id="tabs-2">
					<div id="hum_dramas">
					</div>
				</div>
				<div id="tabs-3">
					<div id="geo_dramas">
					</div>
				</div>
				<div id="tabs-4">
					<div id="ary_dramas">
					</div>
				</div>
				<div id="tabs-5">
					<div id="atv_dramas">
					
					</div>
				</div>
				<div id="tabs-6">
					<div id="ptv_dramas">
					</div>
				</div>
		</div>
	<br>
	</div>

	
	
	
	
	<!-- ----------------------------------------Tab 2 --------------------------------------------- -->
	
	
	
	
	
	<div id="tabs-2">
	<table width="100%"  border="0" align="center" cellpadding="3" cellspacing="0" >
		<tr bgcolor="#CCCCCC">
			<td ><a  href="#">All</a></td>
			<td ><?php 
				for ($i=65; $i<=90; $i++) {
				$x = chr($i);
				echo "<a href=#>".$x."</a> ";
				}
				?>
			</td>
		</tr>
	</table>
	<br>
    <table width="100%"  border="0" align="center" cellpadding="3" cellspacing="0" >
    </table>
	</div>
    
	
	
	<!-- ----------------------------------------Tab 3 --------------------------------------------- -->
	
	
    
	<div id="tabs-3">
	<table width="100%"  border="0" align="center" cellpadding="3" cellspacing="0" >

    </table>
	</div>
    
</div>

</div>


	</div>

	
</div>

</body>
</html>