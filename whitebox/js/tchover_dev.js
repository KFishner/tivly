/* 

TC Framework: Hovers - http://tyler.tc
	
*/
(function($){

	$.fn.tchover = function(options){
	
		/* Setup the options for the tooltip that can be
		   accessed from outside the plugin              */
		var defaults = {
			'page_url': 'http://tyler.tc/',
			'alt_tags': false,
			'scheme':'light',
			'tweet_text': 'Check this awesome page out!',
			'tweet_lang': 'en',
			'count_url': 'http://tyler.tc/'
		};
		
		// Extend options and apply defaults if they are not set
		var options = $.extend(defaults, options);
		
		// Create Vars
		var imgClass = $('img.tc-hover');
			
		imgClass.each(function(index, element){
			
			// Setup Base Image
			var currentImg = $(this);
			var currentSrc = currentImg.attr('src');
			var currentType = currentImg.attr('data-hover');
			if(currentImg.parent().is('a')){
				currentImg.unwrap();
			}
			currentImg.wrap('<div class="tchover-wrapper '+currentType+'"/>');
							
			// Setup Vars
			var imgHeight = this.height; // do not use jQ for this.
			var imgWidth = this.width; // do not use jQ for this.
			if(currentImg.attr('height')){imgHeight = currentImg.attr('height');}
			if(currentImg.attr('width')){imgWidth = currentImg.attr('width');}
			var imgSrc = currentImg.attr('src');
			var imgAlt = currentImg.attr('alt');
			var pgSrc = defaults.page_url;
			var newTop = (imgHeight - 20) / 2;
			var newSide;
			
			// Start Wrapper
			currentImg.parent().css({'width' : imgWidth+'px', 'height' : imgHeight+'px'});
			
			// Wrapper Types
			if(currentType == 'pin'){ // Pinterest
				
				newSide = (imgWidth - 43) / 2;
				var imgSrc = encodeURI(currentImg.attr('src'));
				var imgAlt = encodeURI(currentImg.attr('alt'));
				var pgSrc = encodeURI(defaults.page_url);
	
				// Config description
				if(defaults.alt_tags == false){imgAlt = '';}
				
				// Finish making wrapper
				currentImg.parent().append('<span><div style="position:absolute; top:'+newTop+'px; left:'+newSide+'px;"><img src="images/pinit.png" alt="Pin Image or Video" class="tchover-pin-button" /></span></div>');
								
			} else if(currentType == 'like'){ // Facebook
				
				newSide = (imgWidth - 50) / 2;
				currentImg.parent().append('<span><div style="position:absolute; top:'+newTop+'px; left:'+newSide+'px;"><div class="fb-like" data-href="'+defaults.page_url+'" data-colorscheme="'+defaults.scheme+'" data-send="false" data-layout="button_count" data-width="50" data-show-faces="false"></div></span></div>');
				
			} else if(currentType == 'tweet'){ // Twitter
			
				newSide = (imgWidth - 55) / 2;
				currentImg.parent().append('<span><div style="position:absolute; top:'+newTop+'px; left:'+newSide+'px;"><a href="https://twitter.com/share" class="twitter-share-button" data-url="'+defaults.page_url+'" data-text="'+defaults.tweet_text+'" data-lang="'+defaults.tweet_lang+'" data-counturl="'+defaults.count_url+'" data-count="none">Tweet</a></span></div>');
			
			}
			
		}); // end for each
		
		// Add hover effects for each button (must be done this way to work in chrome + IE)
		$('.tchover-wrapper img.tc-hover').mouseenter(function(){
			
			var enterImage = $(this);
			
			$(this).parent().children('span').css({'display' : 'block'});
			
			$(this).stop().animate( {"opacity": "0.2"}, 55, null, function(){
				
				$(this).parent().children('span').css({'z-index' : '999'});
			
			});
			
		});
	
		// Mouse L e A v E
		$('.tchover-wrapper span').mouseleave(function(){
			
			var leaveImg = $(this);
			$(this).css('z-index', '1');
			$(this).parent().children('img.tc-hover').stop().animate( {"opacity": "1"}, 300);
			$(this).css('display', 'none');
			
		});
		
		// Bind Click of Pin It Buttons
		$('img.tchover-pin-button').click(function(e){
			
			var e = document.createElement('script');
			e.setAttribute('type', 'text/javascript');
			e.setAttribute('charset', 'UTF-8');
			e.setAttribute('src', "http://assets.pinterest.com/js/pinmarklet.js?r=" + Math.random() * 99999999);
			document.body.appendChild(e)
            
        });
					
		
		return true;
	
	}; // End Main Function

})(jQuery); // End Plugin