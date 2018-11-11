$(document).ready(function() {

var browsebar;		
		
	$("#browsebutton")
		.on("click", function(e){
			browsebar = $('<div id="browsedrop"></div>');
			var browsenav = $('<nav id="browsenav"></nav>');
			var browsetitle = $('<h4 id="browsetitle">Categories</h4>');
			var browselist = $('<ul id="browselist"></ul>');
			for(var i = 0; i<9; i++){
				var browseitem = $('<li class="browseitem"><a href="categorypage.html" class="browselink">Filler Name</a></li>');
				$(browselist).append(browseitem);
			} //eventually loop so it pulls the category names from our database
			$(browsetitle).appendTo(browsenav);
			$(browselist).appendTo(browsenav);
			$(browsenav).appendTo(browsebar);
			
			browsebar.appendTo($("header"));
			
			browsebar.fadeIn(1000);
			browsebar.css('position', 'fixed');
			browsebar.css("top", ($("header")).height());
			browsebar.css("left", "0px");
	
			})
			
	$(browsebar)
		.on("click", function(){
			console.log("hi");
			//browsebar.remove();
			});
			
});
