<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) { die(); }

$APPLICATION->SetTitle(GetMessage('UPDATE_TEST'));

$this->addExternalCss($templateFolder . "/styles.css");
$this->addExternalJs($templateFolder . "/script.js");
IncludeTemplateLangFile(__FILE__);
?>
<div class="middleMain">
    <h3 class="mainTitle arial"><?=GetMessage('TESTS')?></h3>
    <?php
    $section_options = [];
    foreach ($_REQUEST['sections_and_options'] as $section){

        for($i = 1; $i <= $section[2]; $i++){
            $section_options[$section[0]]['ids'][] = CIBlockElement::GetList(["RAND" => "ASC"], ['SECTION_ID' => $section[0]], false, false, ['ID'])->Fetch()['ID'];
        }
        $section_options[$section[0]]['points'] = $section[1];
    }
    ?>
    <div class="testName">
        <input type="text" placeholder="<?=GetMessage('INPUT_TEST_NAME')?>" class="arial testNameInput" value="<?=$arResult['EDITABLE_TEST']['UF_TITLE']?>">
    </div>
    <div class="mainSettings arial">
        <div>
            <label class="arial">
                <span class="arial"><?=GetMessage('SELECT_SECTIONS_COUNT')?></span>
                <div class="number">
                    <input type="number" value="<?=count($arResult['EDITABLE_TEST']['UF_QUESTIONS'])?>" min="1" name="countOfQuestions" readonly>
                    <span>
                            <img src="images/trig1.png" alt="" class="addNum">
                            <img src="images/trig2.png" alt="" class="removeNum">
                        </span>
                </div>
            </label>
        </div>
        <div>
            <label class="arial">
                <span class="arial"><?=GetMessage('INPUT_TEST_NAME')?></span>
                <span class="time">
                    <input type="text" name="hours" value="<?=explode(":", $arResult['EDITABLE_TEST']['UF_TIME'])[0]?>">
                    <span>:</span>
                    <input type="text" name="minutes" value="<?=explode(":", $arResult['EDITABLE_TEST']['UF_TIME'])[1]?>">
                </span>
            </label>
        </div>
        <div>
            <label class="arial">
                <span class="arial"><?=GetMessage('MK_OPEN')?></span>
                <input type="checkbox" name="isOpen" <?if($arResult['EDITABLE_TEST']['UF_OPEN'] != 0):?> checked <?php endif;?>>
            </label>
            <span class="info">?</span>
        </div>
        <div>
            <label class="arial">
                <span class="arial"><?=GetMessage('TO_BACK')?></span>
                <input type="checkbox" name="back" <?if($arResult['EDITABLE_TEST']['UF_BACK'] != 0):?> checked <?php endif;?>>
            </label>
        </div>
    </div>
    <div class="mainSettingsRow2">
        <?
        foreach ($arResult['EDITABLE_TEST']['UF_QUESTIONS'] as $key => $section):
            foreach ($section as $key2 => $s) {
                if($key2 == 'point') continue;
            ?>
            <div class="folderForQuestion">
                <a href="#" class="arial" data-section-id="<?=$key2?>"><?=$s['name']?></a>
                <img src="images/Screenshot_1.png" alt="error">
                <label class="points arial">
                    <?=GetMessage('POINT')?>
                    <input type="number" min="1" class="d-block point" value="<?=$section['point']?>">
                </label>

                <img src="images/Screenshot_1.png" alt="error">

                <label class="questionsCount arial">
                    <span><?=GetMessage('SELECT_QUESTIONS_COUNT')?></span>
                    <input type="number" value="<?=count($s) - 1?>" min="1" name="countOfQuestions" class="countOfQuestions">
                </label>
                <span class="del arial">X</span>
            </div>
        <?
            }
        endforeach;?>
    </div>
    <div class="buttons">
        <a href="creatingTest.php" class="button update arial">Պահպանել</a>
        <a href="#" class="button arial">Չեղարկել</a>
    </div>
</div>
