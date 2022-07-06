<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
\Bitrix\Main\Localization\Loc::loadLanguageFile(__DIR__ . '/lang/' . LANGUAGE_ID);
$APPLICATION->SetTitle($arResult['TEST_NAME']);
?>
<p class="gave_time" data-time="<?=$arResult['QUESTIONS']['TIME_FOR_TEST']?>:00"><?=GetMessage('GIVED_TIME')?> <?=$arResult['QUESTIONS']['TIME_FOR_TEST']?>:00 </p>

<a href="#" class="start_test" data-id="<?=$_GET['TEST_ID']?>"><?=GetMessage('START')?></a>






<?require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
