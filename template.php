<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var CMain $APPLICATION
 * @var CUser $USER
 * @var SaleOrderAjax $component
 * @var string $templateFolder
 */

$context = Main\Application::getInstance()->getContext();
$request = $context->getRequest();

$arParams['ALLOW_USER_PROFILES'] = $arParams['ALLOW_USER_PROFILES'] === 'Y' ? 'Y' : 'N';
$arParams['SKIP_USELESS_BLOCK'] = $arParams['SKIP_USELESS_BLOCK'] === 'N' ? 'N' : 'Y';

if (!isset($arParams['SHOW_ORDER_BUTTON']))
{
	$arParams['SHOW_ORDER_BUTTON'] = 'final_step';
}

$arParams['HIDE_ORDER_DESCRIPTION'] = isset($arParams['HIDE_ORDER_DESCRIPTION']) && $arParams['HIDE_ORDER_DESCRIPTION'] === 'Y' ? 'Y' : 'N';
$arParams['SHOW_TOTAL_ORDER_BUTTON'] = $arParams['SHOW_TOTAL_ORDER_BUTTON'] === 'Y' ? 'Y' : 'N';
$arParams['SHOW_PAY_SYSTEM_LIST_NAMES'] = $arParams['SHOW_PAY_SYSTEM_LIST_NAMES'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_PAY_SYSTEM_INFO_NAME'] = $arParams['SHOW_PAY_SYSTEM_INFO_NAME'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_DELIVERY_LIST_NAMES'] = $arParams['SHOW_DELIVERY_LIST_NAMES'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_DELIVERY_INFO_NAME'] = $arParams['SHOW_DELIVERY_INFO_NAME'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_DELIVERY_PARENT_NAMES'] = $arParams['SHOW_DELIVERY_PARENT_NAMES'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_STORES_IMAGES'] = $arParams['SHOW_STORES_IMAGES'] === 'N' ? 'N' : 'Y';

if (!isset($arParams['BASKET_POSITION']) || !in_array($arParams['BASKET_POSITION'], array('before', 'after')))
{
	$arParams['BASKET_POSITION'] = 'after';
}

$arParams['EMPTY_BASKET_HINT_PATH'] = isset($arParams['EMPTY_BASKET_HINT_PATH']) ? (string)$arParams['EMPTY_BASKET_HINT_PATH'] : '/';
$arParams['SHOW_BASKET_HEADERS'] = $arParams['SHOW_BASKET_HEADERS'] === 'Y' ? 'Y' : 'N';
$arParams['HIDE_DETAIL_PAGE_URL'] = isset($arParams['HIDE_DETAIL_PAGE_URL']) && $arParams['HIDE_DETAIL_PAGE_URL'] === 'Y' ? 'Y' : 'N';
$arParams['DELIVERY_FADE_EXTRA_SERVICES'] = $arParams['DELIVERY_FADE_EXTRA_SERVICES'] === 'Y' ? 'Y' : 'N';

$arParams['SHOW_COUPONS'] = isset($arParams['SHOW_COUPONS']) && $arParams['SHOW_COUPONS'] === 'N' ? 'N' : 'Y';

if ($arParams['SHOW_COUPONS'] === 'N')
{
	$arParams['SHOW_COUPONS_BASKET'] = 'N';
	$arParams['SHOW_COUPONS_DELIVERY'] = 'N';
	$arParams['SHOW_COUPONS_PAY_SYSTEM'] = 'N';
}
else
{
	$arParams['SHOW_COUPONS_BASKET'] = isset($arParams['SHOW_COUPONS_BASKET']) && $arParams['SHOW_COUPONS_BASKET'] === 'N' ? 'N' : 'Y';
	$arParams['SHOW_COUPONS_DELIVERY'] = isset($arParams['SHOW_COUPONS_DELIVERY']) && $arParams['SHOW_COUPONS_DELIVERY'] === 'N' ? 'N' : 'Y';
	$arParams['SHOW_COUPONS_PAY_SYSTEM'] = isset($arParams['SHOW_COUPONS_PAY_SYSTEM']) && $arParams['SHOW_COUPONS_PAY_SYSTEM'] === 'N' ? 'N' : 'Y';
}

$arParams['SHOW_NEAREST_PICKUP'] = $arParams['SHOW_NEAREST_PICKUP'] === 'Y' ? 'Y' : 'N';
$arParams['DELIVERIES_PER_PAGE'] = isset($arParams['DELIVERIES_PER_PAGE']) ? intval($arParams['DELIVERIES_PER_PAGE']) : 9;
$arParams['PAY_SYSTEMS_PER_PAGE'] = isset($arParams['PAY_SYSTEMS_PER_PAGE']) ? intval($arParams['PAY_SYSTEMS_PER_PAGE']) : 9;
$arParams['PICKUPS_PER_PAGE'] = isset($arParams['PICKUPS_PER_PAGE']) ? intval($arParams['PICKUPS_PER_PAGE']) : 5;
$arParams['SHOW_PICKUP_MAP'] = $arParams['SHOW_PICKUP_MAP'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_MAP_IN_PROPS'] = $arParams['SHOW_MAP_IN_PROPS'] === 'Y' ? 'Y' : 'N';
$arParams['USE_YM_GOALS'] = $arParams['USE_YM_GOALS'] === 'Y' ? 'Y' : 'N';
$arParams['USE_ENHANCED_ECOMMERCE'] = isset($arParams['USE_ENHANCED_ECOMMERCE']) && $arParams['USE_ENHANCED_ECOMMERCE'] === 'Y' ? 'Y' : 'N';
$arParams['DATA_LAYER_NAME'] = isset($arParams['DATA_LAYER_NAME']) ? trim($arParams['DATA_LAYER_NAME']) : 'dataLayer';
$arParams['BRAND_PROPERTY'] = isset($arParams['BRAND_PROPERTY']) ? trim($arParams['BRAND_PROPERTY']) : '';

$useDefaultMessages = !isset($arParams['USE_CUSTOM_MAIN_MESSAGES']) || $arParams['USE_CUSTOM_MAIN_MESSAGES'] != 'Y';

if ($useDefaultMessages || !isset($arParams['MESS_AUTH_BLOCK_NAME']))
{
	$arParams['MESS_AUTH_BLOCK_NAME'] = Loc::getMessage('AUTH_BLOCK_NAME_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_REG_BLOCK_NAME']))
{
	$arParams['MESS_REG_BLOCK_NAME'] = Loc::getMessage('REG_BLOCK_NAME_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_BASKET_BLOCK_NAME']))
{
	$arParams['MESS_BASKET_BLOCK_NAME'] = Loc::getMessage('BASKET_BLOCK_NAME_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_REGION_BLOCK_NAME']))
{
	$arParams['MESS_REGION_BLOCK_NAME'] = Loc::getMessage('REGION_BLOCK_NAME_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_PAYMENT_BLOCK_NAME']))
{
	$arParams['MESS_PAYMENT_BLOCK_NAME'] = Loc::getMessage('PAYMENT_BLOCK_NAME_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_DELIVERY_BLOCK_NAME']))
{
	$arParams['MESS_DELIVERY_BLOCK_NAME'] = Loc::getMessage('DELIVERY_BLOCK_NAME_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_BUYER_BLOCK_NAME']))
{
	$arParams['MESS_BUYER_BLOCK_NAME'] = Loc::getMessage('BUYER_BLOCK_NAME_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_BACK']))
{
	$arParams['MESS_BACK'] = Loc::getMessage('BACK_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_FURTHER']))
{
	$arParams['MESS_FURTHER'] = Loc::getMessage('FURTHER_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_EDIT']))
{
	$arParams['MESS_EDIT'] = Loc::getMessage('EDIT_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_ORDER']))
{
	$arParams['MESS_ORDER'] = $arParams['~MESS_ORDER'] = Loc::getMessage('ORDER_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_PRICE']))
{
	$arParams['MESS_PRICE'] = Loc::getMessage('PRICE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_PERIOD']))
{
	$arParams['MESS_PERIOD'] = Loc::getMessage('PERIOD_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_NAV_BACK']))
{
	$arParams['MESS_NAV_BACK'] = Loc::getMessage('NAV_BACK_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_NAV_FORWARD']))
{
	$arParams['MESS_NAV_FORWARD'] = Loc::getMessage('NAV_FORWARD_DEFAULT');
}

