<?php
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;

$APPLICATION->SetTitle(GetMessage('FINISHED'));

if($arResult['CAN_VIEW']):?>

    <div class="modalBack">
        <div class="modalWindow">
            <? if ($_REQUEST['flag'] == 'reviewPassesTest') {
                $APPLICATION->RestartBuffer();
            }
            ?>
            <div class="top">
                <h2 class="modalTitle arial"><?= $arResult['TEST_DATA']['DEFAULT']['TEST_TITLE'] ?></h2>
            </div>
            <div class="test">
                <ol class="testList">
                    <?

                    foreach ($arResult['QUESTIONS'] as $question):
                        $pointGiven = 0;
                        foreach ($arResult['TEST_DATA']['DEFAULT']["QUESTIONS_POINT"] as $sectionAndPoint) {
                            if(in_array($question['QUESTION_INFO']['INFO']['ID'], end($sectionAndPoint))){
                                $pointGiven = $sectionAndPoint['point'];
                                break;
                            }
                        }
                        if($question[0]['PREVIEW_PICTURE']){
                            $pic = CFile::GetPath($question[0]['PREVIEW_PICTURE']);
                            ?>
                            <div class="questionPicture">
                                <img src="<?=$pic?>" alt="">
                            </div>
                            <?
                        }
                        switch ($question['QUESTION_INFO']['TYPE']):
                            case "SINGLE_ANSWER":
                                ?>
                                <li>
                                <div class="d-flex">
                                    <div class="question arial">
                                        <p class="arial"><?= $question['QUESTION_INFO']['INFO']['NAME'] ?></p>
                                    </div>
                                </div>

                                <div class="d-felx answerVersions">
                                    <?
                                    foreach ($question['QUESTION_INFO']['ANSWERS'] as $key => $version):
                                        if (in_array($key + 1, $question['SELECTED'])):?>
                                            <div class="arial">
                                                <span class="block <?if(in_array($key + 1, $question['QUESTION_INFO']['CORRECT']) || $key + 1 == $question['CORRECT_ANSWER_ID']){?>red<?}?> checked">
                                                    <span></span>
                                                </span>
                                                <?= $version ?>
                                            </div>
                                        <? else:?>
                                            <div class="arial">
                                                <span class="block <?if(in_array($key + 1, $question['QUESTION_INFO']['CORRECT']) || $key + 1 == $question['CORRECT_ANSWER_ID']){?>red<?}?>">
                                                    <span></span>
                                                </span>
                                                <?= $version ?>
                                            </div>
                                        <?endif;
                                    endforeach; ?>
                                </div>
                                <? break;
                            case "MULTIPLE_ANSWER":?>
                                <li>
                                    <div class="d-flex">
                                        <div class="question arial">
                                            <p class="arial"><?= $question['QUESTION_INFO']['INFO']['NAME'] ?></p>
                                        </div>
                                    </div>

                                    <div class="d-flex answerVersions">
                                        <? foreach ($question['QUESTION_INFO']['ANSWERS'] as $key => $version):
                                            if (in_array($key + 1, $question['SELECTED'])):
                                                ?>
                                                <div class="arial">
                                                <span class="block <?if(in_array($key + 1, $question['QUESTION_INFO']['CORRECT'])){?>red<?}?> checked">
                                                    <span></span>
                                                </span>
                                                    <?= $version ?>
                                                </div>
                                            <? else:?>
                                                <div class="arial">
                                                <span class="block <?if(in_array($key + 1, $question['QUESTION_INFO']['CORRECT'])){?>red<?}?>">
                                                    <span></span>
                                                </span>
                                                    <?= $version ?>
                                                </div>
                                            <?
                                            endif;
                                        endforeach; ?>
                                    </div>
                                </li>
                                <? break;
                            case "TASK_OR_QUESTION":
                                ?>
                                <li>
                                    <div class="">
                                        <div class="question arial">
                                            <p class="arial"><?= $question['QUESTION_INFO']['INFO']['NAME'] ?></p>
                                        </div>
                                    </div>
                                    <div class="banner answerVersions">

                                        <?
                                        $arr = [];
                                        foreach($question['QUESTION_INFO']['CORRECT'] as $correct){
                                            $arr[] = strip_tags($correct);
                                        }?>

                                        <textarea name="textWithMistake" <?if(!in_array($question['SELECTED'][0], $arr)){?>class="b-red" <?}?> disabled><?=($question['SELECTED'][0])?></textarea>

                                        <?if(!in_array($question['SELECTED'][0], $arr) && !empty($question['QUESTION_INFO']['CORRECT'])){
                                        ?>
                                            <input class="textWithMistake_correct" disabled value="<?=strip_tags(implode(", ", $question['QUESTION_INFO']['CORRECT']))?>">
                                        <?}?>
                                    </div>
                                </li>
                                <? break;
                            case "CORRECT_MISTAKE":
                                ?>
                                <li>
                                    <div class="d-flex">
                                        <div class="question arial">
                                            <p class="arial"> <?= $question['QUESTION_INFO']['INFO']['NAME'] ?></p>
                                        </div>
                                    </div>
                                    <div class=" banner">
                                        <?
                                        $arr = [];
                                        foreach($question['QUESTION_INFO']['CORRECT'] as $correct){
                                            $arr[] = strip_tags($correct);
                                        }?>

                                        <textarea name="textWithMistake" <?if(!in_array($question['SELECTED'][0], $arr)){?>class="b-red" <?}?> disabled><?=($question['SELECTED'][0])?></textarea>

                                        <?if(!in_array($question['SELECTED'][0], $arr) && !empty($question['QUESTION_INFO']['CORRECT'])){
                                            ?>
                                            <input class="textWithMistake_correct" disabled value="<?=strip_tags(implode(", ", $question['QUESTION_INFO']['CORRECT']))?>">
                                        <?}?>
                                    </div>
                                </li>
                                <? break;
                            case "ESSE":
                                ?>
                                <li>
                                    <div class="d-flex">
                                        <div class="question arial">
                                            <p class="arial"><?= $question['QUESTION_INFO']['INFO']['NAME'] ?></p>
                                        </div>
                                    </div>
                                    <div class="banner">
                                        <?
                                        $arr = [];
                                        foreach($question['QUESTION_INFO']['CORRECT'] as $correct){
                                            $arr[] = strip_tags($correct);
                                        }?>

                                        <textarea name="textWithMistake" <?if(!in_array($question['SELECTED'][0], $arr)){?>class="b-red" <?}?> disabled><?=($question['SELECTED'][0])?></textarea>

                                        <?if(!in_array($question['SELECTED'][0], $arr) && !empty($question['QUESTION_INFO']['CORRECT'])){
                                            ?>
                                            <input class="textWithMistake_correct" disabled value="<?=strip_tags(implode(", ", $question['QUESTION_INFO']['CORRECT']))?>">
                                        <?}?>
                                    </div>
                                </li>
                            <?endswitch;
                    endforeach; ?>
                </ol>
            </div>
            <? if ($_REQUEST['flag'] == 'reviewPassesTest') {
                die;
            } ?>
            <?=GetMessage('MARK') . $arResult['MARK']?>
        </div>
    </div>
<?php endif;?>