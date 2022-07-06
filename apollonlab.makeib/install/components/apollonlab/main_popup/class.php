<?php
use Bitrix\Main\Access\User;

class main_popup extends \CBitrixComponent
{

    public function getLessons($subjectID, $className, $sectionID){
        global $USER;
        $lessons = MCSchedule::GetLessons(['EMPLOYEE' => $USER->GetID(),  'SUBJECT' => $subjectID, 'CLASS' => $sectionID, 'WEEK_START'=>['COMPARSION' => '=', 'START_DATE' => date("Y-m-d", strtotime('monday this week'))]]);
        foreach ($lessons as $key => $lesson) {
//            if($lesson['id_template'] == '2'){
//                $date_arr = explode(".", $lesson['week_start']);
//                $date = (int)$date_arr[0] + (int)$lesson['week_day'] - 1 . "." . (int)$date_arr[1] . '.' . (int)$date_arr[2];
//                $date2 = explode(".", $date);
//                $time = explode(":", $lesson['lesson_start']);
//                $timestamp = mktime($time[0], $time[1], $time[2], $date2[1], $date2[0], $date2[2]);
//                $date3 = date("d.m.Y H:i:s", $timestamp);
//                $lessons[$key]["day"] = $date3;
//                $realDate = explode(" ", $date3)[0];
//                $lessons[$key]["data-detail"] = $lesson['id_period'] . '_' . $lesson['id_template'] . '_' . $lesson['period_number'] . '_' . $realDate;
//                $res = CIBlockElement::GetList(
//                    array("SORT" => "ASC"),
//                    array("IBLOCK_ID" => 12, "NAME" => "$className", "DATE_ACTIVE_FROM" => $date3),
//                    false,
//                    false,
//                    array("ID"))->Fetch();
//                $lessons[$key]["ID"] = $res['ID'];
//            }else{
//                unset($lessons[$key]);
//            }
        }
        return $lessons;
    }




    public function getAllClasses()
    {
            global $USER;
            $employee = false;
            $user = $USER->GetList([], [], array("ID" => $USER->GetID()), array("SELECT" => ["*", "UF_*"]))->Fetch();
            if (!$USER->IsAdmin() && empty($user["UF_TEACHER"])) {
                $employee = $USER->GetID();
            }
            $arClassSubject = MCSchedule::GetSubjectsForClasses($USER->GetID());

            $arResult = Array(
                "CLASSES"  => Array()
            );

            $arSecClasses = Array();
            $arFilter = Array('IBLOCK_ID' => $arParams["CLASSES_IBLOCK_ID"], 'GLOBAL_ACTIVE' => 'Y');
            $rsSections = CIBlockSection::GetList(Array("sort" => "asc", "name" => "asc"), $arFilter, false, Array("UF_SUBJECTS"));
            while ($arSection = $rsSections->GetNext()) {
                $arSection["ITEMS"] = Array();
                $arSecClasses[$arSection["ID"]] = $arSection;
            }
            $arSelect = Array("ID", "NAME", "IBLOCK_SECTION_ID");
            $arFilter = Array("IBLOCK_ID" => $arParams["CLASSES_IBLOCK_ID"], "ACTIVE_DATE" => "Y", "ACTIVE" => "Y");
            $arFilter["ID"] = $arClassSubject['CLASSES'];
            $rsClasses = CIBlockElement::GetList(Array("sort" => "asc", "name" => "asc"), $arFilter, false, false, $arSelect);
            while ($arClass = $rsClasses->GetNext()) {
                $arSecClasses[$arClass["IBLOCK_SECTION_ID"]]["ITEMS"][] = $arClass;
                $arResult["CLASSES"][$arClass["ID"]] = $arClass;
            }
            return $arResult["CLASSES"];
        }

    public function getStudents($startDate, $startTime, $classID){
        $filter["UF_EDU_STRUCTURE"] = $classID;
        $studentInfo = [];
        $students = CUser::GetList(($by = "LAST_NAME"), ($order="asc"), $filter,array("SELECT"=>array("UF_*")));
        while($student = $students->GetNext()) {
            $studentInfo[$student['ID']] = [$student['NAME'], $student['LAST_NAME']];
        }
        return $studentInfo;
    }

    public function executeComponent()
    {
        global $USER;

        if(in_array(8, $USER->GetUserGroupArray())) {
            if ($_REQUEST['flag'] == 'viewLessons') {

                $this->arResult['LESSONS'] = $this->getLessons(
                    $_REQUEST['subjectID'],
                    $_REQUEST["className"],
                    $_REQUEST["classID"]);

            } elseif ($_REQUEST['flag'] == 'openLesson') {

                $this->arResult['STUDENTS'] = $this->getStudents($_REQUEST['startDate'], $_REQUEST['startTime'],
                    $_REQUEST['classID']);

            } else {
                $this->arResult['allClasses'] = $this->getAllClasses();

            }
        }
        $this->includeComponentTemplate();
    }
}