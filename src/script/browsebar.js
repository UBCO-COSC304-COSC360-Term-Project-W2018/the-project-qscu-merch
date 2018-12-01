$(document).ready(function() {

var browsebar;		
var isOpen = false;

  function listCat() {
      var results = $.get("../src/listCategories.php");
      results.done(function(data) {
                            console.log(data);

                            dostuff1(data);
                              });
      results.fail(function(jqXHR) {console.log("Error: " + jqXHR.status);});
      results.always(function() {console.log("done");});

  }

	$("#browsedropbutton")
		.on("click", function(e){
			console.log("Before function: " + isOpen);
			if(!isOpen){
				isOpen=true;
			var browsedropnav = $('<nav id="browsedropnav"></nav>');
			var browsedroptitle = $('<h4 id="browsedroptitle">Categories</h4>');
			var browsedroplist = $('<ul id="browsedroplist"></ul>');

 			listCat();
			$(browsedroptitle).appendTo(browsedropnav);
			$(browsedroplist).appendTo(browsedropnav);
			$(browsedropnav).appendTo('#browsedropsection');
			
			browsedropnav.fadeIn(100);
			browsedropnav.css('position', 'absolute');
			browsedropnav.css("top", ($("header")).height());
			browsedropnav.css("left", "0px");
			console.log("After if: " + isOpen);
			}else{
			var container = $("#browsedropnav");
    		if (!container.is(e.target) && container.has(e.target).length === 0 &&isOpen) 
				{
					container.remove();
					isOpen=false;
					console.log("After mouseup: " + isOpen);
				}
    		}
    	});

    	
    	$("main").mouseup(function(e){
			var container = $("#browsedropnav");
    		if (!container.is(e.target) && container.has(e.target).length === 0 &&isOpen) 
				{
					container.remove();
					isOpen=false;
					console.log("After mouseup: " + isOpen);
				}
    		});
    		
    	function dostuff1(json){
	    	for(var i = 0; i<json.length; i++){
				var browsedropitem = $("<li class='browsedropitem'><a href='searchpage.php?cat=" +json[i]+"' class='browsedroplink'>" + json[i] + "</a></li>");
				$(browsedroplist).append(browsedropitem);
			}
    	}
});
