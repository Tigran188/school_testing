//opening folder

$(document).on("click", ".foldImgName", function(){
    $('.loader_back').css('display', 'flex');
    let id = this.closest(".fold").dataset.id;
    let name = $(this).children('p').children('span').text();
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
            name: name
        },
        success: function (msg) {
            document.querySelector(".mainmaterials").innerHTML = msg;
            $(".ToLeft").attr("id", id);
            $('.loader_back').css('display', 'none');
        },
        error: function(){
            $('.loader_back').css('display', 'none');
        }
    })
})
$(document).on("click", ".folderImg, .folderInfo span:first-child", function(){
    $('.loader_back').css('display', 'flex');
    let id = this.closest(".folder").dataset.id;
    let name = this.closest(".folder").children[2].children[0].innerHTML;
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
            document.querySelector(".mainmaterials").innerHTML = msg;
            $('.loader_back').css('display', 'none');
        },
        error: function() {
            $('.loader_back').css('display', 'none');
        }
    })
})
