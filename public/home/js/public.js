$(function(){
    $('.fanh').click(function(){
        history.back(-1);
    })
})


function onService(){
    window.location.href = "{:url('index/service')}";
}   

var timestamp = new Date().getTime();
var key = "26F72780372E84B6CFAED6F7B19139CC47B1912B6CAED753";
/*获取sign*/
function doSign(values, datas) {
    values.sort();
    var str = "";
    for(var i in values) {
      str += values[i] + '=' + datas[values[i]] + '&';
    }
    str = str.substr(0, str.length - 1);
    var value = "";
    var str1 = value + str + '&key=' + key + value;
    var sign = (md5(str1)).toUpperCase();
    return sign;
}
