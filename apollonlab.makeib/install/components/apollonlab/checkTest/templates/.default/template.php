<div class="modalBack">
    <div class="modalWindow">
        <? if ($_REQUEST['flag'] == 'reviewPassesTest') {
            $APPLICATION->RestartBuffer();
        }
        ?>
        <div class="top">
            <h2 class="modalTitle arial"><?= $arResult['TEST_DATA']['DEFAULT']['TEST_TITLE'] ?></h2>
            <div class="timeStartEnd">
                <div class="fromTo">
                    <span class="from arial">
                        <span class="start_time_info"><?= GetMessage('START') ?></span>
                        <?=date("H:i:s", $arResult['DATES']['START_DATE'])?>
                    </span>
                    /
                    <span class="to arial">
                        <span class="end_time_info"><?= GetMessage('END') ?></span>
                        <?=date("H:i:s", $arResult['DATES']['END_DATE'])?>
                    </span>
                </div>
                <div class="timeCount">
                    <span class="arial"><?=round($arResult['DATES']['INTERVAL'] / 60)?>
                        <span class="interval">
                            <?=GetMessage('MINUTES')?>
                        </span>
                    </span>
                </div>
            </div>
        </div>
        <div class="test">
            <ol class="testList">
<!--                --><?//p($arResult['TEST_DATA']['DEFAULT'])?>
                <? foreach ($arResult['QUESTIONS'] as $question):

                    $pointGiven = 0;
                    foreach ($arResult['TEST_DATA']['DEFAULT']["QUESTIONS_POINT"] as $sectionAndPoint) {
                        if(in_array($question['QUESTION_INFO']['INFO']['ID'], end($sectionAndPoint))){
                            $pointGiven = $sectionAndPoint['point'];
                            break;
                        }
                    }
                    foreach ($question['QUESTION_INFO']['CORRECT'] as $key => $corr){
                        $question['QUESTION_INFO']['CORRECT'][$key] = strip_tags(trim($corr));
                    }
                    $point = 0;
                    switch ($question['QUESTION_INFO']['TYPE']):
                        case "SINGLE_ANSWER":
                            ?>
                            <li>
                                <div class="d-flex">
                                    <div class="question arial">
                                        <p class="arial"><?= $question['QUESTION_INFO']['INFO']['NAME'] ?></p>
                                        <p class="arial"><?= GetMessage('SELECT_ONE_ANSWER') ?></p>
                                    </div>
                                    <div class="point arial">
                                        <input name="grade" type="number" class="pointInput" value="<?
                                        $isCorrect = true;
                                        foreach ($question['SELECTED'] as $ans){
                                            if(!in_array($ans, $question['QUESTION_INFO']['CORRECT'])){
                                                $isCorrect = false;
                                                break;
                                            }
                                        }
                                        if($isCorrect){
                                            echo $pointGiven;
                                        } else {
                                            echo 0;
                                        }?>" min="0" data-id="<?=$question['QUESTION_INFO']['INFO']['ID']?>">
                                        /<?=$pointGiven?>
                                    </div>
                                </div>

                                <div class="d-felx answerVersions">
                                    <?
                                    foreach ($question['QUESTION_INFO']['ANSWERS'] as $key => $version):
                                        if (in_array($key + 1, $question['SELECTED'])):
                                            ?>
                                            <div class="arial">
                                    <span class="block checked">
                                        <span></span>
                                    </span>
                                                <?= $version ?>
                                            </div>
                                        <? else:?>
                                            <div class="arial">
                                    <span class="block">
                                        <span></span>
                                    </span>
                                                <?= $version ?>
                                            </div>
                                        <?endif;
                                    endforeach; ?>
                                </div>
                            </li>
                            <? break;
                        case "MULTIPLE_ANSWER":?>
                            <li>
                                <div class="d-flex">
                                    <div class="question arial">
                                        <p class="arial"><?= $question['QUESTION_INFO']['INFO']['NAME'] ?></p>
                                        <p class="arial"><?= GetMessage('SELECT_MANY_ANSWER') ?></p>
                                    </div>
                                    <div class="point arial">
                                        <input name="grade" type="number" class="pointInput" value="<?
                                        $isCorrect = true;
                                        foreach ($question['QUESTION_INFO']['CORRECT'] as $corr){
                                            if(!in_array($corr, $question['SELECTED'])){
                                                $isCorrect = false;
                                                break;
                                            }
                                        }
                                        if($isCorrect){
                                            echo $pointGiven;
                                        } else {
                                            echo 0;
                                        }?>" min="0" data-id="<?=$question['QUESTION_INFO']['INFO']['ID']?>">
                                        /<?=$pointGiven?>

                                    </div>
                                </div>

                                <div class="d-flex answerVersions">
                                    <? foreach ($question['QUESTION_INFO']['ANSWERS'] as $key => $version):
                                        if (in_array($key + 1, $question['SELECTED'])):
                                            ?>
                                            <div class="arial">
                                                <span class="block checked">
                                                    <span></span>
                                                </span>
                                                <?= $version ?>
                                            </div>
                                        <? else:?>
                                            <div class="arial">
                                                <span class="block">
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
                                <div class="d-flex ">
                                    <div class="question arial">
                                        <p class="arial"><?= $question['QUESTION_INFO']['INFO']['NAME'] ?></p>
                                        <p class="arial"><?= GetMessage('TASK_OR_QUESTION') ?></p>
                                    </div>
                                    <div class="point arial">
                                        <input name="grade" type="number" class="pointInput" value="<?
                                        $isCorrect = true;
                                        foreach ($question['SELECTED'] as $ans){
                                            if(!in_array($ans, $question['QUESTION_INFO']['CORRECT'])){
                                                $isCorrect = false;
                                                break;
                                            }
                                        }
                                        if($isCorrect){
                                            echo $pointGiven;
                                        } else {
                                            echo 0;
                                        }?>" min="0" data-id="<?=$question['QUESTION_INFO']['INFO']['ID']?>">
                                        /<?=$pointGiven?>
                                    </div>
                                </div>
                                <div class="banner d-flex answerVersions">
                                     <textarea name="textWithMistake" disabled><?=$question['SELECTED'][0]?></textarea>
                                </div>

                            </li>
                            <? break;
                        case "CORRECT_MISTAKE":
                            ?>
                            <li>
                                <div class="d-flex">
                                    <div class="question arial">
                                        <p class="arial"> <?= $question['QUESTION_INFO']['INFO']['NAME'] ?></p>
                                        <p class="arial"><?= GetMessage('CORRECT_MISTAKE') ?></p>
                                    </div>
                                    <div class="point arial">
                                        <input name="grade" type="number" class="pointInput" value="<?
                                        $isCorrect = true;
                                        foreach ($question['SELECTED'] as $ans){
                                            if(!in_array($ans, $question['QUESTION_INFO']['CORRECT'])){
                                                $isCorrect = false;
                                                break;
                                            }
                                        }
                                        if($isCorrect){
                                            echo $pointGiven;
                                        } else {
                                            echo 0;
                                        }?>" min="0" data-id="<?=$question['QUESTION_INFO']['INFO']['ID']?>">
                                        /<?=$pointGiven?>
                                    </div>
                                </div>
                                <div class="d-flex banner">
                                    <textarea name="textWithMistake" disabled><?=$question['SELECTED'][0]?></textarea>
                                </div>
                            </li>
                            <? break;
                        case "ESSE":
                            ?>
                            <li>
                                <div class="d-flex">
                                    <div class="question arial">
                                        <p class="arial"><?= $question['QUESTION_INFO']['INFO']['NAME'] ?></p>
                                        <p class="arial"><?= GetMessage('ESSE') ?></p>
                                    </div>
                                    <div class="point arial">
                                        <input name="grade" type="number" class="pointInput" value="<?
                                        $isCorrect = true;
                                        foreach ($question['SELECTED'] as $ans){
                                            if(!in_array($ans, $question['QUESTION_INFO']['CORRECT'])){
                                                $isCorrect = false;
                                                break;
                                            }
                                        }
                                        if($isCorrect){
                                            echo $pointGiven;
                                        } else {
                                            echo 0;
                                        }?>" min="0" data-id="<?=$question['QUESTION_INFO']['INFO']['ID']?>">
                                        /<?=$pointGiven?>
                                    </div>
                                </div>
                                <div class="banner d-flex">
                                    <textarea disabled name="textWithMistake"><?=$question['SELECTED'][0]?></textarea>
                                </div>
                            </li>
                        <?endswitch;
                endforeach; ?>
            </ol>
            <div class="finish">
                <a href="#" class="arial finishButton"><?= GetMessage('CONFINE_TEST') ?></a>
                <a href="#" class="arial"><?= GetMessage('CANCEL') ?></a>
            </div>
        </div>
        <? if ($_REQUEST['flag'] == 'reviewPassesTest') {
            die;
        } ?>
    </div>
</div>