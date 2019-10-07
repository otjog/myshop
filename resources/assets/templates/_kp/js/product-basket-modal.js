import Ajax from './ajax';

export default function ShopBasket(){

    let module = 'basket';
    let formClass   = 'shop-buy-form';
    let moduleClass = 'shop-module-basket';
    let buttonGroupClass = 'shop-basket-button-group';
    let ajaxMethod  = 'POST';
    let ajaxHeaders = {};
    let qsParams = {};

    this.initQuantityButton = function ()
    {
        initQuantityButton();
    };
    this.initAjaxSubmitAllForms = function ()
    {
        initAjaxSubmitAllForms();
    };

    function addProductToBasket(form, qsParams)
    {
        let ajaxName    = 'shop-basket-add_product';
        let queryString = '';
        qsParams.response = 'json';
        qsParams.name = 'add_product';

        /* Получим данные всех input формы, добавим свои данные для аякс и отправим их. */
        let formInputs = form.getElementsByTagName('input');

        //todo сделать проверку на input class btn
        for (let i = 0; i < formInputs.length; i++) {
            if (formInputs[i].hasAttribute('name') !== false)
                qsParams[formInputs[i].name] = formInputs[i].value;
        }

        queryString = getQueryStringFromObject(qsParams, queryString);

        sendRequest(ajaxName, queryString, function(response){
            let htmlReload = document.getElementsByClassName(moduleClass)[0];
            updateHtml('module', 'default', htmlReload, function(htmlReload){});

            htmlReload = form.closest('.' + buttonGroupClass);
            updateHtml('buy-button', 'category-button-block', htmlReload, function(htmlReload){
                let forms = htmlReload.getElementsByClassName(formClass);

                initAjaxSubmitListForms(forms);
            });

        });


    }

    function updateHtml(name, view, htmlReload, func)
    {
        let ajaxName    = 'shop-basket-update_html_' + name;
        let queryString = '';
        qsParams.response = 'view';
        qsParams.view = view;
        qsParams.name = 'update_html_' + name;

        queryString = getQueryStringFromObject(qsParams, queryString);

        sendRequest(ajaxName, queryString, function(response){
            htmlReload.innerHTML = String(response);
            func(htmlReload);
        });

    }

    function sendRequest(ajaxName, queryString, func)
    {
        let ajaxReq = new Ajax(ajaxMethod, queryString, ajaxHeaders, ajaxName);

        //todo проверить, если объекта нет, делать submit формы
        ajaxReq.req.onreadystatechange = function()
        {
            if (ajaxReq.req.readyState !== 4) return;

            func(ajaxReq.req.responseText);
        };

        ajaxReq.sendRequest();

    }

    function getQueryStringFromObject(object, queryString)
    {
        for (let parameter in object) {

            if (queryString !== '')
                queryString += '&';

            queryString += parameter + '=' + object[parameter];
        }

        return queryString;
    }

    function initAjaxSubmitAllForms()
    {
        let forms = document.getElementsByClassName(formClass);

        if (forms !== null && forms !== undefined) {

            for (let i = 0; i < forms.length; i++) {
                initAjaxSubmitOneForm(forms[i])
            }
        }
    }

    function initAjaxSubmitListForms(forms)
    {
        if (forms !== null && forms !== undefined) {

            for (let i = 0; i < forms.length; i++) {
                initAjaxSubmitOneForm(forms[i])
            }
        }
    }

    function initAjaxSubmitOneForm(form)
    {
        console.log(form);
        /**
         * Перехватываем отправку формы и отменяем её.
         */
        form.addEventListener('submit', function(event)
        {
            event.preventDefault();

            qsParams = {
                'module' : module,
            };

            /*добавялем в корзину 1ед текущего товара*/
            addProductToBasket(form, qsParams);

        });
    }

    function initQuantityButton()
    {
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
                                changeQuantity(e, buttonIndex, quantity)
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

        for (let inputIndex = 0; inputIndex < quantity.inputs.length; inputIndex++) {

            if (quantity.inputs[inputIndex].dataset.ajax) {
                quantity.inputs[inputIndex].addEventListener('click', function(e){

                    addProductToBasket(quantity.form);
                });
            }

        }
    }

    function changeQuantity(e, buttonIndex, quantity)
    {
        let target = e.target;

        if(target.tagName === 'I'){
            target = target.parentElement;

        }

        if (target.classList.contains('quantity_inc')) {
            ++quantity.inputs[buttonIndex].value;
        } else if(target.classList.contains('quantity_dec')){

            let minValue = target.dataset.quantityMinValue;

            if(quantity.inputs[buttonIndex].value > minValue)
                --quantity.inputs[buttonIndex].value;
        }
    }
}