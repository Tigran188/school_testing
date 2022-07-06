<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) { die(); }

$APPLICATION->SetTitle(GetMessage('CREATE_TEST'));


$this->addExternalCss($templateFolder . "/styles.css");
$this->addExternalJs($templateFolder . "/script.js");
IncludeTemplateLangFile(__FILE__);
?>
<div class="middleMain">
    <h3 class="mainTitle arial"><?=GetMessage('TESTS')?></h3>
    <?php
    $section_options = [];





    foreach ($arResult['EDITABLE_TEST']['UF_QUESTIONS'] as $key => $section) {
        foreach ($section as $key2 => $item) {
            foreach ($item as $k => $i) {
                if ($k == 'point') {
                    continue;
                }
                $arResult['EDITABLE_TEST']['UF_QUESTIONS'][$key][$key2][$k]['name'] = CIBlockSection::GetByID($k)->Fetch()['NAME'];
            }
        }
        break;
    }




    foreach ($_REQUEST['sections_and_options'] as $section){

        for($i = 1; $i <= $section[2]; $i++){
            $section_options[$section[0]]['ids'][] = CIBlockElement::GetList(["RAND" => "ASC"], ['SECTION_ID' => $section[0]], false, false, ['ID'])->Fetch()['ID'];
        }
        $section_options[$section[0]]['points'] = $section[1];
    }
    ?>
    <div class="testName">
        <input type="text" placeholder="<?=GetMessage('INPUT_TEST_NAME')?>" class="arial testNameInput">
    </div>
    <div class="mainSettings arial">
        <div>
            <label class="arial">
                <span class="arial"><?=GetMessage('SELECT_SECTIONS_COUNT')?></span>
                <div class="number">
                    <input type="number" value="1" min="1" name="countOfQuestions" readonly>
                    <span>
                            <img src="images/trig1.png" alt="" class="addNum">
                            <img src="images/trig2.png" alt="" class="removeNum">
                        </span>
                </div>
            </label>
        </div>
        <div>
            <label class="arial">
                <span class="arial"><?=GetMessage('TIME_FOR_TEST')?></span>
                <span class="time">
                    <input type="text" name="hours" value="00">
                    <span>:</span>
                    <input type="text" name="minutes" value="10">
                </span>
                <!--                <input type="time" name="time" value="--><?//=$arResult['EDITABLE_TEST']['UF_TIME']?><!--" min="00:00" max="12:00">-->
            </label>
        </div>
        <div>
            <label class="arial">
                <span class="arial"><?=GetMessage('MK_OPEN')?></span>
                <input type="checkbox" name="isOpen">
            </label>
            <span class="info">?</span>
        </div>
        <div>
            <label class="arial">
                <span class="arial"><?=GetMessage('TO_BACK')?></span>
                <input type="checkbox" name="back">
            </label>
        </div>
    </div>
    <div class="mainSettingsRow2">
        <div class="folderForQuestion">
            <a href="#" class="arial"><?=GetMessage('SELECT_SECTION')?></a>
            <img src="images/Screenshot_1.png" alt="error">
            <label class="points arial">
                <?=GetMessage('POINT')?>
                <input type="number" min="1" class="d-block point" value="1">
            </label>

            <img src="images/Screenshot_1.png" alt="error">

            <label class="questionsCount arial">
                <span><?=GetMessage('SELECT_QUESTIONS_COUNT')?></span>
                <input type="number" value="1" min="1" name="countOfQuestions" class="countOfQuestions">
            </label>
            <span class="del arial">X</span>
        </div>
    </div>
    <div class="buttons">
        <a href="#" class="button save arial"><?=GetMessage('SAVE')?></a>
        <a href="#" class="button arial"><?=GetMessage('CANCEL')?></a>
    </div>
</div>
