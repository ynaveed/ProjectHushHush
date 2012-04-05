<?php
	$this->load->view('header1');
	//$json_val=$jdays;
?>
<script type='text/javascript' src='<?php echo base_url(); //$_SERVER['SERVER_NAME'];?>application/js/jlinq.js'></script>
<script type="text/javascript">

	var global_ajax_object = '';
    var all_channels = eval(<?php echo $channels; ?>);
	var all_dramas = eval(<?php echo $all_dramas; ?>);;
	var populate_week = eval(<?php echo $this_week;?>);
	var current_list_episodes = '';
	var day_dates = eval(<?php echo $day_dates;?>);
	var serv_day = "<?php echo $day_at_server;?>";
	var ordered_dates = eval(<?php echo $ordered_dates ;?>);
	var week='allweek';
	var channel='allchannel';

	var daySel;
	var channelSel;
	var curTab = 'thisweekfilter';
	var firstTabHTML = '';
	var current_filter_alphabet = 'all_';
	var prev_filter_alphabet = '';
	var days_enum = new Array();
	days_enum['sun'] = "Sunday";
	days_enum['mon'] = "Monday";
	days_enum['tue'] = "Tuesday";
	days_enum['wed'] = "Wednesday";
	days_enum['thu'] = "Thursday";
	days_enum['fri'] = "Friday";
	days_enum['sat'] = "Saturday";

	
	function populate_day_filter(){			
		var i = 1;
		var day_filter = '<li><a  href="javascript:void(null);" class="weekselected" id="allweek" onClick="change_week(\'allweek\', this)" >All Week</a></li>';
		for(i=1;i<8;i++){
			var temp_date = ordered_dates[i];

			day_filter += '<li><a href="javascript:void(null);" id="'+day_dates[temp_date]+'" onClick="change_week(\''+day_dates[temp_date]+'\',this)">'+days_enum[day_dates[temp_date]]+'</a></li>';
		}				
		$('#thisweekfilter').html(day_filter);
	}

	function populate_channels(){
		var channel_options = '<option value="allchannel">All Channels</option>';
		$.each(all_channels, function(index,obj){
			channel_options += '<option value="'+obj.name+'">'+obj.description+'</option>';
		});
		$('#channelcombo').html(channel_options);
	}
	
	function alphabet_filter(alphabet){
		if(current_filter_alphabet == alphabet.id){
			return false;
		}
		$('#'+current_filter_alphabet).removeClass('weekselected');
		$('#'+alphabet.id).addClass('weekselected');
		
		current_filter_alphabet = alphabet.id;
		
		loadAllDramas('');
	}
	function change_week(param_week, ele){
		week = param_week;
		if(week!='allweek')
			$("#allweek").removeClass('weekselected');
		if(typeof daySel == 'object')
			daySel.className = '';
		ele.className = 'weekselected';
		daySel = ele;
		loadFirstTabHTML();
	}
	
	function change_channel(ele){
	   channel = $(ele).val();
	   if(curTab == 'phhfilter' || curTab == 'popularfilter'){
	   	return false;
	   }
	   if(curTab == 'alldramafilter'){
			loadAllDramas(channel);
			return false;
		}
		channelSel = ele;
		loadFirstTabHTML();
	}
	function populate_modal_episodes(drama_id){

		global_ajax_object = $.ajax({
			type : 'POST',
			url : "<?php echo site_url('index.php/welcome/get_all_episodes'); ?>",
			data: {
				drama_id : drama_id
			},
			success : function(recenlydata){

				var json_episodes = eval(recenlydata);
				current_list_episodes = json_episodes;
                var episodes_html = '';
                       
                $.each(json_episodes, function(i,obj){
                	var obj_syn = obj.synopsis;
                	if(obj.synopsis.length > 30){
                		obj_syn = obj_syn.substr(0,30);
                		obj_syn += "...";
                	}
                	console.log(obj_syn);
                	episodes_html += '<a href="javascript:void(0);"" id="'+obj.id+'" onClick="load_episode(\''+obj.id+'\');"><div class="vidboxin" style="width:150px;">';
                	episodes_html += '<div style="width: 150px;background-image: url(\''+obj.thumbnail+'\');"> <hr/><h1 class="t">'+obj.name+'</h1>'; //\''+obj.thumbnail+'\'\'<?php echo $thumbnail;?>\'
                	episodes_html += '<p>'+obj_syn+'</p>';
                	episodes_html += '</div></div></a>';
                });
				$('#vidrel').html(episodes_html);
				$("#vidrel").scrollbars();
				var scrollbutton = '<img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/scrolbtn.gif"/>';
				$(".scrollbtn").html(scrollbutton);
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				//alert("error: "+errorThrown);
			}
		});
	}
	function load_episode(obj_id){
		var episode_object = jlinq.from(current_list_episodes).ignoreCase().starts("id",obj_id).select();
		$('#modal_logo').attr('src','<?php echo $logo;?>'); //episode_object[0].channel_thumbnail
		$('#modal_title').html(episode_object[0].drama_name+' '+'<span>EP '+episode_object[0].episode_number+'</span>');
		$('#modal_synopsis').html('<p>'+episode_object[0].synopsis+'</p>');
		$('#modal_video_container').html('');
		$('#modal_video_container').block({
												css: { 
											            border: 'none', 
											            padding: '15px', 
											            backgroundColor: '#000', 
											            '-webkit-border-radius': '10px', 
											            '-moz-border-radius': '10px', 
											            opacity: .7, 
											            color: '#fff',
											            textAlign:      'center',
											            top: '44% !important',
											            left: '33% !important'
											        }

			});
		global_ajax_object = $.ajax({
			type : 'POST',
			url : "<?php echo site_url('index.php/welcome/get_videoplayer'); ?>",
			data: {
				video_url : episode_object[0].player_link
			},
			success : function(recenlydata){
				$('#modal_video_container').unblock();
				$('#modal_video_container').html(recenlydata);
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				//alert("error: "+errorThrown);
			}
		});
	}
	function thumbnailHTML(drama){
		var desc = drama.synopsis;
		desc = desc.substr(0,55); //'+drama.drama_thumbnail+' '+drama.channel_thumbnail+'
		if(drama.synopsis.length>55)
			desc += '...';
		return '<a class="videoplayerlink" href="javascript:void(0);"'+
			' onclick="countWatch(\''+drama.id+'\',this,1)" >'+
			'<div class="vidboxin floatleft" id="vidcontainer-'+drama.id+'">'+
			'<div style="background-image:url(\''+drama.thumbnail+'\')"><span class="chlogo">'+
			'<img src="<?php echo $logo; ?>"'+
			'width="16" height="31" alt="" /></span>'+
			'<hr /><h1>'+drama.name+'</h1><p class="vidinf">Air Date: '+drama.date.substr(0,10)+'</p><p>'+desc+'</p></div></div></a>';
	}
    function thumbnailHTML_clips(drama){
		var one_two_line = 1;
		var no_of_char_in_desc = 120;
		if(drama.name.length > 14){
			one_two_line = 2;
		}
		if(one_two_line != 1){
			no_of_char_in_desc = 80;
		}
		var desc = drama.synopsis; //'+drama.thumbnail+' '+drama.channel_thumbnail+'
		desc = desc.substr(0,no_of_char_in_desc);
		if(drama.synopsis.length>no_of_char_in_desc)
			desc += '...';
		return '<a class="videoplayerlink" href="javascript:;"'+
			' onclick="countWatch(\''+drama.id+'\',this,0)" >'+
			'<div class="vidboxin floatleft" id="vidcontainer-'+drama.id+'">'+
			'<div style="background-image:url(\''+drama.thumbnail+'\')"><span class="chlogo">'+
			'<img src="<?php echo $logo; ?>"'+
			'width="16" height="31" alt="" /></span>'+
			'<hr /><h1>'+drama.name+' <span>('+drama.episode_count+')</span></h1><p class="vidinf">'+desc+'</p></div></div></a>'; //<p>'+drama.synopsis+'</p>
	}
    function thumbnailHTML_dramas(drama){
		var desc = drama['desc'].substr(0,55);
		if(drama['desc'].length>55)
			desc += '...';
		return '<a class="videoplayerlink" href="javascript:void(0);"'+
			' onclick="countWatch('+drama['id']+',this,1)" >'+
			'<div class="vidboxin floatleft" id="vidcontainer-'+drama['id']+'">'+
			'<div style="background-image:url('+drama['thumb']+')"><span class="chlogo">'+
			'<img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/logo-thumb.jpg"'+
			'width="16" height="31" alt="" /></span>'+
			'<hr /><h1>'+drama['title']+'</h1><p class="vidinf">'+desc+'</p><p> Just adding for the time being, it is in the script</p></div></div></a>';
	}
	function add_to_fav(fav_video){
		var angle = 0;
		var rotate_id = setInterval(function(){
		      angle+=10;
		     $("#spinning_heart").rotate(angle);
		},10);
		global_ajax_object = $.ajax({
			type : 'POST',
			url : "<?php echo site_url('index.php/welcome/save_favourites'); ?>",
			data: {
				video_id : fav_video
			},
			success : function(recenlydata){
				
				if(recenlydata == 'success'){
					setTimeout('made_fav('+rotate_id+')',500);
					return true;
				}else if(recenlydata = 'already_saved'){
					setTimeout('made_fav('+rotate_id+')',500);
					return false;
				}else if(recenlydata = 'bad_request'){
					return false;
				}else if(recenlydata = 'already_added'){
					
					return false;

				}
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert("error: "+errorThrown);
			}
		});
	}
	function made_fav(rot_id){
		clearInterval(rot_id);
		var fav_item = '<img src="<?php echo base_url();?>application/images/heart.png" width="20" height="17" alt="" />&nbsp; Favorited';
		$('#click_to_fav').html(fav_item);
	}
	function applyAnimation(dramaCount,HTML){
		var curHeight = $("#vidcontainerOuter").height();
		
		var rows = dramaCount/4;
		var rows = parseInt(rows);
		if(dramaCount%4>0)
			rows+=1;
		var newheight = rows*263;
		
		var animateTime = 900;
		var diff = newheight - curHeight;
		if(diff<0)
			diff = diff*(-1);
		
		if(diff<=20){
			animateTime = 100;
		}
		
		$("#vidcontainerdiv").fadeOut(300,function(){
			$("#vidcontainerdiv").html('');
			$("#vidcontainerOuter").animate({
					height: newheight,
				},
				300 ,
				function() {
						$("#vidcontainerOuter").css('height',newheight);
							$("#vidcontainerdiv").html(HTML);
							$("#vidcontainerdiv").fadeIn("slow",function(){});
				});
		});
	}
	
	function closeColorbox(){
		$('.videoplayerlink').colorbox.close();
		 if(global_ajax_object && global_ajax_object.readyState != 4){
            global_ajax_object.abort();
        }
        $('#modal_video_container').html('');
	}
	var lastOpenedPlayer='';
	var lastOpenedVideo='';
	var PLAYER_ANIMATION = false;
	var MAIN_TAB_ANIMATION = false;
	var SEARCH_RESULTS_OPENED = false;
	
	function update_modal_window(vid,populate){
		//$('.videoplayerlink').block({message:null});
		var vid_object = jlinq.from(populate_week).ignoreCase().starts("id",vid).select();
		$('#modal_logo').attr('src','<?php echo $logo; ?>'); //vid_object[0].channel_thumbnail
		$('#modal_title').html(vid_object[0].drama_name+' '+'<span>EP '+vid_object[0].episode_number+'</span>');
		//$('#modal_video_container').html('<iframe src="'+vid_object[0].player_link+'" width="100%" height="102%" style="border:none; overflow:hidden !important;" scrolling="no"></iframe>');
		$('#modal_synopsis').html('<p>'+vid_object[0].synopsis+'</p>');
		if(populate){
			populate_modal_episodes(vid_object[0].drama_id);
		}
		var fav_item = '<a href="javascript:///noo" onclick="add_to_fav(\''+vid+'\')"><img id="spinning_heart" src="<?php echo base_url();?>application/images/heart.png" width="20" height="17" alt="" />&nbsp; Add this Show To Favorites</a>';
		$('#click_to_fav').html(fav_item);
		$('#modal_video_container').html('');
		$('#modal_video_container').block({
												css: { 
											            border: 'none', 
											            padding: '15px', 
											            backgroundColor: '#000', 
											            '-webkit-border-radius': '10px', 
											            '-moz-border-radius': '10px', 
											            opacity: .7, 
											            color: '#fff',
											            textAlign:      'center',
											            top: '44% !important',
											            left: '33% !important',
											        }

			});
		global_ajax_object = $.ajax({
			type : 'POST',
			url : "<?php echo site_url('index.php/welcome/get_videoplayer'); ?>",
			data: {
				video_url : encodeURI(vid_object[0].player_link)
			},
			success : function(recenlydata){
				$('#modal_video_container').unblock();
				$('#modal_video_container').html(recenlydata);
				return true;
				//$('#colorbox').unblock();
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				//alert("error: "+errorThrown);
				//$('#colorbox').unblock();
				return true;
			}
		});
		

	}
	function update_modal_window_drama(vid,populate){
		///$('.videoplayerlink').block({message:null});
		var spinner_div = '<div style="position:relative; top:50%; left:40%;"><img src="<?php echo base_url(); ?>application/css/images/pleaseWaitImage.gif"></div>';
		$('#vidrel').html(spinner_div);//block({message: null, overlayCSS: { backgroundColor: '#000', top:'-17px'},css:{ opacity:0.8}});
		$.ajax({
			url: "<?php echo site_url('index.php/welcome/get_all_episodes'); ?>",
			data: {
				drama_id: vid
			},
			type:'POST',
			success: function(recenlydata){
				vid_object = eval(recenlydata);
				$('#modal_logo').attr('src','<?php echo $logo; ?>'); //vid_object[0].channel_thumbnail
				$('#modal_title').html(vid_object[0].drama_name+' '+'<span>EP '+vid_object[0].episode_number+'</span>');
				//$('#modal_video_container').html('<iframe src="'+vid_object[0].player_link+'" width="100%" height="102%" style="border:none; overflow:hidden !important;" scrolling="no"></iframe>');
				$('#modal_synopsis').html('<p>'+vid_object[0].synopsis+'</p>');
				var fav_item = '<a href="javascript:///noo" onclick="add_to_fav(\''+vid_object[0].id+'\')"><img id="spinning_heart" src="<?php echo base_url();?>application/images/heart.png" width="20" height="17" alt="" />&nbsp; Add this Show To Favorites</a>';
				$('#click_to_fav').html(fav_item);
				if(populate){
					var json_episodes = vid_object;
					current_list_episodes = json_episodes; //'+obj.thumbnail+'
	                var episodes_html = '';  
	                $.each(json_episodes, function(i,obj){
	                	var obj_syn = obj.synopsis;
	                	if(obj.synopsis.length > 80){
	                		obj_syn = obj_syn.substr(0,80);
	                		obj_syn += "...";
	                	}
	                	episodes_html += '<a href="javascript:void(0);"" id="'+obj.id+'" onClick="load_episode(\''+obj.id+'\');"><div class="vidboxin" style="width:150px;">';
	                	episodes_html += '<div style="width: 150px;background-image: url(\''+obj.thumbnail+'\');"> <hr/><h1 class="t">'+obj.name+'</h1>';
	                	episodes_html += '<p>'+obj_syn+'</p>';
	                	episodes_html += '</div></div></a>';
	                });
					$('#vidrel').html(episodes_html);
					$('#vidrel').unblock();
					$("#vidrel").scrollbars();
					var scrollbutton = '<img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/scrolbtn.gif"/>';
					$(".scrollbtn").html(scrollbutton);
					//$('#colorbox').unblock();
				}
				$('#modal_video_container').html('');
				$('#modal_video_container').block({
													css: { 
											            border: 'none', 
											            padding: '15px', 
											            backgroundColor: '#000', 
											            '-webkit-border-radius': '10px', 
											            '-moz-border-radius': '10px', 
											            opacity: .7, 
											            color: '#fff',
											            textAlign:      'center',
											            top: '44% !important',
											            left: '33% !important'
											        }
		        });
				global_ajax_object = $.ajax({
					type : 'POST',
					url : "<?php echo site_url('index.php/welcome/get_videoplayer'); ?>",
					data: {
						video_url : encodeURI(vid_object[0].player_link)
					},
					success : function(recenlydata){
						
						$('#modal_video_container').unblock();
						$('#modal_video_container').html(recenlydata);
						return true;
						//$('#colorbox').unblock();
					},
					error : function(XMLHttpRequest, textStatus, errorThrown) {
						//alert("error: "+errorThrown);
						//$('#colorbox').unblock();
						return true;
					}
		});

			}
		});
	}
	function countWatch(vid,obj,is_vid){
		alert("hello");
		if(is_vid == 1){
			if(update_modal_window(vid,true)){
				alert("hello1");
				the_color_box(vid,obj,is_vid);
			}
		}else if(update_modal_window_drama(vid,true)){
			alert("hello3");
				the_color_box(vid,obj,is_vid);
		}
		
		
	}
	function the_color_box(vid,obj,is_vid){
		jQuery(".videoplayerlink").colorbox({
			transition: 'fade',
			inline:true, 
			href:"#videoboxin",
			initialWidth:"75%",
			initialHeight:"50%",
			//width:"70%",
			//height:"50%",
			speed:500,
			opacity:0.85,
			fixed:false, // make this true
			open:false
		});
		var vidcontainer = '#vidcontainer-';
		var videoplayer = '#videoplayer-';
		//$('#colorbox').block({message:null});
		global_ajax_object = $.ajax({
			type : 'POST',
			url : "<?php echo site_url('index.php/welcome/count_watch_video'); ?>",
			data: {
				video_id : vid
			},
			success : function(recenlydata){
				if(recenlydata == 'success'){
					return true;
				}else if(recenlydata = 'wrong'){
					return false;
				}else if(recenlydata = 'bad_request'){
					return false;
				}
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				//alert("error: "+errorThrown);
			}
		});
		if(lastOpenedVideo!='' && lastOpenedVideo!=(vidcontainer+vid)){
			$(lastOpenedVideo).removeClass("openedinplayer");
		}
		lastOpenedVideo = vidcontainer+vid;
		return false;
	}
	function get_recently_watched(){
		$("#favoritestab").removeClass('weekselected');
		$("#recentlytab").addClass('weekselected');
		global_ajax_object = $.ajax({
			type : 'POST',
			url : "<?php echo site_url('index.php/welcome/get_recently_watched'); ?>",
			data: {},
			success : function(recenlydata){
				console.log(recenlydata);
				if(recenlydata == 'no_data'){
					applyAnimation(4,'<div><h1>You have not watched any videos recently</h1></div>');
					return false;
				}
				var recent = eval(recenlydata);
				var recentlyhtml='';
				var dramaCount = 0;
				var playerCount = 0;
				$.each(recent,function(i,drama){
						recentlyhtml += thumbnailHTML(drama);
						dramaCount++;
				});
				applyAnimation(dramaCount,recentlyhtml);
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert("error: "+errorThrown);
			}
		});
		return false;
	}
	
	function get_favourites(){
		$("#favoritestab").addClass('weekselected');
		$("#recentlytab").removeClass('weekselected');
		global_ajax_object = $.ajax({
			type : 'POST',
			url : '<?php echo site_url('index.php/welcome/get_favourites'); ?>',
			data: {
			},
			success : function(favoritedata){
				if(favoritedata == 'no_data'){
					applyAnimation(4,'<div><h1>You have not favorited any video</h1></div>');
					return false;
				}
				var recent = eval(favoritedata);
				var recentlyhtml='';
				var dramaCount = 0;
				var playerCount = 0;
				$.each(recent,function(i,drama){
						recentlyhtml += thumbnailHTML(drama);
						dramaCount++;
				});
				applyAnimation(dramaCount,recentlyhtml);
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert("error: "+errorThrown);
			}
		});

		return false;
	}
	
	function add_divider(day){
		day_names = new Array();
		day_names['mon'] = "Monday";
		day_names['tue'] = "Tuesday";
		day_names['wed'] = "Wednesday";
		day_names['thu'] = "Thursday";
		day_names['fri'] = "Friday";
		day_names['sat'] = "Saturday";
		day_names['sun'] = "Sunday";
		
		var text = '<div class="dividr"><span>'+day_names[day]+'</span></div>';
		return text;
    }
		
	function loadFirstTabHTML(){
		$('#channelcombo').val(channel);
		firstTabHTML='';
		var dramaCount = 0;
		var playerCount = 0;
        var curDay = '';
	/*	$.each(alldata,function(day,days_array){
			if(week == day || week == "allweek"){
				if(week == 'allweek'){
					if(curDay != day ){
						curDay = day;
						firstTabHTML += add_divider(day);
					}
				}
				$.each(days_array,function(j,channels_array){
					if(channel == j || channel == "allchannel"){
						$.each(channels_array,function(k,drama){
							firstTabHTML += thumbnailHTML(drama);
							dramaCount++;
						});
					}
				});
			}
		});
*/
		var all_episodes_json = populate_week;

		if(week == 'allweek' && channel == 'allchannel'){
			$.each(day_dates,function(iter,value){
				var count_drama_on_date = jlinq.from(populate_week).ignoreCase().starts("date",iter).count();
				if(count_drama_on_date > 0){
					firstTabHTML += add_divider(value);
				}
				var dramas_of_day = jlinq.from(populate_week).ignoreCase().starts("date",iter).select();
				if(!jQuery.isEmptyObject(dramas_of_day)){
					dramaCount = 0;
					$.each(dramas_of_day,function(inner_iter,inner_value){
						firstTabHTML += thumbnailHTML(inner_value);
						dramaCount ++;	
					});
				}
			});
		}else if(week != 'allweek' && channel == 'allchannel'){
			var date_on_this_day ='';
			$.each(day_dates, function(iter_date,value_date){
				if(week == value_date){
					date_on_this_day = iter_date;
					return false; // it breaks from $.each loop
				}
			});
			firstTabHTML = '';
			var dramas_of_day = jlinq.from(populate_week).ignoreCase().starts("date",date_on_this_day).select();
			dramaCount = 0;
			$.each(dramas_of_day,function(inner_iter,inner_value){
				firstTabHTML += thumbnailHTML(inner_value);
				dramaCount ++;	
			});
		}else if(week == 'allweek' && channel != 'allchannel'){
			firstTabHTML = '';
			$.each(day_dates,function(iter,value){
				var count_drama_on_date = jlinq.from(populate_week).ignoreCase().starts("date",iter).count();
				if(count_drama_on_date > 0){
					firstTabHTML += add_divider(value);
				}
				var dramas_of_day = jlinq.from(populate_week).ignoreCase().starts("date",iter).and("channel_name",channel).select();
				if(!jQuery.isEmptyObject(dramas_of_day)){
					dramaCount = 0;
					$.each(dramas_of_day,function(inner_iter,inner_value){
						firstTabHTML += thumbnailHTML(inner_value);
						dramaCount ++;	
					});
				}
			});
		}else if(week != 'allweek' && channel != 'allchannel'){
			var date_on_this_day ='';
			$.each(day_dates, function(iter_date,value_date){
				if(week == value_date){
					date_on_this_day = iter_date;
					return false; // it breaks from $.each loop
				}
			});
			firstTabHTML = '';
			var dramas_of_day = jlinq.from(populate_week).ignoreCase().starts("date",date_on_this_day).and("channel_name",channel).select();
			dramaCount = 0;
			$.each(dramas_of_day,function(inner_iter,inner_value){
				firstTabHTML += thumbnailHTML(inner_value);
				dramaCount ++;	
			});
		}
		if(firstTabHTML == ''){
			firstTabHTML = '';
		}
        applyAnimation(dramaCount,firstTabHTML);
		
	}
	
	function loadSearchResults(){
		if($("#autocomplete").val()!=''){
			$('.search_load').show();
			global_ajax_object = $.ajax({ url: "<?php echo site_url('index.php/welcome/get_search_results'); ?>",
				data: { keyword: $("#autocomplete").val()},
				type: "POST",
				success: function(searchresultdata){
						var searchresult = eval(searchresultdata);
						var searchresulthtml='<a href="javascript:void(null);" onclick="closeSearchResults()" style="position:absolute; top:13px; right:17px; display:block; width:50px; height:30px; color:#900; font-family:Georgia, Times, serif;"><img src="<?php echo base_url();?>application/images/close-btn.png"   /></a>';
						var dramaCount = 1;
						var playerCount = 0; //+drama['thumb']+
						if(!jQuery.isEmptyObject(searchresult)){
							$.each(searchresult,function(i,drama){

								searchresulthtml += thumbnailHTML_clips(drama);
								/*
								searchresulthtml += '<a class="videoplayerlink" href="javascript:void(0)" onclick="countWatch('+drama.id+','+(dramaCount-1)+','+1+',this)" >'+
								'<div class="vidboxin floatleft" id="s-vidcontainer-'+drama.id+'">'+
								'<div style="background-image:url(\'<?php echo $thumbnail;?>\')"><span class="chlogo">'+
								'<img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/logo-thumb.jpg"'+
								'width="16" height="31" alt="" /></span>'+
								'<hr /><h1>'+drama.name+'(Ep '+drama.episode_count+')</h1><p>'+drama.synopsis+'</p></div></div></a>';
								*/

								dramaCount++;
							});
						}else{
							searchresulthtml += '<div style="height:100px;"><h2 style="padding:38px;font-size:18px;">Sorry, no results were found</h2></div>';
						}
						
					$('.search_load').hide();
					var defaultSearchHiddenDivHTML = $("#searchresults").html();
					var animateTime = 300;
					var fadeInTime = 300;
					var fadeOutTime = 200;
					if(SEARCH_RESULTS_OPENED==true){
						animateTime = 300;
						fadeInTime = 300;
						fadeOutTime = 200;
						$("#searchcontent div#innercont div div div#searchvidcontainerdiv").fadeOut("fast", function(){
							$(this).html(searchresulthtml);
							$(this).fadeIn(fadeInTime,function(){
								SEARCH_RESULTS_OPENED = true;
								$("#searchcontent").css('height','auto')
								//jQuery('body').animate({scrollTop : $("#videoplayer-"+res).offset().top - 15},'slow');
							});
						});
					}
					else{
						$("#searchvidcontainerdiv").html(searchresulthtml);
						$("#searchcontent").animate({
							height: $("#searchresults").height()
							}, 
							animateTime ,
							function() {
								$(this).fadeOut(fadeOutTime, function(){
									var resultsHTML = $("#searchresults").html();
									$("#searchresults").html(defaultSearchHiddenDivHTML+'<div style="clear:both"></div>');
									$(this).html(resultsHTML);
									$(this).fadeIn(fadeInTime,function(){
										SEARCH_RESULTS_OPENED = true;
										$("#searchcontent").css('height','auto')
										//jQuery('body').animate({scrollTop : $("#videoplayer-"+res).offset().top - 15},'slow');
									});
								});
							}
						);
					}
					
				},
				error : function(XMLHttpRequest, textStatus, errorThrown) {
					$('.search_load').hide();
				}
			});
		}
	}
	
	function closeSearchResults(){
		SEARCH_RESULTS_OPENED = false;
		var closingheight = $("#searchcontent").height();
		$("#searchcontent").html('');
		$("#searchcontent").css('height',closingheight);
		$("#searchcontent").animate({
			height: 0,
			}, 
			500 ,
			function() {
				
			}
		);
		
	}
	function handleSliderChange(e, ui){
		var maxScroll = $("#content-scroll").attr("scrollWidth") - $("#content-scroll").width();
		$("#content-scroll").animate({scrollLeft: ui.value * (maxScroll / 100) }, 1000);
	}
	
	function handleSliderSlide(e, ui){
		var maxScroll = $("#content-scroll").attr("scrollWidth") - $("#content-scroll").width();
		$("#content-scroll").attr({scrollLeft: ui.value * (maxScroll / 100) });
	}
	
	function loadPopularClips(){  
            global_ajax_object = $.ajax({
			type : 'POST',
			url : '<?php echo site_url('index.php/welcome/popular_clips'); ?>',
			data: {
			},
			success : function(favoritedata){
				var favorite = eval(favoritedata);            
				var favoritehtml='';
				var dramaCount = 0;
				var playerCount = 0;
				$.each(favorite,function(i,drama){
					favoritehtml += thumbnailHTML_dramas(drama);
					dramaCount++;
				});
				applyAnimation(dramaCount,favoritehtml);
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert("error: "+errorThrown);
			}
		});
    }
	
	function loadAllDramas(chann){
		if(all_dramas == ''){
			$.blockUI({message:null});
			global_ajax_object = $.ajax({
				type : 'POST',
				url : '<?php echo site_url('index.php/welcome/drama_lists');?>',
				data: {},
				success : function(data_json){
					console.log(data_json);
					var list_of_dramas = eval(data_json);
					all_dramas = list_of_dramas;
					var drama_html='';
					var dramaCount = 0;
					var playerCount = 0;
					$.each(list_of_dramas,function(i,drama){
						drama_html += thumbnailHTML_clips(drama);
						dramaCount++;
					});
					$.unblockUI();
					applyAnimation(dramaCount,drama_html);
				},
				error : function(XMLHttpRequest, textStatus, errorThrown) {
					alert("error: "+errorThrown);
					$.unblockUI();
				}
			});
		}else{
			var drama_json = all_dramas;
			if(current_filter_alphabet != 'all_' && channel != 'allchannel'){
				var alpha = current_filter_alphabet[0];
				var drama_json = jlinq.from(drama_json).ignoreCase().starts("channel_name",channel).and('name',alpha).select();
			}else if(current_filter_alphabet == 'all_' && channel != 'allchannel'){
				var drama_json = jlinq.from(drama_json).ignoreCase().starts("channel_name",channel).select();
			}else if(current_filter_alphabet != 'all_' && channel == 'allchannel'){
				var alpha = current_filter_alphabet[0];
				var drama_json = jlinq.from(drama_json).ignoreCase().starts('name',alpha).select();
			}else{
				drama_json = all_dramas;
			}
			var drama_html = '';
			var dramaCount = 0;
			$.each(drama_json,function(i,drama){
				drama_html += thumbnailHTML_clips(drama);
				dramaCount++;
			});
			applyAnimation(dramaCount,drama_html);
		}
	   
	}
	
	var ENTER_PRESSED = false;
	$(document).ready(function(){		
		$(function() {
			/*$("#autocomplete").keyup(function(){
				delay(function(){
					$.ajax({
						url: "<?php echo site_url('index.php/welcome/suggest_tags'); ?>",
						data:{
							tag: $("#autocomplete").val()
						},
						type: "POST",
						success: function(data){
						}
					});

				},300);
		
			});*/
			$("#autocomplete" ).autocomplete({
				source: function(request, response) {
				global_ajax_object = $.ajax({ url: "<?php echo site_url('index.php/welcome/suggest_tags'); ?>",
					data: { tag: $("#autocomplete").val()},
					dataType: "json",
					type: "POST",
					success: function(data){
						response(data);
					}
					
				});
			},
			select: function(event, ui) { 
				loadSearchResults();
				//alert(1);
				
			},
			close: function(event, ui) {
				
			},
			minLength: 1,
			autoFocus: true,
			delay:300
			});
		});
		var delay = (function(){
		  var timer = 0;
		  return function(callback, ms){
		    clearTimeout (timer);
		    timer = setTimeout(callback, ms);
		  };
		})();
		/*$.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff',
            'font-size': '16px !important'
        }
        });*/
		loadFirstTabHTML();
		populate_channels();
		populate_day_filter();
		//$.unblockUI();
		$('.magnify-img').click(function(){
			loadSearchResults();
		});
		$('#autocomplete').keypress(function(e){
			if(e.which == 13){
				loadSearchResults();
			}
		});
		$("#vidrel").scrollbars();
		var scrollbutton = '<img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/scrolbtn.gif"/>';
		$(".scrollbtn").html(scrollbutton);
		$("#thisweektab").click(function(){
			if(MAIN_TAB_ANIMATION==false)
			{
				MAIN_TAB_ANIMATION = true;
				$(".tabber a").each(function(){
					if($(this).parent().parent().attr('id')=='maintabbar')
						$(this).removeClass("patternbg selected");
				});
				$("#"+curTab).hide('slide',{direction:'left'},function(){//fadeOut(400,function(){
					$("#thisweekfilter").show('slide',{direction:'right'});//fadeIn();
					$("#subfilterbar").fadeIn(function(){MAIN_TAB_ANIMATION = false;});
				});
				curTab = 'thisweekfilter';
				
				$("#thisweektab").addClass("patternbg selected");
				loadFirstTabHTML();
			}
		});

		$("#alldramatab").click(function(){
			if(MAIN_TAB_ANIMATION==false)
			{
				MAIN_TAB_ANIMATION = true;
				$(".tabber a").each(function(){
					if($(this).parent().parent().attr('id')=='maintabbar')
						$(this).removeClass("patternbg selected");
				});
				$("#"+curTab).hide('slide',{direction:'left'},function(){//fadeOut(400,function(){
					$("#alldramafilter").show('slide',{direction:'right'});//fadeIn();
					$("#subfilterbar").fadeIn("slow",function(){MAIN_TAB_ANIMATION = false;});
				});
				curTab = 'alldramafilter';
				$("#alldramatab").addClass("patternbg selected");
				loadAllDramas('');//loadFirstTabHTML();
			}
		});

		$("#popularcliptab").click(function(){
			if(MAIN_TAB_ANIMATION==false)
			{
				MAIN_TAB_ANIMATION = true;
				$(".tabber a").each(function(){
					if($(this).parent().parent().attr('id')=='maintabbar')
						$(this).removeClass("patternbg selected");
				});
				$("#"+curTab).hide('slide',{direction:'left'},function(){//.fadeOut(400,function(){
					$("#popularfilter").show('slide',{direction:'right'});//.fadeIn();
					//$("#subfilterbar").fadeOut("fast",function(){MAIN_TAB_ANIMATION = false;});
					MAIN_TAB_ANIMATION = false;
				});
				curTab = 'popularfilter';
				$("#popularcliptab").addClass("patternbg selected");
				loadPopularClips();//loadFirstTabHTML();
			}
		});
		
		$("#phh").click(function(){
			if(MAIN_TAB_ANIMATION==false)
			{
				MAIN_TAB_ANIMATION = true;
				$(".tabber a").each(function(){
					if($(this).parent().parent().attr('id')=='maintabbar')
						$(this).removeClass("patternbg selected");
				});
				$("#"+curTab).hide('slide',{direction:'left'},function(){//.fadeOut(400,function(){
					$("#phhfilter").show('slide',{direction:'right'});//.fadeIn();
					//$("#subfilterbar").fadeOut("fast",function(){MAIN_TAB_ANIMATION = false;});
					MAIN_TAB_ANIMATION = false;
				});
				curTab = 'phhfilter';
				$("#phh").addClass("patternbg selected");
				get_recently_watched();
			}
		});		
		
		
		$("#newphhactivitytab").click(function(){
			
			$("#newphhactivitytab").addClass("patternbg selected");
			$("#friendactivitytab").removeClass("patternbg selected");
			$("#newstab").removeClass("patternbg selected");
			$("#bottomconent").fadeOut("slow",function(){
				$("#bottomconent").fadeIn("slow",function(){
					jQuery('body').animate({scrollTop : $("#bottomconent").offset().top -  250},'slow');
					});
			});
		});
		
		$("#friendactivitytab").click(function(){
			
			$("#newphhactivitytab").removeClass("patternbg selected");
			$("#friendactivitytab").addClass("patternbg selected");
			$("#newstab").removeClass("patternbg selected");
			$("#bottomconent").fadeOut("slow",function(){
				$("#bottomconent").fadeIn("slow",function(){
					jQuery('body').animate({scrollTop : $("#bottomconent").offset().top -  250},'slow');
					});
			});
		});
		
		$("#newstab").click(function(){
			$("#newphhactivitytab").removeClass("patternbg selected");
			$("#friendactivitytab").removeClass("patternbg selected");
			$("#newstab").addClass("patternbg selected");
			$("#bottomconent").fadeOut("slow",function(){
				$("#bottomconent").fadeIn("slow",function(){
					jQuery('body').animate({scrollTop : $("#bottomconent").offset().top - 250},'slow');
					});
			});
		});	
	});
