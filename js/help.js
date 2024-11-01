jQuery(document).ready(function(){


    formerOpen = '';
    mode = jQuery('#mode').val();
    jQuery('.accWidget > li > h2').each(function(){
        jQuery(this).siblings().wrap('<div class="accordion_content"></div>')       
    })
    .click(function(){
        if(mode == 'all'){
            if(jQuery(this).hasClass('on')){
                jQuery(this).addClass('off').removeClass('on');
                jQuery(this).siblings('div').hide('slow');    
            }
            else{
                jQuery(this).addClass('on').removeClass('off');
                jQuery(this).siblings('div').show('slow');    
            }
        }
        else{
            if(jQuery(this).hasClass('on')){
                jQuery(this).addClass('off').removeClass('on');
                jQuery(this).siblings('div').hide('slow');    
            }
            else{
                jQuery(this).addClass('on').removeClass('off');
                jQuery(this).siblings('div').show('slow');    
            }
            if(formerOpen && formerOpen.html() != jQuery(this).html()){
                
                formerOpen.addClass('off').removeClass('on'); 
                formerOpen.siblings('div').hide('slow');
            }    
        }
        formerOpen = jQuery(this);
        
    })
    jQuery('.accordion_content').hide();
    jQuery('.accWidget').css({
        display: 'block'
    });
    
    def = jQuery('#default').val(); 
    if(def == 'one'){
        jQuery('.accWidget > li').each(function(x){
            if(!x){  
                jQuery(this).find('h2').addClass('on');
                jQuery(this).find('div').show(); 
                if(mode == 'one'){
                    formerOpen = jQuery(this).find('h2');
    
                }
            }
            
        })        
    }
})