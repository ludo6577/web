$(document).ready(function() { 

	/*
	 *	Change CSS 
	 */
	$(".categories li a").addClass("sidebarModified"); 
	
	/*
	 *	FadeIn FadeOut
	 */
	$("#slidenav li a").click(function(e) { 
		e.preventDefault(); //Empêcher le navigateur de suivre le lien
	
		var img = $(this).attr("href");		
		$("#slideshow img").fadeOut("slow", function() {
			$("#slideshow img").attr("src", img);
			$("#slideshow img").fadeIn("slow");
  		});
	}); 

	/*
	 *	Form in AJAX
	 */
	$("#form").submit(function() { 
		// ... 
		return false;
	}); 

	$.ajax({ 
		type: 'POST', 
		url: 'ajax/post.ajax.php', 
		data: 'name=' + name + '&url=' + url + '&content=' + content, 
		success: function(data) { 
		// Actions à réaliser une fois les données reçues 
		// La variable « data » contient tous les caractères qu'on aurait 
		// affichés (echo) dans le script post.ajax.php 
		} 
	}); 

}); 
