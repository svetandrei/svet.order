<?
define("NO_KEEP_STATISTIC", true);
define("NO_AGENT_STATISTIC", true);
define('NOT_CHECK_PERMISSIONS', true);

require_once($_SERVER["DOCUMENT_ROOT"].'/bitrix/modules/main/include/prolog_before.php');

use Bitrix\Main\Localization\Loc;

header('Content-Type: application/x-javascript; charset='.LANG_CHARSET);

if(!$_POST["query"]) {
    print(CUtil::PhpToJSObject(array(
        "error" => true,
        "data" => Loc::getMessage("EMPTY_QUERY")
    ), false, false, true));
    exit();
}
$fields = array(
    "query" => $_POST["query"],
    "count" => 5,
);
$curl = curl_init();

curl_setopt_array($curl, array(
    //CURLOPT_URL => "https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/party",
    CURLOPT_URL => "https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/party",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING =>"",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode($fields),
    CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json",
        "Accept: application/json",
        "Authorization: Token f82479bd4e76d4786cb6570b4fd45f7f72738d29"
    ),
));

$response = curl_exec($curl);

curl_close($curl);
$response = json_decode($response);
print(json_encode(array("data" => $response)));
exit();