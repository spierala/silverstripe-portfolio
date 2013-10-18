(function(window){
    var ANIMATION = {
        easeOutQuart: function (x, t, b, c, d) {
            return -c * ((t=t/d-1)*t*t*t - 1) + b;
        }
    }
    
    Array.min = function( array ){
        return Math.min.apply( Math, array );
    };
    
    var $allItems = $('.isotope');
    var $allImages = $('.isotope img');
    var $itemsHolder = $(".isotope-holder");
    var $itemsContainer = $(".isotope-container");
    
    var gap = 0;

    function Isotope(){   
        $firstItem = $('.isotope img').first();
        this.idArray = [];
        this.itemWidth = $firstItem.width();
        this.itemHeight = $firstItem.height();
        this.width = 0;
        this.positionArray = [];
                
        this.init();
    }

    Isotope.prototype.init = function(){
        var idArray = [];
        $itemsContainer.addClass("iso");
        this.width = $itemsHolder.width();
        $allItems.each(function(){
            idArray.push($(this).data("pageid"));
            $(this).addClass("iso"); //position absolute
        });
        //this.updateIdArray(idArray);
    };
    
    Isotope.prototype.updateIdArray = function(array){
        this.idArray = array;
    }

    Isotope.prototype.updatePositionArray = function(){     
        var xpos = 0;
        var ypos = 0;

        this.positionArray = getPositionData(this);
        function getPositionData(context){
            var retArray = [];
            var rowCount = 1;
            $allItems.each(function(){
                retArray.push({
                    x:xpos, 
                    y:ypos
                });
                xpos += context.itemWidth + gap;
                if(xpos > (context.width - context.itemWidth)+20){ //(context.width - context.itemWidth)
                    xpos = 0;
                    ypos +=  context.itemHeight + gap;
                    rowCount++;
                }
            });
            var height = rowCount * context.itemHeight + gap;
            $(".projects-page--projects-container.iso").height(height);
            return retArray;
        }
    };

    Isotope.prototype.reposition = function(onReadyFunction){
        this.updatePositionArray();
        var animations = [];
        for(var i = 0; i< this.idArray.length; i++){
            var $item = $itemsContainer.find("[data-pageid='" + this.idArray[i] + "']");
            var pos = this.positionArray[i];
            $item.stop().animate({
                left: pos.x, 
                top:pos.y
            }, 500);
        }   
        if(onReadyFunction){
            $(".project:animated").promise().done(function() {
                onReadyFunction();
            });
        }
    };
    
    Isotope.prototype.position = function(){
        this.updatePositionArray();
        for(var i = 0; i< this.idArray.length; i++){
            var $item = $itemsContainer.find("[data-pageid='" + this.idArray[i] + "']");
            var pos = this.positionArray[i];
            var cssObj = {
                    "left": pos.x, 
                    "top": pos.y
                }
            $item.css(cssObj); 
        }   
    };

//    Isotope.prototype.onResizeReady = function(){
//        this.width = $itemsHolder.width();
//        this.updatePositionArray();
//        this.reposition();
//    };
    
    Isotope.prototype.updateImgWidth = function(){  
        this.width = $itemsHolder.width();
        
        var min = 180;
        var max = 360;
        var imageRatio = 4/3;
        
        var maxRatio = this.width/max; // eg. (1000/360 = 2,77) => 3 cols can be displayed with less then 360px width/col
        
        var maxInteger = Math.ceil(maxRatio); // 2,77 => 3
        
        var imageWidth = Math.round(this.width/maxInteger); //width per column or image 1000/3 = 333,33;
        if(imageWidth<min){
            imageWidth = min;
        }               
        $allImages.each(function(){
            $(this).width(imageWidth);
        });
        
        this.itemWidth =  imageWidth;
        this.itemHeight =  imageWidth/imageRatio;
        $('.project-content').width(this.itemWidth);
        $('.project-content').height(this.itemHeight);
    };
           
    window.Isotope = Isotope;
        
}(window));