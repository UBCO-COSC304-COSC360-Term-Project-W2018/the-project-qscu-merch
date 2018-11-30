$(document).ready(function() {

	$("#searchform").on('submit', function(e) {
		e.preventDefault();
		doSearch();
	});
	$("#searchicon").on('click', function(e) {
		e.preventDefault();
		$("#searchform").trigger('submit');
	});
	console.log($("#searchTransferForLoad").val());
	$("#textinput").val($("#searchTransferForLoad").val());
	doSearch();

});
function doSearch() {

	console.log("Doing search");
	// Some basic sanitation
	var searchString = sanitize($("#textinput").val());
	var data = {
		searchType:"productNameWithRating",
		buildType:"deepgrouped",
		searchInput:searchString
	};

	$.ajax({
		url:"action/getProductList.php",
		method:"post",
		dataType:"json",
		data:JSON.stringify(data),
		beforeSend:function() {

			console.log("Searching....");
			$("#resultHolder").html("<p>Searching...</p>");

		},
		success:function(res) {

			console.log("Recieved result:");
			console.log(res);
			$("#resultHolder").html("<p>Searching...</p>");
			var maxResults = sanitize($("#iperpage").val());
			$("#resultHolder").html("");
			$("#number").html("");
			$("#searchResultsTitle").html("Search Results"+(searchString==""?"":" for &quot;"+searchString+"&quot;"));
			if (res.length > 0) {
				var pageinator = 0;
				for (var i = 0; i < res.length; i++) {

					var current = res[i];
					if (i >= pageinator*maxResults) {
						pageinator++;
						var $newPage = $("<a href=\"#\" "+(pageinator==1?"class=\"active\" ":"")+"data-pageyboi=\""+pageinator+"\">"+pageinator+"</a>");
						$newPage.click(function(e) {
							$("#number >a").removeClass("active");
							$(e.currentTarget).addClass("active");
							var goto = $(e.currentTarget).attr("data-pageyboi");
							$(".item").addClass("hidden");
							$(".item[data-pageinate='"+goto+"']").removeClass("hidden");
						});
						$("#number").append($newPage);
					}
					var price = "0.0";
					for (var key in current.variations) {
						price = current.variations[key].productPrice;
						break; //Hacking 101
					}
					var doHide = false;
					if (i >= maxResults) doHide = true;
					var htmlStr =
						"<div class=\"item"+(doHide?" hidden":"")+"\" data-pageinate=\""+pageinator+"\">"
							+"<div class=\"itempicture\"><a href=\"singleProduct.php?pNo="+current.productNumber+"\"><img src=\"data:"+current.productContentType+";base64,"+current.productImage+"\" alt=\""+current.productName+" Picture\"/></a></div>"
							+"<div class=\"iteminfo\">"
								+"<p class=\"pname\"><a href=\"singleProduct.php?pNo="+current.productNumber+"\">"+current.productName+"</a></p>"
								+"<p class=\"itemprice\">$"+price+"</p>"
								+"<p class=\"numberofliams\">";
					if (current.productRating !== null) {
						var rating = parseFloat(current.productRating);
						for (var j = 0; j < 5; j++) {
							htmlStr += "<span class=\"fa fa-star"+(((j+1) < rating)?" checked":"")+"\"></span>";
						}
					} else {
						htmlStr += "<span>Not Rated</span>";
					}
					htmlStr+="</p>"
								+"<p class=\"addtocart\">"
									+"<button>Add to Cart <i class=\"fa fa-shopping-cart\"></i></button>"
								+"</p>"
							+"</div>"
						+"</div>";
					$("#resultHolder").append(htmlStr);
				}
			} else {
				$("#resultHolder").append("<p>No results found. Please try searching something else.</p>");
			}

		}
	});

}
function sanitize(str) {
	if (typeof str == "String")
		return str.replace(/[^a-zA-Z\d\s:]/g,"");
	else return str;
}
