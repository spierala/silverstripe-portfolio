(function(){
    var isotope;
    var projectDataArray = [];
    var initIdArray = []; //holding original order of project ids
    var currentSlug = "";
    var currentName = "";
    var currentPageID = 0;
    var $images;
    var $projectContainer = $('#projects-page--ajax');
    var projectContainerVisible = false;
    var title = document.title;
    var isMobile = false;
    
    
    if($(window).width()<560){
        isMobile = true;
    }
    
    init();
        
    function init(){    
        initListeners();
        initDeepLinking();
        $('.projects-page--project').each(function(){
            var project = {};
            project.id = $(this).data('pageid');
            project.title = $(this).attr('title');
            project.categories = $(this).data('categories');
            projectDataArray.push(project);
            $(this).find('.project-preview-text').css("visibility", "hidden");
        });   
        //$projectContainer.hide();
        
        initIdArray = getIdArray(); //for reset
        
        initIsotope();   
        updateProjectListeners();
    }
    
    function initDeepLinking(){        
        $.address.change(function(event) {  
            if(event.parameters.category){
                closeProjectContainer();
                var slug = event.parameters.category;
                updateCurrentSlug(slug);
                var name = $(".category-link[data-slug='" + currentSlug + "']").data("name");
                $.address.title(name + " " + pageTitle); //pagetitle is set in Page.ss
            }
            if(event.parameters.page){
                var pageid = event.parameters.page;
                $project = $(".projects-page--project[data-pageid='" + pageid + "']");
                var projectTitle = $project.attr("title");
                $.address.title(projectTitle + " " + pageTitle);
                loadProject($project);
            }
        });  
        
        //set the category "all" on app start,  
//        $.address.externalChange(function(event){
//            if(!event.parameters.category){
//                $.address.value("?category=all");
//            }
//        });  
    }
    
    function initListeners(){                    
        $(window).resize(function() {
            if(this.resizeTO) {
                clearTimeout(this.resizeTO);  
               // resizeIsotope();
            }
            this.resizeTO = setTimeout(function() {
                resizeReadyIsotope();
            }, 500);           
        });

        $(".projects-page--project").click(function(){
            onProjectClick($(this));
        });
    }
    
    function removeListeners(){
        $(window).unbind("resize");
    }
    
    function updateProjectListeners(){
        if(isMobile!=true){
            $('.projects-page--project').unbind("mouseenter");
            $('.projects-page--project').not('.knockout').mouseenter(function(){
                onProjectMouseOver($(this));
            });

            $('.projects-page--project').mouseleave(function(){
                onProjectMouseOut($(this));
            });
        }
    }
       
    function onProjectMouseOver($project){
        $project.addClass("mouseover");
        $project.find('.project-preview-text').css("visibility", "visible");
        var $image = $project.find("img");
        var $previewText = $project.find(".project-preview-text");
        $image.animate({top: -83}, 300, ANIMATION.easeOutQuart);
        $previewText.animate({bottom: -$previewText.height()+83}, 300, ANIMATION.easeOutQuart);
    }
    
    function onProjectMouseOut($project){  
        $project.find('.project-preview-text').css("visibility", "hidden");
        var $image = $project.find("img");
        var $previewText = $project.find(".project-preview-text");
        $image.animate({top: 0}, 100, ANIMATION.easeOutQuart);
        $previewText.animate({bottom: 0}, 100, function(){$project.removeClass("mouseover");});
    }

    function onProjectClick($project){
        loadProject($project);
    }
    
    //AJAX STUFF
    function loadProject($project){
        var pageID = $project.data("pageid");
        if(currentPageID!=pageID){
            currentPageID = pageID;
            var absoluteLink = $project.data("absolutelink");
            var link = absoluteLink+"ajax";
            $projectContainer.load(link, onProjectAjaxComplete);
        }
    }
    
    function onProjectAjaxComplete(){
        initAjaxListeners();
        $imagesContainer = $(".project-page .images-container");
        $imagesContainer.hide();
        $projectContainer.slideDown(500, "swing", function(){
            window.scrollTo(0, 0);
        });
        showImages();
    }
    
    function showImages(){      
        var imagesLoaded = 0;    
        var numberOfImages = $imagesContainer.find("img").length;
        
        $imagesContainer.find("img").load(function(){  
            if(imagesLoaded == numberOfImages-1){ 
                $imagesContainer.show();
                var width = "-" + $imagesContainer.width().toString()  + "px";
                var cssObj = {
                    "left": width
                }
                $imagesContainer.css(cssObj); 
                $imagesContainer.animate({left: 0}, 500, function(){
                    ProjectPage.initProjectPage();
                });
            }
            imagesLoaded++;
        });
    } 
    
    function initAjaxListeners(){
        $('a.btn-close, a.btn-all').click(function(e){
             closeProjectContainer();
             currentPageID = 0;
             e.preventDefault();
        });
        $('a.btn-prev, a.btn-next').click(function(e){
            $.address.value("?page="+$(this).data("id"));
            e.preventDefault();
        });
    }
    
    //SORT/FILTER
    function updateCurrentSlug(slug){
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
    
    function sortByTitle(a, b) {
        return a.title.localeCompare(b.title);
    }
    
    function sortByCategory(a, b){
        if(checkA()<checkB()){
            return 1;
        }
        if(checkA()>checkB()){
            return -1;
        }
        function checkA(){
            for(var i=0; i<a.categories.length; i++){
                 var category = a.categories[i];
                 if(category == currentSlug){
                     return 1;
                 }
            }
            return 0;
        }
        function checkB(){
            for(var i=0; i<b.categories.length; i++){
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
    function filterProjectsByCategory(){
        var activeIdArray = [];
        $('.projects-page--project').each(function(){
            var categories = $(this).data('categories');
            var id = $(this).data('pageid');
            for(var i=0; i<categories.length; i++){
                var category = categories[i];
                if(category==currentSlug){
                    if(idAlreadyExists(id)!=true){
                        activeIdArray.push(id);
                    }
                }
            }
        });
        
        function idAlreadyExists(id){
            for(var j=0; j<activeIdArray.length; j++){
                if(activeIdArray[j] == id){
                    return true;
                }
            }
        }        
        knockout(activeIdArray);
    }
      
    function knockout(activeIdArray){
        $('.projects-page--project').each(function(){
            $(this).addClass("knockout");
            var id = $(this).data('pageid');
            for(var j=0; j<activeIdArray.length; j++){
                if(activeIdArray[j] == id){
                    $(this).removeClass("knockout");
                }
            }
        });
        updateProjectListeners();
    }
    
    function reset(){
        $('.projects-page--project').each(function(){
            $(this).removeClass("knockout");
        });
        resetIsotope();  
    }
    
    //MENU
    function updateMenu(){
        var $menuItem = $(".category-link[data-slug='" + currentSlug + "']").parent();
        $('.current').removeClass('current'); //update menu visually
        $menuItem.addClass("current");
    }
    
    //ISOTOPE
    function initIsotope(){
        isotope = new Isotope();
        isotope.updateIdArray(initIdArray);
        resizeIsotope();
      //  resizeReadyIsotope();
    }
    
    function resetIsotope(){  
        isotope.updateIdArray(initIdArray);
        isotope.reposition();
    }
    
    function updateIsotope(){
        removeListeners();
        isotope.updateIdArray(getIdArray());
        isotope.reposition(initListeners);
    }
    
    function resizeIsotope(){
        isotope.updateImgWidth();
        isotope.position();
    }
    
    function resizeReadyIsotope(){
        isotope.updateImgWidth();
        isotope.reposition();
    }
    
    function getIdArray(){
        var idArray = [];
        for(var i=0; i<projectDataArray.length; i++){
            idArray.push(projectDataArray[i].id);
        }
        return idArray;
    }
    
    //ANIMATION
    function closeProjectContainer(){
        window.scrollTo(0, 0);
        $projectContainer.slideUp(function(){
            projectContainerVisible = false;
        });
    }
    
    var ANIMATION = {
        easeOutQuart: function (x, t, b, c, d) {
            return -c * ((t=t/d-1)*t*t*t - 1) + b;
        }
    }
})();



