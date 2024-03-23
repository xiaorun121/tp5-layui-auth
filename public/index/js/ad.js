 	 

 $(function(){
			var speed=40;
			var tab=document.getElementById("demo");
			var tab1=document.getElementById("demo1");
			var tab2=document.getElementById("demo2");
			tab2.innerHTML=tab1.innerHTML;
			function Marquee(){
			if(tab2.offsetWidth-tab.scrollLeft<=0)
			tab.scrollLeft-=tab1.offsetWidth
			else{
			tab.scrollLeft++;
			}
			}
			var MyMar=setInterval(Marquee,speed);
			tab.onmouseover=function() {clearInterval(MyMar)};
			tab.onmouseout=function() {MyMar=setInterval(Marquee,speed)};
	 })  
	 
	  $(function(){
			var speed=40;
			var tab=document.getElementById("dem");
			var tab1=document.getElementById("dem1");
			var tab2=document.getElementById("dem2");
			tab2.innerHTML=tab1.innerHTML;
			function Marquee(){
			if(tab2.offsetWidth-tab.scrollLeft<=0)
			tab.scrollLeft-=tab1.offsetWidth
			else{
			tab.scrollLeft++;
			}
			}
			var MyMar=setInterval(Marquee,speed);
			tab.onmouseover=function() {clearInterval(MyMar)};
			tab.onmouseout=function() {MyMar=setInterval(Marquee,speed)};
	 })  
	 	  $(function(){
			var speed=40;
			var tab=document.getElementById("de");
			var tab1=document.getElementById("de1");
			var tab2=document.getElementById("de2");
			tab2.innerHTML=tab1.innerHTML;
			function Marquee(){
			if(tab2.offsetWidth-tab.scrollLeft<=0)
			tab.scrollLeft-=tab1.offsetWidth
			else{
			tab.scrollLeft++;
			}
			}
			var MyMar=setInterval(Marquee,speed);
			tab.onmouseover=function() {clearInterval(MyMar)};
			tab.onmouseout=function() {MyMar=setInterval(Marquee,speed)};
	 })  
