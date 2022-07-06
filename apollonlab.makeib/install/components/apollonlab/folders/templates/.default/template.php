<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) { die(); }
use Bitrix\Main\Localization\Loc;

global $APPLICATION;
IncludeTemplateLangFile(__DIR__ . '/lang/' . LANGUAGE_ID);


foreach ($arResult["SECTIONS"] as $section): ?>
    <div class="folder" data-id="<?=$section["ID"]?>">
        <?if($USER->IsAdmin()):?>
            <p class="deleteFolder">X</p>
        <?endif?>
        <img src="images/folder.png" alt="error!" class="folderImg"/>
        <p class="folderInfo">
            <span class="nameOfFolder"><?=$section["NAME"]?></span>
            <span class="editFolder">
                <a href="#" class="editFolderName"><img src="./images/pen.png" alt="error!"></a>
            </span>
        </p>
    </div>
<?php endforeach;?>

<div class="addFolder">
    <a href="#">
        <p class="addSymbol">+</p>
        <p class="addLink"><?=GetMessage("ADD_FOLDER")?></p>
    </a>
</div>