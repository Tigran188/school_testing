<?php
    use Bitrix\Main\Localization\Loc;
    use Bitrix\Main\ModuleManager;
    use Bitrix\Main\Config\Option;
    use Bitrix\Main\EventManager;
    use Bitrix\Main\Application;
    use Bitrix\Main\IO\Directory;
    use Bitrix\Main\Entity\Base;
    use Bitrix\Highloadblock as HL;
    CModule::IncludeModule('highloadblock');
    Loc::loadMessages(__FILE__);

class apollonlab_makeib extends CModule {
    /**
     * apollonlab_makeib constructor.
     */
    public function __construct()
    {
        if (file_exists(__DIR__ . "/version.php")) {

            $arModuleVersion = array();

            include_once (__DIR__ . "/version.php");

            $this->MODULE_ID = str_replace("_", ".", get_class($this));
            $this->MODULE_NAME = Loc::getMessage("MODULE_NAME");
            $this->MODULE_DESCRIPTION = Loc::getMessage("DESCRIPTION");
            $this->PARTNER_NAME = Loc::getMessage("PARTNER_NAME");
            $this->PARTNER_URI = Loc::getMessage("PARTNER_URI");
            $this->MODULE_VERSION = $arModuleVersion['VERSION_DATE'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];

        }
    }

    /**
     * @return bool
     */
    public function InstallFiles(): bool
    {
        /** @var Bitrix\Main\Application $APPLICATION */
        CopyDirFiles(
            __DIR__ . "/assets/css",
            APPLICATION::getDocumentRoot() . "/bitrix/css/" . $this->MODULE_ID . "/",
            true,
            true
        );
        CopyDirFiles(
            __DIR__ . "/assets/js",
            APPLICATION::getDocumentRoot() . "/bitrix/js/" . $this->MODULE_ID . "/",
            true,
            true
        );
        CopyDirFiles(
            __DIR__ . "/components/apollonlab/",
            APPLICATION::getDocumentRoot() . "/local/components/apollonlab/",
            true,
            true
        );

        return false;
    }

