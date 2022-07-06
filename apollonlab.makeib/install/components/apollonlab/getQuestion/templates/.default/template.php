<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) { die(); }
use Bitrix\Main\Localization\Loc;
Loc::loadLanguageFile(__DIR__ . "/lang/", LANGUAGE_ID);
$this->addExternalCss("style.css");
?>

<?php
if($_REQUEST['flag'] == "setQuestion"){
    $APPLICATION->RestartBuffer();
}
?>
<script>
    $(document).ready(function(){
        BX.message({
            INPUT_VERSION: '<?=GetMessage("INPUT_VERSION")?>',
            VERSION: '<?=GetMessage("VERSION")?>',
            SELECT_CORRECT_ANSWER: '<?=GetMessage("SELECT_CORRECT_ANSWER")?>',
            AT_LIST_1_ANSWER: '<?=GetMessage("AT_LIST_1_ANSWER")?>',
            ENTER_QUESTION: '<?=GetMessage("ENTER_QUESTION")?>',
            AT_LIST_2_ANSWER: '<?=GetMessage("AT_LIST_2_ANSWER")?>',
            INPUT_QUESTION: '<?=GetMessage("INPUT_QUESTION")?>',
        });
    })
</script>
<div class="addQuestionWindow">
    <h2><?=GetMessage('ADD_QUESTION')?></h2>
    <div class="selectType">
        <span date-type-id="<?=$arResult["QUEST_TYPES"][0]['XML_ID']?>" data-type-xml-id="2036">
            <?=$arResult["QUEST_TYPES"][0]['VALUE']?>
            <span uk-icon="icon: triangle-down"></span>
        </span>
        <ul class="list">
            <?foreach($arResult["QUEST_TYPES"] as $type):?>
                <li data-id="<?=$type["ID"]?>" data-code="<?=$type["XML_ID"]?>"><?=$type["VALUE"]?></li>
            <?endforeach;?>
        </ul>
    </div>


    <!--        !!!!!!!!!!!!!!!!!!!!!!!! shat patasxanner  !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-->


    <form method="POST" class="manyAnswers d-none" enctype="multipart/form-data">
        <div class="question quest1">
            <input type="text" placeholder="<?=GetMessage('INPUT_QUESTION')?>" name="question" class="questionByText1"/>
            <label class="uploadImage1" for="manyAnswersQuestFile">
                <img src="images/375.png" alt="error">
            </label>
            <input type="file" id="manyAnswersQuestFile" name="manyAnswersQuestFile" class="d-none">
        </div>

        <p class="varyantTitle"><?=GetMessage('VERSIONS')?></p>
        <ol class="variant variant0" type="1">
            <li>
                <div class="question quest2">
                    <input type="text" placeholder="<?=GetMessage('INPUT_VERSION')?>" name="question" class="questionByText">
                </div>
                <span class="deleteVaryant">X</span>
            </li>

            <li>
                <div class="question quest3">
                    <input type="text" placeholder="<?=GetMessage('INPUT_VERSION')?>" name="question" class="questionByText">
                </div>
                <span class="deleteVaryant">X</span>
            </li>

            <li>
                <div class="question quest4">
                    <input type="text" placeholder="<?=GetMessage('INPUT_VERSION')?>" name="question" class="questionByText">
                </div>
                <span class="deleteVaryant">X</span>
            </li>

            <li>
                <div class="question quest5">
                    <input type="text" placeholder="<?=GetMessage('INPUT_VERSION')?>" name="question" class="questionByText">
                </div>
                <span class="deleteVaryant">X</span>
            </li>

        </ol>
        <a href="#" class="arial addAnswer"><span>+</span> <?=GetMessage('ADD_VERSION')?></a>
        <hr/>
        <div class="correctAnswerList">
            <div class="correctAnswer">
                <span><?=GetMessage('SELECT_CORRECT_ANSWER')?></span>
                <select class="correctList"></select>
                <span class="deleteCorrectAnswer">X</span>
            </div>
        </div>
        <a href="#" class="addCorrectAnswer arial"><span>+</span> <?=GetMessage('ADD_CORRECT_ANSWER')?></a>
        <div class="addOrCancle">
            <button type="submit" class="addQuestion" data-id="<?=$_SESSION['folderID']?>" <?if($_REQUEST['flag'] == 'setQuestion') echo "data-id=" . $_REQUEST['folderID']?> href="#"><?=GetMessage('ADD')?></button>
            <a class="delQ" href="#"><?=GetMessage('CANCEL')?></a>
        </div>
    </form>
    <!--        only 1 correct answer !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-->
    <form method="POST" class="OneAnswer" enctype="multipart/form-data">

        <div class="question quest1">
            <input type="text" placeholder="<?=GetMessage('INPUT_QUESTION')?>" name="question" class="questionByText1">
            <label class="uploadImage1" for="oneCorrectQuestion">
                <img src="images/375.png" alt="error">
            </label>
            <input type="file" id="oneCorrectQuestion" name="oneCorrectQuestion" accept="image/*" class="d-none">
        </div>

        <p class="varyantTitle"><?=GetMessage('VERSIONS')?></p>
        <ol class="variant variant1" type="1">
            <li>
                <div class="question quest2">
                    <input type="text" placeholder="<?=GetMessage('INPUT_VERSION')?>" name="question" class="questionByText">
                </div>
                <span class="deleteVaryant">X</span>
            </li>

            <li>
                <div class="question quest3">
                    <input type="text" placeholder="<?=GetMessage('INPUT_VERSION')?>" name="question" class="questionByText">
                </div>
                <span class="deleteVaryant">X</span>
            </li>

            <li>
                <div class="question quest4">
                    <input type="text" placeholder="<?=GetMessage('INPUT_VERSION')?>" name="question" class="questionByText">
                </div>
                <span class="deleteVaryant">X</span>
            </li>

            <li>
                <div class="question quest5">
                    <input type="text" placeholder="<?=GetMessage('INPUT_VERSION')?>" name="question" class="questionByText">
                </div>
                <span class="deleteVaryant">X</span>
            </li>
        </ol>
        <a href="#" class="addAnswer arial"><span>+</span> <?=GetMessage('ADD_VERSION')?></a>
        <hr/>

        <div class="correctAnswerList">
            <div class="correctAnswer">
                <span><?=GetMessage('SELECT_CORRECT_ANSWER')?></span>
                <select class="correctList1 correctList"> </select>
            </div>
        </div>
        <div class="addOrCancle">
            <button type="submit" class="addQuestion" data-id="<?=$_SESSION['folderID']?>" <?if($_REQUEST['flag'] == 'setQuestion') echo "data-id=" . $_REQUEST['folderID']?> href="#"><?=GetMessage('ADD')?></button>
            <a class="delQ" href="#"><?=GetMessage('CANCEL')?></a>
        </div>
    </form>

    <!--        task or question !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-->
    <form method="POST" class="task d-none" enctype="multipart/form-data">
        <div class="question quest1">
            <input type="text" placeholder="<?=GetMessage('INPUT_QUESTION')?>" name="question" class="questionByText1">
            <label class="uploadImage1" for="questionForTask">
                <img src="images/375.png" alt="error">
            </label>
            <input type="file" id="questionForTask" name="questionForTask" accept="image/*" class="d-none">
        </div>
        <ol class="variant variant3" type="1">
            <li>
                <div class="question quest2">
                    <input type="text" placeholder="<?=GetMessage('INPUT_CORRECT_ANSWER')?>" name="question" class="questionByText">
                </div>
                <span class="deleteVaryant">X</span>
            </li>
        </ol>
        <a href="#" class="addAnswer arial"><span>+</span> <?=GetMessage('ADD_VERSION')?></a>
        <hr/>
        <div class="addOrCancle">
            <button type="submit" class="addQuestion" data-id="<?=$_SESSION['folderID']?>" <?if($_REQUEST['flag'] == 'setQuestion') echo "data-id=" . $_REQUEST['folderID']?> href="#"><?=GetMessage('ADD')?></button>
            <a class="delQ" href="#"><?=GetMessage('CANCEL')?></a>
        </div>
    </form>

    <!--        !!!!!!!!!!!!!!!   uxxel sxaly   !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-->

    <form method="POST" class="correctMistake d-none" enctype="multipart/form-data">
        <div class="question quest1">
            <textarea name="question" placeholder="<?=GetMessage('INPUT_QUESTION')?>" cols="50" rows="3"></textarea>
            <label class="uploadImage1" for="questionForMistake">
                <img src="images/375.png" alt="error">
            </label>
            <input type="file" id="questionForMistake" name="questionForMistake" accept="image/*" class="d-none">
        </div>
        <ol class="variant variant4" type="1">
            <li>
                <div class="question quest2">
                    <input type="text" placeholder="<?=GetMessage('INPUT_CORRECT_ANSWER')?>" name="question" class="questionByText">
                </div>
                <span class="deleteVaryant">X</span>
            </li>
        </ol>
        <a href="#" class="arial addAnswer"><span>+</span> <?=GetMessage('ADD_VERSION')?></a>
        <div class="addOrCancle">
            <button type="submit" class="addQuestion" data-id="<?=$_SESSION['folderID']?>" <?if($_REQUEST['flag'] == 'setQuestion') echo "data-id=" . $_REQUEST['folderID']?> href="#"><?=GetMessage('ADD')?></button>
            <a class="delQ" href="#"><?=GetMessage('CANCEL')?></a>
        </div>
    </form>

    <!--        !!!!!!!!!!!!!!!   sharadrutyun   !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-->
    <form method="POST" class="sharadrutyun d-none" enctype="multipart/form-data">
        <div class="question quest1">
            <input type="text" placeholder="<?=GetMessage('INPUT_THEME')?>" name="question" class="questionByText1">
            <label class="uploadImage1" for="sharadrutyun">
                <img src="images/375.png" alt="error">
            </label>
            <input type="file" id="sharadrutyun" name="sharadrutyun" accept="image/*" class="d-none">
        </div>
        <div class="addOrCancle">
            <button type="submit" class="addQuestion" data-id="<?=$_SESSION['folderID']?>" <?if($_REQUEST['flag'] == 'setQuestion') echo "data-id=" . $_REQUEST['folderID']?> href="#"><?=GetMessage('ADD')?></button>
            <a class="delQ" href="#"><?=GetMessage('CANCEL')?></a>
        </div>
    </form>
    <div class="errors"></div>
</div>

<?
if($_REQUEST['flag'] == "setQuestion"){
    die();
}
?>
<script src='https://cdn.tiny.cloud/1/4g845txansvs6c1qll33mgmlxvswipiu7fb3dwucce6sea17/tinymce/5/tinymce.min.js' referrerpolicy="origin">
</script>
<script>
    tinymce.init({
        selector: 'input[name="question"], .question>textarea',
        menubar: true,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks fullscreen',
            'insertdatetime media table hr code'
        ],
        toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code',
        powerpaste_allow_local_images: true,
        powerpaste_word_import: 'prompt',
        powerpaste_html_import: 'prompt',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
    });
</script>