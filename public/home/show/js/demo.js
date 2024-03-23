// 地址
//var img_url ='http://211.149.189.78:8088/medical/';
var img_url ='http://app.uvclinic.cn/';
 
var key ="26F72780372E84B6CFAED6F7B19139CC47B1912B6CAED753";

 
// 签名
function doSign(values,data){
    values.sort();
    var str="";
    for(var i in values) {
	   	str+=values[i]+'='+data[values[i]] +'&';       
    }
   str = str.substr(0,str.length-1);
   var str1 = str;
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
/*微信支付*/
/*weixinUnifiedOrder.action
orderType保险订单2、手动录入违章订单3、补行驶证订单5、异地委托年检审车8 、违章处理9
orderId订单id
*/

function doSign1(values,data){
    values.sort();
    var str="";
    for(var i in values) {
      str+=values[i]+'='+data[values[i]] +'&';       
    }
    str = str.substr(0,str.length-1);
    var value="wxf5nsi5t0qbemwo12hztbftm53tbvcs";
    var str1 = str+'&key='+value;
    var sign = (md5(str1)).toUpperCase();
    return sign;
}


function weixinUnifiedOrder(orderType,orderId){
    var timestamp = Date.parse(new Date());
    var values=['timestamp','orderType','orderId'];
    var data={'timestamp':timestamp,'orderType':orderType,'orderId':orderId};
    var sign = doSign(values,data);
    $.ajax({
        type : "post",
        url : url+'weixinUnifiedOrder.action', 
        data:{'timestamp':timestamp,'orderType':orderType,'orderId':orderId,'sign':sign},        
        dataType : "json",
        success : function(data){
            if(data.status == 1){
                var appid = data.object.appid;
                var timeStamp = Date.parse(new Date());
                var timeStamp1 = timeStamp.toString();      
                var nonceStr = data.object.nonce_str;
                var package = "prepay_id="+data.object.prepay_id;
                var signType ="MD5";
                
                var values1=['appId','timeStamp','nonceStr','package','signType'];
                var data1={'appId':appid,'timeStamp':timeStamp1,'nonceStr':nonceStr,'package':package,'signType':signType};
                var sign1  =doSign1(values1,data1);
                

                function onBridgeReady(){
                    WeixinJSBridge.invoke(
                       'getBrandWCPayRequest', {
                           "appId":appid,     //公众号名称，由商户传入     
                           "timeStamp":timeStamp1,         //时间戳，自1970年以来的秒数     
                           "nonceStr":nonceStr, //随机串     
                           "package":package,     
                           "signType":signType,         //微信签名方式：     
                           "paySign":sign1//微信签名 
                       },
                       function(res){
                          alert(JSON.stringify(res));
                           if(res.err_msg == "get_brand_wcpay_request：ok" ) {} 
                           
                            // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回    ok，但并不保证它绝对可靠。 
                       }
                   ); 
                }
                if (typeof WeixinJSBridge == "undefined"){
                   if( document.addEventListener ){
                       document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
                   }else if (document.attachEvent){
                       document.attachEvent('WeixinJSBridgeReady', onBridgeReady); 
                       document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
                   }
                }else{
                   onBridgeReady();
                }  
            }else{
              alert(data.info);
            }
        }  
    })  
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

// 手机号码中间四位用*代替
function plusXing (str,frontLen,endLen) { 
    var len = str.length-frontLen-endLen;
    var xing = '';
    for (var i=0;i<len;i++) {
        xing+='*';
    }
    return str.substr(0,frontLen)+xing+str.substr(str.length-endLen);
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
 

 