    /**
     * @return bool
     */
    public function DoInstall(): bool
    {
        global $APPLICATION, $DB;

        if (CheckVersion(ModuleManager::getVersion("main"), "14.00.00")) {
            $this->InstallFiles();
            ModuleManager::registerModule($this->MODULE_ID);
        } else {
            $APPLICATION->ThrowException(
                Loc::getMessage("VERSION_ERROR")
            );
        }

//      create IBT
        $IBT = [
            'ID' => "testType",
            'SECTIONS' => 'Y',
            'IN_RSS' => 'N',
            'SORT' => 500,
            'LANG' => array(
                'en' => array(
                    'NAME' => 'vtest',
                ),
                'ru' => array(
                    'NAME' => GetMessage("TEST_IBLOCK_TYPE_NAME"),
                )
            )
        ];
        if (CModule::IncludeModule("iblock")) {
            $isExsist = CIBlockType::GetList(["SORT" => "ASC"], ["ID" => $IBT["ID"]])->Fetch();
            if (!$isExsist) {
                $newType = new CIBlockType();
                $DB->StartTransaction();
                $newType->Add($IBT);

//              create infoBlock
                $infoBlock = new CIBlock;
                $default = array(
                    'ACTIVE' => 'Y',
                    'NAME' => 'questions',
                    'CODE' => 'questions',
                    'LIST_PAGE_URL' => '',
                    'DETAIL_PAGE_URL' => '',
                    'SECTION_PAGE_URL' => '',
                    "RIGHTS_MODE" => "E",
                    'IBLOCK_TYPE_ID' => "testType",
                    'SITE_ID' => array('s1'),
                    'SORT' => 500,
                    'GROUP_ID' => array('2' => 'R'),
                    'VERSION' => 1,
                    'BIZPROC' => 'N',
                    'WORKFLOW' => 'N',
                    'INDEX_ELEMENT' => 'N',
                    'INDEX_SECTION' => 'N'
                );
                $infoBlock->Add($default);
                $DB->Commit();





                //getting id of infoblock
                $ID = CIBlock::GetList(["SORT" => "ASC"], ["TYPE" => "testType", "CODE" => 'questions'], false)->Fetch()['ID'];

                // adding properties!!!!!!!!!!!!!!!!
                $questList = new CIBlockProperty;
                $questList->Add([
                    'NAME' => 'Question List',
                    'ACTIVE' => 'Y',
                    'SORT' => 500,
                    'CODE' => 'QUESTION_LIST',
                    "MULTIPLE" => "Y",
                    'PROPERTY_TYPE' => 'L',
                    'IBLOCK_ID' => $ID,
                    "VALUES" => [
                        array(
                            "VALUE" => "Բազմաթիվ պատասխաններից մեկը ճիշտ պատասխան",
                            "XML_ID" => "SINGLE_ANSWER"
                        ),
                        array(
                            "VALUE" => "Բազմաթիվ պատասխաններից մի քանի ճիշտ պատասխան",
                            "XML_ID" => "MULTIPLE_ANSWER"
                        ),
                        array(
                            "VALUE" => "Խնդիր կամ հարց",
                            "XML_ID" => "TASK_OR_QUESTION"
                        ),
                        array(
                            "VALUE" => "Ուղղել սխալը",
                            "XML_ID" => "CORRECT_MISTAKE"
                        ),
                        array(
                            "VALUE" => "Հարցեր – համեմատություն",
                            "XML_ID" => "COMPARE"
                        ),
                        array(
                            "VALUE" => "Շարադրություն կամ Էսսե",
                            "XML_ID" => "ESSE"
                        )
                    ]
                ]);

                $Single = new CIBlockProperty;
                $Single->Add([
                    'NAME' => 'Single',
                    'ACTIVE' => 'Y',
                    'SORT' => 500,
                    'CODE' => 'SINGLE_ANSWER',
                    "MULTIPLE" => "Y",
                    'PROPERTY_TYPE' => 'S',
                    'IBLOCK_ID' => $ID["ID"],
                    "PROPERTY_MULTIPLE_CNT" => 1
                ]);

                $mult = new CIBlockProperty;
                $mult->Add([
                    'NAME' => 'Multiple',
                    'ACTIVE' => 'Y',
                    'SORT' => 500,
                    'CODE' => 'MULTIPLE_ANSWER',
                    "MULTIPLE" => "Y",
                    'PROPERTY_TYPE' => 'S',
                    'IBLOCK_ID' => $ID["ID"],
                    "PROPERTY_MULTIPLE_CNT" => 1
                ]);

                $compare = new CIBlockProperty;
                $compare->Add([
                    'NAME' => 'Compare',
                    'ACTIVE' => 'Y',
                    'SORT' => 500,
                    'CODE' => 'COMPARE',
                    "MULTIPLE" => "Y",
                    'PROPERTY_TYPE' => 'S',
                    'IBLOCK_ID' => $ID["ID"],
                    "PROPERTY_MULTIPLE_CNT" => 1
                ]);

                $taskOrQuest = new CIBlockProperty;
                $taskOrQuest->Add([
                    'NAME' => 'Task or Question',
                    'ACTIVE' => 'Y',
                    'SORT' => 500,
                    'CODE' => 'TASK_OR_QUESTION',
                    "MULTIPLE" => "Y",
                    'PROPERTY_TYPE' => 'S',
                    "USER_TYPE" => "HTML",
                    'IBLOCK_ID' => $ID["ID"],
                    "PROPERTY_MULTIPLE_CNT" => 1
                ]);

                $correctMistake = new CIBlockProperty;
                $correctMistake->Add([
                    'NAME' => 'Correct Mistake',
                    'ACTIVE' => 'Y',
                    'SORT' => 500,
                    'CODE' => 'CORRECT_MISTAKE',
                    "MULTIPLE" => "Y",
                    'PROPERTY_TYPE' => 'S',
                    "USER_TYPE" => "HTML",
                    'IBLOCK_ID' => $ID["ID"],
                    "PROPERTY_MULTIPLE_CNT" => 1
                ]);

                $correctMistake = new CIBlockProperty;
                $correctMistake->Add([
                    'NAME' => 'Comparson',
                    'ACTIVE' => 'Y',
                    'SORT' => 500,
                    'CODE' => 'COMPARISON_FILE',
                    "MULTIPLE" => "Y",
                    'PROPERTY_TYPE' => 'S',
                    "USER_TYPE" => "HTML",
                    'IBLOCK_ID' => $ID["ID"],
                    "PROPERTY_MULTIPLE_CNT" => 1
                ]);

                $correctMistake = new CIBlockProperty;
                $correctMistake->Add([
                    'NAME' => 'esse',
                    'ACTIVE' => 'Y',
                    'SORT' => 500,
                    'CODE' => 'ESSE',
                    "MULTIPLE" => "Y",
                    'PROPERTY_TYPE' => 'S',
                    "USER_TYPE" => "HTML",
                    'IBLOCK_ID' => $ID["ID"],
                    "PROPERTY_MULTIPLE_CNT" => 1
                ]);

                //correct answer property
                $correctMistake = new CIBlockProperty;
                $correctMistake->Add([
                    'NAME' => 'Correct Answer ID',
                    'ACTIVE' => 'Y',
                    'SORT' => 500,
                    'CODE' => 'CORRECT_ANSWER_ID',
                    "MULTIPLE" => "Y",
                    'PROPERTY_TYPE' => 'N',
                    'IBLOCK_ID' => $ID["ID"],
                    "PROPERTY_MULTIPLE_CNT" => 1
                ]);

                //answer versions property
                $correctMistake = new CIBlockProperty;
                $correctMistake->Add([
                    'NAME' => 'answer versions',
                    'ACTIVE' => 'Y',
                    'SORT' => 500,
                    'CODE' => 'ANSWER_VERSIONS',
                    "MULTIPLE" => "Y",
                    'PROPERTY_TYPE' => 'S',
                    "USER_TYPE" => "HTML",
                    'IBLOCK_ID' => $ID["ID"]
                ]);
                //question image
                $correctMistake = new CIBlockProperty;
                $correctMistake->Add([
                    'NAME' => 'question image',
                    'ACTIVE' => 'Y',
                    'SORT' => 500,
                    'CODE' => 'QUESTION_IMAGE',
                    "MULTIPLE" => "N",
                    'PROPERTY_TYPE' => 'F',
                    'IBLOCK_ID' => $ID["ID"]
                ]);






//
////                ready test options
////                time option
//                $ID = CIBlock::GetList(["SORT" => "ASC"], ["TYPE" => "testType", "CODE" => 'ready_tests'], false)->Fetch()['ID'];
//
//                $correctMistake = new CIBlockProperty;
//                $correctMistake->Add([
//                    'NAME' => 'Time',
//                    'ACTIVE' => 'Y',
//                    'SORT' => 500,
//                    'CODE' => 'TIME',
//                    "MULTIPLE" => "N",
//                    'PROPERTY_TYPE' => 'S',
//                    'IBLOCK_ID' => $ID
//                ]);
//
////                is open option
//                $correctMistake = new CIBlockProperty;
//                $correctMistake->Add([
//                    'NAME' => 'is open',
//                    'ACTIVE' => 'Y',
//                    'SORT' => 500,
//                    'CODE' => 'IS_OPEN',
//                    "MULTIPLE" => "N",
//                    'PROPERTY_TYPE' => 'B',
//                    'IBLOCK_ID' => $ID
//                ]);
//
////                can go back? option
//                $correctMistake = new CIBlockProperty;
//                $correctMistake->Add([
//                    'NAME' => 'go back',
//                    'ACTIVE' => 'Y',
//                    'SORT' => 500,
//                    'CODE' => 'BACK',
//                    "MULTIPLE" => "N",
//                    'PROPERTY_TYPE' => 'B',
//                    'IBLOCK_ID' => $ID
//                ]);
//











            }

            //adding section!
            $bs = new CIBlockSection;
            $arFields = Array(
                "ACTIVE" => "Y",
                "IBLOCK_ID" => $ID["ID"],
                "NAME" => "myTestSection",
                "SORT" => 500,
                "DESCRIPTION" => "DESCRIPTION",
                "DESCRIPTION_TYPE" => "S"
            );
            $bs->Add($arFields);
        }

        $APPLICATION->IncludeAdminFile(
            Loc::getMessage("INSTALL_TITLE"),
            __DIR__ . "/step.php"
        );

        return false;
    }

    /**
     * @return bool
     */
    public function UnInstallFiles(): bool
    {
        Directory::deleteDirectory(Application::getDocumentRoot() . "/bitrix/css/" . $this->MODULE_ID);
        Directory::deleteDirectory(Application::getDocumentRoot() . "/bitrix/js/" . $this->MODULE_ID);
        Directory::deleteDirectory(Application::getDocumentRoot() . "/local/components/apollonlab");

        return false;
    }

    /**
     * @return bool
     */
    public function DoUninstall(): bool
    {
        global $APPLICATION;

        $this->UnInstallFiles();

        if(CModule::IncludeModule("iblock")) {
            CIBlockType::Delete("testType");
        }

        ModuleManager::unRegisterModule($this->MODULE_ID);

        $APPLICATION->IncludeAdminFile(
            Loc::getMessage("UNINSTALL_TITLE") . "\"" . Loc::getMessage("MODULE_NAME") . "\"",
            __DIR__ . "/unstep.php"
        );
        return false;
    }
}