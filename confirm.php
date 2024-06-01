<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var $APPLICATION CMain
 */
?>

<? if (!empty($arResult["ORDER"])): ?>

    <?
    $orderTitle = "Заказ №" . $arResult["ORDER"]["ACCOUNT_NUMBER"];
    $APPLICATION->AddChainItem($orderTitle);
    $APPLICATION->SetTitle($orderTitle);
    ?>
    <section class="siteSection siteSection-small">
        <div class="site-container">
            <div class="orderBox">
                <div class="basketBox__inner">
                    <div class="basketBox__item basketBox__item-main">
                        <div class="orderArea">
                            <div class="orderDone">
                                <div class="orderDone__inner">
                                    <div class="orderDone__ico">
                                        <svg>
                                            <use xlink:href="<?=$templateFolder?>/images/icons.svg#consultant"></use>
                                        </svg>
                                    </div>
                                    <div class="orderDone__text">
                                        Ваш заказ оформлен. Наш менеджер свяжется с Вами в ближайшее время.
                                    </div>
                                </div>
                            </div>
                            <div class="orderDoneList">
                                <div class="orderDoneList__inner">
                                    <div class="orderDoneList__item">
                                        <div class="odItem">
                                            <div class="odItem__title">
                                                <div class="odItem__ico">
                                                    <svg width="22px" height="22px">
                                                        <use xlink:href="<?=$templateFolder?>/images/icons.svg#login"></use>
                                                    </svg>
                                                </div>
                                                <div class="odItem__text">
                                                    Покупатель
                                                </div>
                                            </div>
                                            <div class="odItem__body">
                                                <ul class="charList">
                                                    <? if($arResult['ORDER_DATA']['nameAccountOrder']) { ?>
                                                    <li class="charList__item">
                                                        <div class="charList__inner">
                                                            <span class="charList__prop">Имя:</span> <span class="charList__value"><?=$arResult['ORDER_DATA']['nameAccountOrder']?></span>
                                                        </div>
                                                    </li>
                                                    <? } ?>
                                                    <? if($arResult['ORDER_DATA']['lastnameAccountOrder']) { ?>
                                                    <li class="charList__item">
                                                        <div class="charList__inner">
                                                            <span class="charList__prop">Фамилия:</span> <span class="charList__value"><?=$arResult['ORDER_DATA']['lastnameAccountOrder']?></span>
                                                        </div>
                                                    </li>
                                                    <? } ?>
                                                    <? if($arResult['ORDER_DATA']['phoneAccountOrder']) { ?>
                                                    <li class="charList__item">
                                                        <div class="charList__inner">
                                                            <span class="charList__prop">Телефон:</span> <span class="charList__value phone_mask_value"><?=$arResult['ORDER_DATA']['phoneAccountOrder']?></span>
                                                        </div>
                                                    </li>
                                                    <? } ?>
                                                    <? if($arResult['ORDER_DATA']['emailAccountOrder']) { ?>
                                                    <li class="charList__item">
                                                        <div class="charList__inner">
                                                            <span class="charList__prop">E-mail:</span> <span class="charList__value"><?=$arResult['ORDER_DATA']['emailAccountOrder']?></span>
                                                        </div>
                                                    </li>
                                                    <? } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="orderDoneList__item">
                                        <div class="odItem">
                                            <div class="odItem__title">
                                                <div class="odItem__ico">
                                                    <svg width="22px" height="22px">
                                                        <use xlink:href="<?=$templateFolder?>/images/icons.svg#delivery"></use>
                                                    </svg>
                                                </div>
                                                <div class="odItem__text">
                                                    Доставка
                                                </div>
                                            </div>
                                            <div class="odItem__body">
                                                <ul class="charList">
                                                    <li class="charList__item">
                                                        <div class="charList__inner">
                                                            <span class="charList__prop">Способ доставки:</span> <span class="charList__value"><?=$arResult['ORDER_DATA']['DELIVERY']['SHIP']['DELIVERY_NAME']?></span>
                                                        </div>
                                                    </li>
                                                    <li class="charList__item">
                                                        <div class="charList__inner">
                                                            <? if($arResult['ORDER_DATA']['DELIVERY_PROPS']) {
                                                                $city =  $arResult['ORDER_DATA']['DELIVERY_PROPS']['CITY'] ? : '';
                                                                $street = $arResult['ORDER_DATA']['DELIVERY_PROPS']['STREET'] ? ', ул. '. $arResult['ORDER_DATA']['DELIVERY_PROPS']['STREET'] : '';
                                                                $house = $arResult['ORDER_DATA']['DELIVERY_PROPS']['HOUSE'] ? ', д. '. $arResult['ORDER_DATA']['DELIVERY_PROPS']['HOUSE'] : '';
                                                                $korpus = $arResult['ORDER_DATA']['DELIVERY_PROPS']['KORPUS'] ? ', к. '. $arResult['ORDER_DATA']['DELIVERY_PROPS']['KORPUS'] : '';
                                                                $stroenie = $arResult['ORDER_DATA']['DELIVERY_PROPS']['STROENIE'] ? ', стр. '. $arResult['ORDER_DATA']['DELIVERY_PROPS']['STROENIE'] : '';
                                                                $appartment = $arResult['ORDER_DATA']['DELIVERY_PROPS']['APARTMENT'] ? ', кв./оф. '. $arResult['ORDER_DATA']['DELIVERY_PROPS']['APARTMENT'] : '';
                                                                $podjezd = $arResult['ORDER_DATA']['DELIVERY_PROPS']['PODJEZD'] ? ', '. $arResult['ORDER_DATA']['DELIVERY_PROPS']['PODJEZD'] . ' подъезд' : '';
                                                                $floor = $arResult['ORDER_DATA']['DELIVERY_PROPS']['FLOOR'] ? ', '. $arResult['ORDER_DATA']['DELIVERY_PROPS']['FLOOR'] . ' этаж' : '';
                                                                ?>
                                                            <span class="charList__prop">Адрес:</span> <span class="charList__value"><?=$city.$street.$house.$korpus.$stroenie.$appartment.$podjezd.$floor?></span>
                                                            <? } ?>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="orderDoneList__item">
                                        <div class="odItem">
                                            <div class="odItem__title">
                                                <div class="odItem__ico">
                                                    <svg width="22px" height="22px">
                                                        <use xlink:href="<?=$templateFolder?>/images/icons.svg#pay"></use>
                                                    </svg>
                                                </div>
                                                <div class="odItem__text">
                                                    Оплата
                                                </div>
                                            </div>
                                            <div class="odItem__body">
                                                <ul class="charList">
                                                    <li class="charList__item">
                                                        <div class="charList__inner">
                                                            <?
                                                            if ($arResult["ORDER"]["IS_ALLOW_PAY"] === 'Y')
                                                            {
                                                                if (!empty($arResult["PAYMENT"]))
                                                                {
                                                                    foreach ($arResult["PAYMENT"] as $payment)
                                                                    {
                                                                        if ($payment["PAID"] != 'Y')
                                                                        {
                                                                            if (!empty($arResult['PAY_SYSTEM_LIST'])
                                                                                && array_key_exists($payment["PAY_SYSTEM_ID"], $arResult['PAY_SYSTEM_LIST'])
                                                                            )
                                                                            {
                                                                                $arPaySystem = $arResult['PAY_SYSTEM_LIST_BY_PAYMENT_ID'][$payment["ID"]];

                                                                                if (empty($arPaySystem["ERROR"]))
                                                                                {
                                                                                    ?>
                                                                                    <p><span class="charList__value"><?=$arPaySystem["NAME"]?></span></p><br/>
                                                                                    <? if ($arPaySystem["ACTION_FILE"] <> '' && $arPaySystem["NEW_WINDOW"] == "Y" && $arPaySystem["IS_CASH"] != "Y"): ?>
                                                                                        <?
                                                                                        $orderAccountNumber = urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]));
                                                                                        $paymentAccountNumber = $payment["ACCOUNT_NUMBER"];
                                                                                        ?>
                                                                                        <script>
                                                                                            window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=$orderAccountNumber?>&PAYMENT_ID=<?=$paymentAccountNumber?>&pdf=Y');
                                                                                        </script>
                                                                                        <p><?=Loc::getMessage("SOA_PAY_LINK", array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".$orderAccountNumber."&PAYMENT_ID=".$paymentAccountNumber."&pdf=Y"))?></p>
                                                                                        <? if (CSalePdf::isPdfAvailable() && $arPaySystem['IS_AFFORD_PDF']): ?>
                                                                                            <br/>
                                                                                            </p><?=Loc::getMessage("SOA_PAY_PDF", array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".$orderAccountNumber."&pdf=1&DOWNLOAD=Y"))?></p>
                                                                                        <? endif ?>
                                                                                    <? else: ?>
                                                                                        <?=$arPaySystem["BUFFERED_OUTPUT"]?>
                                                                                    <? endif ?>

                                                                                    <?
                                                                                }
                                                                                else
                                                                                {
                                                                                    ?>
                                                                                    <div class="alert alert-danger" role="alert"><?=Loc::getMessage("SOA_ORDER_PS_ERROR")?></div>
                                                                                    <?
                                                                                }
                                                                            }
                                                                            else
                                                                            {
                                                                                ?>
                                                                                <div class="alert alert-danger" role="alert"><?=Loc::getMessage("SOA_ORDER_PS_ERROR")?></div>
                                                                                <?
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            else
                                                            {
                                                                ?>
                                                                <div class="alert alert-danger" role="alert"><?=$arParams['MESS_PAY_SYSTEM_PAYABLE_ERROR']?></div>
                                                                <?
                                                            }
                                                            ?>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <?if($arResult['ORDER']['USER_DESCRIPTION']) { ?>
                                        <div class="orderDoneList__item">
                                            <div class="odItem">
                                                <div class="odItem__title">
                                                    <div class="odItem__ico">
                                                        <svg width="22px" height="22px">
                                                            <use xlink:href="<?=$templateFolder?>/images/icons.svg#edit"></use>
                                                        </svg>
                                                    </div>
                                                    <div class="odItem__text">
                                                        Комментарий
                                                    </div>
                                                </div>
                                                <div class="odItem__body">
                                                    <ul class="charList">
                                                        <li class="charList__item">
                                                            <div class="charList__inner">
                                                                <span class="charList__value"><?=$arResult['ORDER']['USER_DESCRIPTION']?></span>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    <? } ?>
                                </div>
                            </div>
                            <div class="orderDone__ps">
                                <div class="warningMessage">
                                    <div class="warningMessage__inner">
                                        <div class="warningMessage__ico">
                                            <svg>
                                                <use xlink:href="<?=$templateFolder?>/images/icons.svg#warning"></use>
                                            </svg>
                                        </div>
                                        <div class="warningMessage__text">
                                            Вы можете отслеживать выполнение своего заказа и изменение его статуса в <a href="<?=$arParams["PATH_TO_PERSONAL"]?>">Личном кабинете</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="basketFixed">
                            <div class="basketFixed__inner">
                                <div class="basketFixed__item basketFixed__item-price">
                                    <div class="lineInner">
                                        <div class="lineInner__label">
                                            Всего
                                        </div>
                                        <div class="lineInner__value">
                                            <?=$arResult['ORDER_DATA']['PRICES']['SUM']?>
                                        </div>
                                    </div>
                                </div>
                                <div class="basketFixed__item basketFixed__item-btn">
                                    <button class="customBtn customBtn-light">
                                        <span class="customBtn__inner">
                                            <span class="customBtn__text">Оплатить заказ</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="basketBox__item basketBox__item-side">
                        <div class="basketSide">
                            <div class="basketSide__main">
                                <div class="basketSide__line">
                                    <div class="lineInner">
                                        <div class="lineInner__label">
                                            Товаров на
                                        </div>
                                        <div class="lineInner__value">
                                            <?=$arResult["ORDER_DATA"]['PRICES']["SUM_WITHOUT_DISCOUNT"]?>
                                        </div>
                                    </div>
                                </div>
                                <div class="basketSide__line">
                                    <div class="lineInner">
                                        <div class="lineInner__label">
                                            Скидка
                                        </div>
                                        <div class="lineInner__value">
                                            <?=$arResult['ORDER_DATA']['PRICES']['DISCOUNT_SUM']?>
                                        </div>
                                    </div>
                                </div>
                                <div class="basketSide__line">
                                    <div class="lineInner">
                                        <div class="lineInner__label">
                                            Доставка
                                        </div>
                                        <div class="lineInner__value">
                                            <?=$arResult['ORDER_DATA']['PRICES']['DELIVERY_SUM']?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="basketSide__total">
                                <div class="lineInner">
                                    <div class="lineInner__label">
                                        Всего
                                    </div>
                                    <div class="lineInner__value">
                                        <?=$arResult['ORDER_DATA']['PRICES']['SUM']?>
                                    </div>
                                </div>
                            </div>
                            <?/*<div class="basketSide__btn">
                                <button class="customBtn customBtn-light">
                                    <span class="customBtn__inner">
                                        <span class="customBtn__text">Оплатить заказ</span>
                                    </span>
                                </button>
                                <a class="customBtn" href="">
                                    <span class="customBtn__inner">
                                        <span class="customBtn__arrow">
                                            <svg>
                                                <use xlink:href="<?=$templateFolder?>/images/icons.svg#dropdown"></use>
                                            </svg>
                                        </span>
                                        <span class="customBtn__text">Вернуться в корзину</span>
                                    </span>
                                </a>
                            </div>*/?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<? else: ?>

	<div class="row mb-2">
		<div class="col">
			<div class="alert alert-danger" role="alert"><strong><?=Loc::getMessage("SOA_ERROR_ORDER")?></strong><br />
				<?=Loc::getMessage("SOA_ERROR_ORDER_LOST", ["#ORDER_ID#" => htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"])])?><br />
				<?=Loc::getMessage("SOA_ERROR_ORDER_LOST1")?></div>
		</div>
	</div>

<? endif ?>