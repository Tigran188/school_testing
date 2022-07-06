<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); ?>
<?php $APPLICATION->SetTitle('ՀԱՐՑԱՇԱՐ');
use Bitrix\Main\Localization\Loc;
Loc::loadLanguageFile(SITE_TEMPLATE_PATH . "/testavorum/lang", LANGUAGE_ID);
$ID = CIBlock::GetList([], ['CODE' => 'testInfoBlock'], false)->Fetch()['ID'];
?>
<!--<link rel="stylesheet" href="/testavorum/css/questionsCss.css">-->

<link rel="stylesheet" href="/testavorum/css/foldersMain.css"/>

<link href="/testavorum/css/main.css" rel="stylesheet"/>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.8.1/dist/css/uikit.min.css"/>




<div class="modalWindow">
    <?php
    $APPLICATION->IncludeComponent(
        "apollonlab:editQuestion",
        "",
        array(),
        false
    );
    ?>
    <?php
    $APPLICATION->IncludeComponent(
        "apollonlab:getQuestion",
        "",
        array(),
        false
    );
    ?>
    <div class="makeFolderName">
        <p class="errors"></p>
        <label class="folderName">
            <span class="arial">ԹՂԹԱՊԱԱԿԻ ԱՆՈՒՆԸ<?//echo Loc::getMessage("NEW_FOLDER_NAME")?></span>
            <input type="text">
        </label>
        <div class="buttons">
            <a href="#" class="activate addInFolder">ԱՎԵԼԱՑՆԵԼ<?// echo Loc::getMessage("ADD")?></a>
            <a href="#" class="cancel">ՉԵՂԱՐԿԵԼ<?// echo Loc::getMessage("CANCEL")?></a>
        </div>
    </div>

    <div class="editFolderNameModal">
        <p class="errors"></p>
        <form class="folderName">
            <span class="arial">ԹՂԹԱՊԱՆԱԿԻ ՆՈՐ ԱՆՈՒՆԸ</span>
            <input type="text" name="editFolderName"/>
        </form>
        <div class="buttons">
            <a href="#" class="update">ԹԱՐՄԱՑՆԵԼ</a>
            <a href="#" class="cancel">ՉԵՂԱՐԿԵԼ</a>
        </div>
    </div>

    <div class="folderInner">
        <div class="olderFolders">
            <h2>Դասարաններ</h2>
            <div class="foldersList">
                <?if($_REQUEST['flag'] == 'update_left_section') $APPLICATION->RestartBuffer();?>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:catalog.section.list",
                    "folders_tree",
                    Array(
                        "ADD_SECTIONS_CHAIN" => "Y",
                        "CACHE_FILTER" => "N",
                        "CACHE_GROUPS" => "Y",
                        "CACHE_TIME" => "36000000",
                        "CACHE_TYPE" => "A",
                        "COMPOSITE_FRAME_MODE" => "A",
                        "COMPOSITE_FRAME_TYPE" => "AUTO",
                        "COUNT_ELEMENTS" => "N",
                        "COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
                        "FILTER_NAME" => "sectionsFilter",
                        "IBLOCK_ID" => $ID,
                        "IBLOCK_TYPE" => "testType",
                        "SECTION_CODE" => "",
                        "SECTION_FIELDS" => array("NAME",""),
                        "SECTION_ID" => $_REQUEST["SECTION_ID"],
                        "SECTION_URL" => "",
                        "SECTION_USER_FIELDS" => array("",""),
                        "SHOW_PARENT_NAME" => "Y",
                        "TOP_DEPTH" => "15",
                        "VIEW_MODE" => "LINE"
                    )
                );?>
                <?if($_REQUEST['flag'] == 'update_left_section') die;?>
            </div>
        </div>
        <div class="mainmaterials">
            <?
            if($_REQUEST["flag"] == "ViewFolder" or $_REQUEST["flag"] == "previousSection" or $_REQUEST["flag"] == "setQuestion"){
                $APPLICATION->RestartBuffer();
            }?>
<!--            <div>-->

                <div class="top">
                    <div class="navigation">
                        <div>
                            <div class="ToLeft" id="<?=$_SESSION['FOLDER_ID']?>"><a href="#"> < </a></div>
                            <div class="buttons">
                                <div class="add">
                                    <a href="#" class="activate addFileOrFolder">
                                        <span>Ավելացնել</span>
                                        <span uk-icon="icon: triangle-down"></span>
                                    </a>
                                    <ul>
                                        <li class="addQuestion1 background-blue">
                                            <a href="#">
                                                <img src="images/topFile.png" alt="error!">
                                                <span>ՀԱՐՑ</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="addFolderIn">
                                                <img src="images/folder.png" alt="error!">
                                                <span>ԹՂԹԱՊԱՆԱԿ</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <p class="breadcrumb">
                            <?
                            $nav = CIBlockSection::GetNavChain(false, $_REQUEST['FolderID']);
                            $n = 1;
                            while($arSectionPath = $nav->GetNext()){
                               if ($n == count($nav)){
                                   echo $arSectionPath['NAME'];
                               } else {
                                   echo " > " . $arSectionPath['NAME'];
                               }
                               $n++;
                            }?>
                        </p>
                    </div>

                </div>
                <div class="materialsCenter">


                    <?php
                    $APPLICATION->IncludeComponent(
                        "apollonlab:folderInner",
                        ".default",
                        array(),
                        false
                    );
                    ?>

<!--                </div>-->
            </div>

            <div class="select">
                <a href="#" class="b1">ԸՆՏՐԵԼ ԹՂԹԱՊԱՆԱԿԸ</a>
                <a href="#" class="b2">ՉԵՂԱՐԿԵԼ</a>
            </div>
            <?
            if($_REQUEST["flag"] == "ViewFolder" or $_REQUEST["flag"] == "previousSection" or $_REQUEST["flag"] == "setQuestion"){
                die();
            }
            ?>
        </div>
    </div>
</div>
<div class="middleMain">
    <h2 class="middleTitle2">ԴԱՍԱՐԱՆՆԵՐ</h2>

    <div class="foldersContainer">
        <?php
        if($_REQUEST["flag"] == "addFolder" or $_REQUEST["flag"] == "delFolder" or $_REQUEST["flag"] == "updateFolder") {
            $APPLICATION->RestartBuffer();
        }
        ?>

        <?php
        $APPLICATION->IncludeComponent(
            "apollonlab:folders",
            ".default",
            array(),
            false
        );
        ?>

        <?
        if($_REQUEST["flag"] == "addFolder" or $_REQUEST["flag"] == "delFolder" or $_REQUEST["flag"] == "updateFolder") {
            die();
        }
        ?>
    </div>
</div>
</div>

</div>

</div>
<script src="/testavorum/js/addFolder.js"></script>
<script src="/testavorum/js/index.js"></script>
<script src="https://cdn.jsdelivr.net/npm/uikit@3.8.1/dist/js/uikit.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/uikit@3.8.1/dist/js/uikit-icons.min.js"></script>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
