<?php
$className = CIBlockElement::GetList(
    array(),
    array("ID" => $_REQUEST['CLASS_ID']),
    false,
    false,
    array()
)->Fetch()['NAME'];

$filter = [

];
$users_info = [];
$users = CUser::GetList(
    'id',
    'desc',
    ['UF_EDU_STRUCTURE' => $_REQUEST['CLASS_ID']],
    []
);
while ($user = $users->Fetch()) {
    $users_info[] = $user['ID'];
}
$arResult['CLASS_STUDENTS'] = $users_info;
?>
    <script>
        BX.message({
            SELECT_SECTION: '<?=GetMessage("SELECT_SECTION")?>',
            POINT: '<?=GetMessage("POINT")?>',
            SELECT_QUESTIONS_COUNT: '<?=GetMessage("SELECT_QUESTIONS_COUNT")?>',
            TEST_IS_READY: '<?=GetMessage("TEST_IS_READY")?>',
        });
    </script>

<?php
$arResult['EDITABLE_TEST']['UF_QUESTIONS'] = $arResult['EDITABLE_TEST']['UF_QUESTIONS'][key($arResult['EDITABLE_TEST']['UF_QUESTIONS'])];
foreach ($arResult['EDITABLE_TEST']['UF_QUESTIONS'] as $key => $section) {
    foreach ($section as $key2 => $item) {
        if ($key2 == 'point') {
            continue;
        }
        $arResult['EDITABLE_TEST']['UF_QUESTIONS'][$key][$key2]['name'] = CIBlockSection::GetByID($key2)->Fetch()['NAME'];
    }
}


















?>