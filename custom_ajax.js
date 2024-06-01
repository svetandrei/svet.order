/*
Автор: sto.uzbekov
Telegram: @sto_uzbekov
*/

BX.Sale.OrderAjaxComponent = {
    init: function (result, form, blocks, params, templateFolder, siteId, signedParamsString, ajaxUrl) {
        this.lastWait = [];
        this.BXFormPosting = false;
        this.ymapInit = true;
        this.isDoubleRefresh = false;
        this.ajaxUrl = ajaxUrl || '';
        this.result = result;
        this.form = '#' + form;
        this.BXform = form;
        this.siteId = siteId || '';
        this.signedParamsString = signedParamsString || '';
        this.blocks = blocks;
        this.params = params;
        this.data = false;
        this.InnSuggestions = false;
        this.templateFolder = templateFolder;
        this.refreshOrder();
        this.sendRequest();
        /*BX.addCustomEvent('onAjaxSuccess', function() {
            let height = $('#bx-soa-delivery .orderType__itemContainer--lit').height();
            $('#bx-soa-delivery .orderType__itemContainer--big .orderType__list').css('max-height', height + 'px');
        })*/
    },

    eventOrder: function () {
        $('body').on('click', '._shiptor_widget_balloon_pick_pvz', function () {
            let height = $('#bx-soa-delivery .orderType__itemContainer--lit').height();
            $('#bx-soa-delivery .orderType__itemContainer--big .orderType__list').css('max-height', height + 'px');
        })
        let simpleBars = document.querySelectorAll('.customScrollBox');
        simpleBars.forEach((simpleBar) => {
            new SimpleBar(simpleBar);
        });
        $(this.form).find('input[type=radio]').off('change');
        $(this.form).find('input[type=radio]').change((e) => {
            e.preventDefault();
            let _th = $(e.target);
            // глюк битрикса... при изменении типа покупателя в компонент не уходит код местоположения, который задан по умолчанию... производим двойной запрос для исправления
            this.isDoubleRefresh = _th.prop('name') === 'PERSON_TYPE';
            this.sendRequest();
        });
        //$('.telInput').inputmask("+7 (999) 999 99 99");
        $('.telInput').mask("+0 (000) 000 00 00");
        $('[data-suggestion]').suggestions({
            token: 'f82479bd4e76d4786cb6570b4fd45f7f72738d29',
            type: 'PARTY',
            count: 5,
            onSelect: (data) => {
                $('#soa-property-15').val(data.data.kpp || '');
                $('#soa-property-14').val(data.data.inn || '');
                $('#soa-property-3').val(data.value || '');
            }
        });
        /*$(this.form).find('[data-inn], [data-company]').off('input');
        $(this.form).find('[data-inn], [data-company]').on('input', (e) => {
            let _th = $(e.target);
            if(_th.val().length >= 1) {
                BX.showWait(e.target);
                BX.ajax({
                    method: 'POST',
                    url: this.templateFolder + '/dadata.php',
                    data: {
                        'query': _th.val()
                    },
                    dataType: 'json',
                    onsuccess: (result) => {
                        let wrapperList = _th.parent('.fieldList__item').find('.dataChanger');
                        let list = wrapperList.find('.dataDropDown__list');
                        if(!result.error && result.data.suggestions.length > 0) {
                            this.InnSuggestions = result.data.suggestions;
                            wrapperList.addClass('__active');
                            list.html('');
                            for (let d in this.InnSuggestions) {
                                let item = this.InnSuggestions[d];
                                list.append('<li data-id-suggestion="' + d + '">' + item.value + '</li>')
                            }
                            list.find('[data-id-suggestion]').off('click');
                            list.find('[data-id-suggestion]').on('click', (e) => {
                                let _thA = $(e.target);
                                let idSuggestion = _thA.data('id-suggestion');
                                let kppNode = $('#soa-property-15');
                                let innNode = $('#soa-property-14');
                                let companyNode = $('#soa-property-3');
                                wrapperList.removeClass('__active');
                                list.html('');
                                if(!!this.InnSuggestions[idSuggestion].data.kpp) {
                                    kppNode.val(this.InnSuggestions[idSuggestion].data.kpp);
                                } else {
                                    kppNode.val('000000000');
                                }

                                $('#soa-property-34').val(this.InnSuggestions[idSuggestion].data.address.unrestricted_value);
                                $('#soa-property-35').val(this.InnSuggestions[idSuggestion].data.address.unrestricted_value);
                                if(_th.data('inn')) {
                                    _th.val(this.InnSuggestions[idSuggestion].data.inn);
                                    companyNode.val(this.InnSuggestions[idSuggestion].value);
                                } else if(_th.data('company')) {
                                    innNode.val(this.InnSuggestions[idSuggestion].data.inn);
                                    _th.val(this.InnSuggestions[idSuggestion].value);
                                }
                            })
                        } else {
                            wrapperList.removeClass('__active');
                            list.html('');
                        }
                        BX.closeWait(e.target);
                    }
                })
            }
        })*/
        $(this.form).find('[data-location]').off('input');
        $(this.form).find('[data-location]').on('input', (e) => {
            let _th = $(e.target);
            _th.parent('.cityChanger').find('.locationFullName').html('');
            _th.parent('.cityChanger').find('input[type=hidden]').val('');
            BX.showWait(e.target);
            BX.ajax({
                method: 'POST',
                url: this.templateFolder + '/get_location.php',
                data: {
                    'phrase': _th.val()
                },
                dataType: 'json',
                onsuccess: (data) => {
                    if(!data.error) {
                        _th.parent('.cityChanger').addClass('__active');
                        _th.parent('.cityChanger').find('.cityDropDown__list').html('');
                        for(let d in data.data) {
                            let item = data.data[d];
                            _th.parent('.cityChanger').find('.cityDropDown__list').append('<li class="cityDropDown__item"><a data-name="' + item.NAME + '" data-code="' + item.CODE + '" class="cityDropDown__point" href="#">' + item.FULL_NAME + '</a></li>');
                        }
                        $(this.form).find('.cityDropDown__list a').off('click');
                        $(this.form).find('.cityDropDown__list a').on('click', (e) => {
                            e.preventDefault();
                            let _thA = $(e.target);
                            _th.val(_thA.data('name'));
                            _th.parent('.cityChanger').find('.locationFullName').html(_thA.html());
                            _th.parent('.cityChanger').removeClass('__active');
                            _th.parent('.cityChanger').find('.cityDropDown__list').html('');
                            _th.parent('.cityChanger').find('input[type=hidden]').val(_thA.data('code'));
                            this.sendRequest();
                            //BX.onCustomEvent("bx-ui-sls-after-select-item", [84]);
                        });
                    } else {
                        _th.parent('.cityChanger').removeClass('__active');
                        _th.parent('.cityChanger').find('.cityDropDown__list').html('');
                    }
                    BX.closeWait(e.target);
                },
                onfailure: (data) => {
                    console.log(data);
                    BX.closeWait(e.target);
                }
            })
        });
        $(this.form).off('submit');
        $(this.form).submit((e) => {
            e.preventDefault();
            this.sendRequest('saveOrderAjax');
        });
    },
    getData: function(action, actionData)
    {
        var data = {
            order: this.getAllFormData(),
            sessid: BX.bitrix_sessid(),
            via_ajax: 'Y',
            SITE_ID: this.siteId,
            signedParamsString: this.signedParamsString
        };
        data[this.params.ACTION_VARIABLE] = action;
        return data;
    },
    getAllFormData: function()
    {
        let form = BX(this.BXform),
            prepared = BX.ajax.prepareForm(form),
            i;

        for (i in prepared.data)
        {
            if (prepared.data.hasOwnProperty(i) && i == '')
            {
                delete prepared.data[i];
            }
        }
        return !!prepared && prepared.data ? prepared.data : {};
    },
    sendRequest: function(action = 'refreshOrderAjax') {
        if (!this.showWait())
            return;
        //this.showWait();
        let eventArgs = {
            action: action,
            actionData: '',
            cancel: false
        };
        BX.Event.EventEmitter.emit('BX.Sale.OrderAjaxComponent:onBeforeSendRequest', eventArgs);
        if (action === 'saveOrderAjax') {
            form = BX(this.BXform);
            if (form)
            {
                form.querySelector('input[type=hidden][name=sessid]').value = BX.bitrix_sessid();
            }

            BX.ajax.submitAjax(
                BX(this.BXform),
                {
                    url: this.ajaxUrl,
                    method: $(this.form).attr('method'),
                    dataType: 'json',
                    data: {
                        via_ajax: 'Y',
                        action: 'saveOrderAjax',
                        sessid: BX.bitrix_sessid(),
                        SITE_ID: this.siteId,
                        signedParamsString: this.signedParamsString
                    },
                    onsuccess: (data) => {
                        if (data && data.order) {
                            result = data.order;

                            if (result.REDIRECT_URL) {
                                location.href = result.REDIRECT_URL;
                            }
                            else {
                                BX.cleanNode(BX('order-error'));
                                for (let er in data.order.ERROR) {
                                    for (let erI in data.order.ERROR[er]) {
                                        let erItem = data.order.ERROR[er][erI];
                                        $('#order-error').append('<p>'+erItem+'</p>')
                                    }
                                }
                            }
                        }
                        this.closeWait();
                    },
                    onfailure: (data) => {
                        console.log(data);
                        this.closeWait();
                    }
                }
            );
        } else {
            BX.ajax({
                method: $(this.form).attr('method'),
                url: this.ajaxUrl,
                data: this.getData(eventArgs.action, eventArgs.actionData),
                dataType: 'json',
                onsuccess: BX.delegate(function (data) {
                    if (data.redirect && data.redirect.length)
                        document.location.href = data.redirect;

                    if (typeof data.order.ERROR === 'object' && typeof data.order.ERROR.length === 'undefined') {
                        BX.cleanNode(BX('order-error'));
                        for (let er in data.order.ERROR) {
                            for (let erI in data.order.ERROR[er]) {
                                let erItem = data.order.ERROR[er][erI];
                                $('#order-error').append('<p>'+erItem+'</p>')
                            }
                        }
                    } else {
                        this.result = data.order;
                        this.data = data;
                        this.refreshOrder();
                    }
                    this.closeWait();
                    if(this.isDoubleRefresh) {
                        this.isDoubleRefresh = false;
                        this.sendRequest();
                    }
                }, this),
                onfailure: (data) => {
                    console.log(data);
                    this.closeWait();
                }
            })
        }
    },

    refreshOrder: function () {
        // this.result.DELIVERY должен быть массивом для того что бы скрипт boxberry отработал парвильно
        this.result.DELIVERY = this.getDeliverySortedArray(this.result.DELIVERY);
        this.sideInit();
        this.basketInit();
        this.personInit();
        this.deliveryInit();
        this.personInfoInit();
        this.commentInit();
        this.paymentInit();
        this.mobileBlockInit();
        this.eventOrder();
    },
    getDeliverySortedArray: function (objDelivery) {
        let deliveries = [];
        for (k in objDelivery) {
            if (objDelivery.hasOwnProperty(k)) {
                deliveries.push(objDelivery[k]);
            }
        }
        return deliveries;
    },
    mobileBlockInit: function() {
        let node = BX(this.blocks.mobile);
        BX.cleanNode(node, false);
        BX.addClass(node, 'basketFixed');
        let basketFixedInner = BX.create('div', {props: {className:'basketFixed__inner'}});
        node.appendChild(basketFixedInner);
        let basketFixedItemPrice = BX.create('div', {props: {className:'basketFixed__item basketFixed__item-price'}});
        basketFixedInner.appendChild(basketFixedItemPrice);
        basketFixedItemPrice.appendChild(
            BX.create('div', {
                props: {
                    className: 'lineInner'
                },
                html: '<div class="lineInner__label">Всего</div><div class="lineInner__value">' + this.result.TOTAL.ORDER_TOTAL_PRICE_FORMATED + '</div>'
            })
        )
        basketFixedInner.appendChild(
            BX.create('div', {
                props: {
                    className: 'basketFixed__item basketFixed__item-btn'
                },
                html: '<button class="customBtn customBtn-light"><span class="customBtn__inner"><span class="customBtn__text">Подтвердить заказ</span></span></button>'
            })
        )
    },
    personInfoInit: function () {
        let node = BX(this.blocks.personInfo);
        BX.cleanNode(node, false);
        BX.addClass(node, 'orderArea__section');
        node.appendChild(this.generateTitle('login', 'Укажите данные получателя заказа'));
        let nodeContent = BX.create('div', {props: {className: 'orderArea__content'}});
        let checkGrubContent = BX.create('div', {props: {className: 'checkGrub__content __active'}});
        nodeContent.appendChild(checkGrubContent);
        let checkGrubSection = BX.create('div', {props: {className: 'checkGrub__section'}});
        checkGrubContent.appendChild(checkGrubSection);
        let checkGrubFieldSet = BX.create('fieldset');
        checkGrubSection.appendChild(checkGrubFieldSet);
        let checkGrubFieldList = BX.create('div', {props: {className: 'fieldList fieldList-big'}});
        checkGrubFieldSet.appendChild(checkGrubFieldList);
        for (let p in this.result.ORDER_PROP.properties) {
            let item = this.result.ORDER_PROP.properties[p];
            if (item.RELATION.length > 0 || item.TYPE === 'LOCATION' || item.USER_PROPS === 'N') continue;
            checkGrubFieldList.appendChild(this.generateInput(item, false, true))
        }
        checkGrubFieldList.appendChild(
            BX.create('div', {
                props: {
                    className: 'fieldList__item fieldList__item-big'
                },
                html: '<div class="warningMessage"><div class="warningMessage__inner"><div class="warningMessage__ico"><svg><use xlink:href="' + this.templateFolder + '/images/icons.svg#warning"></use></svg></div><div class="warningMessage__text">При оплате покупки на сайте, пожалуйста укажите данные получателя. Если товар будет забирать другой человек (не заказчик) – укажите его данные. Заказы выдаются при предъявлении любого документа, удостоверяющего личность.</div></div></div>'
            })
        )
        let haveRequisites = false;
        for (let p in this.result.ORDER_PROP.properties) {
            let item = this.result.ORDER_PROP.properties[p];
            if (item.RELATION.length === 0 && item.TYPE !== 'LOCATION' && item.USER_PROPS === 'N') {
                haveRequisites = true;
                break;
            }
        }
        if(haveRequisites) {
            let checkGrubSectionRequisites = BX.create('div', {props: {className: 'checkGrub__section'}});
            checkGrubContent.appendChild(checkGrubSectionRequisites);
            let checkGrubSectionRequisitesFieldset = BX.create('fieldset');
            checkGrubSectionRequisites.appendChild(checkGrubSectionRequisitesFieldset);
            checkGrubSectionRequisitesFieldset.appendChild(
                BX.create('legend', {
                    html: '<h3 class="orderArea__h3">Реквизиты</h3>'
                })
            );
            let checkGrubRequisitesFieldList = BX.create('div', {props: {className: 'fieldList fieldList-big'}});
            checkGrubSectionRequisitesFieldset.appendChild(checkGrubRequisitesFieldList);
            let checkGrubRequisitesFieldListLong = BX.create('div', {props: {className: 'fieldList fieldList-big'}});
            checkGrubSectionRequisitesFieldset.appendChild(checkGrubRequisitesFieldListLong);
            for (let p in this.result.ORDER_PROP.properties) {
                let item = this.result.ORDER_PROP.properties[p];
                if (item.RELATION.length > 0 || item.TYPE === 'LOCATION' || item.USER_PROPS === 'Y') continue;
                if(item.IS_ADDRESS === 'N')
                    checkGrubRequisitesFieldList.appendChild(this.generateInput(item, false, true));
                else
                    checkGrubRequisitesFieldListLong.appendChild(this.generateInput(item, 1));
            }
        }
        node.appendChild(nodeContent)
        for (i in this.result.USER_PROFILES) {
            if (this.result.USER_PROFILES.hasOwnProperty(i) && this.result.USER_PROFILES[i].CHECKED === 'Y') {
                node.appendChild(
                    BX.create('input', {
                        props: {
                            name: 'PROFILE_ID',
                            type: 'hidden',
                            value: this.result.USER_PROFILES[i].ID}
                    })
                );
            }
        }
    },
    getSelectedDelivery: function()
    {
        let currentDelivery;
        for (i in this.result.DELIVERY) {
            if (this.result.DELIVERY[i].CHECKED === 'Y') {
                currentDelivery = this.result.DELIVERY[i];
                break;
            }
        }
        return currentDelivery;
    },
    deliveryInit: function () {
        let node = BX(this.blocks.delivery);
        BX.cleanNode(node, false);
        BX.addClass(node, 'orderArea__section');
        node.appendChild(this.generateTitle('delivery', 'Как вы хотите получить заказ?'));
        let nodeContent = BX.create('div', {props: {className: 'orderArea__content'}, attrs: {id: 'bx-soa-delivery'}});
        let orderType = BX.create('div', {props: {className: 'orderType'}});
        nodeContent.appendChild(orderType);
        let orderTypeRow = BX.create('div', {props: {className: 'orderType__row'}});
        orderType.appendChild(orderTypeRow);
        let deliveryItemsContainer = BX.create('div', {props: {className: 'orderType__itemContainer orderType__itemContainer--big'}});
        orderTypeRow.appendChild(deliveryItemsContainer);
        let deliveryList = BX.create('div', {props: {className: 'orderType__list customScrollBox'}});
        deliveryItemsContainer.appendChild(deliveryList);
        let currentDelivery = this.getSelectedDelivery();
        for (let d in this.result.DELIVERY) {
            let item = this.result.DELIVERY[d];
            let titleDelivery;
            if(!!item.PRICE) {
                titleDelivery = item.PRICE_FORMATED;
            } else if(item.PRICE === 0) {
                titleDelivery = 'Бесплатно';
            } else if(!!item.CALCULATE_ERRORS) {
                titleDelivery = 'Ошибка расчета';
            } else {
                titleDelivery = 'Рассчитать'
            }
            deliveryList.appendChild(
                BX.create('label', {
                    props: {
                        className: 'orderType__radio'
                    },
                    html: '<input type="radio" id="ID_DELIVERY_ID_' + item.ID + '" name="' + item.FIELD_NAME + '" value="' + item.ID + '"' + (!!item.CHECKED ? ' checked' : '') + '><span class="orderType__radioContainer"><span class="orderType__checkboxIcon"></span><span class="orderType__checkboxName">' + item.NAME + '</span><span class="orderType__checkboxValue">' + titleDelivery + '</span></span>'
                })
            )
        }
        let deliveryCurrentContainer = BX.create('div', {props: {className: 'orderType__itemContainer orderType__itemContainer--lit'}});
        orderTypeRow.appendChild(deliveryCurrentContainer);
        let orderTypeItem = BX.create('div', {props: {className: 'orderType__item'}});
        deliveryCurrentContainer.appendChild(orderTypeItem);
        if(!!currentDelivery.LOGOTIP_SRC) {
            orderTypeItem.appendChild(
                BX.create('img', {
                    props: {
                        className: 'orderType__itemLogo'
                    },
                    attrs: {
                        src: currentDelivery.LOGOTIP_SRC,
                        alt: currentDelivery.NAME,
                    }
                })
            )
        }
        orderTypeItem.appendChild(
            BX.create('div', {
                props: {
                    className: 'orderType__itemName'
                },
                html: currentDelivery.NAME
            })
        )
        if(!!currentDelivery.DESCRIPTION) {
            orderTypeItem.appendChild(
                BX.create('div', {
                    props: {
                        className: 'orderType__itemDesc bx-soa-pp-company-desc'
                    },
                    html: (!!currentDelivery.CALCULATE_ERRORS ? '<p>' + currentDelivery.CALCULATE_ERRORS + '</p>' : '') + '<p>' + currentDelivery.DESCRIPTION + '</p>' + (!!currentDelivery.CALCULATE_DESCRIPTION ? currentDelivery.CALCULATE_DESCRIPTION : '')
                })
            )
        }
        if(!!currentDelivery.PERIOD_TEXT || !!currentDelivery.PRICE) {
            let currentDeliveryValues = BX.create('ul', {props: {className: 'orderType__itemValues'}});
            orderTypeItem.appendChild(currentDeliveryValues);
            if(!!currentDelivery.PRICE) {
                currentDeliveryValues.appendChild(
                    BX.create('li', {
                        props: {
                            className: 'orderType__itemValue'
                        },
                        html: '<span class="orderType__itemValue-title">Стоимость</span><span class="orderType__itemValue-info">' + currentDelivery.PRICE_FORMATED + '</span>'
                    })
                )
            }
            if(!!currentDelivery.PERIOD_TEXT) {
                currentDeliveryValues.appendChild(
                    BX.create('li', {
                        props: {
                            className: 'orderType__itemValue'
                        },
                        html: '<span class="orderType__itemValue-title">Сроки</span><span class="orderType__itemValue-info">' + currentDelivery.PERIOD_TEXT + '</span>'
                    })
                )
            }
        }
        /*orderTypeItem.appendChild(
            BX.create('div', {
                attrs: {
                    id: 'sdek_button'
                }
            })
        )*/
        let propsList = [];
        for(let p in this.result.ORDER_PROP.properties) {
            let item = this.result.ORDER_PROP.properties[p];
            for (let r in item.RELATION) {
                if(item.RELATION[r].ENTITY_TYPE === 'D') {
                    propsList.push(item);
                    break;
                }
            }
        }
        nodeContent.appendChild(
            BX.create('div', {props:{className:'alert-danger'}})
        );
        if(propsList.length > 0) {
            let currentDeliveryProps = BX.create('div', {props: {className: 'checkGrub__content __active'},attrs:{id:'bx-soa-properties'}});
            nodeContent.appendChild(currentDeliveryProps);
            let currentDeliveryPropsContainer = BX.create('div', {props: {className: 'checkGrub__section'}});
            currentDeliveryProps.appendChild(currentDeliveryPropsContainer);
            let currentDeliveryPropsFieldset = BX.create('fieldset');
            currentDeliveryPropsContainer.appendChild(currentDeliveryPropsFieldset);
            let currentDeliveryPropsTitle = BX.create('legend');
            currentDeliveryPropsFieldset.appendChild(currentDeliveryPropsTitle);
            currentDeliveryPropsTitle.appendChild(
                BX.create('h3', {
                    props: {
                        className: 'orderArea__h3'
                    },
                    html: 'Адрес доставки'
                })
            );
            let currentDeliveryPropsFieldList = BX.create('div', {props: {className: 'fieldList fieldList-big'}});
            currentDeliveryPropsFieldset.appendChild(currentDeliveryPropsFieldList);
            let i = 1;
            for (let pl in propsList) {
                let item = propsList[pl];
                if(propsList.length < 4) i = 2;
                if(propsList.length <= 2) i = 1;
                currentDeliveryPropsFieldList.appendChild(this.generateInput(item, i));
                if(i === 1 && propsList.length > 2)
                    currentDeliveryPropsFieldList.appendChild(
                        BX.create('div', {props: {className: 'fieldList__item'}})
                    );
                i++;
            }
        }
        if(currentDelivery.STORE.length > 0) {
            let store = this.result.STORE_LIST[currentDelivery.STORE[0]];
            let currentDeliveryMap = BX.create('div', {props: {className: 'checkGrub__content __active'}});
            nodeContent.appendChild(currentDeliveryMap);
            let orderMapBox = BX.create('div', {props: {className: 'orderMapBox'}});
            currentDeliveryMap.appendChild(orderMapBox);
            let orderMapBoxInner = BX.create('div', {props: {className: 'orderMapBox__inner'}});
            orderMapBox.appendChild(orderMapBoxInner);
            let orderMapBoxInfo = BX.create('div', {props: {className: 'orderMapBox__item orderMapBox__info'}});
            orderMapBoxInner.appendChild(orderMapBoxInfo);
            let orderMapBoxMap = BX.create('div', {props: {className: 'orderMapBox__item orderMapBox__map'}});
            orderMapBoxInner.appendChild(orderMapBoxMap);
            let orderMapInfo = BX.create('div', {props: {className: 'orderMapInfo'}});
            orderMapBoxInfo.appendChild(orderMapInfo);
            let orderMapInfoTitle = BX.create('div', {props: {className: 'orderMapInfo__title'},html:store.TITLE});
            orderMapInfo.appendChild(orderMapInfoTitle);
            let orderMapInfoText = BX.create('div', {props: {className: 'orderMapInfo__text'},html:store.DESCRIPTION});
            orderMapInfo.appendChild(orderMapInfoText);
            let orderMapInfoAddress = BX.create('div', {props: {className: 'orderMapInfo__address'},html:store.ADDRESS});
            orderMapInfo.appendChild(orderMapInfoAddress);
            let orderMapInfoImage = BX.create('div', {props: {className: 'orderMapInfo__img'},html:'<img src="' + store.IMAGE_ID_SRC_ORIGINAL + '">'});
            orderMapInfo.appendChild(orderMapInfoImage);
            let orderMapBoxMapYandex = BX.create('div', {props: {className: 'order-map'},attrs:{id: 'orderMap'}});
            orderMapBoxMap.appendChild(orderMapBoxMapYandex);
            this.store = store;
            if(typeof ymaps !== 'undefined') {
                ymaps.ready(() => {
                    if(!this.ymapInit) return false;
                    this.ymapInit = false;
                    let myMap = new ymaps.Map('orderMap', {
                        center: [this.store.GPS_N, this.store.GPS_S],
                        zoom: 15,
                        controls: ['zoomControl'],
                    }, {
                        searchControlProvider: 'yandex#search'
                    });
                    myMap.geoObjects.add(new ymaps.Placemark([this.store.GPS_N, this.store.GPS_S], {
                        balloonContent: this.store.ADDRESS
                    }, {
                        preset: 'islands#icon',
                        iconColor: '#0095b6'
                    }));
                    this.ymapInit = true;
                });
            } else {
                console.log('Карты Yandex не загрузились! Обратитесь к администратору сайта.')
            }
        } else {
            this.store = false;
        }
        node.appendChild(nodeContent)
    },
    generateInput: function (item, long = false, mid = false) {
        let type;
        switch(item.TYPE) {
            case 'STRING':
                type = 'text';
                break;
            case 'NUMBER':
                type = 'number';
                break;
            case 'ENUM':
                type = 'select';
                break;
            default:
                type = 'text';
        }
        if (item.IS_PHONE === 'Y') type = 'text';
        let currentPropItem
        if (long === 1)
            currentPropItem = BX.create('div', {props: {className: 'fieldList__item'}, attrs: {'data-property-id-row': item.ID}});
        else if (mid)
            currentPropItem = BX.create('div', {props: {className: 'fieldList__item fieldList__item-mid'}, attrs: {'data-property-id-row': item.ID}});
        else
            currentPropItem = BX.create('div', {props: {className: 'fieldList__item fieldList__item-small'}, attrs: {'data-property-id-row': item.ID}});

        let idElem = 'soa-property-' + item.ID;
        if(item.IS_ZIP === 'Y') idElem = 'zipProperty';
        let currentPropLabel = BX.create('label', {
            props: {
                className: 'custom-label'
            },
            attrs: {
                for: idElem
            },
            html: item.NAME + (item.REQUIRED === 'Y' ? ' <span>*</span>' : '')
        })
        let currentPropInput;
        if(type === 'select') {
            let curVal = !!item.VALUE ? item.VALUE[0] : item.DEFAULT_VALUE;
            currentPropInput = BX.create('select', {
                props: {
                    className: 'customInput'
                },
                attrs: {
                    id: idElem,
                    name: 'ORDER_PROP_' + item.ID,
                    required: item.REQUIRED === 'Y'
                }
            })
            for(let o in item.OPTIONS) {
                let optItem = item.OPTIONS[o];
                currentPropInput.appendChild(
                    BX.create('option', {
                        props: {
                            value: optItem
                        },
                        attrs: {
                            selected: curVal === optItem
                        },
                        html: optItem
                    })
                )
            }
        } else {
            currentPropInput = BX.create('input', {
                props: {
                    className: 'customInput' + (item.IS_PHONE === 'Y'?' telInput':'')
                },
                attrs: {
                    type,
                    placeholder: item.DESCRIPTION,
                    id: idElem,
                    'data-suggestion': item.CODE === 'INN' || item.CODE === 'COMPANY',
                    name: 'ORDER_PROP_' + item.ID,
                    value: !!item.VALUE ? item.VALUE[0] : item.DEFAULT_VALUE,
                    required: item.REQUIRED === 'Y'
                }
            })
        }

        currentPropItem.appendChild(currentPropLabel);
        currentPropItem.appendChild(currentPropInput);
        if(item.IS_ZIP === 'Y') {
            currentPropItem.appendChild(
                BX.create('input', {
                    props: {
                        id: 'ZIP_PROPERTY_CHANGED',
                        name: 'ZIP_PROPERTY_CHANGED',
                        type: 'hidden',
                        value: this.result.ZIP_PROPERTY_CHANGED || 'N'
                    }
                })
            );
        }
        /*if(item.CODE === 'INN' || item.CODE === 'COMPANY') {
            currentPropItem.appendChild(
                BX.create('div', {
                    props: {
                        className: 'dataChanger'
                    },
                    children: [
                        BX.create('div', {
                            props: {
                                className:'dataDropDown'
                            },
                            children: [
                                BX.create('ul', {
                                    props: {
                                        className: 'dataDropDown__list'
                                    }
                                })
                            ]
                        })
                    ]
                })
            );
        }*/
        return currentPropItem;
    },
    sideInit: function () {
        let node = BX(this.blocks.side);
        BX.cleanNode(node, false);
        BX.addClass(node, 'basketBox__item basketBox__item-side');
        let nodeInner = BX.create('div', {props:{className:'basketSide'}});
        let nodeInnerMain = BX.create('div', {props:{className:'basketSide__main'}});
        let nodeInnerTotal = BX.create('div', {props:{className:'basketSide__total'}});
        let nodeInnerBtns = BX.create('div', {props:{className:'basketSide__btn'}});
        nodeInnerMain.appendChild(
            BX.create('div', {
                props: {
                    className: 'basketSide__line',
                },
                html: '<div class="lineInner"><div class="lineInner__label">Товаров на</div><div class="lineInner__value">' + this.result.TOTAL.ORDER_PRICE_FORMATED + '</div></div>'
            })
        );
        nodeInnerMain.appendChild(
            BX.create('div', {
                props: {
                    className: 'basketSide__line',
                },
                html: '<div class="lineInner"><div class="lineInner__label">Скидка</div><div class="lineInner__value">' + this.result.TOTAL.DISCOUNT_PRICE_FORMATED + '</div></div>'
            })
        );
        nodeInnerMain.appendChild(
            BX.create('div', {
                props: {
                    className: 'basketSide__line',
                },
                html: '<div class="lineInner"><div class="lineInner__label">Доставка</div><div class="lineInner__value">' + this.result.TOTAL.DELIVERY_PRICE_FORMATED + '</div></div>'
            })
        );
        nodeInnerTotal.appendChild(
            BX.create('div', {
                props: {
                    className: 'lineInner',
                },
                html: '<div class="lineInner__label">Всего</div><div class="lineInner__value">' + this.result.TOTAL.ORDER_TOTAL_PRICE_FORMATED + '</div>'
            })
        );
        nodeInnerBtns.appendChild(
            BX.create('button', {
                props: {
                    className: 'customBtn customBtn-light',
                },
                html: '<span class="customBtn__inner"><span class="customBtn__text">Подтвердить заказ</span></span>'
            })
        );
        nodeInnerBtns.appendChild(
            BX.create('a', {
                props: {
                    className: 'customBtn',
                },
                attrs: {
                    href: '/personal/cart/',
                },
                html: '<span class="customBtn__inner"><span class="customBtn__arrow"><svg><use xlink:href="' + this.templateFolder + '/images/icons.svg#dropdown"></use></svg></span><span class="customBtn__text">Вернуться в корзину</span></span>'
            })
        );
        nodeInnerBtns.appendChild(
            BX.create('div', {
                props: {
                    className: 'order-error',
                    id: 'order-error'
                }
            })
        );
        node.appendChild(nodeInner);
        nodeInner.appendChild(nodeInnerMain);
        nodeInner.appendChild(nodeInnerTotal);
        nodeInner.appendChild(nodeInnerBtns);
    },

    basketInit: function () {
        let node = BX(this.blocks.basket);
        BX.cleanNode(node, false);
        BX.addClass(node, 'orderArea__section');
        node.appendChild(this.generateTitle('cart', 'Ваш заказ'));
        let nodeContent = BX.create('div', {props: {className: 'orderArea__content'}});
        let productsList = BX.create('div', {props: {className: 'orderProducts'}})
        for (let p in this.result.GRID.ROWS) {
            let item = this.result.GRID.ROWS[p].data;
            let itemNode = BX.create('div', {props: {className: 'orderProducts__item'}});
            let itemNodeInner = BX.create('div', {props: {className: 'orderProductItem'}});
            let itemNodeInnerInner = BX.create('div', {props: {className: 'prodLink__inner'}});
            itemNodeInnerInner.appendChild(
                BX.create('div', {
                    props: {
                        className: 'prodLink__img'
                    },
                    html: '<span class="plImg"><img src="' + (!!item.PREVIEW_PICTURE_SRC ? item.PREVIEW_PICTURE_SRC : this.templateFolder + '/images/empty_cart.svg') + '" alt="' + item.NAME + '"></span>'
                })
            );
            itemNodeInnerInner.appendChild(
                BX.create('div', {
                    props: {
                        className: 'prodLink__info'
                    },
                    html: '<span class="plName">' + item.NAME + '</span><div class="prodLink__q">' + item.QUANTITY + ' ' + item.MEASURE_TEXT + '</div><div class="prodLink__values"><div class="prodLink__new-value">' + item.SUM + '</div><div class="prodLink__old-value">' + (item.SUM !== item.SUM_BASE_FORMATED ? item.SUM_BASE_FORMATED : '') + '</div></div>'
                })
            );
            itemNodeInner.appendChild(itemNodeInnerInner);
            itemNode.appendChild(itemNodeInner);
            productsList.appendChild(itemNode);
        }
        nodeContent.appendChild(productsList);
        node.appendChild(nodeContent);
    },

    personInit: function () {
        let node = BX(this.blocks.person);
        BX.cleanNode(node, false);
        BX.addClass(node, 'orderArea__section');
        node.appendChild(this.generateTitle('login', 'Укажите тип покупателя'));
        let nodeContent = BX.create('div', {props: {className: 'orderArea__content'}});
        let nodeFieldList = BX.create('div', {props: {className: 'fieldList'}});
        for(let f in this.result.PERSON_TYPE) {
            let item = this.result.PERSON_TYPE[f];
            nodeFieldList.appendChild(
                BX.create('div', {
                    props: {
                        className: 'fieldList__item'
                    },
                    html: '<label class="labelBox' + (!!item.CHECKED ? ' __active' : '') + '"><span class="labelBox__inner labelBox__main"><span class="labelBox__lf labelBox__title">' + item.NAME + '</span><span class="labelBox__input"><input class="customCb customCb-radio visually-hidden" type="radio" value="' + item.ID + '" name="PERSON_TYPE"' + (!!item.CHECKED ? ' checked' : '') + '><span class="customCb--item"></span></span></span></label>'
                })
            );
            if(!!item.CHECKED) {
                nodeFieldList.appendChild(
                    BX.create('input', {
                        props: {
                            type: 'hidden',
                            name: 'PERSON_TYPE_OLD',
                            value: item.ID
                        }
                    })
                );
            }
        }
        nodeContent.appendChild(nodeFieldList);
        let locationNode;
        for (let l in this.result.ORDER_PROP.properties) {
            let item = this.result.ORDER_PROP.properties[l];
            if(item['IS_LOCATION'] === 'Y') {
                locationNode = BX.create('div', {props: {className: 'checkGrub checkGrub--margin-top'}});
                let fieldset = BX.create('fieldset');
                locationNode.appendChild(fieldset);
                let fieldList = BX.create('div', {props: {className: 'fieldList fieldList-big'}});
                fieldset.appendChild(fieldList);
                let fieldList__item = BX.create('div', {props: {className: 'fieldList__item'}});
                fieldList.appendChild(fieldList__item);
                fieldList__item.appendChild(
                    BX.create('label', {
                        props: {
                            className: 'custom-label'
                        },
                        attrs: {
                            for: 'soa-property-' + item.ID
                        },
                        html: item.NAME + (item.REQUIRED === 'Y' ? ' <span>*</span>' : '')
                    })
                )
                let cityChanger = BX.create('div', {
                    props: {
                        className: 'cityChanger'
                    },
                    html: '<input class="customInput" type="text" data-location' + (item.REQUIRED === 'Y' ? ' required' : '')  + '><span class="locationFullName"></span><input type="hidden" name="ORDER_PROP_' + item.ID + '" id="soa-property-' + item.ID + '" value="' + item.VALUE + '"><div class="cityChanger__dd"><div class="cityDropDown"><ul class="cityDropDown__list"></ul></div></div>'
                })
                fieldList__item.appendChild(cityChanger);
                if(!!this.data.locations) {
                    fieldList__item.appendChild(BX.create('INPUT', {
                        props: {
                            type: 'hidden',
                            name: 'RECENT_DELIVERY_VALUE',
                            value: this.data.locations[item.ID].lastValue
                        }
                    }));
                }
                BX.showWait(cityChanger);
                BX.ajax({
                    method: 'POST',
                    url: this.templateFolder + '/get_location.php',
                    data: {
                        'code': item.VALUE
                    },
                    dataType: 'json',
                    onsuccess: (data) => {
                        if(!data.error) {
                            $('#soa-property-' + item.ID).val(data.data.CODE);
                            $('#soa-property-' + item.ID).parent('.cityChanger').find('[data-location]').val(data.data.DISPLAY);
                            $('#soa-property-' + item.ID).parent('.cityChanger').find('.locationFullName').html(data.data.FULL_NAME);
                        } else {
                            console.log(data);
                        }
                        BX.closeWait(cityChanger);
                    },
                    onfailure: (data) => {
                        console.log(data);
                        BX.closeWait(cityChanger);
                    }
                })
                nodeContent.appendChild(locationNode);
            }
        }
        node.appendChild(nodeContent);
    },
    commentInit: function () {
        let node = BX(this.blocks.comment);
        BX.cleanNode(node, false);
        BX.addClass(node, 'orderArea__section');
        node.appendChild(this.generateTitle('edit', 'Комментарий к заказу'));
        let nodeContent = BX.create('div', {props: {className: 'orderArea__content'}});
        let nodeFieldList = BX.create('div', {props: {className: 'fieldList'}});
        let nodeTextarea = BX.create('div', {props: {className: 'fieldList__item fieldList__item-big'}});
        let nodePolicy = BX.create('div', {props: {className: 'fieldList__item fieldList__item-big'}});
        let nodeBtns = BX.create('div', {props: {className: 'orderArea__buttons'}});
        nodeTextarea.appendChild(
            BX.create('textarea', {
                props: {
                    className: 'customTextArea'
                },
                attrs: {
                    name: 'ORDER_DESCRIPTION',
                    placeholder: 'Введите комментарий'
                }
            })
        );
        nodePolicy.appendChild(
            BX.create('div', {
                props: {
                    className: 'ps-text'
                },
                html: '<div class="ps-text__inner"><div class="ps-text__inf">Нажимая кнопку «Подтвердить заказ», я принимаю условия <a href="/policy/" target="_blank">политики конфиденциальности</a> и <a href="/policy/" target="_blank">пользовательского соглашения</a></div>'
            })
        );
        nodeBtns.appendChild(
            BX.create('button', {
                props: {
                    className: 'customBtn customBtn-light'
                },
                html: '<span class="customBtn__inner"><span class="customBtn__text">Подтвердить заказ</span></span>'
            })
        );
        nodeBtns.appendChild(
            BX.create('a', {
                props: {
                    className: 'customBtn'
                },
                attrs: {
                    //href: '#'
                    onclick:"window.history.back();"
                },
                html: '<span class="customBtn__inner"><span class="customBtn__arrow"><svg><use xlink:href="' + this.templateFolder + '/images/icons.svg#dropdown"></use></svg></span><span class="customBtn__text">Назад</span></span>'
            })
        );
        nodeFieldList.appendChild(nodeTextarea);
        nodeFieldList.appendChild(nodePolicy);
        nodeFieldList.appendChild(nodeBtns);
        nodeContent.appendChild(nodeFieldList);
        node.appendChild(nodeContent);
    },
    paymentInit: function () {
        let node = BX(this.blocks.payment);
        BX.cleanNode(node, false);
        BX.addClass(node, 'orderArea__section');
        node.appendChild(this.generateTitle('pay', 'Как вам будет удобнее оплатить заказ?'));
        let nodeContent = BX.create('div', {props: {className: 'orderArea__content'}});
        let nodeFieldList = BX.create('div', {props: {className: 'fieldList'}});
        for (let k in this.result.PAY_SYSTEM) {
            let item = this.result.PAY_SYSTEM[k];
            let itemNode = BX.create('div', {props: {className: 'fieldList__item'}});
            let itemNodeInner = BX.create('label', {props: {className: 'labelBox' + (!!item.CHECKED ? ' __active' : '') + ' labelBox-big'}});
            let itemNodeInnerInner = BX.create('span', {props: {className: 'labelBox__inner'}});
            itemNodeInnerInner.appendChild(
                BX.create('span', {
                    props: {
                        className: 'labelBox__main'
                    },
                    html: '<span class="labelBox__lf"><span class="labelBox__title">' + item.NAME + '</span></span><span class="labelBox__input"><span class="labelBox__ico"><input class="customCb customCb-radio visually-hidden" type="radio" id="ID_PAY_SYSTEM_ID_' + item.ID + '" value="' + item.ID + '" name="PAY_SYSTEM_ID"' + (!!item.CHECKED ? ' checked' : '') + '><span class="customCb--item"></span></span></span>'
                })
            );
            itemNodeInnerInner.appendChild(
                BX.create('span', {
                    props: {
                        className: 'labelBox__subtext'
                    },
                    html: item.DESCRIPTION + (!!item.PSA_LOGOTIP_SRC_ORIGINAL ? '<div class="labelBox__img"><div class="payIcons"><div class="payIcons__item"><img src="' + item.PSA_LOGOTIP_SRC_ORIGINAL + '" alt="' + item.NAME + '"></div></div></div>' : '')
                })
            )
            itemNodeInner.appendChild(itemNodeInnerInner);
            itemNode.appendChild(itemNodeInner);
            nodeFieldList.appendChild(itemNode);
        }
        nodeContent.appendChild(nodeFieldList);
        node.appendChild(nodeContent);

    },

    generateTitle: function (icon, title) {
        let nodeTitle = BX.create('div', {props: {className: 'orderArea__title'}});
        nodeTitle.appendChild(
            BX.create('div', {
                props: {
                    className: 'orderTitle'
                },
                html: '<div class="orderTitle__ico"><svg width="22px" height="22px"><use xlink:href="' + this.templateFolder + '/images/icons.svg#' + icon + '"></use></svg></div><div class="orderTitle__txt"><h2 class="orderTitle_h">' + title + '</h2></div>'
            })
        );
        return nodeTitle;
    },
    showWait: function (node, msg) {
        if (this.BXFormPosting === true)
            return false;

        this.BXFormPosting = true;
        node = BX(node) || document.body || document.documentElement;
        msg = msg || BX.message('JS_CORE_LOADING');
        msg = '';

        var container_id = node.id || Math.random();

        var obMsg = node.bxmsg = document.body.appendChild(BX.create('DIV', {
            props: {
                id: 'wait_' + container_id,
                className: 'bx-core-waitwindow'
            },
            text: msg
        }));

        setTimeout(BX.delegate(this.adjustWait, node), 10);

        $('#win8_wrapper').show();
        this.lastWait[this.lastWait.length] = obMsg;
        return obMsg;
    },
    closeWait: function (node, obMsg) {
        this.BXFormPosting = false;
        $('#win8_wrapper').hide();
        if (node && !obMsg)
            obMsg = node.bxmsg;
        if (node && !obMsg && BX.hasClass(node, 'bx-core-waitwindow'))
            obMsg = node;
        if (node && !obMsg)
            obMsg = BX('wait_' + node.id);
        if (!obMsg)
            obMsg = this.lastWait.pop();

        if (obMsg && obMsg.parentNode)
        {
            for (var i = 0, len = this.lastWait.length; i < len; i++)
            {
                if (obMsg == this.lastWait[i])
                {
                    this.lastWait = BX.util.deleteFromArray(this.lastWait, i);
                    break;
                }
            }

            obMsg.parentNode.removeChild(obMsg);
            if (node)
                node.bxmsg = null;
            BX.cleanNode(obMsg, true);
        }
    },
    adjustWait: function () {
        if (!this.bxmsg)
            return;

        var arContainerPos = BX.pos(this),
            div_top = arContainerPos.top;

        if (div_top < BX.GetDocElement().scrollTop)
            div_top = BX.GetDocElement().scrollTop + 5;

        this.bxmsg.style.top = (div_top + 5) + 'px';

        if (this == BX.GetDocElement())
        {
            this.bxmsg.style.right = '5px';
        }
        else
        {
            this.bxmsg.style.left = (arContainerPos.right - this.bxmsg.offsetWidth - 5) + 'px';
        }
    }
}


