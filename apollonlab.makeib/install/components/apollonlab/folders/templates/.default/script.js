$(document).on("click", ".addFolderIn", function() {
    $('.addInFolder').attr('data-id', sessionStorage.getItem('CURRENT_FOLDER'));
    $('.modalWindow').fadeIn(100);
    $('.makeFolderName').fadeIn(100);
    return false;
});
$(document).on("click", ".addFolder", function() {
    $(this).addClass('Active')
    sessionStorage.setItem('CURRENT_FOLDER', '');
    // $('.addInFolder').attr('data-id', sessionStorage.getItem('CURRENT_FOLDER'));
    $('.modalWindow').fadeIn(100);
    $('.makeFolderName').fadeIn(100);
    return false;
});