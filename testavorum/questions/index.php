<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); ?>



<?php
$APPLICATION->IncludeComponent(
    "apollonlab:PassTest",
    ".default",
    array(),
    false
);
?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>