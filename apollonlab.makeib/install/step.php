<?php /** @noinspection PhpUndefinedVariableInspection */

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

if(!check_bitrix_sessid()){

    return;
}

if ($errorException = $APPLICATION->GetException()) {
    echo(CAdminMessage::ShowMessage($errorException->GetString()));
}else{
    echo(CAdminMessage::ShowNote(Loc::getMessage("INSTALL_FINISHED")));
}
?>

<form action="">
    <input type="hidden" name="lang" value="1" />
    <input type="submit" value="<?php echo(Loc::getMessage("GO_BACK")); ?>">
</form>