//opening folder
$(document).on("click", ".foldImgName", function(){
    let id = this.closest(".fold").dataset.id;
    $(".addQuestion").attr("data-id", id);
    $(".addInFolder").attr("data-id", id);
    $(`.left_folder`).removeClass("c-blue");
    $(`.left_folder#${id}`).addClass("c-blue");
    sessionStorage.setItem("CURRENT_FOLDER", id);
    $.ajax({
        type: "POST",
        url: "",
        crossDomain: true,
        dataType: 'HTML',
        data: {
            flag: "ViewFolder",
            FolderID: id,
        },
        success: function (msg) {
            document.querySelector(".materialsCenter").innerHTML = msg;
            $(".ToLeft").attr("id", id);
        }
    })
})
$(document).on("click", ".folderImg, .folderInfo span:first-child", function(){
    
    let id = this.closest(".folder").dataset.id;
    let name = $(".nameOfFolder").html();
    $(`.left_folder`).removeClass("c-blue");
    $(`.left_folder#${id}`).addClass("c-blue");
    $('.modalWindow').fadeIn(100);
    $('.folderInner').css('display', 'flex');
    sessionStorage.setItem("CURRENT_FOLDER", id);
    $.ajax({
        type: "POST",
        url: "",
        crossDomain: true,
        dataType: 'HTML',
        data: {
            flag: "ViewFolder",
            FolderID: id,
            name: name
        },
        success: function (msg) {
            document.querySelector(".materialsCenter").innerHTML = msg;
        }
    })
})