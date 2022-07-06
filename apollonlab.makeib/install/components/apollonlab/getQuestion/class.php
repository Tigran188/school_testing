<?php
class getQuestion extends \CBitrixComponent
{
    public function setQuestion($question, $versions = "", $correctAns = "", $folderID, $type, $typeID, $picture)
    {
        if(!empty($_FILES)){
            move_uploaded_file($_FILES['picture']['tmp_name'], '/upload/questions/' . explode('.', $_FILES['picture']['name'])[0]);
        }
        $ib_ID = 391;
        $el = new CIBlockElement;

        $PROP = [
            "ANSWER_VERSIONS"   => json_decode($versions),
            "CORRECT_ANSWER_ID" => json_decode($correctAns),
            $type               => $question,
            "QUESTION_LIST"     => $typeID
        ];

        $arLoadProductArray = Array(
            "ACTIVE"            => "Y",            // активен
            "IBLOCK_SECTION_ID" => $folderID,      // элемент лежит в корне раздела
            "IBLOCK_ID"         => $ib_ID,
            "NAME"              => $question,
            "PROPERTY_VALUES"   => $PROP,
            'PREVIEW_PICTURE'   => $_FILES['picture']
        );

        $el->Add($arLoadProductArray);
    }

    /**
     * @return bool
     */
    public function executeComponent(): bool
    {
        if ($_REQUEST["flag"] == "setQuestion") {
            self::setQuestion($_REQUEST["question"], $_REQUEST['answers'], $_REQUEST["correctAns"], $_REQUEST["folderID"], $_REQUEST["type"], $_REQUEST["typeID"], $_REQUEST['picture']);
        }

        $arr = CIBlockPropertyEnum::GetList(
            array("id"=>"ASC"),
            array("CODE" => "QUESTION_LIST")
        );
        $this->arResult["QUEST_TYPES"] = [];
        while($item = $arr->Fetch()){
            $this->arResult["QUEST_TYPES"][] = $item;
        }
        $this->IncludeComponentTemplate();
        return false;
    }
}