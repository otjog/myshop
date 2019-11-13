import Ajax from './ajax';

export default function ProductFilter()
{
    let ajaxHeaders = {};

    this.initAjaxSubmitForm = function ()
    {
        initAjaxActionElements();
    };

    this.initProductFilter = function()
    {
        /*****************************************************
         Product Filter (Скорее всего не оптимизированный код)
         *****************************************************/
        let sliders = $('.filter-slider');

        $('.filter-slider .slider-show').css('display', 'block');

        for(let i = 0; i < sliders.length; i++){
            let values = getValues(sliders[i]);

            getSliderShow(sliders[i]).slider({
                range: true,
                min: values.range[0],
                max: values.range[1],
                values: [values.value[0], values.value[1]],
                slide: function(e, ui) {
                    changeInputValue([ui.handleIndex], [ui.value], $(ui.handle.parentNode).closest('.filter-slider')[0]);
                }
            });
        }

        $('input[data-filter-type=slider]').on('change', function(e){
            console.log(1);
            e = e || event;
            var slider = $(e.target).closest('.filter-slider')[0];
            var values = getValues(slider);
            if($.isNumeric(Number(e.target.value))){
                if(values.value[0] > values.value[1]){
                    if(values.value[0] > values.range[1]){
                        values.value[0] = values.range[1];
                        values.value[1] = values.range[1];
                        changeInputValue([0,1], [values.range[1], values.range[1]], slider);
                    }else if(values.value[1] < values.range[0]){
                        values.value[1] = values.value[0];
                        changeInputValue([1], [values.value[0]], slider);
                    }else{
                        values.value[1] = values.value[0];
                        changeInputValue([1], [values.value[0]], slider);
                    }
                }else if(values.value[0] < values.range[0]){
                    values.value[0] = values.range[0];
                    changeInputValue([0], [values.range[0]], slider);
                }else if(values.value[1] > values.range[1]){
                    values.value[1] = values.range[1];
                    changeInputValue([1], [values.range[1]], slider);
                }
            }else{
                var index = e.target.dataset.filterSliderInputIndex;
                values.value[index] = values.range[index];
                changeInputValue([index], [values.range[index]], slider);
            }
            changeSliderValue(values.value, slider);
        });

        function getValues(slider){
            var inputs = getInputs(slider);
            var inputsValue = {'value':[], 'range':[]};
            for(var i = 0; i < inputs.length ;i++){
                inputsValue.value[i] = Number(inputs[i].value);
                if(inputs.length === 1) break;
                //todo проверить работоспособность break
            }
            inputsValue.range[0] = Number(inputs[0].min);
            inputsValue.range[1] = Number(inputs[0].max);

            return inputsValue;
        }

        function getInputs(slider){
            return $(slider).find('input[data-filter-type=slider]');
        }

        function getSliderShow(slider){
            return $(slider).find('.slider-show');
        }

        function changeInputValue(index, values, slider){
            var inputs = getInputs(slider);
            for(var i = 0; i < index.length; i++){
                inputs[index[i]].value = values[i];
            }
        }

        function changeSliderValue(values, slider){
            getSliderShow(slider).slider("values", values);
        }


        /*Очистка фильтра. Для каждого типа фильтра */
        $('.filter-clear').css('display', 'inline').on('click', function(e) {

            let filter = e.target.closest('.filter');

            if (filter !== null && filter !== undefined) {
                clearOneFilter(filter);
            } else {
                let filterWrap = e.target.closest('.product-filter');
                let filters = $(filterWrap).find('.filter');
                for (let i = 0; i < filters.length; i++) {
                    clearOneFilter(filters[i]);
                }
            }
        });

        function clearOneFilter(filter)
        {
            let inputs = $(filter).find('[data-filter-type]');

            for(let i = 0; i < inputs.length; i++){

                switch(inputs[i].type){
                    case 'checkbox' :
                        if(inputs[i].checked === true){
                            inputs[i].checked = false;
                        }
                        break;

                    case 'text' :
                        if(inputs[i].dataset.filterType === 'slider'){
                            let values = [];
                            values[0] = inputs[i].min;
                            values[1] = inputs[i].max;
                            changeInputValue([0, 1], values, filter);
                            changeSliderValue(values, filter);
                        }else{
                            inputs[i].value = '';
                        }
                        break;
                    case 'select':
                    case 'select-multiple':
                        let options = inputs[i];
                        for(let i = 0; i < options.length; i++){
                            if(options[i].selected === true){
                                options[i].selected = false;
                            }
                        }
                        break;
                }

            }
        }
    };

    function initAjaxActionElements(className)
    {
        if (className === null || className === undefined)
            className = '';
        else
            className = '.' + className + ' ';

        let actionElements = document.querySelectorAll(className + '[data-ajax]');

        for (let i = 0; i < actionElements.length; i++) {
            let eventName = actionElements[i].getAttribute('data-ajax-event-name');
            catchEvent(actionElements[i], eventName);
        }
    }

    function catchEvent(actionElement, eventName)
    {
        /**
         * Перехватываем и отменяем (отправку формы или переход по ссылке)
         */
        actionElement.addEventListener(eventName, function(event)
        {
            event.preventDefault();
            onRouteController(actionElement);
        });
    }

    function onRouteController(actionElement)
    {
        let formParameters = getFormParameters(actionElement);

        let fullUrl = getFullUrl(actionElement);

        let ajaxPath    = getPath(fullUrl, actionElement);

        let queryString = getQueryStringFromHref(fullUrl);

        queryString = getQueryStringFromObject(formParameters, queryString);

        let dataset     = actionElement.dataset;

        let htmlReload  = document.getElementsByClassName(dataset.ajaxReloadClass)[0];

        sendRequest (dataset.ajaxName, dataset.ajaxMethod, queryString, ajaxPath, htmlReload, function(response) {
            htmlReload.innerHTML = String(response);
            initAjaxActionElements(dataset.ajaxReloadClass);
        });

    }

    function sendRequest(ajaxName, ajaxMethod, queryString, path, htmlReload, func)
    {
        let ajaxReq = new Ajax(ajaxMethod, queryString, ajaxHeaders, ajaxName, path);

        ajaxReq.req.onloadstart = function()
        {
            onloadstart(htmlReload);
        };

        //todo проверить, если объекта нет, делать submit формы
        ajaxReq.req.onreadystatechange = function()
        {
            if (ajaxReq.req.readyState !== 4) return;

            func(ajaxReq.req.responseText);

            onloadend(htmlReload);
        };

        ajaxReq.sendRequest();

        history.pushState('', '', '?' + queryString);


    }

    function getQueryStringFromHref(fullUrl)
    {
        let locationArray = fullUrl.split('?');

        /**
         * Мы не кодируем строку с помощью encodeURI,
         * т.к. ожидаем, что она уже приходит закодированной.
         */
        return (locationArray[1] !== undefined) ? locationArray[1] : '';

    }

    function getQueryStringFromObject(object, queryString)
    {
        for (let parameter in object) {
            if(object.hasOwnProperty(parameter)){

                if (queryString !== '')
                    queryString += '&';

                queryString += parameter + '=' + encodeURIComponent(object[parameter]);

            }
        }

        return queryString;
    }

    function getFormParameters(form)
    {
        let formParameters = {};
        /* Получим данные всех input формы, добавим свои данные для аякс и отправим их. */
        let formInputs = form.getElementsByTagName('input');

        //todo сделать проверку на input class btn
        for (let i = 0; i < formInputs.length; i++) {
            if (formInputs[i].hasAttribute('name') !== false) {

                let type = formInputs[i].getAttribute('type');

                switch (type) {
                    case 'checkbox' :
                        if (formInputs[i].checked) {
                            formParameters[formInputs[i].name] = formInputs[i].value;
                        }
                        break;
                    case 'text' :
                        formParameters[formInputs[i].name] = formInputs[i].value;
                        break;
                }
            }
        }

        return formParameters;
    }

    function getPath(fullUrl, actionElement)
    {
        let locationArray = fullUrl.split('?');

        let viewpath = '/views/' + actionElement.dataset.ajaxView;

        return locationArray[0] + viewpath;
    }

    function getFullUrl(actionElement)
    {
        if (actionElement.hasAttribute('action')) {
            return actionElement.getAttribute('action')
        } else if(actionElement.hasAttribute('href')) {
            return actionElement.getAttribute('href')
        }
    }

    function onloadstart(htmlReload)
    {

        htmlReload.style.opacity = 0.25;

        let spinners = htmlReload.getElementsByClassName('spinner-border');

        for (let i = 0; i < spinners.length; i++) {
            spinners[i].style.display = 'block';
        }

        let step, length;

        step = length = -75;

        let coordinates = htmlReload.getBoundingClientRect();

        let int = setInterval(function() {
            window.scrollBy(0, step);
            length += step;
            if (length <= (coordinates.y - 100))
                clearInterval(int);
        }, 20);



    }

    function onloadend(htmlReload)
    {
        let spinners = htmlReload.getElementsByClassName('spinner-border');

        for (let i = 0; i < spinners.length; i++) {
            spinners[i].style.display = 'none';
        }

        htmlReload.style.opacity = 1.0;
    }
}