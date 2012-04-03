<?php 
$srchTxt = $this->session->userdata('searchText');
$order = $this->uri->segment(3);
$orderType = $this->uri->segment(4);
$page = $this->uri->segment(5);
if($order == "")
{
	$order == "ad";
	echo 'null';
}
if($orderType == "")
{
	$orderType = "d";
		echo 'null';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Song Library</title>
<script language="javascript" src="<?php echo base_url()."application/js/jquery.js"?>"></script>
<script language="javascript" src="<?php echo base_url()."application/js/facebox/facebox.js"?>"></script>
<script language="javascript" src="<?php echo base_url()."application/js/common.js"?>"></script>
<script language="javascript">
var SongID;
var col;
function markRating(rating,song)
{
	document.getElementById("ajax_image").style.display="block";
	jQuery.post("<?php echo base_url();?>ajaxC/",{rating:rating,song:song,f:'markRating'},_makeRating);
}

function delSong(songId)
{
	document.getElementById("ajax_image").style.display="block";
	//jQuery.post("<?php echo base_url();?>ajaxC/",{songId:songId,f:'delSong'},_delSong);
			jQuery.post("<?php echo base_url();?>library/showAjaxLib",{songId:songId,type:'delSong'},_showAjaxLib);
}

function getTable(Order,Ordertype,Page)
{
		col=Order;
		document.getElementById("ajax_image").style.display="block";
		var SearchTxt = jQuery('#search').val();
		var ClearSrch = jQuery('#clearSrch').val();
		jQuery.post("<?php echo base_url();?>library/showAjaxLib",{order:Order,ordertype:Ordertype,page:Page,searchTxt:SearchTxt,clearSrch:ClearSrch,type:'ajax'},_showAjaxLib);
}

function _getTable(response)
{
	var res = response.split("##");
	if(res[0] == "SUC")
	jQuery('#lib-tbl').html(res[1]);
	document.getElementById("ajax_image").style.display="none";
}

function _delSong(response)
{
	$("#row_"+SongID).remove();
	document.getElementById("ajax_image").style.display="none";
	
	/*var myTbl = document.getElementById('maintable');
	var rows = myTbl.rows;
	for(i=0;i<rows.length;i++)
	{
		alert(rows[i].id);
		//row[i].childNodes[(int) index of child node].id = your new id;
	}*/
	//alert(response);
	//document.getElementById("showprogress_"+SongID)
	}

jQuery(document).ready(function($) {
	
  $('a[rel*=facebox]').facebox();
 // document.getElementById("ajax_image").style.backgroundImage="none";	  
  showAjaxLib('<?php echo $order;?>','<?php echo $orderType;?>',<?php echo ($page != "" ? $page : 1);?>);
}) ;
function showAjaxLib(order,orderType,page)
{
	var searchTxt = jQuery('#search').val();
	var clearSrch = jQuery('#clearSrch').val();
	$.post('<?php echo base_url();?>library/showAjaxLib/'+order+'/'+orderType+'/'+page+'',{searchTxt:searchTxt,clearSrch:clearSrch},_showAjaxLib);
}
function _showAjaxLib(response)
{
	var res = response.split("##");
	if(res[0] == "SUC")
	jQuery('#lib-tbl').html(res[1]);
	document.getElementById("ajax_image").style.display="none";
}
</script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url()."application/js/facebox/facebox.css"?>" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url()."application/js/jquery.tablesorter.css"?>" />
</head>
<body>

	<table width="100%" cellpadding="0" cellspacing="" align="center" class="libsong">
		<?php $this->load->view('header');?>
		<tr>
			<td>
				<h1>Song Library!</h1>
				<input type="button" name="launchApp" value="New Song"/>
				<input type="hidden" name="clearSrch" id="clearSrch" value="N" />
				<br />
				<br />
				<div>
					<div style="height:24px;width:24px;position:absolute;margin-top:40px;margin-left:20px;"><img id="ajax_image" src="<?php echo base_url()."application/css/ajax-loader.gif"?>" /></div>
					<table id="lib-tbl"></table>
				</div>
			</td>
		</tr>
	</table>

<!--
<object id="player" type="audio/mpeg" data="<?php echo base_url()?>upload/Rashid/ms.mp3" width="288" height="69">

<param name="src" value="<?php echo base_url()?>upload/Rashid/ms.mp3" />
</object> 
    <object width="300" height="42">
    <param name="src" value="gtr.mp3">
    <param name="autoplay" value="true">
    <param name="controller" value="true">
    <param name="bgcolor" value="#FF9900">
    <embed src="<?php echo base_url()?>upload/Rashid/ms.mp3" autostart="false" loop="false" width="300" height="42" controller="true" bgcolor="#FF9900"></embed>
    </object>

-->
</body>
</html>