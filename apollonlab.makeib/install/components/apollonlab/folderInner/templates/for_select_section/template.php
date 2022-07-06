<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) { die(); }?>
    <span class="folder_id d-none" id="<?=$arResult['FOLDER_ID']?>"></span>
<?php
    foreach ($arResult["ELEMENTS"]["SECTIONS"] as $item) {
        if($item['ELEMS_COUNT'] > 0):
        ?>
        <div class="fold" data-count="<?=$item['ELEMS_COUNT']?>" data-id="<?=$item['ID']?>" id="<?=$item['ID']?>">
            <label>
                <input value="<?=$item['ID']?>" type="radio" name="section">
            </label>
            <a href="#" class="foldImgName">
                <img src="images/folder.png" alt="error!">
                <p>
                    <span class="section_name"><?=strip_tags($item["NAME"])?></span>
                </p>
            </a>
        </div>
<?php
    endif;
    }

