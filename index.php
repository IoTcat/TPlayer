<?php
include '../../functions.php';

yimian__header();
yimian__headerEnd();
?>
<?php aplayer__element()?>
<?php aplayer__setup()?>
<script>
	var nameList=new Array();
	var artistList=new Array();
	var urlList=new Array();
	var coverList=new Array();
	var lrcList=new Array();
	var themeList=new Array();
	
	function netease()
	{
	
	$.ajax({
        type: "GET",
        url: 'https://api.bzqll.com/music/netease/songList',
        data: { "key": 579621905,
			  	"id": 808097971,
				"limit": 10},
        traditional: true,
        dataType: 'json',
        success: function (msg) {
		   for(var i=0;i<Math.min(msg.data.songListCount,999);i++)
		   {
		   		ap.list.add([{
				name: msg.data.songs[i].name,
				artist: msg.data.songs[i].singer,
				url: msg.data.songs[i].url,
				cover: msg.data.songs[i].pic,
				lrc: msg.data.songs[i].lrc,
				theme: '#ebd0c2'
				}]);
				
				nameList[i]=msg.data.songs[i].name;
				artistList[i]=msg.data.songs[i].singer;
				urlList[i]=msg.data.songs[i].url;
				coverList[i]=msg.data.songs[i].pic;
				lrcList[i]=msg.data.songs[i].lrc;
				themeList[i]='#ebd0c2';
		   }
        }
    });
		
	}
	setTimeout("if(tp_host=='host')netease();",1200);
	</script>
<h2 id="code"></h2>
<input type="text" id="room" />
<button id="join">Join a Room</button>
<h3 id="ishost"></h3>
<button id="host">Set Room Host</button>
<h3 id="cali"></h3>
<button id="cali-less">slower</button><button id="cali-more">quicker</button>
<script>
var cali=0;
$("#cali-less").click(function(){cali=cali-200;$("#cali").html(cali);});
$("#cali-more").click(function(){cali=cali+200;$("#cali").html(cali);});
</script>
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
	var planTime=Number(new Date())+5000;
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
			var timeLeft=planTime-Number(new Date());
			setTimeout("ap.seek(planSeek)",timeLeft);
			
        }
    });
});
	
ap.on('pause', function () {
	ishost();
	var i=$.inArray(ap.audio.currentSrc,urlList);
	var planTime=Number(new Date())+5000;
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
			   	"planstatus":"pause",
			   	"planseek":planSeek,
			   	"plantime":planTime
			  },
        traditional: true,
        dataType: 'json',
        success: function (msg) {
			var timeLeft=planTime-Number(new Date());
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
<script>

var lastIndex='';
var fw_lefttime;
var fw_seek;
var state='pause';
var tink;
function follow()
{
	if(1)
		$.ajax({
        type: "GET",
        url: 'https://cn.yimian.xyz/etc/TPlayer/aj_follow.php',
        data: {"code":code,"last":lastIndex},
        traditional: true,
        dataType: 'json',
        success: function (msg) {
			if(msg.code==1)
				{
					if(msg.planstatus=='seek')
					{
						fw_lefttime=msg.plantime-msg.time;
						fw_seek=msg.planseek;
						setTimeout("ap.play();ap.seek(fw_seek);",fw_lefttime);
					}
						
					if(ap.audio.currentSrc!=msg.url)	
					{
					ap.list.clear();
						ap.list.add([{
    					name: msg.name,
    					artist: msg.artist,
    					url: msg.url,
    					cover: msg.cover,
    					lrc: msg.lrc,
    					theme: msg.theme
						}]);
					}
					lastIndex=msg.index;

					if(msg.planstatus=='play')
						{
							fw_lefttime=msg.plantime-msg.time;
							tink=msg.plantime;
							fw_seek=msg.planseek;
							ad_seek=fw_seek;ap.play();
							setTimeout("ap.play();state='play';ap.seek(fw_seek);",fw_lefttime-cali);
						}
					if(msg.planstatus=='pause')
						{
							fw_lefttime=msg.plantime-msg.time;
							
							fw_seek=msg.planseek;
							setTimeout("ap.pause();state='pause';ap.seek(fw_seek);",fw_lefttime);
						}
					}
				
			
			setTimeout("follow()",1000);
        }
    });	
}
var adSeek;
var adTime;
var ad_seek;
function adjust()
{
	if(state=='play'&&tp_host!='host')
	{
		adSeek=Math.round(ap.audio.currentTime)+1;
		adTime=tink+(adSeek-ad_seek)*1000;alert(tink);
		
		setTimeout("ap.seek(adSeek);",adTime-Number(new Date()));
	}
	setTimeout("adjust()",2000);
}
//adjust();
function school()
{
	var i=$.inArray(ap.audio.currentSrc,urlList);
	var pseek=Math.round(ap.audio.currentTime+4);
	var ptime=Math.round(Number(new Date())+(pseek-ap.audio.currentTime)*1000);
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
			   	"planstatus":"seek",
			   	"planseek":pseek,
			   	"plantime":ptime
			  },
        traditional: true,
        dataType: 'json',
        success: function (msg) {			
			
        }
    });	
		setTimeout("school()",19000);
}

if(tp_host!='host')	follow();
//school();



</script>


<?php yimian__footer()?>