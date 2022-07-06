<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) { die(); }?>
    <span class="folder_id d-none" id="<?=$arResult['FOLDER_ID']?>"></span>
<?php
    foreach ($arResult["ELEMENTS"]["SECTIONS"] as $item) {
        ?>
        <div class="fold" data-id="<?=$item['ID']?>" id="<?=$item['ID']?>">
            <?if($USER->IsAdmin() || $USER->GetID() == 4122):?>
                <a href="#" class="del">X</a>
            <?endif;?>
            <a href="#" class="foldImgName">
                <img src="images/folder.png" alt="error!">
                <p>
                    <span class="section_name"><?=$item["NAME"]?></span>
                    <img src="images/pen.png" alt="error!" class="editFolderIn"/>
                </p>
            </a>
        </div>
<?php }

foreach ($arResult["ELEMENTS"]["ELEMENTS"] as $item) {?>


    <div class="sectElement" data-id="<?=$item['ID']?>" id="<?=$item['ID']?>">
        <a href="#" class="delElem">X</a>
        <a href="#" class="elemImgName">
            <img src="images/file.png" alt="error!">
            <p>
                <span><?=strip_tags($item["NAME"])?></span>
                <img src="images/pen.png" alt="error!" class="editElem"/>
            </p>
        </a>
    </div>

<?php } ?>

