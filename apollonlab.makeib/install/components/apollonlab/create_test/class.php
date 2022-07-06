<?php
use Bitrix\Main;
//use Bitrix\Main\Application;
use Bitrix\Main\Loader;
Loader::includeModule("highloadblock");

use Bitrix\Highloadblock\HighloadBlockTable as HLBT;
use Bitrix\Main\Entity;

CModule::IncludeModule('highloadblock');

class create_test extends CBitrixComponent
{

    public function add_test($testName, $time, $isOpen, $back, $sections_and_options, $lesson_id, $date)
    {
        global $USER;

        $users_info = [];

        $className = CIBlockElement::GetList(
            array(),
            array(
                "ID" => $_REQUEST['CLASS_ID']
            ),
            false,
            false,
            array()
        )->Fetch()['NAME'];

        $users = CUser::GetList(
            'id',
            'desc',
            ['UF_EDU_STRUCTURE' => $_REQUEST['CLASS_ID']],
            []
        );
        while($user = $users->Fetch()){
            $users_info[] = $user['ID'];
        }

        $questions = [];
        foreach ($sections_and_options as $sect) {
            $res = CIBlockElement::GetList([], ['SECTION_ID' => $sect["section_id"], "INCLUDE_SUBSECTIONS" => "Y"], false, false, ['ID']);
            while($r = $res->Fetch()){
                $questions[$sect["section_id"]][] = $r['ID'];
            }
        }

        $createDate = date('d.m.Y');
        $userID = $USER->GetID();

        $section_options = [];

        foreach ($users_info as $user) {

            foreach ($sections_and_options as $section) {

                $questIDs = [];
                if($section["count_questions"] == 1){
                    $num = rand(0, count($questions[$section['section_id']]) - 1);
                    $questIDs[] = $questions[$section['section_id']][$num];
                }else {
                    $quests = array_rand($questions[$section['section_id']], $section['count_questions']);
                    for($i = 0; $i<count($quests); $i++){
                        $questIDs[] = $questions[$section['section_id']][$quests[$i]];
                    }
                }
                $section_options[$user][] = ['point' => $section['points'], $section["section_id"] => $questIDs];
            }
        }

        $isOpen == 'false' ? $isOpen = '' : $isOpen = 'Y';
        $back == 'false' ? $back = '' : $back = 'Y';


        $hlbl = 3; // Указываем ID нашего highloadblock блока к которому будет делать запросы.
        $hlblock = HLBT::getById($hlbl)->fetch();

        $entity = HLBT::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();

// Массив полей для добавления
        $data = array(
            "UF_TITLE"      => $testName,
            "UF_TIME"       => $time,
            "UF_OPEN"       => $isOpen,
            "UF_BACK"       => $back,
            "UF_QUESTIONS"  => serialize($section_options),
            "UF_CREATE"     => $createDate,
            "UF_CREATED_BY" => $userID,
            "UF_CLASS_ID"   => $_REQUEST['CLASS_ID'],
            "UF_PERIOD"     => $_REQUEST['PERIOD'],
            "UF_SUBJECT_ID" => $_REQUEST['SUBJECT_ID'],
            "UF_LESSON_ID" => $lesson_id,
            "UF_LESSON_DATE_TIME" => implode(' ', explode('_', $date)),
        );
        if($entity_data_class::add($data)){
            return true;
        }else{
            return false;
        }
    }

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

    public function edit_test($testName, $time, $isOpen, $back, $sections_and_options, $test_id)
    {
        global $USER;

        $users_info = [];

        $className = CIBlockElement::GetList(
            array(),
            array(
                "ID" => $_REQUEST['CLASS_ID']
            ),
            false,
            false,
            array()
        )->Fetch()['NAME'];
        $users = CUser::GetList(
            'id',
            'desc',
            ['UF_EDU_STRUCTURE' => $_REQUEST['CLASS_ID']],
            []
        );
        while($user = $users->Fetch()){
            $users_info[] = $user['ID'];
        }

        $questions = [];
        foreach ($sections_and_options as $sect) {
            $res = CIBlockElement::GetList([], ['SECTION_ID' => $sect["section_id"], "INCLUDE_SUBSECTIONS" => "Y"], false, false, ['ID']);
            while($r = $res->Fetch()){
                $questions[$sect["section_id"]][] = $r['ID'];
            }
        }

        $createDate = date('d.m.Y');
        $userID = $USER->GetID();

        $section_options = [];

        foreach ($users_info as $user) {

            foreach ($sections_and_options as $section) {

                $questIDs = [];
                if($section["count_questions"] == 1){
                    $num = rand(0, count($questions[$section['section_id']]) - 1);
                    $questIDs[] = $questions[$section['section_id']][$num];
                }else {
                    $quests = array_rand($questions[$section['section_id']], $section['count_questions']);
                    for($i = 0; $i<count($quests); $i++){
                        $questIDs[] = $questions[$section['section_id']][$quests[$i]];
                    }
                }
                $section_options[$user][] = ['point' => $section['points'], $section["section_id"] => $questIDs];
            }
        }
        $entity_data_class = $this->GetEntityDataClass(3);
        $result = $entity_data_class::update($test_id, array(
            "UF_TITLE"       => $testName,
            "UF_TIME"        => $time,
            "UF_OPEN"        => $isOpen,
            "UF_BACK"        => $back,
            "UF_QUESTIONS"   => serialize($section_options),
            "UF_MODIFIED_BY" => $userID,
            "UF_MODIFIED"    => $modeDate
        ));
        if($result){
            return true;
        }else{
            return false;
        }

    }