$useDefaultMessages = !isset($arParams['USE_CUSTOM_ADDITIONAL_MESSAGES']) || $arParams['USE_CUSTOM_ADDITIONAL_MESSAGES'] != 'Y';

if ($useDefaultMessages || !isset($arParams['MESS_PRICE_FREE']))
{
	$arParams['MESS_PRICE_FREE'] = Loc::getMessage('PRICE_FREE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_ECONOMY']))
{
	$arParams['MESS_ECONOMY'] = Loc::getMessage('ECONOMY_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_REGISTRATION_REFERENCE']))
{
	$arParams['MESS_REGISTRATION_REFERENCE'] = Loc::getMessage('REGISTRATION_REFERENCE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_AUTH_REFERENCE_1']))
{
	$arParams['MESS_AUTH_REFERENCE_1'] = Loc::getMessage('AUTH_REFERENCE_1_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_AUTH_REFERENCE_2']))
{
	$arParams['MESS_AUTH_REFERENCE_2'] = Loc::getMessage('AUTH_REFERENCE_2_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_AUTH_REFERENCE_3']))
{
	$arParams['MESS_AUTH_REFERENCE_3'] = Loc::getMessage('AUTH_REFERENCE_3_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_ADDITIONAL_PROPS']))
{
	$arParams['MESS_ADDITIONAL_PROPS'] = Loc::getMessage('ADDITIONAL_PROPS_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_USE_COUPON']))
{
	$arParams['MESS_USE_COUPON'] = Loc::getMessage('USE_COUPON_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_COUPON']))
{
	$arParams['MESS_COUPON'] = Loc::getMessage('COUPON_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_PERSON_TYPE']))
{
	$arParams['MESS_PERSON_TYPE'] = Loc::getMessage('PERSON_TYPE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_SELECT_PROFILE']))
{
	$arParams['MESS_SELECT_PROFILE'] = Loc::getMessage('SELECT_PROFILE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_REGION_REFERENCE']))
{
	$arParams['MESS_REGION_REFERENCE'] = Loc::getMessage('REGION_REFERENCE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_PICKUP_LIST']))
{
	$arParams['MESS_PICKUP_LIST'] = Loc::getMessage('PICKUP_LIST_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_NEAREST_PICKUP_LIST']))
{
	$arParams['MESS_NEAREST_PICKUP_LIST'] = Loc::getMessage('NEAREST_PICKUP_LIST_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_SELECT_PICKUP']))
{
	$arParams['MESS_SELECT_PICKUP'] = Loc::getMessage('SELECT_PICKUP_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_INNER_PS_BALANCE']))
{
	$arParams['MESS_INNER_PS_BALANCE'] = Loc::getMessage('INNER_PS_BALANCE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_ORDER_DESC']))
{
	$arParams['MESS_ORDER_DESC'] = Loc::getMessage('ORDER_DESC_DEFAULT');
}

