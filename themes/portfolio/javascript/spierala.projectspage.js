(function(){
    var isotope,
        projectDataArray = [],
        initIdArray = [], //holding original order of project ids
        currentSlug = "",
        currentPageID = 0,
        $projectContainer = $('#projects-page--ajax'),
        $animationContainer,
        $imagesContainer,
        animationDirection = -1,
        projectContainerVisible = false,
        title = document.title,
        isMobile = false;

    if($(window).width()<560) {
        isMobile = true;
    }

    $('.projects-page--project').each(function(){
        var project = {};
        project.id = $(this).data('pageid');
        project.title = $(this).attr('title');
        project.categories = $(this).data('categories');
        projectDataArray.push(project);
        $(this).find('.project-preview-text').css("visibility", "hidden");
    });

    initIdArray = getIdArray(); //for reset

    initListeners();
    initDeepLinking();
    initIsotope();
    updateProjectListeners();

    
    function initDeepLinking() {
        var slug,
            name,
            pageid,
            projectTitle;
        $.address.change(function(event) {  
            if(event.parameters.category){
                closeProjectContainer();
                slug = event.parameters.category;
                updateCurrentSlug(slug);
                name = $(".category-link[data-slug='" + currentSlug + "']").data("name");
                $.address.title(name + " " + pageTitle); //pagetitle is set in Page.ss
            }
            if(event.parameters.page) {
                pageid = event.parameters.page;
                $project = $(".projects-page--project[data-pageid='" + pageid + "']");
                projectTitle = $project.attr("title");
                $.address.title(projectTitle + " " + pageTitle);
                loadProject($project);
            }
        });
    }
    
    function initListeners() {
        $(window).resize(function() {
            if(this.resizeTO) {
                clearTimeout(this.resizeTO);
            }
            this.resizeTO = setTimeout(function() {
                resizeReadyIsotope();
            }, 500);           
        });

        $(".projects-page--project").click(function() {
            onProjectClick($(this));
        });
    }
    
    function removeListeners() {
        $(window).unbind("resize");
    }
    
    function updateProjectListeners() {
        if(isMobile!=true) {
            $('.projects-page--project').unbind("mouseenter");
            $('.projects-page--project').not('.knockout').mouseenter(function(){
                onProjectMouseOver($(this));
            });

            $('.projects-page--project').mouseleave(function() {
                onProjectMouseOut($(this));
            });
        }
    }
       
    function onProjectMouseOver($project) {
        var $image = $project.find("img"),
            $previewText = $project.find(".project-preview-text");
        $project.addClass("mouseover");
        $project.find('.project-preview-text').css("visibility", "visible");
        $image.animate({top: -83}, 300, ANIMATION.easeOutQuart);
        $previewText.animate({bottom: -$previewText.height()+83}, 300, ANIMATION.easeOutQuart);
    }
    
    function onProjectMouseOut($project) {
        var $image = $project.find("img"),
            $previewText = $project.find(".project-preview-text");
        $project.find('.project-preview-text').css("visibility", "hidden");
        $image.animate({top: 0}, 100, ANIMATION.easeOutQuart);
        $previewText.animate({bottom: 0}, 100, function(){$project.removeClass("mouseover");});
    }

    function onProjectClick($project) {
        loadProject($project);
    }
    
    //AJAX
    function loadProject($project) {
        var pageID = $project.data("pageid"),
            absoluteLink = "",
            link = "";
        if(currentPageID!=pageID){ //prevent loading same content again
            currentPageID = pageID;
            absoluteLink = $project.data("absolutelink");
            link = absoluteLink+"ajax";
            $projectContainer.load(link, onProjectAjaxComplete);
        }
    }
    
    function onProjectAjaxComplete() {
        initAjaxListeners();
        $animationContainer = $(".project-page .animation-container");
        $imagesContainer = $(".project-page .images-container");
        $imagesContainer.hide();
        $projectContainer.slideDown(500, "swing", function(){
            window.scrollTo(0, 0);
        });
        showImages();
    }
    
    function showImages() {
        var imagesLoaded = 0,
            width,
            numberOfImages = $imagesContainer.find("img").length;
        $imagesContainer.find("img").load(function(){  
            if(imagesLoaded == numberOfImages-1){ 
                $imagesContainer.show();
                if(animationDirection == 1) {
                    width = $animationContainer.width().toString()  + "px";
                } else if (animationDirection == -1) {
                    width = "-" + $imagesContainer.width().toString()  + "px";
                }
                var cssObj = {
                    "left": width
                }
                $imagesContainer.css(cssObj); 
                $imagesContainer.animate({left: 0}, 500, function(){
                    ScrollMedia.init();
                });
            }
            imagesLoaded++;
        });
    } 
    
    function initAjaxListeners() {
        $('a.btn-close, a.btn-all').click(function(e) {
             closeProjectContainer();
             e.preventDefault();
        });
        $('a.btn-prev, a.btn-next').click(function(e) {
            switch($(this).attr('class')){
                case 'btn-prev':
                    animationDirection = -1;
                break;
                case 'btn-next':
                    animationDirection = 1;
                break;
            };
            $.address.value("?page="+$(this).data("id"));
            e.preventDefault();
        });
    }
    
    //SORT/FILTER
    function updateCurrentSlug(slug) {
        currentSlug = slug;
        updateMenu();
        if(slug=="all"){
            reset();
        }else{
            filterProjectsByCategory();
            projectDataArray.sort(sortByCategory);
            updateIsotope();
        }
    }
    
    function sortByCategory(a, b) {
        if(checkA()<checkB()){
            return 1;
        }
        if(checkA()>checkB()) {
            return -1;
        }
        function checkA() {
            for(var i=0; i<a.categories.length; i++){
                 var category = a.categories[i];
                 if(category == currentSlug){
                     return 1;
                 }
            }
            return 0;
        }
        function checkB() {
            for(var i=0; i<b.categories.length; i++) {
                 var category = b.categories[i];
                 if(category == currentSlug){
                     return 1;
                 }
            }
            return 0;
        }        
        return 0;
    }
    
    //KNOCKOUT
    function filterProjectsByCategory() {
        var activeIdArray = [],
            categories,
            id;
        $('.projects-page--project').each(function() {
            categories = $(this).data('categories');
            id = $(this).data('pageid');
            for(var i=0; i<categories.length; i++) {
                var category = categories[i];
                if(category==currentSlug){
                    if(idAlreadyExists(id)!=true) {
                        activeIdArray.push(id);
                    }
                }
            }
        });
        
        function idAlreadyExists(id){
            for(var i=0; i<activeIdArray.length; i++) {
                if(activeIdArray[i] == id){
                    return true;
                }
            }
        }        
        knockout(activeIdArray);
    }
      
    function knockout(activeIdArray) {
        $('.projects-page--project').each(function() {
            $(this).addClass("knockout");
            var id = $(this).data('pageid');
            for(var i=0; i<activeIdArray.length; i++) {
                if(activeIdArray[i] == id) {
                    $(this).removeClass("knockout");
                }
            }
        });
        updateProjectListeners();
    }
    
    function reset() {
        $('.projects-page--project').each(function() {
            $(this).removeClass("knockout");
        });
        resetIsotope();  
    }
    
    //MENU
    function updateMenu() {
        var $menuItem = $(".category-link[data-slug='" + currentSlug + "']").parent();
        $('.current').removeClass('current'); //update menu visually
        $menuItem.addClass("current");
    }
    
    //ISOTOPE
    function initIsotope() {
        isotope = new Isotope();
        isotope.updateIdArray(initIdArray);
        resizeIsotope();
      //  resizeReadyIsotope();
    }
    
    function resetIsotope() {
        isotope.updateIdArray(initIdArray);
        isotope.reposition();
    }
    
    function updateIsotope(){
        removeListeners();
        isotope.updateIdArray(getIdArray());
        isotope.reposition(initListeners);
    }
    
    function resizeIsotope() {
        isotope.updateImgWidth();
        isotope.position();
    }
    
    function resizeReadyIsotope() {
        isotope.updateImgWidth();
        isotope.reposition();
    }
    
    function getIdArray() {
        var idArray = [];
        for(var i=0; i<projectDataArray.length; i++) {
            idArray.push(projectDataArray[i].id);
        }
        return idArray;
    }
    
    //ANIMATION
    function closeProjectContainer() {
        currentPageID = 0; // reset to allow content load again
        window.scrollTo(0, 0);
        $projectContainer.slideUp(function() {
            projectContainerVisible = false;
        });
    }
    
    var ANIMATION = {
        easeOutQuart: function (x, t, b, c, d) {
            return -c * ((t=t/d-1)*t*t*t - 1) + b;
        }
    }
})();



