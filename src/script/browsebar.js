$(document).ready(function() {

var browsebar;		
var isOpen = false;


	$("#browsedropbutton")
		.on("click", function(e){
			console.log(isOpen);
			if(!isOpen){
				isOpen=true;
			var browsedropnav = $('<nav id="browsedropnav"></nav>');
			var browsedroptitle = $('<h4 id="browsedroptitle">Categories</h4>');
			var browsedroplist = $('<ul id="browsedroplist"></ul>');
			for(var i = 0; i<9; i++){
				var browsedropitem = $('<li class="browsedropitem"><a href="categorypage.html" class="browsedroplink">Filler Name</a></li>');
				$(browsedroplist).append(browsedropitem);
			} //eventually loop so it pulls the category names from our database
			$(browsedroptitle).appendTo(browsedropnav);
			$(browsedroplist).appendTo(browsedropnav);
			$(browsedropnav).appendTo('#browsedropsection');
			
			browsedropnav.fadeIn(1000);
			browsedropnav.css('position', 'absolute');
			browsedropnav.css("top", ($("header")).height());
			browsedropnav.css("left", "0px");
			
			}else{
				var container = $("#browsedropnav");
					if (!container.is(e.target) && container.has(e.target).length === 0&&isOpen) 
				{
					container.remove();
					isOpen=false;
				}
				
			}
			});
			

		$(document).mouseup(function(e){
			var container = $("#browsedropnav");
    		if (!container.is(e.target) && container.has(e.target).length === 0 &&isOpen) 
				{
					container.remove();
					
				}
    	});
});