</script>

</head>
<body>
	<div class="wrap">
    	
        <!-- Header Starts -->
    <div class="clearfix" id="header">
        	<div class="floatleft">
            <a href="#"><img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/logo.png" width="225" height="54" alt="" /></a>
            </div>
            <div class=" floatright" id="topnav">
           	<a href="#" id="homenav">Home</a>
            <a href="#" id="faqnav">FAQs</a>
            <a href="#" id="settingsnav">Account Settings</a>
            <a href="<?php echo site_url('index.php/landing/logout/'); ?>" id="logoutnav">Logout</a>
            </div>
      </div>
        <!-- Header Ends -->
        
        <!-- Info box -->
        <div class="boxround patternbg clearfix" id="infobox">
        	<div class="floatleft infoleft">Welcome  Mr <?php echo $username;?> </div>
            <div class="floatleft">
            <img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/icon-clock.png"  alt="" /><span class="color1  ">&nbsp;3</span>/<span class="color2  ">6</span> hours left for your quota<br />
			 <img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/icon-refresh.png"  alt="" /><span class="color1  ">&nbsp;3</span> hours left till your quota refresh
            </div>
            <div class="floatleft  inforight">
            <img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/icon-dollar.png"  alt="" /><span class="color1">&nbsp;20</span> days untill your next bill date
            </div>
        </div>        
        <!-- Info box Ends -->
      
        <!-- Search Box -->
        <div id="searchbox" class="boxround">
        <div class="inputstyler">
        <img class="search_load" src="<?php echo base_url(); ?>application/css/images/spinner.gif">
       	<img class="magnify-img" src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/search.png">
        <input id="autocomplete" style="outline:none;" type="text" placeholder="Type Name of show you want to watch...." />
        </div>
        </div>
        
        <!-- Search Box Ends -->
        <!-- Content Starts -->
        <div id="searchresults" style="display:none; visibility:hidden" >
            <div>
                <ul class="tabber" id="searchtabbar">
                    <li><a href="javascript:void(null);" class="patternbg selected" id="searchresulttab">Search Results</a></li>
                </ul>
            </div>
            
            <div class="boxround" style="margin-bottom:20px !important;" id="innercont">
  				<div class="vidbx ">  
  					<div class="clearfix">  

			
					
					<!-- search video Seg -->
					<div id="searchvidcontainerdiv"></div>
					<!-- search Video Seg Ends -->
                    </div>
 					<div style="clear:both"></div>
                   	
                </div> 
            </div>
            <div style="clear:both"></div>
        </div>
        <div style="clear:both"></div>
        <div style="position:relative" id="searchcontent">
          
        </div>
        <div style="clear:both"></div>
        <div id="content">

        	<!-- Tabs Starts -->
            <div>
            
            	<ul class="tabber" id="maintabbar">
                	<li><a href="javascript:void(null);" class="patternbg selected" id="thisweektab">Episodes aired this week</a></li>
                    <li><a href="javascript:void(null);" id="alldramatab">All Dramas</a></li>
                    <li><a href="javascript:void(null);" id="popularcliptab">Popular Clips</a></li>
                    <li><a href="javascript:void(0);" id="phh">My PHH</a></li>
                </ul>
            </div>
            <!-- Tabs ends -->
         	<!-- Inner Content -->
