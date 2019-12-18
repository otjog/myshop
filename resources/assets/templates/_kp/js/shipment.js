import Ajax from './ajax';
import InitMap from './googlemap';
import MarkerClusterer from '@google/markerclusterer/src/markerclusterer';

export default function Shipment(){

    this.getOffers = function () {

        let offers = getOffersRequestData();

        if(offers.elements.wrapBlock !== null && offers.elements.wrapBlock !== undefined){

            let queryString = setQueryString(offers.qsParams);

            let requests = offers.elements.wrapBlock.getElementsByClassName('reload');

            allRequestCount = requests.length;

            for(let i=0; i < requests.length; i++){

                if(requests[i].hasAttribute('data-alias')){

                    if(requests[i].hasAttribute('data-type')){

                        let requestData = Object.assign({}, offers);

                        let offerAttributes = requests[i].attributes;

                        requestData.queryString = setQueryString(offerAttributes, queryString);
                        requestData.requestName += offerAttributes['data-alias']['nodeValue'] + '_' + offerAttributes['data-type']['nodeValue'];
                        requestData.reloadBlock = requests[i];

                    sendRequest(requestData);

                    }

                }

            }

        }

    };

    this.getPoints = function() {

        let maps = getMapsRequestData();

        if(maps.elements.wrapBlock !== null && maps.elements.wrapBlock !== undefined){

            maps.queryString = setQueryString(maps.qsParams, maps.queryString);

            sendRequest(maps);

        }

    };

    let allRequestCount = 0;

    let sendRequestCount = 0;

    //FUNCTIONS
    function sendRequest(requestData){

        let ajaxReq = new Ajax(requestData.method, requestData.queryString, requestData.headers, requestData.requestName);

        ajaxReq.req.onloadstart = function () {
            requestData.functions.onloadstart(requestData)
        };

        ajaxReq.req.ontimeout = function () {
            requestData.functions.ontimeout(requestData)
        };

        ajaxReq.req.onreadystatechange = function () {

            if (ajaxReq.req.readyState !== 4) return;

            requestData.functions.onreadystatechange(requestData, ajaxReq);

        };

        ajaxReq.sendRequest();

    }

    function getMarkerOnMap(map, json, controls = null) {

        let markers = [];

        let companyAlias = '';

        for(let company in json){

            companyAlias = company;

            if(json.hasOwnProperty(company)){

                for(let i in json[company].points){

                    if(json[company].points.hasOwnProperty(i)){

                        let geoShop = json[company].points[i].geoCoordinates;

                        let locationShop = {lat: +geoShop.latitude, lng: +geoShop.longitude};

                        let image = location.origin + '/' + json[company].mapMarker;

                        let point = json[company].points[i];

                        let infowindow = new google.maps.InfoWindow({
                            content: point.markerInfo
                        });

                        let marker = new google.maps.Marker({position: locationShop, map: map, icon: image});

                        markers.push(marker);

                        marker.addListener('click', function() {
                            infowindow.open(map, marker);
                        });

                    }

                }

            }

        }

        let markerCluster = new MarkerClusterer(map, markers,
            {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});

        if (controls !== null) {
            let input = controls.querySelector("input[type=checkbox][value=" + companyAlias + "]");

            if(input !== null && input !== undefined){

                if(markers.length > 0){
                    input.removeAttribute('disabled');
                    input.setAttribute('checked', 'checked');
                }
                input.addEventListener('change', function(e) {
                    if(input.checked){
                        markerCluster.addMarkers(markers);
                    }else{
                        for (let i = 0; i < markers.length; i++) {
                            markerCluster.removeMarker(markers[i]);
                        }
                    }
                });
            }
        }
    }

    /**
     * Добавляет или создает новую строку запроса с переданными параметрами
     *
     * @param {Object} attributes - атрибуты для добавления параметров
     * @param {String} [queryString] - строка, к которой нужно добавить параметры. Не обязательный параметр
     * @returns {string}
     */
    function setQueryString(attributes, queryString = '')
    {
        if(attributes.length !== undefined && attributes.length !== null && attributes.length > 0 ){
        //для атрибутов ДОМ-Элемента
            for (let i = 0; i < attributes.length; i++) {

                if (attributes[i].name !== 'id' && attributes[i].name !== 'class' && attributes[i].name !== 'style') {

                    if (queryString !== '') {
                        queryString += '&';
                    }

                    queryString += attributes[i].name.replace('data-', '');
                    queryString += '=';
                    queryString += attributes[i].nodeValue;
                }
            }

        } else {
            //для нашего объекта
            for (let attribute in attributes)
            {

                if(queryString !== ''){
                    queryString += '&';
                }

                queryString += attribute;
                queryString += '=';
                queryString += attributes[attribute];
            }
        }

        return queryString;
    }

    function getOffersRequestData() {
        return {
            method : 'GET',
            qsParams : {
                module : 'shipment',
                response : 'view'
            },
            requestName : 'shipment_',
            elements : {
                wrapBlock : document.getElementById('shipment-offers'),
                shipmentBestOfferWrap   : document.getElementById('shipment-best-offer'),
                shipmentDefaultMethods  : {
                    'toTerminal'    : document.querySelector('[data-alias="toTerminal"]'),
                    'toDoor'        : document.querySelector('[data-alias="toDoor"]'),
                }
            },
            functions : {
                onloadstart : function (self) {

                    self.elements.loadingBlock    = self.elements.wrapBlock.getElementsByClassName('loading');
                    //self.elements.errorBlock      = self.elements.reloadBlock.getElementsByClassName('error');
                    self.elements.contentBlock    = self.reloadBlock.getElementsByClassName('blur');

                    self.elements.loadingBlock[0].style.display = 'block';

                    self.elements.loadingBlock[0].dataset.ariaValuenow = sendRequestCount;
                    self.elements.loadingBlock[0].dataset.ariaValuemin = 0;
                    self.elements.loadingBlock[0].dataset.ariaValuemax = allRequestCount;


                    /* Best Offer*/
                    if(self.elements.shipmentBestOfferWrap !== null && self.elements.shipmentBestOfferWrap !== undefined){
                        self.functions.bestOfferInit(self);
                    }

                },
                ontimeout : function (self) {
                    allRequestCount--;
                    if(sendRequestCount > allRequestCount){
                        self.elements.loadingBlock[0].style.display = 'none';
                    }else{
                        self.elements.loadingBlock[0].style.width = (100 / allRequestCount * sendRequestCount) + '%';
                    }
                },
                onreadystatechange :function(self, ajaxReq) {

                    let result = String(ajaxReq.req.responseText);
                    self.reloadBlock.innerHTML = result;

                    if(result !== ''){
                        
                        let arrayReqName = self.requestName.split('_');

                        if (arrayReqName[arrayReqName.length -1 ] === 'toDoor' && arrayReqName[arrayReqName.length - 2 ] !== 'toDoor') {
                            self.elements.shipmentDefaultMethods.toDoor.style.display = 'none';

                        } else if (arrayReqName[arrayReqName.length -1 ] === 'toTerminal' && arrayReqName[arrayReqName.length - 2 ] !== 'toTerminal') {
                            self.elements.shipmentDefaultMethods.toTerminal.style.display = 'none';
                        }

                    }

                    sendRequestCount++;
                    if(sendRequestCount === allRequestCount){
                        self.elements.loadingBlock[0].style.display = 'none';

                        /* Best Offer*/
                        if(self.elements.shipmentBestOfferWrap !== null && self.elements.shipmentBestOfferWrap !== undefined){
                            self.functions.bestOfferCalculate(self);
                        }

                    }else{
                        self.elements.loadingBlock[0].style.width = (100 / allRequestCount * sendRequestCount) + '%';
                    }

                    //self.elements.contentBlock[0].style.opacity = 1;

                },
                bestOfferInit : function(self){

                    self.elements.shipmentOffersPrices      = self.elements.wrapBlock.getElementsByClassName('shipment-price');
                    self.elements.shipmentOffersDays        = self.elements.wrapBlock.getElementsByClassName('shipment-days');
                    self.elements.shipmentBestOfferPrices   = self.elements.shipmentBestOfferWrap.getElementsByClassName('shipment-price');
                    self.elements.shipmentBestOfferDays     = self.elements.shipmentBestOfferWrap.getElementsByClassName('shipment-days');

                    self.elements.shipmentBestOfferPrices[0].innerHTML    = '';
                    self.elements.shipmentBestOfferDays[0].innerHTML      = '';

                    self.elements.shipmentBestOfferDays[0].parentNode.style.display   = 'none';
                    self.elements.shipmentBestOfferPrices[0].parentNode.style.display = 'none';
                },
                bestOfferCalculate : function(self){
                    let pricesArray = [];
                    let daysArray = [];

                    for(let i = 0; i < self.elements.shipmentOffersPrices.length; i++){

                        let value = self.elements.shipmentOffersPrices[i].innerHTML;

                        if(Number.isInteger(value*1)) {
                            pricesArray[i] = value * 1;
                        }
                    }

                    for(let i = 0; i < self.elements.shipmentOffersDays.length; i++){
                        let valuesArray = self.elements.shipmentOffersDays[i].innerHTML.split('-');

                        if(Number.isInteger(valuesArray[0]*1)){

                            if (
                                valuesArray[1] !== undefined
                                && valuesArray[1] !== null
                                && Number.isInteger(valuesArray[1]*1)
                            ) {
                                daysArray[i] = valuesArray[1] * 1;
                            }else{
                                daysArray[i] = valuesArray[0] * 1;
                            }
                        }

                    }

                    pricesArray.sort(function(a,b){
                        return a - b;
                    });

                    daysArray.sort(function(a,b){
                        return a - b;
                    });


                    self.elements.shipmentBestOfferPrices[0].innerHTML    = pricesArray[0];
                    self.elements.shipmentBestOfferDays[0].innerHTML      = daysArray[0];

                    self.elements.shipmentBestOfferDays[0].parentNode.style.display   = 'block';
                    self.elements.shipmentBestOfferPrices[0].parentNode.style.display = 'block';
                }
            },

        };
    }

    function getMapsRequestData(){
        return {
            method : 'GET',
            requestName : 'map',
            qsParams : {
                module : 'map',
                response : 'json'
            },
            elements    : {
                wrapBlock : document.getElementById('map'),
                wrapCheckbox : document.getElementById('mapShipmentCheckbox')
            },
            functions : {
                onloadstart : function (self) {},
                ontimeout : function (self) {},
                onreadystatechange :function(self, ajaxReq) {
                    if (ajaxReq.req.readyState !== 4) return;

                    let json = JSON.parse(ajaxReq.req.responseText);

                    let points = getPointsRequestData();

                    points.elements.wrapBlock = self.elements.wrapBlock.parentElement;

                    let zoom = 4;

                    if (json.region_code !== undefined && json.region_code !== null)
                        zoom = 12;
                    if (json.street_name !== undefined && json.street_name !== null)
                        zoom = 15;
                    if (json.house_number !== undefined && json.house_number !== null)
                        zoom = 18;

                    points.map = InitMap(json, zoom);

                    if(self.elements.wrapBlock.hasAttribute('data-alias')){

                        let aliasesString = self.elements.wrapBlock.getAttribute('data-alias');

                        let aliasesArray = aliasesString.split('|');

                        for(let i=0; i < aliasesArray.length; i++) {

                            let requestData = Object.assign({}, points);

                            requestData.requestName += aliasesArray[i];
                            requestData.qsParams.alias = aliasesArray[i];

                            requestData.queryString = setQueryString(requestData.qsParams);

                            sendRequest(requestData);

                        }

                    }else{
                        console.log('У карты не указаны data-alias');
                    }

                },
            },

        };
    }

    function getPointsRequestData(){
        return {
            method : 'GET',
            qsParams : {
                module : 'points',
                response : 'json',
                alias : ''
            },
            queryString : '',
            requestName : 'points_',
            elements    : {
                wrapCheckbox : document.getElementById('mapShipmentCheckbox')
            },
            functions : {
                onloadstart : function (self)
                {
                    self.elements.loadingBlock = self.elements.wrapBlock.getElementsByClassName('loading');
                    self.elements.errorBlock = self.elements.wrapBlock.getElementsByClassName('error');
                    self.elements.contentBlock = self.elements.wrapBlock.getElementsByClassName('blur');
                    self.elements.loadingBlock[0].style.display = 'block';
                    self.elements.errorBlock[0].style.display = 'none';
                    self.elements.contentBlock[0].style.opacity = 0.75;

                },
                ontimeout : function (self)
                {
                    self.elements.loadingBlock[0].style.display = 'none';
                    self.elements.errorBlock[0].style.display = 'block';
                },
                onreadystatechange :function(self, ajaxReq)
                {
                    let json  = JSON.parse(ajaxReq.req.responseText);

                    getMarkerOnMap(self.map, json, self.elements.wrapCheckbox);

                    self.elements.loadingBlock[0].style.display   = 'none';
                    self.elements.errorBlock[0].style.display = 'none';
                    self.elements.contentBlock[0].style.opacity = 1;

                },
            },

        };
    }
}