    public function get_test_data($id)
    {
        //Напишем функцию получения экземпляра класса:
        function GetEntityDataClass($HlBlockId)
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
        $entity_data_class = GetEntityDataClass(3);
        $rsData = $entity_data_class::getList(array(
            'select' => array('*'),
            'filter' => array(
                'ID' => $id
            )
        ));
        $arr = [];
        while($elem = $rsData->fetch()){
            $arr[] = $elem;
        }
        $arr[0]['UF_QUESTIONS'] = unserialize($arr[0]['UF_QUESTIONS']);
        return $arr[0];
    }

    public function deactivate_test($id)
    {

        $hlblock = HLBT::getById(3)->fetch(); // id highload блока
        $entity = HLBT::compileEntity($hlblock);
        $entityClass = $entity->getDataClass();
        $res = $entityClass::getList(array(
            'select' => array('*'),
            'order' => array('ID' => 'ASC'),
            'filter' => array(
                'UF_LESSON_ID'  => $id
            )
        ));
        $hlblock_elem_id = $res->fetch()['ID'];

        $result = $entityClass::update($hlblock_elem_id, array(
            'UF_ACTIVE' => false
        ));
        if($result){
            return true;
        }else{
            return false;
        }

    }


    public function activate_test($id)
    {

        $hlblock = HLBT::getById(3)->fetch(); // id highload блока
        $entity = HLBT::compileEntity($hlblock);
        $entityClass = $entity->getDataClass();
        $res = $entityClass::getList(array(
            'select' => array('*'),
            'order' => array('ID' => 'ASC'),
            'filter' => array(
                'UF_LESSON_ID'  => $id
            )
        ));
        $hlblock_elem_id = $res->fetch()['ID'];

        $result = $entityClass::update($hlblock_elem_id, array(
            'UF_ACTIVE' => 'Y'
        ));
        if($result){
            return true;
        }else{
            return false;
        }

    }

    public function executeComponent()
    {
        $request = Bitrix\Main\Application::getInstance()->getContext()->getRequest();

        if($_REQUEST['flag'] == 'create_test'){
            $this->arResult["CREATED_OR_NOT"] = self::add_test($_REQUEST['testName'], $_REQUEST['time'], $_REQUEST['isOpen'], $_REQUEST['back'], $_REQUEST['sections_and_options'], $_REQUEST['LESSON_ID'], $_REQUEST['DATE']);

        } elseif($_REQUEST['flag'] == 'ACTIVATE_TEST'){

            $this->arResult['ACTIVATE_RESULT'] = self::activate_test($_REQUEST['LESSON_ID']);

        } elseif($_REQUEST['flag'] == 'DEACTIVATE_TEST'){

            return self::deactivate_test($_REQUEST['LESSON_ID']);

        } elseif ($_REQUEST['EDIT_TEST']){

            $this->arResult['EDITABLE_TEST'] = self::get_test_data($_REQUEST['EDIT_TEST']);

        } if ($_REQUEST['flag'] == 'EDIT_TEST2'){
            self::edit_test($_REQUEST['testName'], $_REQUEST['time'], $_REQUEST['isOpen'], $_REQUEST['back'], $_REQUEST['sections_and_options'], $_REQUEST['EDIT_TEST']);
        }
        if ($_REQUEST['EDIT_TEST'] || $_REQUEST['flag'] == 'EDIT_TEST2'){
            $this->IncludeComponentTemplate('editing_test');
        }else{
            $this->IncludeComponentTemplate();
        }
    }
}