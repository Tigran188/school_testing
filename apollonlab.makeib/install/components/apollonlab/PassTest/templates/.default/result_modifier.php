<?php
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;
\Bitrix\Main\Localization\Loc::loadLanguageFile(__DIR__ . '/lang/' . LANGUAGE_ID);
global $USER;
$request = Bitrix\Main\Application::getInstance()->getContext()->getRequest();






$hlblock = HLBT::getById(4)->fetch();
$entity = HLBT::compileEntity($hlblock);
$entity_data_class = $entity->getDataClass();
$passed_data = $entity_data_class::getList(array(
    'select' => array('*'),
    'filter' => array(
        "UF_TEST_ID" => $request->get('TEST_ID'),
        "UF_USER_ID" => $USER->GetID(),
    )
))->Fetch();

$hlblock = HLBT::getById(3)->fetch();
$entity = HLBT::compileEntity($hlblock);
$entity_data_class = $entity->getDataClass();
$passed_data2 = $entity_data_class::getList(array(
    'select' => array('*'),
    'filter' => array(
        "ID" => $request->get('TEST_ID'),
    )
))->Fetch();
$arResult['CAN_VIEW'] = false;
if($passed_data['UF_CHECKED'] && $passed_data2['UF_OPEN']){
    $arResult['CAN_VIEW'] = true;
}