$(function(){

      $("#zhuce-sub").click(function(){
          var tel = $('#tel').val();
          var partten       = /^(((13[0-9]{1})|(15[0-9]{1})|(16[0-9]{1})|(17[0-9]{1})|(18[0-9]{1})|(19[0-9]{1}))+\d{8})$/;
          if(tel == ''){
              layer.msg('请填写手机号', {
                   icon: 2,
                   time: 1500
              }, function(){});
              return false;
          }else if(!partten.test(tel)){
              layer.msg('手机号格式不正确', {
                   icon: 2,
                   time: 1500
              }, function(){});
              return false;
          }

          var smsCode = $('#smsCode').val();
          if(smsCode == ''){
              layer.msg('请点击获取验证码', {
                   icon: 2,
                   time: 1500
              }, function(){});
              return false;
          }

          var password = $('#password').val();
          if(password == ''){
              layer.msg('密码必须填写', {
                   icon: 2,
                   time: 1500
              }, function(){});
              return false;
          }

          var repassword = $('#repassword').val();
          if(repassword == ''){
              layer.msg('重复密码必须填写', {
                   icon: 2,
                   time: 1500
              }, function(){});
              return false;

          }else if(repassword != password){
              document.getElementById('repassword').value = '';
              layer.msg('密码跟重复密码不一致', {
                   icon: 2,
                   time: 1500
              }, function(){});
              return false;
          }

          if(!$('#vehicle').is(':checked')){
              layer.msg('请勾选《服务协议》', {
                   icon: 2,
                   time: 1500
              }, function(){});
              return false;
          }

          $(".zhuce").hide();
          $(".xinxiwanshan").show();
          $(".public-top h2").html("信息完善");
          document.getElementById('zhuce-sub').value = '提交注册';

          var realName = $('#realName').val();
          if(realName == ''){
              layer.msg('真实姓名必须填写', {
                   icon: 2,
                   time: 1500
              }, function(){});
              return false;
          }

          var cardNo = $('#cardNo').val();
          if(cardNo == ''){
              layer.msg('身份证号码必须填写', {
                   icon: 2,
                   time: 1500
              }, function(){});
              return false;
          }

          var sex = document.getElementById('xinxiwanshan-xb-1').innerHTML;
          if(sex == '请选择性别'){
              layer.msg('请选择性别', {
                   icon: 2,
                   time: 1500
              }, function(){});
              return false;
          }

          var birthday = $('#birthday').val();
          var email = $('#email').val();

          var userType = 1;
          var companyId = 1;
          var values = ["phone", "password", "userType", "smsCode", "companyId", "realName", "email", "cardNo", "sex", "birthday", "timestamp"];
          var datas = {
              "phone": tel,
              "password": md5(password),
              "userType":userType,
              "smsCode":smsCode,
              "companyId":companyId,
              "realName":realName,
              "email":email,
              "cardNo":cardNo,
              "sex":sex,
              "birthday":birthday,
              "timestamp": timestamp,
          };
          var sign = doSign(values, datas);

          $.ajax({
              url:'/app/accoutInfo/register',
              data:{phone:tel,password:md5(password),userType:userType,smsCode:smsCode,companyId:companyId,realName:realName,email:email,cardNo:cardNo,sex:sex,birthday:birthday,sign:sign,key:key,timestamp:timestamp},
              type:'POST',
              dataType:'json',
              success:function(data){
                  if(data.success == false){
                      layer.msg('注册失败', {
                           icon: 2,
                           time: 1500
                      }, function(){});
                  }else{
                      layer.msg('注册成功', {
                           icon: 1,
                           time: 1500
                      }, function(){
                          window.location.href = "/index/index/login";
                      });
                      
                  } 
              }
          })

      });

      // 性别
      $(".xinxiwanshan-xb1").click(function() {
            $(".xinxiwanshan-xb2").show();
            $(".yy-bg").show();
      });
      $(".xinxiwanshan-xb2 span").click(function() {
            $(this).addClass('on').siblings().removeClass('on');
      })
      $("#xinxiwanshan-xb-2").click(function() {
            $("#xinxiwanshan-xb-1").html($(".xinxiwanshan-xb2").find('span.on').html());
            $(".xinxiwanshan-xb2").hide();
            $(".yy-bg").hide();
      })

})
// 生日
var calendar = new lCalendar();
    calendar.init({
      'trigger': '#birthday',
      'type': 'date'
    });

//验证码60s倒计时
var waitzhuce=60;
function timezhuce(i) {  
    if (waitzhuce == 0) {  
        i.removeAttribute("disabled");            
        i.value="获取验证码";  
        waitzhuce = 60;  
    } else {  
        i.setAttribute("disabled", true);  
        i.value="" + waitzhuce + "s";  
        waitzhuce--;  
        setTimeout(function() {  
            timezhuce(i)  
        },  
        1000)  
    }  
}

$(function(){
    $('#zhuce-yanz').click(function(){
        var tel = $('#tel').val();
        var partten       = /^(((13[0-9]{1})|(15[0-9]{1})|(16[0-9]{1})|(17[0-9]{1})|(18[0-9]{1})|(19[0-9]{1}))+\d{8})$/;
        if(tel == ''){
            layer.msg('请填写手机号', {
                 icon: 2,
                 time: 1500
            }, function(){});
            return false;
        }else if(!partten.test(tel)){
            layer.msg('手机号格式不正确', {
                 icon: 2,
                 time: 1500
            }, function(){});
            return false;
        }

        var loginType = 1;
        var type = "reg";
        var values = ["phone", "loginType", "type", "timestamp"];
        var datas = {
          "phone": tel,
          "loginType": loginType,
          "type": type,
          "timestamp": timestamp,
        };
        var sign = doSign(values, datas);

        $.ajax({
            url:'/app/accoutInfo/sendSmsCode',
            data:{phone:tel,loginType:loginType,type:type,sign:sign,key:key,timestamp:timestamp},
            type:'POSt',
            dataType:'json',
            success:function(data){
                if(data.success == true){
                    layer.msg('验证码发送成功', {
                         icon: 1,
                         time: 1500
                    }, function(){});
                }else{
                    layer.msg('验证码发送失败', {
                         icon: 2,
                         time: 1500
                    }, function(){});
                }
            },
            error:function(){

            }
        })  

        timezhuce(this);

    })
})