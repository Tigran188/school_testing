<?php

namespace PassTest;

use Bitrix\Bizproc\BaseType\Date;
use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;
use Bitrix\Main\Entity;
use Bitrix\Im\User;
Loader::includeModule("highloadblock");
date_default_timezone_set('Asia/Yerevan');
class PassTest extends \CBitrixComponent
{

    public static function get_test_data($id)
    {

        global $USER;
        //Напишем функцию получения экземпляра класса:
        function GetEntityDataClass($HlBlockId)
        {
            if (empty($HlBlockId) || $HlBlockId < 1) {
                return false;
            }
            $hlblock = HLBT::getById($HlBlockId)->fetch();
            $entity = HLBT::compileEntity($hlblock);
            $entity_data_class = $entity->getDataClass();
            return $entity_data_class;
        }

        $entity_data_class = GetEntityDataClass(3);
        $rsData = $entity_data_class::getList(array(
            'select' => array('*'),
            'filter' => array(
                "ID" => $id
            )
        ));
        $arr = [];
        while ($elem = $rsData->fetch()) {
            $arr[] = $elem;
        }

        $entity_data_class = GetEntityDataClass(4);
        $passedData = $entity_data_class::getList(array(
            'select' => array('*'),
            'filter' => array(
                "UF_TEST_ID" => $id
            )
        ));
        $arr2 = [];
        while ($elem = $passedData->fetch()) {
            $arr2[] = $elem;
        }
        $arr[0]['UF_QUESTIONS'] = unserialize($arr[0]['UF_QUESTIONS']);
        $questions['END_DATE'] = $arr2[0]['UF_END_DATE'];
//        get question data
        $questions = [];
        $test_questions = $arr[0]['UF_QUESTIONS'][$USER->GetID()];
        $num = 0;
        foreach ($test_questions as $section) {
            foreach (end($section) as $key => $question) {
                $res = \CIBlockElement::GetList(
                    array('SORT' => 'ASC'),
                    array(
                        "ID" => $question
                    ),
                    false,
                    false,
                    array()
                )->Fetch();
                $questions['QUESTIONS'][] = $res;
                $questions["END_DATE"] = $res['END_DATE'];
                $questions['TIME_FOR_TEST'] = $arr[0]['UF_TIME'];
                $questions['TEST_NAME'] = $arr[0]['UF_TITLE'];
                $questions['QUESTIONS'][$num] = $res;
                $questions['QUESTIONS'][$num]['POINT'] = $section['point'];
                $type = \CIBlockElement::GetProperty(
                    $res['IBLOCK_ID'],
                    $res['ID'],
                    array(),
                    array(
                        "CODE" => "QUESTION_LIST"
                    )
                )->Fetch();
                $questions['QUESTIONS'][$num]['PROPS']['QUESTION_TYPE'] = $type;

                $questions['QUESTIONS'][$num]['PROPS']['MAIN_QUESTION'] = \CIBlockElement::GetProperty(
                    $res['IBLOCK_ID'],
                    $res['ID'],
                    array(),
                    array(
                        "CODE" => $type['VALUE_XML_ID']
                    )
                )->Fetch()['VALUE']['TEXT'];


                $prop = \CIBlockElement::GetProperty(
                    $res['IBLOCK_ID'],
                    $res['ID'],
                    array(),
                    array(
                        "CODE" => "ANSWER_VERSIONS"
                    )
                );
                while ($v = $prop->Fetch()){
                    $questions['QUESTIONS'][$num]['PROPS']['ANSWER_VERSIONS'][] = $v['VALUE'];
                }

                $prop = \CIBlockElement::GetProperty(
                    $res['IBLOCK_ID'],
                    $res['ID'],
                    array(),
                    array(
                        "CODE" => "CORRECT_ANSWER_ID"
                    )
                );
                while ($v = $prop->Fetch()){
                    $questions['QUESTIONS'][$num]['PROPS']['CORRECT_ANSWER_ID'][] = $v['VALUE'];
                }
                $num++;
            }
        }
        $questions['END_DATE'] = $arr2[0]['UF_END_DATE'];
        return $questions;
    }
    public function GetEntityDataClass($HlBlockId)
    {
        if (empty($HlBlockId) || $HlBlockId < 1)
        {
            return false;
        }
        $hlblock = HLBT::getById($HlBlockId)->fetch();
        $entity = HLBT::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();
        return $entity_data_class;
    }

