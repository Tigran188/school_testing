<?php
use Bitrix\Main\Page\Asset,
    Bitrix\Main\Localization\Loc;

// Получаем содержимое языкового файла
$ARJSMESS = Loc::LoadLanguageFile($_SERVER["DOCUMENT_ROOT"]."/local/");
if (!empty($ARJSMESS)) {
    // Добавляем объект с переводами.
    Asset::getInstance()->AddString("<sc ript type=\"text/javascript\">BX.message(".CUtil::PhpToJSObject($ARJSMESS).")</sc ript>");
}