// 地址
 
//var upload_url ='http://qcap.hangtuosoft.com/';
var img_url ='http://app.uvclinic.cn/';
function wxSetTitle(title) {
    document.title = title;
    var mobile = navigator.userAgent.toLowerCase();
    if (/iphone|ipad|ipod/.test(mobile)) {
        var iframe = document.createElement('iframe');
        iframe.style.visibility = 'hidden';
        iframe.setAttribute('src', 'loading.png');
        var iframeCallback = function() {
            setTimeout(function() {
                iframe.removeEventListener('load', iframeCallback);
                document.body.removeChild(iframe);
            }, 0);
        };
        iframe.addEventListener('load', iframeCallback);
        document.body.appendChild(iframe);
    }
}
// 获取页面url数据
function GetRequest() {
    var url = location.search; //获取url中"?"符后的字串 
    var theRequest = new Object();
    if (url.indexOf("?") != -1) {
        var str = url.substr(1);
        strs = str.split("&");
        for (var i = 0; i < strs.length; i++) {
            theRequest[strs[i].split("=")[0]] = unescape(strs[i].split("=")[1]);
        }
    }
    return theRequest;
};
function parseUrl(){
    var url=location.href;
    var i=url.indexOf('?');
    if(i==-1)return;
    var querystr=url.substr(i+1);
    var arr1=querystr.split('&');
    var arr2=new Object();
    for  (i in arr1){
        var ta=arr1[i].split('=');
        arr2[ta[0]]=ta[1];
    }
    return arr2;
};
function GetQueryString(name) {  
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");  
    var r = window.location.search.substr(1).match(reg);  //获取url中"?"符后的字符串并正则匹配
    var context = "";  
    if (r != null)  
         context = r[2];  
    reg = null;  
    r = null;  
    return context == null || context == "" || context == "undefined" ? "" : context;  
};


// 签名
function doSign(values,data){
    values.sort();
    var str="";
    for(var i in values) {
        str+=values[i]+'='+data[values[i]] +'&';       
    }
   str = str.substr(0,str.length-1);
   var key ="idf5nsi5t0qbemwo12hztbftm53tbv6pht";
   var value="idf5nsi5t0qbemwo124213198as";
   var str1 = value+str+'&key='+key+value;
   var sign = (md5(str1)).toUpperCase();
   return sign;
}
// 解析地址
function parseUrl(){
    var url=location.href;
    var i=url.indexOf('?');
    if(i==-1)return;
    var querystr=url.substr(i+1);
    var arr1=querystr.split('&');
    var arr2=new Object();
    for  (i in arr1){
        var ta=arr1[i].split('=');
        arr2[ta[0]]=ta[1];
    }
    return arr2;
}
//转换日期
function dateToStr(datetime){ 
  var year = datetime.getFullYear();
  var month = datetime.getMonth()+1;//js从0开始取 
  var date = datetime.getDate(); 
  var hour = datetime.getHours(); 
  var minutes = datetime.getMinutes(); 
  var second = datetime.getSeconds();          
  if(month<10){month = "0" + month;}
  if(date<10){date = "0" + date;}
  if(hour <10){hour = "0" + hour;}
  if(minutes <10){ minutes = "0" + minutes;}
  if(second <10){second = "0" + second ;}          
//  var time = year+"."+month+"."+date+" "+hour+":"+minutes+":"+second; 
  var time=+month+"-"+date+" "+hour+":"+minutes;
  return time;
}

function msg(str){
  $('<div class="msg_bg">'+str+'</div>').appendTo("body");
  var w=$(".msg_bg").width()/2;
  var h=$(".msg_bg").height()/2;
  $(".msg_bg").css("margin-left",-w-10);
  $(".msg_bg").css("margin-top",-h);
  $(".msg_bg").delay(1500).fadeOut("slow");
}

/*Created by meng */
/*获取所有的banner图片*/
function getBannerImg(code,companyId){
  var companyId = companyId || '';
	var sign=doSign(['code','companyId'],{'code':'wechatAdImg','companyId':companyId});
	var datas;
	mui.ajax('/medical/app/dataDictionary/getListByParentIdOrCode',{
		type:'post',
		data:{
			sign:sign,
			code:'wechatAdImg',
      companyId:companyId
		},
		async:false,
		success:function(data){
			datas=JSON.parse(data).rows;
		}
	});
	for(var i=0;i<datas.length;i++){
		if(datas[i].code==code){
			return datas[i].value1
		}
	}
}
/*获取平台客服电话*/
function systemConfigInfo(){

  var phone;
  mui.ajax('/medical/app/systemConfigInfo/view',{
    type:'post',
    data:{},
    async:false,
    success:function(data){
      var data = JSON.parse(data);
      phone=data.systemConfigInfo.phone;
    }
  });
  return phone;
}
/*分中心电话*/
function phone(id){
  var sign=doSign(['id'],{'id':'id'});
  var phone;
  mui.ajax('/medical/app/company/getInfo',{
    type:'post',
    data:{
      sign:sign,
      id:id
    },
    async:false,
    success:function(data){
      
      var data = JSON.parse(data);
      phone = data.info.phone;
      console.log(data);
    }
  });
  return phone;
}

function getPhone(phone){
	if(phone){
		localStorage.fzxPhone=phone;
	}else{
		if($('.consultPhone').length){
			$('.consultPhone').text(localStorage.fzxPhone)
		}
		if($('#consultPhone').length){
			$('#consultPhone').prop('href','tel:'+localStorage.fzxPhone)
		}
	}
}