<div class="boxround  " id="innercont">
            	
                <!-- Filter Bar -->
                <div class="patternbg boxround" id="filterbar">
                	<ul id="thisweekfilter">
                    	
                    </ul>
					<ul id="alldramafilter" style="display:none">
                        <li><a id="all_"  href="javascript:void(null);" class="weekselected" onclick="alphabet_filter(this);">All</a></li>
                    	<li><a id="a_" href="javascript:void(null);" onclick="alphabet_filter(this);" >A</a></li>
                        <li><a id="b_" href="javascript:void(null);" onclick="alphabet_filter(this);" >B</a></li>
                        <li><a id="c_" href="javascript:void(null);" onclick="alphabet_filter(this);" >C</a></li>
                        <li><a id="d_" href="javascript:void(null);" onclick="alphabet_filter(this);" >D</a></li>
                        <li><a id="e_" href="javascript:void(null);" onclick="alphabet_filter(this);" >E</a></li>
                        <li><a id="f_" href="javascript:void(null);" onclick="alphabet_filter(this);" >F</a></li>
                        <li><a id="g_" href="javascript:void(null);" onclick="alphabet_filter(this);" >G</a></li>
                        <li><a id="h_" href="javascript:void(null);" onclick="alphabet_filter(this);" >H</a></li>
                        <li><a id="i_" href="javascript:void(null);" onclick="alphabet_filter(this);" >I</a></li>
                        <li><a id="j_" href="javascript:void(null);" onclick="alphabet_filter(this);" >J</a></li>
                        <li><a id="k_" href="javascript:void(null);" onclick="alphabet_filter(this);" >K</a></li>
                        <li><a id="l_" href="javascript:void(null);" onclick="alphabet_filter(this);" >L</a></li>
                        <li><a id="m_" href="javascript:void(null);" onclick="alphabet_filter(this);" >M</a></li>
                        <li><a id="n_" href="javascript:void(null);" onclick="alphabet_filter(this);" >N</a></li>
                        <li><a id="o_" href="javascript:void(null);" onclick="alphabet_filter(this);" >O</a></li>
                        <li><a id="p_" href="javascript:void(null);" onclick="alphabet_filter(this);" >P</a></li>
                        <li><a id="q_" href="javascript:void(null);" onclick="alphabet_filter(this);" >Q</a></li>
                        <li><a id="r_" href="javascript:void(null);" onclick="alphabet_filter(this);" >R</a></li>
                        <li><a id="s_" href="javascript:void(null);" onclick="alphabet_filter(this);" >S</a></li>
                        <li><a id="t_" href="javascript:void(null);" onclick="alphabet_filter(this);" >T</a></li>
                        <li><a id="u_" href="javascript:void(null);" onclick="alphabet_filter(this);" >U</a></li>
                        <li><a id="v_" href="javascript:void(null);" onclick="alphabet_filter(this);" >V</a></li>
                        <li><a id="w_" href="javascript:void(null);" onclick="alphabet_filter(this);" >W</a></li>
                        <li><a id="x_" href="javascript:void(null);" onclick="alphabet_filter(this);" >X</a></li>
                        <li><a id="y_" href="javascript:void(null);" onclick="alphabet_filter(this);" >Y</a></li>
                        <li><a id="z_" href="javascript:void(null);" onclick="alphabet_filter(this);" >Z</a></li>
                    </ul>
					<ul id="popularfilter" style="display:none;">
                    	<li><a  class="fav" href="javascript:void(null);" >All time popular</a></li>
                        <li><a  class="fav-heart-7" href="javascript:void(null);">This week popular</a></li>
                        <li><a  class="fav-heart-30" href="javascript:void(null);">This month popular</a></li>
                    </ul>
					<ul id="phhfilter" style="display:none">
                    	<li><a class="rec weekselected" id="recentlytab" href="javascript:void(null);" onClick="get_recently_watched()"> Recently Watched</a></li>
                        <li><a class="fav" id="favoritestab" href="javascript:void(null);" onClick="get_favourites()">Favorites</a></li>
                    </ul>
                </div>
                <!-- Filter Bar ends -->
				
  				<div class="vidbx ">  
  					<div class="clearfix">  

					<div id="subfilter">
					<div id="subfilterbar" class="floatleft">
					<span>Channel: </span><span class="combobox ">
                    <select id="channelcombo" onChange="change_channel(this)">
                    	<option value="allchannel" selected="selected">All Channels</option>
                        <option value="hum">HUM</option>
                        <option value="geo">GEO</option>
                        <option value="ary">ARY</option>
                        <option value="atv">ATV</option>
                        <option value="ptv">PTV</option>
                    </select>
                    </span>
					</div>
					<div style="clear:both"></div>
					</div>
					
					<!-- video Seg -->
                                        <div id="vidcontainerOuter">
					<div id="vidcontainerdiv" style="display:none"></div>
                                        </div>
					<!-- Video Seg Ends -->
                    </div>
 					<div style="clear:both"></div>
                   <!--<div align="center">
               		 <span class="btnshowmore"><a href="#">Show More</a></span>
                  </div>	-->
				</div> 
            </div>
            
            <!-- Inner Content Ends -->
            
        	<!-- Tabs Starts -->
            <div>
            	<ul class="tabber">
                	<li><a href="javascript:void(null);" id="friendactivitytab" class="patternbg selected" >PHH Additions</a></li>
                </ul>
            </div>
            <!-- Tabs ends -->
         	<!-- Inner Content -->
