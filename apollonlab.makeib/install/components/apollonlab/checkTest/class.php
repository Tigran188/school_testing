<?php

use Bitrix\Main\Application;
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;

class checkTest extends CBitrixComponent
{

    public function GetEntityDataClass($HlBlockId)
    {
        if (empty($HlBlockId) || $HlBlockId < 1) {
            return false;
        }
        $hlblock = HLBT::getById($HlBlockId)->fetch();
        $entity = HLBT::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();
        return $entity_data_class;
    }

    public function get_passed_test_data($testID){
        global $USER;
        $entity_data_class = $this->GetEntityDataClass(4);
        $testData = $entity_data_class::getList(array(
            'select' => array('*'),
            'order' => array(),
            'filter' => array(
                'ID' => $testID
            )
        ))->Fetch();
        $testData['UF_QUESTIONS_AND_ANSWERS'] = unserialize($testData['UF_QUESTIONS_AND_ANSWERS']);
        return $testData;
    }


    public function get_passed_test_time($testID){
        global $USER;
        $entity_data_class = $this->GetEntityDataClass(4);
        $testData = $entity_data_class::getList(array(
            'select' => array('UF_START_DATE', 'UF_FINISH_DATE'),
            'order' => array(),
            'filter' => array(
                'ID' => $testID
            )
        ))->Fetch();
        $testData['START_DATE'] = $testData['UF_START_DATE'];
        $testData['END_DATE'] = $testData['UF_FINISH_DATE'];
        $testData['INTERVAL'] = $testData['UF_FINISH_DATE'] - $testData['UF_START_DATE'];
        return $testData;
    }



    public function get_question($id){
        $arResult = [];

        $res = CIBlockElement::GetList(
            Array(
                "SORT"=>"ASC"
            ),
            array(
                "ID" => $id,
                "IBLOCK_ID"  => 391
            ),
            false,
            false,
            array("NAME", "ID", "SECTION_ID", "IBLOCK_SECTION_ID")
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
            $arResult[] = $answers_list;
        }
        return $arResult;
    }

    public function get_test_default_data($lessonID, $studentID){
        global $USER;
        $entity_data_class = $this->GetEntityDataClass(3);
        $testData = $entity_data_class::getList(array(
            'select' => array('*'),
            'order' => array(),
            'filter' => array(
                'UF_LESSON_ID' => $lessonID
            )
        ))->Fetch();
        $testData['UF_QUESTIONS'] = unserialize($testData['UF_QUESTIONS']);
        return ['TEST_TITLE' => $testData['UF_TITLE'], 'QUESTIONS_POINT' => $testData['UF_QUESTIONS'][$studentID]];
    }

    public function executeComponent(): bool
    {
        $request = Bitrix\Main\Application::getInstance()->getContext()->getRequest();
        if($request->getPost('flag') == 'reviewPassesTest') {
            $passedTests = $this->get_passed_test_data($request->getPost('test_id'))['UF_QUESTIONS_AND_ANSWERS'];
            $this->arResult['DATES'] = $this->get_passed_test_time($request->getPost('test_id'));
//            p($this->arResult['END_DATE']);
            foreach($passedTests as $question => $selected){
                $this->arResult['QUESTIONS'][] = ["QUESTION_INFO" => $this->get_question($question)[0], 'SELECTED' => $selected];
            }
            $this->arResult['TEST_DATA']['DEFAULT'] = $this->get_test_default_data($this->arParams['LESSON_ID'], $request->getPost('student_id'));
        } elseif ($request->getPost('flag') == "ACCEPT_TEST") {
            $testID = $request->getPost('test_id');
            $hlbl = 4;
            $summ = '0';
            foreach ($request->getPost('points') as $point){
                if($point != 0) {
                    $summ += (int)$point;
                }
            }
            $entity_data_class = $this->GetEntityDataClass($hlbl);
            $result = $entity_data_class::update($testID, array(
                'UF_CHECKED_POINTS' => serialize($request->getPost('points')),
                "UF_CHECKED" => true,
                "UF_COINS_SUMMARY" => $summ
            ));
        }
        $this->IncludeComponentTemplate();
        return false;
    }
}




