<?php
if($_REQUEST['flag'] == 'viewClass') {
    $arResult["classID"] = $_REQUEST['classID'];
}
//$arResult['classRealID'] = CIBlockElement::GetList(array('SORT' => "ASC"), array('TITLE' => $_REQUEST["className"]), false, false, array("ID"))->Fetch()['ID'];
