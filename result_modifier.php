<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 * @var SaleOrderAjax $component
 */

$component = $this->__component;
$component::scaleImages($arResult['JS_DATA'], $arParams['SERVICES_IMAGES_SCALING']);

if(!empty($arResult["ORDER"])) {
    $order = \Bitrix\Sale\Order::load($arResult['ORDER']['ID']);
    $properties = $order->getPropertyCollection()->getArray();
    foreach ($properties['properties'] as $props) {
        switch ($props['CODE']) {
            case 'NAME':
                $arResult['ORDER_DATA']['nameAccountOrder']  = $props['VALUE']['0'];
                break;
            case 'LAST_NAME':
                $arResult['ORDER_DATA']['lastnameAccountOrder'] = $props['VALUE']['0'];
                break;
            case 'PHONE':
                $arResult['ORDER_DATA']['phoneAccountOrder'] = $props['VALUE']['0'];
                break;
            case 'EMAIL':
                $arResult['ORDER_DATA']['emailAccountOrder'] = $props['VALUE']['0'];
                break;
            default:
                $arResult['ORDER_DATA']['DELIVERY_PROPS'][$props['CODE']] = $props['VALUE']['0'];
        }
    }
    $sql = Bitrix\Sale\Location\LocationTable::getList(array(
        "filter" => array("=CODE" => $arResult["ORDER_DATA"]["DELIVERY_PROPS"]["CITY"], "=NAME.LANGUAGE_ID" => LANGUAGE_ID),
        "select" => array("ID", "CODE", "SORT", "DISPLAY" => "NAME.NAME", "LEFT_MARGIN", "RIGHT_MARGIN", "VALUE" => "ID", "TYPE_ID"),
        "limit" => 1
    ));
    while($item = $sql->fetch()) {
        $arResult["ORDER_DATA"]["DELIVERY_PROPS"]["CITY"] = $item["DISPLAY"];
    }
    $paymentCollection = $order->getPaymentCollection();
    foreach ($paymentCollection as $payment) {
        $ps[] = array(
            'SUM' => $payment->getSum(),
            'NAME' => $payment->getPaymentSystemName()
        );
    }
    $arResult['ORDER_DATA']['PAYMENT'] = $ps;
    foreach ($order->getShipmentCollection() as $shipment){
        if ($shipment->isSystem()) continue;
        $storeId = $shipment->getStoreId();
        $arResult['ORDER_DATA']['DELIVERY']['SHIP'] = $shipment->getFieldValues();
        $extra = $shipment->getExtraServices();
        $extraList = \Bitrix\Sale\Delivery\ExtraServices\Manager::getExtraServicesList($arResult['ORDER']['DELIVERY_ID'], false);
        foreach ($extra as $keyEs => $es) {
            if($es != 'N' && $es != '0') {
                $arResult['ORDER_DATA']['DELIVERY']['EXTRA'][$keyEs] = $extraList[$keyEs];
            }
        }
        if($storeId){
            $arResult['ORDER_DATA']['DELIVERY']['STORE'] = \Bitrix\Catalog\StoreTable::getRow([
                'select' => ['UF_*', '*'],
                'filter' => [
                    'ID' => $storeId,
                ]
            ]);
            break;
        }
    }

    $basket = $order->getBasket();
    $arResult['ORDER_DATA']['PRICES']['SUM'] = SaleFormatCurrency($order->getPrice(), $arResult['ORDER']['CURRENCY']);
    $arResult['ORDER_DATA']['PRICES']['SUM_WITHOUT_DISCOUNT'] = SaleFormatCurrency($basket->getBasePrice(), $arResult['ORDER']['CURRENCY']);
    $arResult['ORDER_DATA']['PRICES']['DISCOUNT_SUM'] = SaleFormatCurrency($order->getDiscountPrice() + ($basket->getBasePrice() - $basket->getPrice()), $arResult['ORDER']['CURRENCY']);
    $arResult['ORDER_DATA']['PRICES']['DELIVERY_SUM'] = SaleFormatCurrency($order->getDeliveryPrice(), $arResult['ORDER']['CURRENCY']);
    foreach ($basket->getBasketItems() as $b) {
        $arResult['ORDER_DATA']['BASKET'][] = CIBlockElement::GetByID($b->getField('PRODUCT_ID'))->GetNext();
    }
    $arResult['ORDER_DATA']['BASKET_COUNT'] = count($arResult['ORDER_DATA']['BASKET']);
}