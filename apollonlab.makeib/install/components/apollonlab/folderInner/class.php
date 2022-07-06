<?php

class folderInner extends CBitrixComponent {

    /**
     * @param $id
     * @return array
     */
    public function viewFolderSections($id): array
    {

        $arResult = [];
        $res = CIBlockElement::GetList(
            Array(
                "SORT"=>"ASC"
            ),
            array(
                "SECTION_ID" => $id,
                "IBLOCK_ID"  => 391
            ),
            false,
            false,
            array("NAME", "ID")
        );
        while ($arr = $res->Fetch()){
            $arResult[] = $arr;
        }

        return $arResult;
    }

    /**
     * @param $id
     * @return array
     */
    public function viewFolderElems($id): array
    {
        $res = CIBlockSection::GetList(
            Array(
                "SORT"=>"DESC"
            ),
            array(
                "SECTION_ID" => $id,
                "IBLOCK_ID"  => 391,
            ),
            false,
            array('*')
        );
        $key = 0;
        $arResult = [];
        while ($arr = $res->Fetch()){
            $c = 0;
            $e = CIBlockElement::GetList([], ['SECTION_ID' => $arr['ID'], 'INCLUDE_SUBSECTIONS' => 'Y'], false, false, ['ID']);
            while($e->Fetch()){
                $c++;
            }
            $arResult[$key] = $arr;
            $arResult[$key]['ELEMS_COUNT'] = $c;
            $key++;
        }

        return $arResult;
    }


    /**
     * @param $id
     */
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
     * @return bool
     */
    public function executeComponent(): bool
    {
        global $APPLICATION;
        if ($_REQUEST["flag"] == "ViewFolder") {
            $APPLICATION->AddChainItem($_REQUEST["name"], $_REQUEST["name"]);
            $this->arResult['FOLDER_ID'] = $_REQUEST["FolderID"];
            $this->arResult['ELEMENTS']["ELEMENTS"] = $this->viewFolderSections($_REQUEST['FolderID']);
            $this->arResult['ELEMENTS']["SECTIONS"] = $this->viewFolderElems($_REQUEST["FolderID"]);

        } elseif($_REQUEST['flag'] == 'previousSection') {

            $this->arResult['FOLDER_ID'] = $sectID[count($sectID) - 1]['ID'];
            $this->arResult['ELEMENTS']["ELEMENTS"] = $this->viewFolderSections($sectID[count($sectID) - 1]['ID']);
            $this->arResult['ELEMENTS']["SECTIONS"] = $this->viewFolderElems($sectID[count($sectID) - 1]['ID']);
            session_start();
            $_SESSION['CURRENT_FOLDER'] = $sectID[count($sectID) - 1]['ID'];

        } elseif ($_REQUEST["flag"] == "delElem"){

            self::delElem($_REQUEST["id"]);

        } elseif ($_REQUEST["flag"] == "delFolderIn"){

            self::delFolder($_REQUEST["id"]);

        } elseif ($_REQUEST["flag"] == "updateFolder"){

            self::edit($_REQUEST["folderId"], $_REQUEST["newFolderName"]);

        }
        $this->IncludeComponentTemplate();
        return false;
    }
}