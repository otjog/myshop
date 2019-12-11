import Ajax from './ajax';

export default function ProductFilter()
{
    let ajaxHeaders = {};

    let ajaxAfterRequestCount;

    this.initAjaxModules = function ()
    {
        initAjaxActionElements();
    };

    function initAjaxActionElements(htmlReload)
    {
        if (htmlReload === null || htmlReload === undefined)
            htmlReload = document;

        let actionElements = htmlReload.querySelectorAll('[data-ajax]');

        for (let i = 0; i < actionElements.length; i++) {
            let eventName = actionElements[i].getAttribute('data-ajax-event-name');

            /**
             * Перехватываем и отменяем (отправку формы или переход по ссылке)
             */
            catchEvent(actionElements[i], eventName);

            /**
             * Запуск Ajax при изменении любого input
             */
            sendRequestAfterChangeInput(actionElements[i]);

            /**
             * Инициализиуем кнопки очистки формы
             */
            sendRequestAfterClearFilter(actionElements[i]);

            /**
             * Инициализируем слайдеры фильтра
             */
            initSlider(actionElements[i]);
        }
    }

    function catchEvent(actionElement, eventName)
    {
        actionElement.addEventListener(eventName, function(event)
        {
            ajaxAfterRequestCount = 1;
            event.preventDefault();
            onRouteController(actionElement, event);

        });

    }

    function sendRequestAfterChangeInput(actionElement)
    {
        let textInputs = actionElement.querySelectorAll('input:not([type=hidden])');

        for (let i = 0; i < textInputs.length; i++) {
            textInputs[i].addEventListener('change', function (event) {
                onRouteController(actionElement, event);
            })
        }
    }

    function sendRequestAfterClearFilter(actionElement)
    {
        let filterClears = actionElement.getElementsByClassName('filter-clear');

        for (let i = 0; i < filterClears.length; i++) {

            /**/
            if(filterClears[i].tagName !== 'A' && filterClears[i].tagName !== 'BUTTON' ) {
                filterClears[i].style.display = 'inline';
                filterClears[i].addEventListener('click', function (event) {

                    /*старый участок кода*/
                    let filter = event.target.closest('.filter');

                    if (filter !== null && filter !== undefined)
                        clearOneFilter(filter);

                    onRouteController(actionElement, event);
                });
            } else {
                filterClears[i].addEventListener('click', function (event) {
                    let filters = actionElement.getElementsByClassName('filter');

                    for (let i = 0; i < filters.length; i++)
                        clearOneFilter(filters[i]);
                });
            }

        }
    }

    function onRouteController(actionElement, event, pf)
    {
        let formParameters = {};

        if (pf === undefined) {
            pf = '';
            formParameters = getFormParameters(actionElement)
        }

        let dataset = actionElement.dataset;

        let pushState = dataset.ajaxPushState;

        let fullUrl = getFullUrl(actionElement, pf);

        let ajaxPath = getPath(fullUrl, dataset['ajaxView'+pf]);

        let queryString = getQueryStringFromHref(fullUrl);

        queryString = getQueryStringFromObject(formParameters, queryString);
        /*Находим html который нужно перегрузить аяксом*/
        let reloadClassName = dataset['ajaxReloadClass'+pf];
        let htmlReload  = getHtmlReload(event.target.parentNode, reloadClassName);
        /**/

        let effectsList = getEffectsList(actionElement, dataset, pf);

        sendRequest (dataset['ajaxName'+pf], dataset['ajaxMethod'+pf], queryString, ajaxPath, pushState, htmlReload, effectsList, function(response) {

            if (htmlReload !== null) {
                htmlReload.innerHTML = String(response);
                initAjaxActionElements(htmlReload);
            }

            if (pf === '') {
                for (let i = 1; i < 4; i++) {
                    if ((actionElement.hasAttribute('data-ajax-method' + i)))
                        onRouteController(actionElement, event, i);
                }

            }

        });

    }

    function sendRequest(ajaxName, ajaxMethod, queryString, path, pushState, htmlReload, effectsList, func)
    {
        let ajaxReq = new Ajax(ajaxMethod, queryString, ajaxHeaders, ajaxName, path);

        ajaxReq.req.onloadstart = function()
        {
            onloadstart(htmlReload, effectsList);
        };

        //todo проверить, если объекта нет, делать submit формы
        ajaxReq.req.onreadystatechange = function()
        {
            if (ajaxReq.req.readyState !== 4) return;

            func(ajaxReq.req.responseText);

            onloadend(htmlReload, effectsList);
        };

        ajaxReq.sendRequest();

        if (pushState)
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
                    case 'hidden' :
                    case 'text' :
                        formParameters[formInputs[i].name] = formInputs[i].value;
                        break;
                }
            }
        }

        return formParameters;
    }

    function getPath(fullUrl, ajaxView)
    {
        let locationArray = fullUrl.split('?');

        let viewpath = '';

        if (ajaxView !== undefined)
            viewpath = '/views/' + ajaxView;

        return locationArray[0] + viewpath;
    }

    function getFullUrl(actionElement, pf)
    {
        if (actionElement.hasAttribute('data-ajax-action'+pf)) {
            return actionElement.getAttribute('data-ajax-action'+pf)
        } else if (actionElement.hasAttribute('action')) {
            return actionElement.getAttribute('action')
        } else if(actionElement.hasAttribute('href')) {
            return actionElement.getAttribute('href')
        }
    }

    function getHtmlReload(parentNode, className)
    {
        if (className !== undefined && className !== null){
            if (parentNode.getElementsByClassName(className)[0])
                return parentNode.getElementsByClassName(className)[0];
            else
                return getHtmlReload(parentNode.parentNode, className)
        }
        return null;

    }

    function onloadstart(htmlReload, effectsList)
    {
        if (htmlReload !== null) {
            for (let i = 0; i < effectsList.length; ++i) {
                effectFunctions[effectsList[i]].start(htmlReload);
            }
        }
    }

    function onloadend(htmlReload, effectsList)
    {
        if (htmlReload !== null) {
            for (let i = 0; i < effectsList.length; ++i) {
                effectFunctions[effectsList[i]].end(htmlReload);
            }
        }
    }

    function getEffectsList(actionElement, dataset, pf)
    {
        let effectsString = dataset['ajaxEffects'+pf];

        let defaultEffects = ['default'];

        let effectsList = [];

        if (typeof effectsString === 'string')
            effectsList = effectsString.split('|').concat(defaultEffects);
        else
            effectsList = defaultEffects;

        return effectsList;

    }

    let effectFunctions = {
        'default' : {
            'start' : function (htmlReload) {
                effectFunctions.opacity.start(htmlReload);
            },
            'end' : function (htmlReload) {
                effectFunctions.opacity.end(htmlReload);
            },
        },
        'spinner' : {
            'start' : function (htmlReload) {
                let spinners = htmlReload.getElementsByClassName('spinner-border');

                for (let i = 0; i < spinners.length; i++) {
                    spinners[i].style.display = 'block';
                }
            },
            'end'   : function (htmlReload) {
                let spinners = htmlReload.getElementsByClassName('spinner-border');

                for (let i = 0; i < spinners.length; i++) {
                    spinners[i].style.display = 'none';
                }
            },
        },
        'opacity' : {
            'start' : function (htmlReload) {
                htmlReload.style.opacity = 0.25;
            },
            'end'   : function (htmlReload) {
                htmlReload.style.opacity = 1.0;
            },
        },
        'scrolltop' : {
            'start' : function (htmlReload) {
                let step, length;

                step = length = -75;

                let coordinates = htmlReload.getBoundingClientRect();

                let int = setInterval(function() {
                    window.scrollBy(0, step);
                    length += step;
                    if (length <= (coordinates.y - 100))
                        clearInterval(int);
                }, 20);
            },
            'end' : function (htmlReload) {

            },
        }
    };

    /*Старый код*/
    function clearOneFilter(filter){
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

    function initSlider(actionElement){
        /*****************************************************
         Product Filter (Скорее всего не оптимизированный код)
         *****************************************************/
        let sliders = actionElement.getElementsByClassName('filter-slider');

        $('.filter-slider .slider-show').css('display', 'block');

        for(let i = 0; i < sliders.length; i++){
            let values = getValues(sliders[i]);

            getSliderShow(sliders[i]).slider({
                range: true,
                min: values.range[0],
                max: values.range[1],
                values: [values.value[0], values.value[1]],
                slide: function(event, ui) {
                    changeInputValue([ui.handleIndex], [ui.value], $(ui.handle.parentNode).closest('.filter-slider')[0]);
                },
                change: function(event, ui) {
                    onRouteController(actionElement, event);
                }
            });
        }

        $('input[data-filter-type=slider]').on('change', function(e){

            e = e || event;
            let slider = $(e.target).closest('.filter-slider')[0];
            let values = getValues(slider);
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
                let index = e.target.dataset.filterSliderInputIndex;
                values.value[index] = values.range[index];
                changeInputValue([index], [values.range[index]], slider);
            }
            changeSliderValue(values.value, slider);
        });
    }

    function getValues(slider){
        let inputs = $(slider).find('input[data-filter-type=slider]');
        let inputsValue = {'value':[], 'range':[]};
        for(let i = 0; i < inputs.length; i++){
            inputsValue.value[i] = Number(inputs[i].value);
            if(inputs.length === 1) break;
        }
        inputsValue.range[0] = Number(inputs[0].min);
        inputsValue.range[1] = Number(inputs[0].max);

        return inputsValue;
    }

    function getSliderShow(slider){
        return $(slider).find('.slider-show');
    }

    function changeInputValue(index, values, slider){
        let inputs = $(slider).find('input[data-filter-type=slider]');
        for(let i = 0; i < index.length; i++){
            inputs[index[i]].value = values[i];
        }

    }

    function changeSliderValue(values, slider){
        getSliderShow(slider).slider("values", values);
    }
}