<div class="boxround   "  id="feedbck">
            	
                <!-- Filter Bar -->
                <div class="patternbg boxround" id="filterbar">
                	 
                </div>
                <!-- Filter Bar ends -->
	  <div class="vidbx" id="bottomconent">        
  					
                    <div class="clearfix feedbxin">        
                			
<div class="clearfix feedxbox">
                            	<div class="floatleft userthumb">
                           	    <img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/user-thumb.jpg" width="105" height="105" alt="" />
                                </div>
                                <div class="floatleft feedtxt">
                                	<h1 class="color2"><a href="#">Geo Starting New Darama from <span class="color3">{Dec 20}</span></a></h1>
                                    <p>
                                    Before mutants had revealed themselves to the world, and before Charles Xavier and Erik Lehnsherr took the names Professor X and Magneto, they were two young men discovering their powers for the first time. Not archenemies, they were instead at first the closest of friends, working together with other Mutants. (some familiar, some new), to prevent nuclear Armageddon. In the process.
                                    </p>
                                </div>
                            </div>
                            
                            <div class="clearfix feedxbox">
                            	<div class="floatleft userthumb">
                           	    <img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/user-thumb.jpg" width="105" height="105" alt="" />
                                </div>
                                <div class="floatleft feedtxt">
                                	<h1 class="color2"><a href="#">Geo Starting New Darama from <span class="color3">{Dec 20}</span></a></h1>
                                    <p>
                                    Before mutants had revealed themselves to the world, and before Charles Xavier and Erik Lehnsherr took the names Professor X and Magneto, they were two young men discovering their powers for the first time. Not archenemies, they were instead at first the closest of friends, working together with other Mutants. (some familiar, some new), to prevent nuclear Armageddon. In the process.
                                    </p>
                                </div>
                            </div>
                            
                            
                            
          </div>
               		 