    public function start_test($id){
        global $USER;
        $request = Application::getInstance()->getContext()->getRequest();
        $entity_data_class = $this->GetEntityDataClass(3);
        $rsData = $entity_data_class::getList(array(
            'select' => array('*'),
            'filter' => array(
                "ID" => $id
            )
        ))->fetch();
        $hour = 0;
        $min = 0;
        $date = explode(" ", microtime())[1];
        $date_start = explode(" ", microtime())[1];
        if($rsData['UF_TIME'][0] == '0'){
            if($rsData['UF_TIME'][1] == '0'){
                $hour = 0;
            }else{
                $hour = $rsData['UF_TIME'][1];
                $date = $date + $hour * 3600;
            }
        } else {
            $hour = explode(':', $rsData['UF_TIME'])[0];
            $date = $date + $hour * 3600;
        }
        if(explode(":", $rsData['UF_TIME'])[1][0] == '0'){
            if(explode(":", $rsData['UF_TIME'])[1][1] == '0'){
                $min = 0;
            }else{
                $hour = $rsData['UF_TIME'][1];
                $date = $date + $min * 60;
            }
        }else {
            $min = explode(':', $rsData['UF_TIME'])[1];
            $date = $date + $min * 60;
        }
        $date = explode(" ", microtime())[1] + $hour * 3600 + $min * 60;
        $hlbl = 3; // Указываем ID нашего highloadblock блока к которому будет делать запросы.
        $entity_data_class = $this->GetEntityDataClass($hlbl);

        $rsData = $entity_data_class::getList(array(
            'select' => array('*'),
            'filter' => array(
                "ID" => $id
            )
        ))->fetch();

        $passedData = $this->GetEntityDataClass(4);
        $data = [
            "UF_TEST_ID" => $request->get("TEST_ID"),
            "UF_USER_ID" => $USER->GetID(),
            "UF_END_DATE" => $date,
            "UF_START_DATE" => $date_start,
            "UF_CURRENT_QUESTION" => 0

        ];
        $result = $passedData::add($data);
        setcookie('test_' . $_REQUEST['TEST_ID'] . '_current', 1);
    }

    public function next_question($test, $answers, $is_finished = false){
        global $USER;
        $entity_data_class = $this->GetEntityDataClass(3);
        $request = Application::getInstance()->getContext()->getRequest();
        $rsData = $entity_data_class::getList(array(
            'select' => array('*'),
            'filter' => array(
                "ID" => $test
            )
        ))->fetch();
        $hlbl = 4; // Указываем ID нашего highloadblock блока к которому будет делать запросы.

        $entity_data_class2 = $this->GetEntityDataClass(4);
        $data = $entity_data_class2::getList(array(
            'select' => array('*'),
            'filter' => array(
                "UF_USER_ID" => $USER->GetID(),
                "UF_TEST_ID" => $test
            )
        ))->fetch();
        $entity_data_class = $this->GetEntityDataClass($hlbl);
        $result = $entity_data_class::update($data['ID'], array(
            'UF_CURRENT_QUESTION' => (int)$data['UF_CURRENT_QUESTION'] + 1
        ));
        $hlbl = 4;
        $quests = serialize($request->getPost('myAnswer'));
        $hlblock = HLBT::getById($hlbl)->fetch();
        $entity = HLBT::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();

        $elems = $this->GetEntityDataClass(4);
        $data = $entity_data_class::getList(array(
            'select' => array('*'),
            'filter' => array(
                "UF_TEST_ID" => $test,
                "UF_USER_ID" => $USER->GetID()
            )
        ))->fetch();
        $correct_version_id = \CIBlockElement::GetProperty(391, $request->getPost('question_id'), ["sort" => "desc"], ['CODE' => 'CORRECT_ANSWER_ID']);
        $correct_version_id_array = [];
        while($r = $correct_version_id->Fetch()){
            $correct_version_id_array[] = explode(" ", $r['VALUE'])[0];
        }
        foreach ($correct_version_id_array as $key => $corr){
            $correct_version_id_array[$key] = strip_tags(trim($corr));
        }
        $points_previous = $data['UF_COINS_SUMMARY'];
        $myAnswer = $answers;

        if($data){
            $highload_answers = unserialize($data['UF_QUESTIONS_AND_ANSWERS']);
            $highload_answers[$request->getPost('question_id')] = $request->getPost('myAnswer');
            $entity_data_class = $this->GetEntityDataClass($hlbl);
            $isCorrect = true;
            foreach ($myAnswer as $ans){
                if(!in_array($ans, $correct_version_id_array)){
                    $isCorrect = false;
                    break;
                }
            }
            $finishDate = '';
            if($is_finished){
                $finishDate = explode(" ", microtime())[1];
            }
            if($isCorrect){
                $result = $entity_data_class::update($data['ID'], array(
                    'UF_QUESTIONS_AND_ANSWERS' => serialize($highload_answers),
                    'UF_COINS_SUMMARY' => (int)$points_previous + (int)$request->getPost('point'),
                    'UF_FINISHED' => $is_finished,
                    'UF_FINISH_DATE' => $finishDate
                ));
            }else {
                $result = $entity_data_class::update($data['ID'], array(
                    'UF_QUESTIONS_AND_ANSWERS' => serialize($highload_answers),
                    'UF_FINISHED' => $is_finished,
                    'UF_FINISH_DATE' => $finishDate
                ));
            }
        } else {
            $arr[$request->getPost('question_id')] = $request->getPost('myAnswer');
            $isCorrect = true;
            foreach ($myAnswer as $ans){
                if(!in_array($ans, $correct_version_id_array)){
                    $isCorrect = false;
                    break;
                }
            }
            if($isCorrect){
                $data = array(
                    'UF_USER_ID' => $USER->GetID(),
                    'UF_TEST_ID' => $test,
                    'UF_QUESTIONS_AND_ANSWERS' => serialize($arr),
                    'UF_COINS_SUMMARY' => (int)$points_previous + (int)$request->getPost('point')
                );
            }else{
                $data = array(
                    'UF_USER_ID' => $USER->GetID(),
                    'UF_TEST_ID' => $test,
                    'UF_QUESTIONS_AND_ANSWERS' => serialize($arr),
                    'UF_COINS_SUMMARY' => 0,
                );
            }
            if($entity_data_class::add($data)){
                return true;
            }else{
                return false;
            }
        }

    }

