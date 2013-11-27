/* 	
	ADMINPRO - CUSTOM.JS
	Version: 1.0
	Updated: 9/10/2011
	Author: Justin Scheetz
	
	Need support? http://scheetzdesigns.ticksy.com
*/
	

// Wait for the page to load...
var j=jQuery.noConflict();
j(document).ready(function() {
	
	
	
	/* OPEN & CLOSE PANELS													*/
	/* -------------------------------------------------------------------- */
	
	var screenSize = j('body').width();
	
	j('.panel .cap').click(function(){
	
		var content = j(this).parent().find('.content');
		var tabs = j(this).parent().find('.tabs');
		var accordionWrapper = j(this).parent().find('.accordion-wrapper');
		var isOpen = content.is(":visible");
		if (!isOpen) { var isOpen = tabs.is(":visible"); }
		if (!isOpen) { var isOpen = accordionWrapper.is(":visible"); }
		if (isOpen){
			if (screenSize <= 1024){
				content.hide();
				tabs.hide();
				accordionWrapper.hide();
			} else {
				content.slideUp();
				tabs.slideUp();
				accordionWrapper.slideUp();
			}
		} else {
			if (screenSize <= 1024){
				content.show();
				tabs.show();
				accordionWrapper.show();
			} else {
				content.slideDown();
				tabs.slideDown();
				accordionWrapper.slideDown();
			}
			
			// If this is the gallery tab, resize the galleries for mobile browsers.
			if (content.hasClass('gallery')) { resizeGalleries(); }
		}
	});
	
	j('.alert-text .close').click(function(){
		j(this).parents('.alert-wrapper').slideUp('normal');
		return false;
	});
	
	/* /// END - OPEN & CLOSE PANELS /// */
	
	
	
	/* SORTABLE TABLES														*/
	/* -------------------------------------------------------------------- */
	
	try {
		j('.tablesorter')
		.tablesorter({headers: {0:{sorter: false},3:{sorter: false}}, widthFixed: true, widgets: ['zebra']}) 
	    .tablesorterPager({container: j("#table-pager-1")});
	    
	    j(".pagesize").chosen();
	    
	    j('.checkall').click(function(){
	    	j(this).parents('table:eq(0)').find(':checkbox').attr('checked', this.checked);
	    });
	}
	catch(err){
		// Error stuff here
	}
    
    /* /// END - SORTABLE TABLES /// */
    


	/* TABS																	*/
	/* -------------------------------------------------------------------- */
	
    //When page loads...
	j(".tab_content").hide(); //Hide all content
	j("ul.tabs li:first").addClass("active").show(); //Activate first tab
	j(".tab_content:first").show(); //Show first tab content

	//On Click Event
	j("ul.tabs li a").click(function() {

		j("ul.tabs li").removeClass("active"); //Remove any "active" class
		j(this).parent().addClass("active"); //Add "active" class to selected tab
		j(".tab_content").hide(); //Hide all tab content

		var activeTab = j(this).attr("href"); //Find the href attribute value to identify the active tab + content
		j(activeTab).fadeIn(); //Fade in the active ID content
		return false;
		
	});
	
	/* /// END - TABS /// */
	
	
	
	/* ACCORDIONS															*/
	/* -------------------------------------------------------------------- */
	
	// On load, show the first panel in each accordion.
	j('.accordion').each(function(){
		j(this).find('.accordion-block').eq(0).addClass('open');
		j(this).find('.accordion-block').eq(0).find('.accordion-content').show();
	});
	
	j('.accordion-block h3').click(function(){
		if(j(this).parent().hasClass('open')){
			j('.accordion-block .accordion-content').slideUp('fast',function(){
				j('.accordion-block').removeClass('open');
			});
		} else {
			j('.accordion-block .accordion-content').slideUp('fast');
			j(this).parent().find('.accordion-content').slideDown('fast');
			j('.accordion-block').removeClass('open');
			j(this).parent().addClass('open');
		}
	});
	
	/* /// END - ACCORDIONS /// */
	
	
	
	/* GALLERIES															*/
	/* -------------------------------------------------------------------- */
	
	// Add Fancybox lightboxing to each of the images.
	try { j('.fancybox').fancybox(); } catch(err) { /* Error Stuff */ }

	// On window resize, adjust the sizing.
	j(window).resize(function(){
  		setTimeout("resizeGalleries()",100);
		setTimeout("resizeChosenWidths()",100);
		setTimeout("generateGraphs()", 100);
  	});
  	
  	// When you check a checkbox, add some styling to the image block
  	j('.gallery-item .checkbox-block input').click(function(){
  	
  		var checkedLayer = j(this).parent().parent().find('.checked-layer');
  	
  		if (j(this).attr('checked')){
  			checkedLayer.show();
  		} else {
  			checkedLayer.hide();
  		}
  		
   	});
   	
   	j('.gallery').find('.next').click(function(){
   		var thisGallery = j(this).parent().parent().parent().find('.gallery-wrap');
   		
   		// Get page information
   		var pageDisplayContent = j(this).parent().find('.pagedisplay').val();
   		pageDisplayContent = pageDisplayContent.split('/');
   		currentPage = pageDisplayContent[0];
   		totalPages = pageDisplayContent[1];
   		var nextPage = parseInt(currentPage) + 1;
   		
   		// Get this galleries height
   		var galleryHeight = j(this).parent().parent().parent().find('.gallery-wrap').height();
   		var galleryHeight = galleryHeight + 10;
   		
   		// Slide the gallery to the next page
   		if (nextPage <= totalPages){
   			galleryPaginate(thisGallery,nextPage,galleryHeight,totalPages);
   		}
   	});
   	
   	j('.gallery').find('.prev').click(function(){
   		var thisGallery = j(this).parent().parent().parent().find('.gallery-wrap');
   		
   		// Get page information
   		var pageDisplayContent = j(this).parent().find('.pagedisplay').val();
   		pageDisplayContent = pageDisplayContent.split('/');
   		currentPage = pageDisplayContent[0];
   		totalPages = pageDisplayContent[1];
   		var prevPage = parseInt(currentPage) - 1;
   		
   		// Get this galleries height
   		var galleryHeight = j(this).parent().parent().parent().find('.gallery-wrap').height();
   		var galleryHeight = galleryHeight + 10;
   		
   		// Slide the gallery to the previous page
   		if (prevPage > 0){
   			galleryPaginate(thisGallery,prevPage,galleryHeight,totalPages);
   		}
   	});
   	
   	j('.gallery').find('.last').click(function(){
   		var thisGallery = j(this).parent().parent().parent().find('.gallery-wrap');
   		
   		// Get page information
   		var pageDisplayContent = j(this).parent().find('.pagedisplay').val();
   		pageDisplayContent = pageDisplayContent.split('/');
   		currentPage = pageDisplayContent[0];
   		totalPages = pageDisplayContent[1];
   		
   		// Get this galleries height
   		var galleryHeight = j(this).parent().parent().parent().find('.gallery-wrap').height();
   		var galleryHeight = galleryHeight + 10;
   		
   		// Slide the gallery to the last page
   		galleryPaginate(thisGallery,totalPages,galleryHeight,totalPages);
   	});
   	
   	j('.gallery').find('.first').click(function(){
   		var thisGallery = j(this).parent().parent().parent().find('.gallery-wrap');
   		
   		// Get page information
   		var pageDisplayContent = j(this).parent().find('.pagedisplay').val();
   		pageDisplayContent = pageDisplayContent.split('/');
   		currentPage = pageDisplayContent[0];
   		totalPages = pageDisplayContent[1];
   		
   		// Get this galleries height
   		var galleryHeight = j(this).parent().parent().parent().find('.gallery-wrap').height();
   		var galleryHeight = galleryHeight + 10;
   		
   		// Slide the gallery to the first page
   		galleryPaginate(thisGallery,1,galleryHeight,totalPages);
   	});
   	
   	/* /// END - GALLERIES /// */
   	
   	
   	
   	/* FORMS																*/
	/* -------------------------------------------------------------------- */
   	
   	
   	// Custom file field
   	j('form.styled input[type=file]').each(function(){
   		j(this).before('<input class="textbox file-field" name="uploadField" type="text" value="" /><span class="browse button medium grey">Browse...</span>');
   	});
   	
   	j('form.styled input[type=file]').animate({'opacity':0},0);
   	
   	j('form.styled input[type=file]').hover(function(){
   		j(this).parent().find('.browse').addClass('hover');
   	},function(){
   		j(this).parent().find('.browse').removeClass('hover');
   	});
   	
   	j('form.styled input[type=file]').change(function(){
   		j(this).parent().find('.file-field').val(j(this).val().replace('C:\\fakepath\\',''));
   	});
   	
   	// "Chosen" field
   	// http://harvesthq.github.com/chosen/

	try {
   		j('form.styled').find('.chosen').chosen();
   	}
   	catch(err){
   		// Error stuff here
   	}
   	   	
   	/* /// END - FORMS /// */
   	
   	
   	
   	/* MOBILE DROPDOWN NAVIGATION											*/
	/* -------------------------------------------------------------------- */
   	
   	j('.mobile-navigation').change(function(){
   		var url = j(this).val();
   		location.href = url;
	  	return false;
   	});
   	
   	/* /// END - MOBILE DROPDOWN NAVIGATION /// */
   	
   	
   	
   	/* 	FOR MOBILE WEB APPS
   		This allows the app to stay contained instead of launching Safari
   		when clicking on links.												*/
	/* -------------------------------------------------------------------- */
	
	j('a').click(function(){
		if ( !j(this).hasClass('fancybox') ){
	  		var href = j(this).attr('href');
	  		if (href) { var firstChar = href.substring(0,1); }
	  		if (href && href != '#' && firstChar != '#') {
	  			location.href = href;
	  			return false;
	  		} else {
	  			return false;
	  		}
	  	}
  	});
  	
  	/* /// END - FOR MOBILE WEB APPS /// */

	setTimeout("resizeGalleries()",100);
	setTimeout("resizeChosenWidths()",100);
	setTimeout("generateGraphs()", 100);

});



