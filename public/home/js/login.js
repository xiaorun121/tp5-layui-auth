$(function(){
      $(".ZHdengru-1 a").click(function() {
            $(this).addClass('on').siblings().removeClass('on');
            $(".dengru div").eq($(this).index()).addClass('on').siblings().removeClass('on');
      });
})


$(function(){
     // 账号密码登录 
     $('#ZHdengru-sub').click(function(){
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

          var password = $('#password').val();
          if(password == ''){
              layer.msg('密码必须填写', {
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

          var loginType = 1;
          var values = ["loginName", "password", "loginType", "timestamp"];
          var datas = {
            "loginName": tel,
            "password": md5(password),
            "loginType": loginType,
            "timestamp": timestamp,
          };
          var sign = doSign(values, datas);

          $.ajax({
              url:'/app/accoutInfo/login',
              data:{loginName:tel,password:md5(password),loginType:loginType,sign:sign,key:key,timestamp:timestamp},
              type:'POST',
              dataType:'json',
              async: false,    // 使用同步操作
              timeout : 50000, //超时时间：50秒
              success: function(data){
                  if(data.success == false){
                      layer.msg('账号或者密码错误', {
                           icon: 2,
                           time: 1500
                      }, function(){});
                  }else{
                      document.getElementById('ZHdengru-sub').value = '登录中...';
                      layer.msg('登录成功', {
                           icon: 1,
                           time: 1500
                      }, function(){
                          saveToken('token',data.token,30);
                          window.location.href = "/index/index/center";
                      });
                      
                  }
              },
              error:function(){
                  layer.msg('登录失败！', {
                       icon: 2,
                       time: 1500
                  }, function(){});
              }
          });
      })

     // 手机号验证码登录 
     $('#DXdengru-sub').click(function(){
          var tel = $('#dxtel').val();
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

          var smsGetCode = getToken('smsCode');
          if(!smsGetCode){
              layer.msg('请重新获取验证码', {
                   icon: 2,
                   time: 1500
              }, function(){});
              return false;
          }

          if(!$('#vehicles').is(':checked')){
              layer.msg('请勾选《服务协议》', {
                   icon: 2,
                   time: 1500
              }, function(){});
              return false;
          }


          var loginType = 1;
          var values = ["loginName", "loginType", "smsCode", "timestamp"];
          var datas = {
            "phone": tel,
            "smsCode":smsCode,
            "loginType": loginType,
            "timestamp": timestamp,
          };
          var sign = doSign(values, datas);
          $.ajax({
              url:'/app/accoutInfo/smsLogin',
              data:{loginName:tel,smsCode:smsCode,loginType:loginType,sign:sign,key:key,timestamp:timestamp},
              type:'POST',
              dataType:'json',
              success:function(data){
                  if(data.success == false){
                        layer.msg('登录失败', {
                             icon: 2,
                             time: 1500
                        }, function(){});
                  }else{
                      document.getElementById('DXdengru-sub').value = '登录中...';
                      layer.msg('登录成功', {
                           icon: 1,
                           time: 1500
                      }, function(){
                          saveToken('token',data.token,30);
                          window.location.href = "/index/index/center";
                      });
                    }  
              },
              error:function(){
                  layer.msg('登录失败', {
                       icon: 2,
                       time: 1500
                  }, function(){});
              }
          })

     })

     $('#zhuce-yanz').click(function(){
          var tel = $('#dxtel').val();
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

          var loginType = "pc1";
          var type = "login";
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
                      layer.msg('验证码发送成功！', {
                           icon: 1,
                           time: 1500
                      }, function(){});
                      saveSmsCode('smsCode',data.message,60);
                  }else{
                      layer.msg(data.message, {
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
                  1500)  
              }  
          }

})