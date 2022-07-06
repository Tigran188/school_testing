<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); ?>
    <link rel="stylesheet" href="/testavorum/css/createTest.css">

    <link rel="stylesheet" href="/testavorum/css/foldersMain.css">

    <link href="/testavorum/css/main.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.8.1/dist/css/uikit.min.css" />





    <div class="modalWindow">

        <div class="folderInner"><div class="folderInner">
                <div class="olderFolders">
                    <h2>Դասարաններ</h2>
                    <div class="foldersList">
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
                                "IBLOCK_ID" => '391',
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

                    </div>
                </div>
                <div class="mainmaterials">
                    <div>
                        <?
                        if($_REQUEST["flag"] == "ViewFolder" or $_REQUEST["flag"] == "prevFolder"){
                            $APPLICATION->RestartBuffer();
                        }?>
                        <div class="top">
                            <div class="navigation">
                                <div>
                                    <div class="ToLeft" id="<?=$_SESSION['FOLDER_ID']?>"><a href="#"> < </a></div>
                                </div>
                                <p class="breadcrumb">

                                </p>
                            </div>

                        </div>
                        <div class="materialsCenter">


                            <?php
                            $APPLICATION->IncludeComponent(
                                "apollonlab:folderInner",
                                "for_select_section",
                                array(),
                                false
                            );
                            ?>

                        </div>
                    </div>
                    <div class="select">
                        <a href="#" class="b1">ԸՆՏՐԵԼ ԹՂԹԱՊԱՆԱԿԸ</a>
                        <a href="#" class="b2">ՉԵՂԱՐԿԵԼ</a>
                    </div>
                    <?
                    if($_REQUEST["flag"] == "ViewFolder" or $_REQUEST["flag"] == "prevFolder"){
                        die();
                    }
                    ?>
                </div>
            </div>
    </div>
    </div>

    <?php
        $APPLICATION->IncludeComponent(
            "apollonlab:create_test",
            ".default",
            array(),
            false
        );
?>


    <script src="/testavorum/js/addFolder.js"></script>
    <script src="/testavorum/js/index.js"></script>
    <script src="/testavorum/js/createTest.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.8.1/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.8.1/dist/js/uikit-icons.min.js"></script>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>