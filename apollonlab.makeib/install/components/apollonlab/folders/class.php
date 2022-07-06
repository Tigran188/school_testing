<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {die();}

use Bitrix\Main\LoaderException;

class folders extends CBitrixComponent {


    public static function addFolder($name, $section = false): bool
    {

        $ID = CIBlock::GetList(["SORT" => "ASC"], ["TYPE" => "testType", 'CODE' => 'testInfoBlock'], false)->Fetch()['ID'];
        $bs = new CIBlockSection();
        if($section){
            $arFields = Array(
                "ACTIVE" => "Y",
                "IBLOCK_ID" => $ID,
                "IBLOCK_SECTION_ID" => $section,
                "NAME" => $name,
                "SORT" => 500,
                "DESCRIPTION" => "DESCRIPTION",
                "DESCRIPTION_TYPE" => "S"
            );
        }else{
            $arFields = Array(
                "ACTIVE" => "Y",
                "IBLOCK_ID" => $ID,
                "NAME" => $name,
                "SORT" => 500,
                "DESCRIPTION" => "DESCRIPTION",
                "DESCRIPTION_TYPE" => "S"
            );
        }
        if($bs->Add($arFields)){
            return true;
        }
        return false;
    }

    /**
     * @return array
     * Getting all sections on step 1 in infoblock
     */
    public function getFolders (): array
    {
        $arResult = [];
        $id_IB = CIBlock::GetList(["SORT" => "DESC"], ["TYPE" => "testType", "CODE" => 'testInfoBlock'], false)->Fetch()["ID"];

        $sections = CIBlockSection::GetList(
            array("ORDER" => "ASC"),
            array(
                "IBLOCK_ID" => $id_IB,
                "DEPTH_LEVEL" => 1,
            )
        );
        while($arr = $sections->Fetch()){
            $arResult[] = $arr;
        }
        return $arResult;
    }

    public function delFolder($id)
    {
        global $DB;
        CIBlockSection::Delete($id);
        $DB->Commit();
    }

    public function delElem($id)
    {
        global $DB;
        CIBlockElement::Delete($id);
        $DB->Commit();
    }

    /**
     * @param $id
     * @param $name
     * editing name of section
     */
    public function edit($id, $name)
    {
        $sect = new CIBlockSection;
        $sect->Update($id, ["NAME" => $name]);
    }

    /**
     * @throws LoaderException
     */
    public function executeComponent(): bool
    {

        if ($_REQUEST["flag"] == "addFolder") {

            if ($_REQUEST["folderID"]){
                self::addFolder($_REQUEST["folderName"], $_REQUEST["folderID"]);

            } else {

                self::addFolder($_REQUEST["folderName"]);

            }

        } elseif ($_REQUEST["flag"] == "delFolder") {

            self::delFolder($_REQUEST["id"]);
            $this->arResult["SECTIONS"] = $this->getFolders();

        } elseif ($_REQUEST["flag"] == "updateFolder"){

            self::edit($_REQUEST["folderId"], $_REQUEST["newFolderName"]);
            $this->arResult["SECTIONS"] = $this->getFolders();

        }

        $this->arResult["SECTIONS"] = $this->getFolders();
        $this->IncludeComponentTemplate();

        return true;
    }
}








