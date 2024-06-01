<?
define("NO_KEEP_STATISTIC", true);
define("NO_AGENT_STATISTIC", true);
define('NOT_CHECK_PERMISSIONS', true);

use Bitrix\Main\Loader;
use Bitrix\Sale\Location;
use Bitrix\Main\Service\GeoIp;

require_once($_SERVER["DOCUMENT_ROOT"].'/bitrix/modules/main/include/prolog_before.php');

Loader::includeModule('sale');

$siteId = '';
if($_REQUEST['SITE_ID'] <> '')
{
    $siteId = $_REQUEST['SITE_ID'];
}
elseif(mb_strlen(SITE_ID))
{
    $siteId = SITE_ID;
}
if($_REQUEST['phrase']) {
    $sql = Location\Search\Finder::find(array(
        "filter" => array("PHRASE" => $_REQUEST['phrase'], "SITE_ID" => $siteId, "=NAME.LANGUAGE_ID" => LANGUAGE_ID),
        "select" => array("ID", "CODE", "SORT", "NAME.NAME", "LEFT_MARGIN", "RIGHT_MARGIN", "LT_SORT", "VALUE" => "ID", "TYPE_ID"),
        "limit" => 5
    ));
    while($item = $sql->fetch()) {
        $result['ITEMS'][$item['ID']] = $item;
    }
    if(!empty($result['ITEMS'])) {
        $sql = Location\LocationTable::getPathToMultipleNodes($result['ITEMS'], array('select' => array('ID', 'DISPLAY' => 'NAME.NAME')));
        while($path = $sql->fetch()) {
            $i = 1;
            foreach($path['PATH'] as $id => $pItem) {
                if($i === count($path['PATH']))
                    $result['ITEMS'][$path['ID']]['FULL_NAME'] .= $pItem['DISPLAY'];
                else
                    $result['ITEMS'][$path['ID']]['FULL_NAME'] .= $pItem['DISPLAY'] . ', ';
                $i++;
            }
        }
    }
}

if($_REQUEST['code']) {
    $code = $_REQUEST['code'];

    /*$ipAddress = GeoIp\Manager::getRealIp();
    if($ipAddress) {
        $code = Location\GeoIp::getLocationCode($ipAddress, LANGUAGE_ID) ? : $code;
    }*/
    $sql = Location\LocationTable::getList(array(
        "filter" => array("=CODE" => $code, "=NAME.LANGUAGE_ID" => LANGUAGE_ID),
        "select" => array("ID", "CODE", "SORT", "DISPLAY" => "NAME.NAME", "LEFT_MARGIN", "RIGHT_MARGIN", "VALUE" => "ID", "TYPE_ID"),
        "limit" => 1
    ));
    while($item = $sql->fetch()) {
        $result['ITEM'][$item["ID"]] = $item;
    }
    if(!empty($result['ITEM'])) {
        $sql = Location\LocationTable::getPathToMultipleNodes($result['ITEM'], array('select' => array('ID', 'DISPLAY' => 'NAME.NAME')));
        while($path = $sql->fetch()) {
            $i = 1;
            foreach($path['PATH'] as $id => $pItem) {
                if($i === count($path['PATH']))
                    $result['ITEM'][$path["ID"]]['FULL_NAME'] .= $pItem['DISPLAY'];
                else
                    $result['ITEM'][$path["ID"]]['FULL_NAME'] .= $pItem['DISPLAY'] . ', ';
                $i++;
            }
        }
    }
    $result["ITEMS"] = reset($result["ITEM"]);
}

header('Content-Type: application/x-javascript; charset='.LANG_CHARSET);
print(CUtil::PhpToJSObject(array(
    'error' => empty($result['ITEMS']),
    'data' => $result['ITEMS']
), false, false, true));

/*$item = Helper::getLocationsByZip($_REQUEST['ZIP'], array('limit' => 1))->fetch();

if(!isset($item['LOCATION_ID'])) {
    $result['ERRORS'] = array('Not found');
} else {
    $result['DATA']['ID'] = intval($item['LOCATION_ID']);

    if($siteId <> '')
    {
        if(!Location\SiteLocationTable::checkConnectionExists($siteId, $result['DATA']['ID']))
        {
            $result['ERRORS'] = array('Found, but not connected');
        }
    }
}

header('Content-Type: application/x-javascript; charset='.LANG_CHARSET);

print(CUtil::PhpToJSObject(array(
    'result' => empty($result['ERRORS']),
    'errors' => $result['ERRORS'],
    'data' => $result['DATA']
), false, false, true));*/