    public function prev_question($test){
        global $USER;
        $hlbl = 4; // Указываем ID нашего highloadblock блока к которому будет делать запросы.
        $entity_data_class = $this->GetEntityDataClass(4);
        $data = $entity_data_class::getList(array(
            'select' => array('*'),
            'filter' => array(
                "UF_USER_ID" => $USER->GetID(),
                "UF_TEST_ID" => $test
            )
        ))->fetch();
        if($data) {
            $arr = unserialize($data['UF_QUESTIONS_AND_ANSWERS']);
            $key = key(array_slice($arr, -1, 1, true));
            unset($arr[$key]);
//            $arr = array_pop($arr);
//            $arr = serialize(array_pop($arr));
            $result = $entity_data_class::update($data['ID'], array(
                'UF_CURRENT_QUESTION' => (int)$data['UF_CURRENT_QUESTION'] - 1,
                'UF_QUESTIONS_AND_ANSWERS' => serialize($arr)
            ));
        }
    }

    public function get_question($id){
        $arResult = [];

        $res = \CIBlockElement::GetList(
            Array(
                "SORT"=>"ASC"
            ),
            array(
                "ID" => $id,
                "IBLOCK_ID"  => 391
            ),
            false,
            false,
            array("NAME", "ID", "SECTION_ID", "IBLOCK_SECTION_ID", 'PREVIEW_PICTURE')
        );

        $type = \CIBlockElement::GetProperty(
            391,
            $id,
            array(),
            array(
                "CODE" => "QUESTION_LIST"
            )
        )->Fetch()['VALUE_XML_ID'];

        $answersRes = \CIBlockElement::GetProperty(
            391,
            $id,
            array(),
            array(
                "CODE" => "ANSWER_VERSIONS"
            )
        );

        $answers = [];
        while($a = $answersRes->Fetch()){
            $answers[] = $a['VALUE']['TEXT'];
        }

        $correctRes = \CIBlockElement::GetProperty(
            391,
            $id,
            array(),
            array(
                "CODE" => "CORRECT_ANSWER_ID"
            )
        );
        $correct = [];
        while($c = $correctRes->Fetch()){
            $correct[] = $c['VALUE'];
        }

        while ($arr = $res->Fetch()){
            if (empty($answers[0]) && !empty($correct[0])) {
                $answers_list = ['INFO' => $arr, "TYPE" => $type, "CORRECT" => $correct];
            } elseif (empty($correct[0]) && !empty($answers[0])) {
                $answers_list = ['INFO' => $arr, "TYPE" => $type, "ANSWERS" => $answers];
            } elseif (empty($answers[0]) && empty($correct[0])) {
                $answers_list = ['INFO' => $arr, "TYPE" => $type];
            } else {
                $answers_list = ['INFO' => $arr, "TYPE" => $type, "ANSWERS" => $answers, "CORRECT" => $correct];
            }
            if(!empty($arr['PREVIEW_PICTURE'])){
                $answers_list['PREVIEW_PICTURE'] = $arr['PREVIEW_PICTURE'];
            }
            $arResult[] = $answers_list;

        }
        return $arResult;
    }

