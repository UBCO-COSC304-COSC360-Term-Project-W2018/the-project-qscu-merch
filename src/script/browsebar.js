$(document).ready(function() {

var browsebar;		
		
	$("#browsebutton")
		.on("click", function(e){
			browsebar = document.getElementById("browsesection");
			var browsenav = $('<nav class="added" id="browsenav"></nav>');
			var browsetitle = $('<h4 class="added" id="browsetitle">Categories</h4>');
			var browselist = $('<ul class="added" id="browselist"></ul>');
			for(var i = 0; i<9; i++){
				var browseitem = $('<li class="added" class="browseitem"><a href="categorypage.html" class="added" class="browselink">Filler Name</a></li>');
				$(browselist).append(browseitem);
			} //eventually loop so it pulls the category names from our database
			$(browsetitle).appendTo(browsenav);
			$(browselist).appendTo(browsenav);
			$(browsenav).appendTo('#browsesection');
			
			browsenav.fadeIn(1000);
			browsenav.css('position', 'absolute');
			browsenav.css("top", ($("header")).height());
			browsenav.css("left", "0px");
	
			});
			
		
		$(document).mouseup(function(e){
			console.log("heythere");
			var container = $("#browsenav");
    		if (!container.is(e.target) && container.has(e.target).length === 0) 
				{
					container.remove();
				}
    	
    	});
			
});
