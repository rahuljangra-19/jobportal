$(document).ready(function(){

    /**Tabs */
    jQuery('.tabs ul li:first-child').click(function(){
        jQuery(this).addClass('active').siblings().removeClass('active'); 
        jQuery('#category-one').addClass('active').siblings().removeClass('active'); 
    });
    jQuery('.tabs ul li:nth-child(2)').click(function(){
        jQuery(this).addClass('active').siblings().removeClass('active'); 
        jQuery('#category-two').addClass('active').siblings().removeClass('active'); 
    });
    jQuery('.tabs ul li:nth-child(3)').click(function(){
        jQuery(this).addClass('active').siblings().removeClass('active'); 
        jQuery('#category-three').addClass('active').siblings().removeClass('active'); 
    });
    jQuery('.tabs ul li:nth-child(4)').click(function(){
        jQuery(this).addClass('active').siblings().removeClass('active'); 
        jQuery('#category-four').addClass('active').siblings().removeClass('active'); 
    });

    /**Carousels */
    $(".testimonail-carousel").owlCarousel({
        loop: true,
        margin: 20,
        nav: true,
        dots: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });
    $(".barnd-carousel").owlCarousel({
        loop: true,
        autoplay: true,
        autoplayTimeout: 3000,
        margin: 20,
        nav: false,
        dots: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 6
            }
        }
    });
    
    $('.salary label:nth-child(1)').click(function(){
        $('#fixed_salary').addClass('show').siblings().removeClass('show');
    });
    $('.salary label:nth-child(2)').click(function(){
        $('#salary_range').addClass('show').siblings().removeClass('show');
    });
    $('.salary label:nth-child(3)').click(function(){
        $('.extra-fields .conditional-field').removeClass('show');
    });
});