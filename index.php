<?php
include '../../functions.php';

yimian__header();
yimian__headerEnd();
?>
<?php aplayer__element()?>
<?php aplayer__setup()?>
<?php $rand=rand(0,300);aplayer__netease(808097971,$rand,$rand+10);?>
<h2 id="code"></h2>
<input type="text" id="room" />
<button id="join">Join a Room</button>
<h3 id="ishost"></h3>
<button id="host">Set Room Host</button>
<script>
var code='';
var planSeek;
var tp_host='';
	
function ishost()
{
		
 $.ajax({
        type: "GET",
        url: 'https://cn.yimian.xyz/etc/TPlayer/aj_ishost.php',
        data: { "fp":fp,
			  	"code":code
			  },
        traditional: true,
        dataType: 'json',
        success: function (msg) {
			if(msg.code==1) {tp_host='host';$("#ishost").html('You are the room Host!');}
			else {tp_host='';$("#ishost").html('Not Host');}
			
        }
    });
	
}


ap.on('play', function () {
	ishost();
	var i=$.inArray(ap.audio.currentSrc,urlList);
	var planTime=Math.round(Number(new Date())/1000)+2;
	planSeek=ap.audio.currentTime;
	if(tp_host=='host')
    $.ajax({
        type: "GET",
        url: 'https://cn.yimian.xyz/etc/TPlayer/aj_action.php',
        data: { "code":code,
			  	"name":nameList[i],
			   	"artist":artistList[i],
			   	"url":urlList[i],
			   	"cover":coverList[i],
			   	"lrc":lrcList[i],
			   	"theme":themeList[i],
			   	"planstatus":"play",
			   	"planseek":planSeek,
			   	"plantime":planTime
			  },
        traditional: true,
        dataType: 'json',
        success: function (msg) {
			var timeLeft=planTime*1000-Number(new Date());
			setTimeout("ap.seek(planSeek)",timeLeft);
			
        }
    });
});
</script>
<script>
	function rc(){
	$.ajax({
        type: "GET",
        url: 'https://cn.yimian.xyz/etc/TPlayer/aj_new.php',
        data: { "fp": fp},
        traditional: true,
        dataType: 'json',
        success: function (msg) {
			$("#code").html('Your Room Code: '+msg.code);
			code=msg.code;
			ishost();
        }
    });}
rc();
</script>
<script>
	$("#join").click(function(){
		$.ajax({
        type: "GET",
        url: 'https://cn.yimian.xyz/etc/TPlayer/aj_join.php',
        data: { "fp": fp,"code":$("#room").val()},
        traditional: true,
        dataType: 'json',
        success: function (msg) {
			$("#code").html('Your Room Code: '+msg.code);
			code=msg.code;
			ishost();
        }
    });	
		
	})
	
	$("#host").click(function(){
		$.ajax({
        type: "GET",
        url: 'https://cn.yimian.xyz/etc/TPlayer/aj_sethost.php',
        data: { "fp": fp,"code":code},
        traditional: true,
        dataType: 'json',
        success: function (msg) {
			ishost();
        }
    });	
		
	})
</script>
<?php yimian__footer()?>