/* CHARTS																*/
/* -------------------------------------------------------------------- */
     
function generateGraphs(){
    j("table.statics").each(function() {
    	var widthOfParent = j(this).parent().width();
    	j(this).hide();
    	j(this).parent().find('.flot-graph').remove();
        var colors = [];
        j(this).find("thead th:not(:first)").each(function() {
            colors.push(j(this).css("color"));
        });
        j(this).graphTable({
            series: 'columns',
            position: 'before',
            width: widthOfParent,
            height: '200px',
            colors: colors
        }, {
            xaxis: {
                tickSize: 1
            }
        });
    });

    j('.flot-graph').before('<div class="space"></div>');

    function showTooltip(x, y, contents) {
        j('<div id="tooltip" style="color:#fff; padding:4px 8px; -moz-border-radius:5px; -webkit-border-radius:5px; border-radius:5px; line-height:11px; font-size:11px; background:#333;">' + contents + '</div>').css({
            position: 'absolute',
            display: 'none',
            top: y + 5,
            left: x + 5
        }).appendTo("body").fadeIn("fast");
    }

    var previousPoint = null;
    j(".flot-graph").bind("plothover", function(event, pos, item) {
        j("#x").text(pos.x);
        j("#y").text(pos.y);

        if (item) {
            if (previousPoint != item.dataIndex) {
                previousPoint = item.dataIndex;

                j("#tooltip").remove();
                var x = item.datapoint[0],
                    y = item.datapoint[1];

                showTooltip(item.pageX, item.pageY, "<b>" + item.series.label + "</b>: " + y);
            }
        }
        else {
            j("#tooltip").remove();
            previousPoint = null;
        }
    });
}

