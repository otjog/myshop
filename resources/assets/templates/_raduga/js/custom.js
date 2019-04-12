//MAGNIFIC POPUP
$(document).ready(function() {
    $('.images-block').magnificPopup({
        delegate: 'a', 
        type: 'image',
        gallery: {
        enabled: true
        }
    });
});

(function($) {

    "use strict";

    // TOOLTIP	
	$(".header-links .fa, .tool-tip").tooltip({
        placement: "bottom"
    });
    $(".btn-wishlist, .btn-compare, .display .fa").tooltip('hide');

    // Product Owl Carousel
    $(".owl-carousel").owlCarousel({
        autoPlay: false, //Set AutoPlay to 3 seconds
        items : 3,
        stopOnHover : true,
        navigation : true, // Show next and prev buttons
        pagination : false,
        navigationText : ["<span class='fa fa-chevron-left'></span>","<span class='fa fa-chevron-right'></span>"]
    });

    // TABS
    $('.nav-tabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });	
	
})(window.jQuery);

//Quantity Button
let quantity = {
    'buttons': {
        'increment' : document.getElementsByClassName('quantity_inc'),
        'decrement' : document.getElementsByClassName('quantity_dec'),
        'delete'    : document.getElementsByClassName('quantity_del'),
        'update'    : document.getElementsByClassName('quantity_upd')
    },
    'inputs'    : document.getElementsByClassName('quantity_input'),
    'form'      : document.getElementById('basket_form')
};

for(let buttonsType in quantity.buttons){

    if(quantity.buttons.hasOwnProperty(buttonsType)){

        for( let buttonIndex = 0; buttonIndex < quantity.buttons[buttonsType].length; buttonIndex++){

            switch(buttonsType){
                case 'increment':
                case 'decrement':
                    quantity.buttons[ buttonsType ][ buttonIndex ].addEventListener('click', function(e){
                        e = e || event;
                        changeQuantity(e, buttonIndex)
                    });
                    break;
                case 'delete':
                    quantity.buttons[ buttonsType ][ buttonIndex ].addEventListener('click', function(e){
                        quantity.inputs[buttonIndex].value = 0;
                        quantity.form.submit();
                    });
                    break;
                case 'update':
                    quantity.buttons[ buttonsType ][ buttonIndex ].addEventListener('click', function(e){
                        //любая кнопка обновляет все товары
                        quantity.form.submit();
                    });
                    break;
            }

        }

    }

}

function changeQuantity(e, buttonIndex){

    let minValue = e.target.dataset.quantityMinValue;

    if ( e.target.classList.contains('quantity_inc')) {
        ++quantity.inputs[buttonIndex].value;
    } else if(e.target.classList.contains('quantity_dec')){
        if(quantity.inputs[buttonIndex].value > minValue)
            --quantity.inputs[buttonIndex].value;
    }
}
//END Quantity Button