    public function get_test_default_data($lessonID, $studentID){
        global $USER;
        $entity_data_class = $this->GetEntityDataClass(3);
        $testData = $entity_data_class::getList(array(
            'select' => array('UF_TITLE', 'UF_QUESTIONS'),
            'order' => array(),
            'filter' => array(
                'UF_LESSON_ID' => $lessonID
            )
        ))->Fetch();
        $testData['UF_QUESTIONS'] = unserialize($testData['UF_QUESTIONS']);
        return ['TEST_TITLE' => $testData['UF_TITLE'], 'QUESTIONS_POINT' => $testData['UF_QUESTIONS'][$studentID]];
    }

    public function get_passed_test_data($userID, $test){
        global $USER;
        $entity_data_class = $this->GetEntityDataClass(4);
        $testData_DB = $entity_data_class::getList(array(
            'select' => array('*'),
            'filter' => array(
                'UF_USER_ID' => $userID,
                "UF_TEST_ID" => $test
            )
        ))->Fetch();
        $testData_DB['UF_QUESTIONS_AND_ANSWERS'] = unserialize($testData_DB['UF_QUESTIONS_AND_ANSWERS']);
        return $testData_DB;
    }


    public function executeComponent()
    {
        global $APPLICATION, $USER;

        $request = Application::getInstance()->getContext()->getRequest();
        if($_REQUEST['flag'] == 'START_TEST'){
            $this->start_test($_REQUEST['TEST_ID']);
        }
        session_start();
        $_SESSION[$request->getPost('TEST_ID')] = "true";

        $entity_data_class2 = $this->GetEntityDataClass(4);
        $is_finished = $entity_data_class2::getList(array(
            'select' => array('UF_FINISHED'),
            'filter' => array(
                "UF_USER_ID" => $USER->GetID(),
                "UF_TEST_ID" => $request->get('TEST_ID')
            )
        ))->fetch()['UF_FINISHED'];

        if($_REQUEST['flag'] == 'NEXT_QUESTION'){
            self::next_question($request->get('TEST_ID'), $request->get('myAnswer'), $request->getPost('order'));
        } elseif ($_REQUEST['flag'] == 'PREVIOUS_QUESTION'){
            self::prev_question($request->getPost('test'));
        }
        $entity_data_class = $this->GetEntityDataClass(3);
        $rsData = $entity_data_class::getList(array(
            'select' => array('UF_TIME', 'UF_BACK', 'ID'),
            'filter' => array(
                "ID" => $request->get('TEST_ID')
            )
        ))->Fetch();
        if($rsData['UF_BACK']){
            $this->arResult['BACK'] = true;
        }
        $entity_data_class = $this->GetEntityDataClass(4);
        $passed_data = $entity_data_class::getList(array(
            'select' => array('*'),
            'filter' => array(
                "UF_TEST_ID" => $request->get('TEST_ID'),
                "UF_USER_ID" => $USER->GetID(),
            )
        ))->Fetch();
        $date_now = time();
        $date_future = $passed_data['UF_END_DATE'];
        $diff = $date_future - $date_now;
        $hours = floor($diff / 3600);
        $diff = $diff % 3600;
        $mins = floor($diff / 60);
        $secs = $diff % 60;
        $this->arResult['TIME'] = $hours . ":" . $mins . ":" . $secs;

        $this->arResult['CURRENT'] = $passed_data['UF_CURRENT_QUESTION'];
        $this->arResult['QUESTIONS'] = self::get_test_data($request->get('TEST_ID'));
        if(count($this->arResult['QUESTIONS']['QUESTIONS']) == $this->arResult['CURRENT'] + 1){
            $this->arResult['LAST'] = 'Y';
        }
        if($passed_data['UF_END_DATE'] && count($this->arResult['QUESTIONS']['QUESTIONS']) >= $this->arResult['CURRENT'] + 1){
            $_COOKIE['test_' . $rsData['ID'] . '_time'] = date('H:i:s', $passed_data['UF_END_DATE']);
            if(time() > $passed_data['UF_END_DATE']){
                $this->arResult['EXPIRED'] = true;
            }
            $this->includeComponentTemplate();
        } elseif($is_finished){
            $passedTestsInfo = $this->get_passed_test_data($USER->GetID(), $request->get('TEST_ID'));
            $passedTests = $passedTestsInfo['UF_QUESTIONS_AND_ANSWERS'];
            $this->arResult['MARK'] = $passedTestsInfo['UF_COINS_SUMMARY'];
            foreach($passedTests as $question => $selected){
                $this->arResult['QUESTIONS'][] = ["QUESTION_INFO" => $this->get_question($question)[0], 'SELECTED' => $selected];
            }
            $this->arResult['TEST_DATA']['DEFAULT'] = $this->get_test_default_data($request->get('LESSON_ID'), $USER->GetID());
            $this->includeComponentTemplate('end');
            die;
        } else {
            $this->includeComponentTemplate('start');
        }
    }
}