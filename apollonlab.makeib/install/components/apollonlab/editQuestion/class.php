<?php

class editQuestion extends CBitrixComponent
{
    public function updateQuestion($id)
    {

    }

    public function getOldData($id){
        $props = [];
        $elemProp = CIBlockElement::GetProperty("391", $id, array("sort" => "ASC"), array());
        while($prop = $elemProp->Fetch()){
            $props[] = $prop;
        }
        return $props;
    }

    public function executeComponent()
    {
        if($_REQUEST["flag"] == "updateQuestion"){
//        ID elementa
            $ID = $_REQUEST["ID"];
            $this->arResult["ID"] = $ID;

//       stanum enq harci tesaky (XML_ID)
            $elemTypeXML_ID = CIBlockElement::GetProperty("391", $ID, array("sort" => "ASC"), array('CODE' => "QUESTION_LIST"))->Fetch()['VALUE_XML_ID'];
            $this->arResult["TYPE_XML_ID"] = $elemTypeXML_ID;

//        stanum enq harci tesaki svoistvai ID
//        $this->arResult["typeID"] = CIBlockElement::GetProperty("391", $ID, array("sort" => "ASC"), array('CODE' => $elemTypeXML_ID))->Fetch()["ID"];

//        stanum enq bun harcy
            $elem = CIBlockElement::GetList(array("SORT"=>"ASC"), array("ID" => $ID), false, false, array("NAME", 'PREVIEW_PICTURE'))->Fetch();
            $this->arResult["QUESTION"] = $elem["NAME"];
            $this->arResult["PREV_PIC"] = $elem['PREVIEW_PICTURE'];

//        stanum enq patasxani tarberaknery
            $versions = CIBlockElement::GetProperty("391", $ID, array("sort" => "ASC"), array('CODE' => "ANSWER_VERSIONS"));
            while($version = $versions->Fetch()){
                $this->arResult["ANSWER_VERSIONS"][] = $version["VALUE"]["TEXT"];
            }

//        stanum enq chisht patasxani id-nerty
            $correct_id = CIBlockElement::GetProperty("391", $ID, array("sort" => "ASC"), array('CODE' => "CORRECT_ANSWER_ID"));
            while($id = $correct_id->Fetch()){
                $this->arResult["CORRECT_ANSWERS_ID"][] = $id["VALUE"];
            }

        }
        elseif($_REQUEST["flag"] == "editQuestion"){
            if(!empty($_FILES)){
                move_uploaded_file($_FILES['picture']['tmp_name'], '/upload/questions/' . explode('.', $_FILES['picture']['name'])[0]);
            }
            $elemTypeXML_ID = CIBlockElement::GetProperty("391", $_REQUEST["ID"], array("sort" => "ASC"), array('CODE' => "QUESTION_LIST"))->Fetch()["VALUE_XML_ID"];
            $elemTypeID = CIBlockElement::GetProperty("391", $_REQUEST["ID"], array("sort" => "ASC"), array('CODE' => "QUESTION_LIST"))->Fetch()["VALUE"]  ;
            $elem = new CIBlockElement();
            $elem->Update(
                $_REQUEST["ID"],
                array(
                    "NAME"                  => $_REQUEST["question"],
                    "PREVIEW_PICTURE"       => $_FILES['picture'],
                    PROPERTY_VALUES         => [
                        $elemTypeXML_ID         => $_REQUEST["question"],
                        "ANSWER_VERSIONS"       => json_decode($_REQUEST["answers"]),
                        "CORRECT_ANSWER_ID"     => json_decode($_REQUEST["correctAns"]),
                        "QUESTION_LIST"         => $elemTypeID
                    ],
                ),
                true
            );
        }
        $this->IncludeComponentTemplate();
    }
}