/* /// END - CHARTS /// */



/* FUNCTIONS - GALLERY													*/
/* -------------------------------------------------------------------- */

function resetGalleryPager(thisGallery,thumbsToFit,newWrapHeight){
	var totalThumbs = thisGallery.find('.gallery-item').size();
	var totalVisibleThumbs = thumbsToFit * 2;
	var totalPages = Math.ceil(totalThumbs / totalVisibleThumbs);
	window.adminpro_totalPages = totalPages;
	thisGallery.parent().find('.pagedisplay').val('1/'+totalPages);
	galleryPaginate(thisGallery,1,newWrapHeight,totalPages);
	window.adminpro_newWrapHeight = newWrapHeight;
}

function galleryPaginate(thisGallery,currentPage,galleryHeight,totalPages){
	var pageLocation = -1 * ((currentPage * galleryHeight) - galleryHeight);
	thisGallery.find('.gallery-pager').css('top',pageLocation);
	thisGallery.parent().find('.pagedisplay').val(currentPage+'/'+totalPages);
	window.currentPage = currentPage;
}

function resizeGalleries(i,width){

	galleryWrap = j('.gallery-wrap');
	galleryWrap.each(function(){
		
		var thisGallery = j(this);
		var galleryWrapWidth = thisGallery.width();
		var thumbsToFit = Math.floor(galleryWrapWidth / 140);
		var totalThumbWidth = thumbsToFit * 140;
		var leftOverWidth = galleryWrapWidth - totalThumbWidth;
		var addToThumbWidth = Math.floor(leftOverWidth / thumbsToFit);
		var totalThumbSize = addToThumbWidth + 130;
		var newWrapHeight = (totalThumbSize * 2) + 10;
		thisGallery.find('.gallery-item').width(totalThumbSize).height(totalThumbSize);
		thisGallery.height(newWrapHeight);
		
		resetGalleryPager(thisGallery,thumbsToFit,newWrapHeight);
	
	});
	
}

/* /// END - FUNCTIONS - GALLERY /// */



/* FUNCTIONS - RESIZE THE "CHOSEN" STYLE DROPDOWNS						*/
/* -------------------------------------------------------------------- */
function resizeChosenWidths(){
	j('form.styled').each(function(){
		j(this).find('.chzn-container').width('100%');
		var containerWidth = j(this).find('.chzn-container').width();
		j(this).find('.chzn-drop').width(containerWidth - 2);
		var searchWidth = j(this).find('.chzn-search').width();
		j(this).find('.chzn-search input').width(searchWidth - 26);
	});
}

/* /// END - FUNCTIONS - RESIZE THE "CHOSEN" STYLE DROPDOWNS /// */