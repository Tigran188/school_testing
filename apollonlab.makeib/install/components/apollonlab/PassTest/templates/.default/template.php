<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$request = Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$APPLICATION->SetTitle($arResult['TEST_DATA']['UF_TITLE']);

if(!$arResult['EXPIRED']):
    ?>

    <div class="middleMain">

        <?
        if ($request->getPost('flag')) {
            $APPLICATION->RestartBuffer();
        }
        $question = $arResult['QUESTIONS']['QUESTIONS'][$arResult['CURRENT']];
        if($question['PREVIEW_PICTURE']){
            $pic = CFile::GetPath($question['PREVIEW_PICTURE']);
            ?>
            <div class="questionPicture">
                <img src="<?=$pic?>" alt="#">
            </div>
            <?
        }

//        global $USER;
//        if($USER->GetID() == 1894) {
//            echo "<pre>";
//            print_r($question);
//            die;
//        }
        switch ($question['PROPS']['QUESTION_TYPE']['VALUE_XML_ID']):
            case 'SINGLE_ANSWER':
                ?>
                <!--    one answer version-->
                <div data-id="<?= $question['ID'] ?>" class="oneAnswer question_block">
                    <div class="question">
                        <p class="mainQuestion arial">
                            <span class="number arial">1.</span>
                            <?= strip_tags($question['PROPS']['MAIN_QUESTION']) ?>
                        </p>
                    </div>
                    <div class="answerVersions">
                        <? foreach ($question['PROPS']['ANSWER_VERSIONS'] as $key => $version): ?>
                            <label class="arial">
                                <span class="checkLabel">
                                    <span></span>
                                </span>
                                <input value="<?echo $key + 1;?>" type="radio" name="version" hidden>
                                <?= $version['TEXT'] ?>
                            </label>
                        <? endforeach; ?>
                    </div>
                    <div class="buttonAndCoins">
                        <p class="arial"><span class="question_point"><?= $question['POINT'] ?></span> <?=GetMessage('POINT')?></p>
                        <div>
                            <?if($arResult['BACK'] && $arResult['CURRENT'] > 0){?>
                                <a href="#" class="previous_question arial"><?=GetMessage('PREVIOUS')?></a>
                            <?}?>
                            <? if ($arResult['LAST'] == 'Y'):?>
                                <a href="#" class="finish_test next arial"><?=GetMessage('FINISH')?></a>
                            <? else:?>
                                <span class="next arial"><?=GetMessage('NEXT')?></span>
                            <?endif; ?>
                        </div>
                    </div>
                </div>

                <?
                break;
            case 'MULTIPLE_ANSWER':
                ?>
                <!--                many answers version    -->
                <div data-id="<?= $question['ID'] ?>" class="manyAnswers question_block">
                    <div class="question">
                        <p class="mainQuestion arial">
                            <span class="number arial">1.</span>
                            <?= strip_tags($question['PROPS']['MAIN_QUESTION']) ?>
                        </p>
                    </div>
                    <div class="answerVersions">
                        <? foreach ($question['PROPS']['ANSWER_VERSIONS'] as $key => $version): ?>
                            <label class="arial">
                                <span class="checkLabel">
                                    <span></span>
                                </span>
                                <input value="<?=$key + 1?>" type="checkbox" name="version" hidden>
                                <?= $version['TEXT'] ?>
                            </label>
                        <? endforeach; ?>
                    </div>
                    <div class="buttonAndCoins">
                        <p class="arial"><span class="question_point"><?= $question['POINT'] ?></span> <?=GetMessage('POINT')?></p>
                        <div>
                            <?if($arResult['BACK'] && $arResult['CURRENT'] > 0){?>
                                <a href="#" class="previous_question arial"><?=GetMessage('PREVIOUS')?></a>
                            <?}?>
                            <? if ($arResult['LAST'] == 'Y'):?>
                                <a href="#" class="finish_test next arial"><?=GetMessage('FINISH')?></a>
                            <? else:?>
                                <span class="next arial"><?=GetMessage('NEXT')?></span>
                            <?endif; ?>
                        </div>
                    </div>
                </div>

                <?
                break;
            case 'CORRECT_MISTAKE':
                ?>
                <!--                correct mistake    -->
                <div data-id="<?= $question['ID'] ?>" class="correctMistake question_block">
                    <div class="question">
                        <p class="mainQuestion arial">
                            <span class="number arial">1.</span>
                            Ուղղել սխալը
                        </p>
                    </div>
                    <div class="banner">
                        <textarea name="textWithMistake"><?= strip_tags($question['PROPS']['MAIN_QUESTION']) ?></textarea>
                    </div>
                    <div class="buttonAndCoins">
                        <p class="arial"><span class="question_point"><?= $question['POINT'] ?></span> <?=GetMessage('POINT')?></p>
                        <div>
                            <?if($arResult['BACK'] && $arResult['CURRENT'] > 0){?>
                                <a href="#" class="previous_question arial"><?=GetMessage('PREVIOUS')?></a>
                            <?}?>
                            <? if ($arResult['LAST'] == 'Y'):?>
                                <a href="#" class="finish_test next arial"><?=GetMessage('FINISH')?></a>
                            <? else:?>
                                <span class="next arial"><?=GetMessage('NEXT')?></span>
                            <?endif; ?>
                        </div>
                    </div>
                </div>

                <?
                break;
            case 'ESSE':
                ?>
                <!--                sharadrutyun-->
                <div data-id="<?= $question['ID'] ?>" class="essay question_block">
                    <div class="question">
                        <p class="mainQuestion arial">
                            <span class="number arial">1.</span>
                            <?= $question['PROPS']['MAIN_QUESTION'] ?>
                        </p>
                    </div>
                    <div class="banner">
                        <textarea name="esse"></textarea>
                    </div>
                    <div class="buttonAndCoins">
                        <p class="arial"><span class="question_point"><?= $question['POINT'] ?></span> <?=GetMessage('POINT')?></p>
                        <div>
                            <?if($arResult['BACK'] && $arResult['CURRENT'] > 0){?>
                                <a href="#" class="previous_question arial"><?=GetMessage('PREVIOUS')?></a>
                            <?}?>
                            <? if ($arResult['LAST'] == 'Y'):?>
                                <a href="#" class="finish_test next arial"><?=GetMessage('FINISH')?></a>
                            <? else:?>
                                <span class="next arial"><?=GetMessage('NEXT')?></span>
                            <?endif; ?>
                        </div>
                    </div>
                </div>

                <?
                break;
            case 'TASK_OR_QUESTION':
                ?>
                <!--                task or question    -->
                <div data-id="<?= $question['ID'] ?>" class="correctMistake question_block">
                    <div class="question">
                        <p class="mainQuestion arial">
                            <span class="number arial">1.</span>
                            <?= strip_tags($question['PROPS']['MAIN_QUESTION']) ?>
                        </p>
                    </div>
                    <div class="banner">
                        <textarea name="esse"></textarea>
                    </div>
                    <div class="buttonAndCoins">
                        <p class="arial"><span class="question_point"><?= $question['POINT'] ?></span> <?=GetMessage('POINT')?></p>
                        <div>
                            <?if($arResult['BACK'] && $arResult['CURRENT'] > 0){?>
                                <a href="#" class="previous_question arial"><?=GetMessage('PREVIOUS')?></a>
                            <?}?>
                            <? if ($arResult['LAST'] == 'Y'):?>
                                <a href="#" class="finish_test next next arial"><?=GetMessage('FINISH')?></a>
                            <? else:?>
                                <span class="next arial"><?=GetMessage('NEXT')?></span>
                            <? endif; ?>
                        </div>
                    </div>
                </div>
            <? endswitch; ?>

        <div class="main-right">
            <h3 class="timer arial" id="demo">
            <span data-id="<?=$_REQUEST['TEST_ID']?>" class="hours">
<!--                --><?//if($_REQUEST['flag'] == 'UPDATE_TIMER'){$APPLICATION->RestartBuffer();}?>
                <?=$arResult['TIME']?>
<!--                --><?//if($_REQUEST['flag'] == 'UPDATE_TIMER'){die;}?>
            </span>
            </h3>
            <div class="allQuestionsList">
                <ul>
                    <?
                    $num = 1;
                    unset($arResult['TEST_DATA']['TIME_FOR_TEST']);
                    foreach ($arResult['QUESTIONS']['QUESTIONS'] as $key1 => $question):
                        ?>
                        <li>
                            <a class="arial <?if($arResult['CURRENT'] == $key1):?>active<?endif?>" href="#"><?=GetMessage('QUESTION')?> <?= $num ?></a>
                        </li>
                        <?
                        $num++;
                    endforeach; ?>
                </ul>
            </div>
        </div>
        <? if ($request->getPost('flag') == 'NEXT_QUESTION' || $request->getPost('flag') == 'PREVIOUS_QUESTION') {
            die;
        } ?>
    </div>
<?php
else:
    echo "Expired!";
endif;?>