$useDefaultMessages = !isset($arParams['USE_CUSTOM_ERROR_MESSAGES']) || $arParams['USE_CUSTOM_ERROR_MESSAGES'] != 'Y';

if ($useDefaultMessages || !isset($arParams['MESS_PRELOAD_ORDER_TITLE']))
{
	$arParams['MESS_PRELOAD_ORDER_TITLE'] = Loc::getMessage('PRELOAD_ORDER_TITLE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_SUCCESS_PRELOAD_TEXT']))
{
	$arParams['MESS_SUCCESS_PRELOAD_TEXT'] = Loc::getMessage('SUCCESS_PRELOAD_TEXT_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_FAIL_PRELOAD_TEXT']))
{
	$arParams['MESS_FAIL_PRELOAD_TEXT'] = Loc::getMessage('FAIL_PRELOAD_TEXT_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_DELIVERY_CALC_ERROR_TITLE']))
{
	$arParams['MESS_DELIVERY_CALC_ERROR_TITLE'] = Loc::getMessage('DELIVERY_CALC_ERROR_TITLE_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_DELIVERY_CALC_ERROR_TEXT']))
{
	$arParams['MESS_DELIVERY_CALC_ERROR_TEXT'] = Loc::getMessage('DELIVERY_CALC_ERROR_TEXT_DEFAULT');
}

