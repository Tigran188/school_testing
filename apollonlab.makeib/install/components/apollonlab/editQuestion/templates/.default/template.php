<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) { die(); }
$this->addExternalCss($templateFolder . "/styles.css");
$this->addExternalJs($templateFolder . "/script.js");



if($_REQUEST['flag'] == "updateQuestion"){
    $APPLICATION->RestartBuffer();
}
?>
<script>
    BX.message({
        UPDATE_QUESTION: '<?=GetMessage("UPDATE_QUESTION")?>',
        INPUT_QUESTION: '<?=GetMessage("INPUT_QUESTION")?>',
        VERSIONS: '<?=GetMessage("VERSIONS")?>',
        VERSION: '<?=GetMessage("VERSION")?>',
        INPUT_VERSION: '<?=GetMessage("INPUT_VERSION")?>',
        ADD_VERSION: '<?=GetMessage("ADD_VERSION")?>',
        SELECT_CORRECT_ANSWER: '<?=GetMessage("SELECT_CORRECT_ANSWER")?>',
        ADD_CORRECT_ANSWER: '<?=GetMessage("ADD_CORRECT_ANSWER")?>',
        UPDATE: '<?=GetMessage("UPDATE")?>',
        CANCEL: '<?=GetMessage("CANCEL")?>',
        ENTER_CORRECT_ANSWER: '<?=GetMessage("ENTER_CORRECT_ANSWER")?>',
    })
