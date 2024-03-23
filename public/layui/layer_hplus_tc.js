$(document).on('submit','form[data-type=ajax]',function(){
    //获取数据
    var url = $(this).attr('action');
    var data = $(this).serializeArray();//序列化表单元素
    //弹出询问框
    layer.confirm('您确定提交处理吗?',{icon:3, title:'提示'},function(index){
        //异步提交
        $.ajax({
            type: "POST",
            dataType:"json",
            url:url,
            data:data,
            success:function(obj){
                var icon_num = (obj.status==200) ? 1 : 2;
                if(obj.status==200 || obj.status==202){
                    layer.open({
                      content: obj.msg,
                      btn: ['确定'],
                      shade: 0.1,
                      icon: icon_num,
                      yes: function(index, layero){
                          if(obj.url){
                              window.parent.location.href = obj.url;
                          }else{
                              layer.close(index);
                          }
                      },
                      cancel: function(){
                          if(obj.url){
                              window.parent.location.href = obj.url;
                          }else{
                              layer.close();
                          }
                      },
                    });
                }
            },
            error:function(data){
                layer.alert('网络故障!');
            }
        });
    });
    return false;
});