</div> 
    
        </div>
            
            
        </div>
        
        <!-- Content Ends -->
       
         
    </div>
     <!-- Footer Starts -->
     <div class=" footer" id="footerarea">
    	 <div class="footercloud">
         	 <div class="wrap clearfix">
             	 <div class="floatleft ftlogo">
                 	<a href="#"><img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/footerlogo.gif" width="230" height="50" alt="" /></a>
                 </div>
                 <div class="floatleft">
                 <h4>About PHH</h4>
                 <ul>
                 	<li><a href="#">About</a></li>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">Team</a></li>
                    <li><a href="#">Press</a></li>
                 </ul>
                 </div>
                 <div class="floatleft">
                 <h4>Legal</h4>
                 <ul>
                 	<li><a href="#">Terms</a></li>
                    <li><a href="#">Privacy</a></li>
                    
                 </ul>
                 </div>
                 <div class="floatleft">
                 <h4>Partner Page</h4>
                 <ul>
                 	<li><a href="#">ARY</a></li>
                    <li><a href="#">GEO</a></li>
                    <li><a href="#">HUM</a></li>
                    <li><a href="#">ATV</a></li>
                    <li><a href="#">PT</a></li>
                 </ul>
                 </div>
               <div class="floatleft">
                 <h4>Follow Us</h4>
                 <ul>
                 	<li><a href="#"><img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/icon-fb.png" width="36" height="34" alt="" /></a></li>
                    <li><a href="#"><img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/icon-tw.png" width="36" height="34" alt="" /></a></li>
                    <li><a href="#"><img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/icon-rss.png" width="36" height="34" alt="" /></a></li>
                     
                 </ul>
                 </div>
             </div>
         </div>
     </div>
     <!-- Footer Ends-->
    <div style="display:none">
    <div id="myplayer" >
        <img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/videoplayer.jpg" alt="" />
    </div>
                    <!-- Video Player -->
                <div id="videobox">

                	<div id="videoboxin" class=" boxround clearfix">

                    	<div class="clearfix">
                        	<div class="floatright" style="margin-right: 4px;"><a href="javascript:void(0)" onClick="closeColorbox()"><img style="margin-top: 10px;" src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/close-btn.png"   /></a></div>
                        	<div class="floatleft"><span class="chlogo2"><img id="modal_logo" src=""  alt="" /></span></div>
                             
                            <h1 id="modal_title" class="floatleft dramatitle">Meera Naseeb <span>EP-21</span></h1>
                      </div>
                      	<div class="clearfix">
                      	   <div>	
                      		
                        	<div id="modal_video_container" style="width:699px;height:427px;" class="floatleft"></div>
                        <div style="float:;left;">
                           
                          <div class="floatleft" id="vidrel" style="overflow: auto;">
                            <div class="vidboxin">
                    		<div>
                                    <hr/>
                                    <h1 class="t">Sanjdal - EP 11</h1>
                                    <p>
                                    Throw this government out and save the country," in a campaign aimed.
                                    </p>	
                       		</div>
                            </div>
                              <div class="vidboxin ">
                    		<div>
                                    <hr/>
                                    <h1 class="t">Sanjdal - EP 11</h1>
                                    <p>
                                    Throw this government out and save the country," in a campaign aimed.
                                    </p>	
                       		</div>
                            </div>
                            <div class="vidboxin ">
                    		<div>
                                    <hr/>
                                    <h1 class="t">Sanjdal - EP 11</h1>
                                    <p>
                                     Throw this government out and save the country," in a campaign aimed.
                                    </p>	
                       		</div>
                            </div>
                            
                            
                          </div>
                         
                     </div>
                        
                       </div>  
                          <div class="floatleft" id="vidscrl">
                            	<ul>
                                	<li><img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/scrolbtn.gif"   /></li>
                                    <li id="scrolr">
                                    	<span></span>
                                    </li>
                                    <li><img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/scrolbtn.gif"   /></li>
                                </ul>
                          </div>
                        </div>
                        	<div id="like">
                            <span><img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/like.png"   alt="" /></span>&nbsp;
                            <span><span class="color2">500</span> people and <span class="color2">200</span> friends like this</span> &nbsp;&nbsp;|&nbsp;&nbsp;
                            <span id="click_to_fav"><a href="javascript:///noo" on><img src="<?php echo base_url();//$_SERVER['SERVER_NAME'];?>application/images/heart.png" width="20" height="17" alt="" />&nbsp; Add this Show To Favorites</a></span>
                             </div>
                             
                          <div id="tabinplr">
                          		
                                <div>
            					<ul class="tabber">
                				<li><a class=" selected" href="#">Episode Synopsis</a></li>
                   				<li><a href="#" class="  ">Cast & Crew</a></li>
                                </ul>
            					</div>
                                
                                <div  class="boxround synop">
            	
                                        <!-- Filter Bar -->

                                        <!-- Filter Bar ends -->
                                    <div id="modal_synopsis" class="vidbx">        
                                    	    
                                    </div> 
                     
            
            
                                </div>
                                
                          </div>
                    </div>
                    
                </div>
    </div>
</body>

</html>