</script>
<div class="editQuestionWindow">
    <h2><?=GetMessage('UPDATE_QUESTION')?></h2>
        <div class="prevPic">
            <img src="<?if($arResult['PREV_PIC']){ echo CFile::GetPath($arResult['PREV_PIC']);}?>" alt="">
        </div>
        <?
    switch($arResult['TYPE_XML_ID']) {
        case "SINGLE_ANSWER":?>
            <!--        only 1 correct answer !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-->
            <form method="POST" class="OneAnswer OneAnswerEdit" enctype="multipart/form-data">

                <div class="question quest1">
                    <textarea>
                        <?=$arResult['QUESTION']?>
                    </textarea>
                    <label class="uploadImage1" for="oneCorrectQuestion">
                        <img src="images/375.png" alt="error">
                    </label>
                    <input type="file" id="oneCorrectQuestion" name="oneCorrectQuestionFile" accept="image/*" class="d-none">
                </div>

                <p class="varyantTitle"><?=$arResult['VERSIONS']?></p>
                <ol class="variant variant1" type="1">
                    <?foreach ($arResult["ANSWER_VERSIONS"] as $version):?>
                        <li>
                            <div class="question quest2">
                                <input value="<?=$version?>" type="text" placeholder="<?=GetMessage('INPUT_QUESTION')?>" name="question2" class="questionByText">
                            </div>
                            <span class="deleteVaryant">X</span>
                        </li>
                    <?endforeach;?>
                </ol>
                <a href="#" class="addAnswer arial"><span>+</span> <?=GetMessage('ADD_VERSION')?></a>
                <hr/>

                <div class="correctAnswerList">
                    <?foreach($arResult["CORRECT_ANSWERS_ID"] as $id):?>
                        <div class="correctAnswer">
                            <span><?=GetMessage('SELECT_CORRECT_ANSWER')?></span>
                            <select class="correctList">
                                <?for($i=1; $i <= count($arResult["ANSWER_VERSIONS"]); $i++):?>
                                    <option value="<?=$i?>" <?if($id == $i){echo "selected";}?>> <?=$i?> <?=GetMessage('VERSION')?> </option>
                                <?endfor;?>
                            </select>
                            <span class="deleteCorrectAnswer">X</span>
                        </div>
                    <?endforeach;?>
                </div>
                <div class="addOrCancle">
                    <button type="submit" class="editQuestion" href="#" data-id="<?=$arResult['ID']?>" data-type="<?=$arResult["TYPE_XML_ID"]?>"><?=GetMessage('UPDATE')?></button>
                    <a class="delQ" href="#"><?=GetMessage('CANCEL')?></a>
                </div>
            </form>
            <?break;?>
        <? case "MULTIPLE_ANSWER":?>
            <!--    many answers-->
            <form method="POST" class="manyAnswers manyAnswersEdit" enctype="multipart/form-data">
                <div class="question quest1">
                    <textarea>
                        <?=$arResult['QUESTION']?>
                    </textarea>
                    <label class="uploadImage1" for="multFile">
                        <img src="images/375.png" alt="error">
                    </label>
                    <input type="file" id="multFile" name="multFileFile" accept="image/*" class="d-none">
                </div>

                <p class="varyantTitle"><?=$arResult['VERSIONS']?></p>
                <ol class="variant variant0" type="1">
                    <?foreach ($arResult["ANSWER_VERSIONS"] as $version):?>
                        <li>
                            <div class="question quest2">
                                <input value="<?=$version?>" type="text" placeholder="<?=GetMessage('INPUT_VERSION')?>" name="question2" class="questionByText">
                                <div>
                                    <a href="#"><img src="images/sum-sign%201.png" alt="error"></a>
                                    <a href="#"><img src="images/T.png" alt="error"></a>
                                </div>
                            </div>
                            <span class="deleteVaryant">X</span>
                        </li>
                    <?endforeach;?>

                </ol>
                <a href="#" class="arial addAnswer"><span>+</span> <?=GetMessage('ADD_VERSION')?></a>
                <hr/>
                <div class="correctAnswerList">
                    <?foreach($arResult["CORRECT_ANSWERS_ID"] as $id):?>
                        <div class="correctAnswer">
                            <span><?=GetMessage('SELECT_CORRECT_ANSWER')?></span>
                            <select class="correctList">
                                <?for($i=1; $i <= count($arResult["ANSWER_VERSIONS"]); $i++):?>
                                    <option value="<?=$i?>" <?if($id == $i){echo "selected";}?>> <?=$i?> <?=GetMessage('VERSION')?> </option>
                                <?endfor;?>
                            </select>
                            <span class="deleteCorrectAnswer">X</span>
                        </div>
                    <?endforeach;?>
                </div>
                <a href="#" class="addCorrectAnswer arial"><span>+</span> <?=GetMessage('ADD_CORRECT_ANSWER')?></a>
                <div class="addOrCancle">
                    <button type="submit" class="editQuestion" href="#" data-id="<?=$arResult['ID']?>" data-type="<?=$arResult["TYPE_XML_ID"]?>"><?=GetMessage('UPDATE')?></button>
                    <a class="delQ" href="#"><?=GetMessage('CANCEL')?></a>
                </div>
            </form>
            <?break;?>
        <?case "TASK_OR_QUESTION":?>
            <!--        task or question !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-->
            <form method="POST" class="task taskEdit" enctype="multipart/form-data">
                <div class="question quest1">
                    <textarea>
                        <?=$arResult['QUESTION']?>
                    </textarea>

                    <label class="uploadImage1" for="questionForTask">
                        <img src="images/375.png" alt="error">
                    </label>
                    <input type="file" id="questionForTask" name="questionForTaskFile" accept="image/*" class="d-none">
                </div>
                <ol class="variant variant3" type="1">
                    <?foreach ($arResult["CORRECT_ANSWERS_ID"] as $version):?>
                        <li>
                            <div class="question quest2">
                                <input value="<?=$version?>" type="text" placeholder="<?=GetMessage('ENTER_CORRECT_ANSWER')?>" name="question2" class="questionByText">
                                <div>
                                    <a href="#"><img src="images/sum-sign%201.png" alt="error"></a>
                                    <a href="#"><img src="images/T.png" alt="error"></a>
                                </div>
                            </div>
                            <span class="deleteVaryant">X</span>
                        </li>
                    <?endforeach;?>

                </ol>
                <a href="#" class="arial addAnswer"><span>+</span> <?=GetMessage('ADD_VERSION')?></a>
                <div class="addOrCancle">
                    <button type="submit" class="editQuestion" href="#" data-id="<?=$arResult['ID']?>" data-type="<?=$arResult["TYPE_XML_ID"]?>"><?=GetMessage('UPDATE')?></button>
                    <a class="delQ" href="#"><?=GetMessage('CANCEL')?></a>
                </div>
            </form>
            <?break;?>
        <?case "CORRECT_MISTAKE":?>
            <!--        !!!!!!!!!!!!!!!   uxxel sxaly   !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-->
            <form method="POST" class="correctMistake correctMistakeEdit" enctype="multipart/form-data">
                <div class="question quest1">
                    <textarea>
                        <?=$arResult['QUESTION']?>
                    </textarea>
                    <label class="uploadImage1" for="questionForMistake">
                        <img src="images/375.png" alt="error">
                    </label>
                    <input type="file" id="questionForMistake" name="questionForMistakeFile" accept="image/*" class="d-none">
                </div>
                <ol class="variant variant4" type="1">
                    <?foreach ($arResult["ANSWER_VERSIONS"] as $version):?>
                        <li>
                            <div class="question quest2">
                                <input value="<?=$version?>" type="text" placeholder="<?=GetMessage('ENTER_CORRECT_ANSWER')?>" name="question2" class="questionByText">
                                <div>
                                    <a href="#"><img src="images/sum-sign%201.png" alt="error"></a>
                                    <a href="#"><img src="images/T.png" alt="error"></a>
                                </div>
                            </div>
                            <span class="deleteVaryant">X</span>
                        </li>
                    <?endforeach;?>
                </ol>
                <a href="#" class="arial addAnswer"><span>+</span> <?=GetMessage('ADD_VERSION')?></a>
                <div class="addOrCancle">
                    <button type="submit" class="editQuestion" href="#" data-id="<?=$arResult['ID']?>" data-type="<?=$arResult["TYPE_XML_ID"]?>"><?=GetMessage('UPDATE')?></button>
                    <a class="delQ" href="#"><?=GetMessage('CANCEL')?></a>
                </div>
            </form>
            <?break;?>
        <?case "ESSE":?>
            <!--        !!!!!!!!!!!!!!!   sharadrutyun   !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-->
            <form method="POST" class="sharadrutyun sharadrutyunEdit" enctype="multipart/form-data">
                <div class="question quest1">
                    <textarea>
                        <?=$arResult['QUESTION']?>
                    </textarea>
                    <label class="uploadImage1" for="sharadrutyun">
                        <img src="images/375.png" alt="error">
                    </label>
                    <input type="file" id="sharadrutyun" name="sharadrutyunFile" accept="image/*" class="d-none">
                </div>
                <div class="addOrCancle">
                    <button type="submit" class="editQuestion" href="#" data-id="<?=$arResult['ID']?>" data-type="<?=$arResult["TYPE_XML_ID"]?>"><?=GetMessage('UPDATE')?></button>
                    <a class="delQ" href="#"><?=GetMessage('CANCEL')?></a>
                </div>
            </form>
            <?break;?>
        <?}?>
    <div class="errors"></div>
</div>

<?
if($_REQUEST['flag'] == "updateQuestion"){
    die();
}
?>


</script>


