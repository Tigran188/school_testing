<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) { die(); }
use Bitrix\Main\Localization\Loc;
if (IsModuleInstalled("im")) $APPLICATION->IncludeComponent("bitrix:im.messenger", "", Array(), null, array("HIDE_ICONS" => "Y"));
?>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
<div class="notification_panel_outer">
    <div class="popup_for_nots">
        <div class="chat_button_top">
            <div class="nots_icon_outer">
                <i class="fas fa-bell"></i>
            </div>
            <div class="add_door_outer">
                <a href=""><img src="/local/components/apollonlab/main_popup/images/addDoor.png" alt=""/></a>
                <a href=""><img src="/local/components/apollonlab/main_popup/images/addRoom2.png" alt=""/></a>
            </div>
        </div>
        <div class="notification_popup_inner">


            <?if(in_array(8, $USER->GetUserGroupArray())):
                global $APPLICATION;
                ?>

                <?if($_REQUEST['flag'] == 'viewClass'):
                $APPLICATION->RestartBuffer();

                $APPLICATION->IncludeComponent(
                    "school:school.logs.list",
                    "popup.subjects",
                    array(
                        "CLASSES_IBLOCK_ID" => '11',
                        "SUBJECTS_IBLOCK_ID" => '10',
                        "DETAIL_URL" => "",
                    ),
                    false
                );
            endif;
                if($_REQUEST['flag'] == 'viewClass'){die;}?>


                <?if($_REQUEST['flag'] == 'viewAllClasses'){$APPLICATION->RestartBuffer();}
                foreach ($arResult['allClasses'] as $class):?>
                    <div class="popup_element popup-class">
                        <span class="title"><?=$class['NAME']?></span>
                        <button id="<?=$class['ID']?>"> › </button>
                    </div>
                <? endforeach;
                if($_REQUEST['flag'] == 'viewAllClasses'){die;}?>

                <?php if($_REQUEST['flag'] == 'viewLessons'){$APPLICATION->RestartBuffer();}?>

                <div class="previous previous_subjects">
                    <?=$_REQUEST['className']?>
                    <button class="rotate180" id="<?=$lesson['ID']?>"> › </button>
                </div>


                <?foreach($arResult['LESSONS'] as $key=>$lesson):?>
                <div class="popup_element popup_lesson">
                    <span data-subjectID="<?=$_REQUEST['subjectID']?>" id="<?=$lesson['ID']?>" class="popUp_lesson" data-date="<?=$lesson['date']?>" data-startTime="<?=$lesson['lesson_start']?>" data-classID="<?=$_REQUEST['classID']?>" data-detail="<?=$lesson['data-detail']?>"><?=$lesson['lesson_start']?></span>
                </div>
            <?endforeach;?>
                <?php if($_REQUEST['flag'] == 'viewLessons'){die;}?>

                <?php if($_REQUEST['flag'] == 'openLesson'){$APPLICATION->RestartBuffer();}?>


                <div class="previous previous_lessons">
                    <?=$_REQUEST['startTime']?>
                    <button class="rotate180" id="<?=$lesson['ID']?>"> › </button>
                </div>


                <?foreach ($arResult['STUDENTS'] as $key=>$student):?>
                <div class="popup_student">
                    <span>
                        <?=$student[0] . " " . $student[1]?>
                        <span onclick="BXIM.openMessenger('<?=$key?>');" class="popUpChat"></span>
                    </span>
                </div>
            <?endforeach;?>
                <?php if($_REQUEST['flag'] == 'openLesson'){die;}?>







            <?elseif (in_array(9, $USER->GetUserGroupArray())):?>


                <?$APPLICATION->IncludeComponent(
                    "school:school.student.diary",
                    ".default",
                    Array(
                        "IBLOCK_ID" => 12,
                        "DETAIL_URL" => '',
                    ),
                    false
                );?>



            <?endif;?>

        </div>
    </div>
    <div class="notification_panel">
        <span><i class="fas fa-chevron-up"></i></span>
        <span class="notebook_backhground" title="<?=Loc::getMessage('VIRTUAL_ROOM')?>">
            <span>
            </span>
        </span>
    </div>
</div>
<?php
$this->addExternalJs('script.js');
?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
    <br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
