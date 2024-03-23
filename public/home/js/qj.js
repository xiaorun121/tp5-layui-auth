function isLogin(){
	var token = getToken();
	if(token == undefined){
		return false;
	}
	return true;
}


function getToken(token){
	return Cookies.get('token');
}


function saveToken(cname,cvalue,exdays){
	var d = new Date();
	d.setTime(d.getTime()+(exdays*24*60*60*1000));
	var expires = "expires="+d.toGMTString();
	document.cookie = cname+"="+cvalue+"; "+expires;
}

function saveSmsCode(cname,cvalue,exsecond){
	var d = new Date();
	d.setTime(d.getTime()+(exsecond*1000));
	var expires = "expires="+d.toGMTString();
	document.cookie = cname+"="+cvalue+"; "+expires;
}

function removeToken(){
	Cookies.remove('token');
}