if ($useDefaultMessages || !isset($arParams['MESS_PAY_SYSTEM_PAYABLE_ERROR']))
{
	$arParams['MESS_PAY_SYSTEM_PAYABLE_ERROR'] = Loc::getMessage('PAY_SYSTEM_PAYABLE_ERROR_DEFAULT');
}

$scheme = $request->isHttps() ? 'https' : 'http';

?>
	<NOSCRIPT>
		<div style="color:red"><?=Loc::getMessage('SOA_NO_JS')?></div>
	</NOSCRIPT>
<?

if ($request->get('ORDER_ID') <> '')
{
	include(Main\Application::getDocumentRoot().$templateFolder.'/confirm.php');
}
elseif ($arParams['DISABLE_BASKET_REDIRECT'] === 'Y' && $arResult['SHOW_EMPTY_BASKET'])
{
	include(Main\Application::getDocumentRoot().$templateFolder.'/empty.php');
}
else
{
    $APPLICATION->AddChainItem("Оформление заказа");
    $this->addExternalJs($templateFolder.'/custom_ajax.js');
	?>
    <section class="siteSection siteSection-small">
        <div class="site-container">
            <div class="orderBox">
                <form action="<?=POST_FORM_ACTION_URI?>" method="POST" name="ORDER_FORM" class="basketBox__inner" id="st-order-form" enctype="multipart/form-data">
                    <?=bitrix_sessid_post()?>
                    <input type="hidden" name="<?=$arParams['ACTION_VARIABLE']?>" value="saveOrderAjax">
                    <input type="hidden" name="location_type" value="code">
                    <input type="hidden" name="BUYER_STORE" id="BUYER_STORE" value="<?=$arResult['BUYER_STORE']?>">
                    <div class="basketBox__item basketBox__item-main">
                        <div class="orderArea">
                            <div class="orderArea__inner">
                                <div id="st-basket-block"></div>
                                <div id="st-person-block"></div>
                                <div id="st-delivery-block"></div>
                                <div id="st-person-info-block"></div>
                                <div id="st-payment-block"></div>
                                <div id="st-comment-block"></div>
                            </div>
                        </div>
                        <div id="st-mobile-block"></div>
                    </div>

                    <div id="st-side-block"></div>
                </form>
            </div>
        </div>
    </section>
    <div id="win8_wrapper">
        <div class="windows8">
            <div class="wBall" id="wBall_1">
                <div class="wInnerBall"></div>
            </div>
            <div class="wBall" id="wBall_2">
                <div class="wInnerBall"></div>
            </div>
            <div class="wBall" id="wBall_3">
                <div class="wInnerBall"></div>
            </div>
            <div class="wBall" id="wBall_4">
                <div class="wInnerBall"></div>
            </div>
            <div class="wBall" id="wBall_5">
                <div class="wInnerBall"></div>
            </div>
        </div>
    </div>
    <style>
        /* AJAX CUSTOM PRELOADER */
        #win8_wrapper{
            display: none;
            background: #000;
            height: 100%;
            opacity: 0.7;
            position: fixed;
            width: 100%;
            z-index: 100;
            top: 0;
            left: 0;
        }
        .windows8 {
            /*position: relative;
            width: 50px;
            height:50px;
            margin:auto;*/
            width: 50px;
            height: 50px;
            margin: auto;
            position: absolute;
            top: 0; left: 0; bottom: 0; right: 0;
        }

        .windows8 .wBall {
            position: absolute;
            width: 47px;
            height: 47px;
            opacity: 0;
            transform: rotate(225deg);
            -o-transform: rotate(225deg);
            -ms-transform: rotate(225deg);
            -webkit-transform: rotate(225deg);
            -moz-transform: rotate(225deg);
            animation: orbit 3.3225s infinite;
            -o-animation: orbit 3.3225s infinite;
            -ms-animation: orbit 3.3225s infinite;
            -webkit-animation: orbit 3.3225s infinite;
            -moz-animation: orbit 3.3225s infinite;
        }

        .windows8 .wBall .wInnerBall{
            position: absolute;
            width: 6px;
            height: 6px;
            background: rgb(255,255,255);
            left:0px;
            top:0px;
            border-radius: 6px;
            -o-border-radius: 6px;
            -ms-border-radius: 6px;
            -webkit-border-radius: 6px;
            -moz-border-radius: 6px;
        }

        .windows8 #wBall_1 {
            animation-delay: 0.726s;
            -o-animation-delay: 0.726s;
            -ms-animation-delay: 0.726s;
            -webkit-animation-delay: 0.726s;
            -moz-animation-delay: 0.726s;
        }

        .windows8 #wBall_2 {
            animation-delay: 0.143s;
            -o-animation-delay: 0.143s;
            -ms-animation-delay: 0.143s;
            -webkit-animation-delay: 0.143s;
            -moz-animation-delay: 0.143s;
        }

        .windows8 #wBall_3 {
            animation-delay: 0.2865s;
            -o-animation-delay: 0.2865s;
            -ms-animation-delay: 0.2865s;
            -webkit-animation-delay: 0.2865s;
            -moz-animation-delay: 0.2865s;
        }

        .windows8 #wBall_4 {
            animation-delay: 0.4295s;
            -o-animation-delay: 0.4295s;
            -ms-animation-delay: 0.4295s;
            -webkit-animation-delay: 0.4295s;
            -moz-animation-delay: 0.4295s;
        }

        .windows8 #wBall_5 {
            animation-delay: 0.583s;
            -o-animation-delay: 0.583s;
            -ms-animation-delay: 0.583s;
            -webkit-animation-delay: 0.583s;
            -moz-animation-delay: 0.583s;
        }



        @keyframes orbit {
            0% {
                opacity: 1;
                z-index:99;
                transform: rotate(180deg);
                animation-timing-function: ease-out;
            }

            7% {
                opacity: 1;
                transform: rotate(300deg);
                animation-timing-function: linear;
                origin:0%;
            }

            30% {
                opacity: 1;
                transform:rotate(410deg);
                animation-timing-function: ease-in-out;
                origin:7%;
            }

            39% {
                opacity: 1;
                transform: rotate(645deg);
                animation-timing-function: linear;
                origin:30%;
            }

            70% {
                opacity: 1;
                transform: rotate(770deg);
                animation-timing-function: ease-out;
                origin:39%;
            }

            75% {
                opacity: 1;
                transform: rotate(900deg);
                animation-timing-function: ease-out;
                origin:70%;
            }

            76% {
                opacity: 0;
                transform:rotate(900deg);
            }

            100% {
                opacity: 0;
                transform: rotate(900deg);
            }
        }

        @-o-keyframes orbit {
            0% {
                opacity: 1;
                z-index:99;
                -o-transform: rotate(180deg);
                -o-animation-timing-function: ease-out;
            }

            7% {
                opacity: 1;
                -o-transform: rotate(300deg);
                -o-animation-timing-function: linear;
                -o-origin:0%;
            }

            30% {
                opacity: 1;
                -o-transform:rotate(410deg);
                -o-animation-timing-function: ease-in-out;
                -o-origin:7%;
            }

            39% {
                opacity: 1;
                -o-transform: rotate(645deg);
                -o-animation-timing-function: linear;
                -o-origin:30%;
            }

            70% {
                opacity: 1;
                -o-transform: rotate(770deg);
                -o-animation-timing-function: ease-out;
                -o-origin:39%;
            }

            75% {
                opacity: 1;
                -o-transform: rotate(900deg);
                -o-animation-timing-function: ease-out;
                -o-origin:70%;
            }

            76% {
                opacity: 0;
                -o-transform:rotate(900deg);
            }

            100% {
                opacity: 0;
                -o-transform: rotate(900deg);
            }
        }

        @-ms-keyframes orbit {
            0% {
                opacity: 1;
                z-index:99;
                -ms-transform: rotate(180deg);
                -ms-animation-timing-function: ease-out;
            }

            7% {
                opacity: 1;
                -ms-transform: rotate(300deg);
                -ms-animation-timing-function: linear;
                -ms-origin:0%;
            }

            30% {
                opacity: 1;
                -ms-transform:rotate(410deg);
                -ms-animation-timing-function: ease-in-out;
                -ms-origin:7%;
            }

            39% {
                opacity: 1;
                -ms-transform: rotate(645deg);
                -ms-animation-timing-function: linear;
                -ms-origin:30%;
            }

            70% {
                opacity: 1;
                -ms-transform: rotate(770deg);
                -ms-animation-timing-function: ease-out;
                -ms-origin:39%;
            }

            75% {
                opacity: 1;
                -ms-transform: rotate(900deg);
                -ms-animation-timing-function: ease-out;
                -ms-origin:70%;
            }

            76% {
                opacity: 0;
                -ms-transform:rotate(900deg);
            }

            100% {
                opacity: 0;
                -ms-transform: rotate(900deg);
            }
        }

        @-webkit-keyframes orbit {
            0% {
                opacity: 1;
                z-index:99;
                -webkit-transform: rotate(180deg);
                -webkit-animation-timing-function: ease-out;
            }

            7% {
                opacity: 1;
                -webkit-transform: rotate(300deg);
                -webkit-animation-timing-function: linear;
                -webkit-origin:0%;
            }

            30% {
                opacity: 1;
                -webkit-transform:rotate(410deg);
                -webkit-animation-timing-function: ease-in-out;
                -webkit-origin:7%;
            }

            39% {
                opacity: 1;
                -webkit-transform: rotate(645deg);
                -webkit-animation-timing-function: linear;
                -webkit-origin:30%;
            }

            70% {
                opacity: 1;
                -webkit-transform: rotate(770deg);
                -webkit-animation-timing-function: ease-out;
                -webkit-origin:39%;
            }

            75% {
                opacity: 1;
                -webkit-transform: rotate(900deg);
                -webkit-animation-timing-function: ease-out;
                -webkit-origin:70%;
            }

            76% {
                opacity: 0;
                -webkit-transform:rotate(900deg);
            }

            100% {
                opacity: 0;
                -webkit-transform: rotate(900deg);
            }
        }

        @-moz-keyframes orbit {
            0% {
                opacity: 1;
                z-index: 99;
                -moz-transform: rotate(180deg);
                -moz-animation-timing-function: ease-out;
            }

            7% {
                opacity: 1;
                -moz-transform: rotate(300deg);
                -moz-animation-timing-function: linear;
                -moz-origin: 0%;
            }

            30% {
                opacity: 1;
                -moz-transform: rotate(410deg);
                -moz-animation-timing-function: ease-in-out;
                -moz-origin: 7%;
            }

            39% {
                opacity: 1;
                -moz-transform: rotate(645deg);
                -moz-animation-timing-function: linear;
                -moz-origin: 30%;
            }

            70% {
                opacity: 1;
                -moz-transform: rotate(770deg);
                -moz-animation-timing-function: ease-out;
                -moz-origin: 39%;
            }

            75% {
                opacity: 1;
                -moz-transform: rotate(900deg);
                -moz-animation-timing-function: ease-out;
                -moz-origin: 70%;
            }

            76% {
                opacity: 0;
                -moz-transform: rotate(900deg);
            }

            100% {
                opacity: 0;
                -moz-transform: rotate(900deg);
            }
        }
    </style>
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=a1bb1e7b-e3e4-4bb5-a06a-fd058cd2f28d" type="text/javascript"></script>
    <?
    $signer = new Main\Security\Sign\Signer;
    $signedParams = $signer->sign(base64_encode(serialize($arParams)), 'sale.order.ajax');
    ?>
    <script>
        // Вызываем JS класс
        let blocks = {
            'side': 'st-side-block',
            'basket': 'st-basket-block',
            'person': 'st-person-block',
            'comment': 'st-comment-block',
            'personInfo': 'st-person-info-block',
            'payment': 'st-payment-block',
            'delivery': 'st-delivery-block',
            'mobile': 'st-mobile-block'
        }
        BX.Sale.OrderAjaxComponent.init(<?=CUtil::PhpToJSObject($arResult['JS_DATA'])?>, 'st-order-form', blocks, <?=CUtil::PhpToJSObject($arParams)?>, '<?=$templateFolder?>', '<?=CUtil::JSEscape($component->getSiteId())?>', '<?=CUtil::JSEscape($signedParams)?>', '<?=CUtil::JSEscape($component->getPath().'/ajax.php')?>');
    </script>
    <script>

    </script>
<? }