
let count_elements;
let number_of_elements;
let new_Element;
$(document).ready(function() {
    $(document).on("click", ".addAnswer", function() {
        number_of_elements++;
        new_Element = document.createElement('li');
        new_Element.innerHTML = `                <div class=\"question quest${number_of_elements}\">\n` +
            "                    <input type=\"text\" placeholder=\"" + BX.message('INPUT_VERSION') + "\" name=\"question\" class=\"questionByText\">\n" +
            "                    <div><a href=\"#\"><img src=\"images/sum-sign%201.png\" alt=\"error\"></a>\n" +
            "                    <a href=\"#\"><img src=\"images/T.png\" alt=\"error\"></a></div>\n" +
            "                </div>\n" +
            "\n" +
            "<span class='deleteVaryant'>X</span>"
        this.previousElementSibling.appendChild(new_Element);


        let count_elements = document.querySelector('.variant').children.length;
        // count_elements = document.querySelector('.variant1').children.length;

        Array.from($(this).closest('form').children('.correctAnswerList').children().children('select')).
            forEach(function(element) {
                let a = '';
                for (let i = 1; i <= count_elements + 1; i++) {
                    a += `<option data-id="${i}" value="${i}">${i} ` + BX.message('VERSION') + `</option>`
                }
                element.innerHTML = a;
            })
        tinymce.init({
            selector: 'input[name="question"], .question>textarea',
            menubar: true,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks fullscreen',
                'insertdatetime media table hr code'
            ],
            toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code',
            powerpaste_allow_local_images: true,
            powerpaste_word_import: 'prompt',
            powerpaste_html_import: 'prompt',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
    })

//      CORRECT ANSWERS OPTIONS

    $('.textType .side1').on('click', "span", function() {
        $(this).parent().remove();
        $('.textType ol').last().children().last().remove()
        $('.allCorrectnswers').children().last().remove();
        Array.from($('.Correctnswers').children()).forEach(function(element) {
            element.lastChild.previousElementSibling.remove()
        })
    })
    $('.textType .side2').on('click', "span", function() {
        $(this).parent().remove();
        $('.textType ol').first().children().last().remove()
        $('.allCorrectnswers').children().last().remove();
        Array.from($('.Correctnswers').children()).forEach(function(element) {
            element.lastChild.remove()
        })
    })

//delete element
    $(document).on('click', ".deleteVaryant", function() {

        Array.from($(this).
            closest('ol').
            parent().
            children('.correctAnswerList').
            children()).forEach(function(elem) {
            elem.childNodes.forEach(function(item) {
                if (item.tagName == "SELECT") {
                    item.lastChild.remove();
                }
            })
        })
        $(this).parent().remove();
        $(this).closest("li").remove();
    })

    $(document).on('click', ".deleteCorrectAnswer", function() {
        $(this).parent().remove()
    })
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!   chisht patasxanner    !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    $(document).on('click', ".addCorrectAnswer", function() {
        let count = document.querySelector('.variant').children.length;
        this.previousElementSibling.innerHTML += "<div class=\"correctAnswer\">\n" +
            "                <span>" + BX.message('SELECT_CORRECT_ANSWER') + "</span>\n" +
            "                <select class=\"correctList\"></select>\n" +
            "                       <span class=\"deleteCorrectAnswer\">X</span>         </div>"
        document.querySelectorAll(
            '.manyAnswers .correctAnswerList .correctAnswer .correctList').
            forEach(function(element) {
                let a = '';
                for (let i = 1; i <= count; i++) {
                    a += `<option data-id="${i}" value="${i}">${i} ` + BX.message('VERSION') + `</option>`
                }
                element.innerHTML = a;
            })

    })
// !!!!!!!!!!!!!  harci kargavorumner !!!!!!!!!!!!!!!!!!!!!!!!!
    $(document).on("click", ".delQ", function() {
        $('.addQuestionWindow').hide();
        $('.modalWindow').hide();
        $("input").val('');
        tinymce.editors.forEach(function(element){
            tinymce.get(element.id).setContent('');
        })
    })
    $('#sharadrutyun, #questionForMistake, #hamematutyunQuestion, #questionForTask, #imageFile, #oneCorrectQuestion').
        change(function() {
            if($(this).val() !== ''){
                $(this).removeClass('d-none');
                $('.question').css('display', 'block')
                $('.uploadImage1').hide();
            } else {
                $('.uploadImage1').show();
                $(this).addClass('d-none');
                $('.question').css('display', 'inline-flex')
            }
        })

// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!  harci tesaki yntrutyun  !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    $(document).on("click", '.list li', function() {
        $('.addQuestionWindow .errors').html('')
        $('.selectType span').
            html(
                $(this).html() + '<span uk-icon="icon: triangle-down"></span>');
        $('.selectType span').attr("date-type-id", $(this).attr("data-code"));
        $('.selectType span').attr("data-type-xml-id", $(this).attr("data-id"));
        switch ($(this).attr("data-code")) {
            case "MULTIPLE_ANSWER":
                $('.OneAnswer, .task, .correctMistake, .hamematutyun, .sharadrutyun').
                    addClass('d-none');
                $('.manyAnswers').removeClass('d-none');
                $('.question').css('align-items', 'center');
                $('input').val(null);
                break;
            case "SINGLE_ANSWER":
                $('.OneAnswer').removeClass('d-none');
                $('.manyAnswers, .task, .correctMistake, .hamematutyun, .sharadrutyun').
                    addClass('d-none');
                $('.question').css('align-items', 'center');
                $('input').val(null);
                break;
            case "TASK_OR_QUESTION":
                $('.task').removeClass('d-none');
                $('.manyAnswers, .correctMistake, .OneAnswer, .hamematutyun, .sharadrutyun').
                    addClass('d-none');
                $('.question').css('align-items', 'center');
                $('input').val(null);
                break;
            case "CORRECT_MISTAKE":
                $('.correctMistake').removeClass('d-none');
                $('.manyAnswers, .task, .OneAnswer, .hamematutyun, .sharadrutyun').
                    addClass('d-none');
                $('.question').css('align-items', 'flex-end');
                $('input').val(null);
                break;
            case "ESSE":
                $('.manyAnswers, .task, .OneAnswer, .hamematutyun, .correctMistake').
                    addClass('d-none');
                $('.sharadrutyun').removeClass('d-none');
                $('input').val(null);
                break;
            default:
                $('.OneAnswer, .task, .correctMistake, .hamematutyun, .sharadrutyun').
                    addClass('d-none');
                $('.manyAnswers').removeClass('d-none');
                $('.question').css('align-items', 'center');
                $('input').val(null);
        }
    })

//   ajax zapros (submit)  !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    let variantsMassiv = [];
    let correctAns = [];
    let question = '';

    $(document).on("click", ".addQuestion", function(e) {
        e.preventDefault();
        e.stopPropagation();
        let errors = [];
        $('.addQuestionWindow .errors').html('')
        tinyMCE.triggerSave();

        let id = sessionStorage.getItem('CURRENT_FOLDER');
        $(".addQuestion").attr("data-id", id);
        $(".addInFolder").attr("data-id", id);
        $(`.left_folder`).addClass("c-black");
        let selector = '.left_folder#' +
            sessionStorage.getItem('CURRENT_FOLDER');
        $(`${selector}`).addClass("c-blue");
        let xml_id = $('.selectType>span').attr('data-type-xml-id')
        let fd = new FormData();
        switch ($('.selectType>span').attr("date-type-id")) {
            case "SINGLE_ANSWER":
                //question
                question = "";
                if ($('.OneAnswer .quest1 input').val() != '') {
                    question = $('.OneAnswer .quest1 input').val();
                }

                if (question.length == 0) {
                    errors.push(BX.message('ENTER_QUESTION'));
                }

                //answer version
                variantsMassiv = [];
                for (let i = 0; i <
                $('.OneAnswer .variant li div input').length; i++) {
                    if ($('.OneAnswer .variant li div input')[i].value != '') {
                        variantsMassiv.push(
                            $('.OneAnswer .variant li div input')[i].value)
                    }
                }


                if (variantsMassiv.length < 2) {
                    errors.push(BX.message('AT_LIST_2_ANSWER'))
                }
                //correct answer
                let correctAnswer = $('.OneAnswer .correctAnswerList .correctAnswer .correctList').val();
                if (errors.length == 0) {

                    $('.loader_back').css('display', 'flex');
                    let files = $('input[name="oneCorrectQuestion"]')[0].files[0];
                    fd.append('picture', files)
                    fd.append('flag', "setQuestion")
                    fd.append('type', "SINGLE_ANSWER")
                    fd.append('typeID', xml_id)
                    fd.append('question', question)
                    fd.append('answers', JSON.stringify(variantsMassiv))
                    fd.append('correctAns', JSON.stringify(correctAnswer))
                    fd.append('folderID', sessionStorage.getItem('CURRENT_FOLDER'))
                    fd.append('flag', "setQuestion")
                    $.ajax({
                        type: "POST",
                        url: "",
                        crossDomain: true,
                        contentType: false,
                        processData: false,
                        data: fd,
                        success: function(msg) {
                            document.querySelector(".addQuestionWindow").outerHTML = msg;
                            tinymce.editors.forEach(function(element){
                                tinymce.get(element.id).setContent('');
                            })
                            // $('.loader_back').css('display', 'none');
                            // window.location.reload();
                            $.ajax({
                                type: 'POST',
                                url: '',
                                crossDomain: true,
                                dataType: 'HTML',
                                data: {
                                    flag: 'ViewFolder',
                                    FolderID: sessionStorage.getItem('CURRENT_FOLDER'),
                                },
                                success: function(msg) {
                                    document.querySelector('.materialsCenter').innerHTML = msg;
                                    $('.ToLeft').attr('id', id);
                                    $('.loader_back').css('display', 'none');
                                },
                            });
                        },
                        error: function() {
                            alert("error");
                            // $('.loader_back').css('display', 'none');
                        }
                    })
                    $('.folderInner').show();
                    // $('.modalWindow').fadeOut(50);
                    // $('.addQuestionWindow').fadeOut(50);
                    $('input').val('')
                } else {
                    errors.forEach(element => {
                        document.querySelector('.addQuestionWindow .errors').innerHTML += `<p class="errorByJs" style="color: red">${element}</p>`
                    })
                    return false;
                }
                break;
            case "MULTIPLE_ANSWER":

                //question
                question = "";
                if ($('.manyAnswers .quest1 input').val() != '') {
                    question = $('.manyAnswers .quest1 input').val();
                }

                if (question == '') {
                    errors.push(BX.message('ENTER_QUESTION'));
                }

                    //answer version
                    variantsMassiv = [];
                for (let i = 0; i <
                $('.manyAnswers .variant li div input').length; i++) {
                    if ($('.manyAnswers .variant li div input')[i].value != '') {
                        variantsMassiv.push(
                            $('.manyAnswers .variant li div input')[i].value)
                    }
                }
                if (variantsMassiv.length < 2) {
                    errors.push(BX.message('AT_LIST_2_ANSWER'))
                }
                //correct answer
                let a = [];
                for (let i = 0; i <
                $('.manyAnswers .correctAnswerList .correctAnswer .correctList').length; i++) {
                    a.push(
                        $('.manyAnswers .correctAnswerList .correctAnswer .correctList')[i].value);
                    correctAns = a;
                }

                if (errors.length == 0) {
                    let files = $('input[name="manyAnswersQuestFile"]')[0].files[0];
                    fd.append('picture', files)
                    fd.append('flag', "setQuestion")
                    fd.append('type', "MULTIPLE_ANSWER")
                    fd.append('typeID', xml_id)
                    fd.append('question', question)
                    fd.append('answers', JSON.stringify(variantsMassiv))
                    fd.append('correctAns', JSON.stringify(correctAns))
                    fd.append('folderID', sessionStorage.getItem('CURRENT_FOLDER'))
                    fd.append('flag', "setQuestion");
                    $('.loader_back').css('display', 'flex');
                    $.ajax({
                        type: "POST",
                        url: "",
                        crossDomain: true,
                        contentType: false,
                        processData: false,
                        dataType: 'text',
                        data: fd,
                        success: function(msg) {
                            document.querySelector(".addQuestionWindow").outerHTML = msg;
                            tinymce.editors.forEach(function(element){
                                tinymce.get(element.id).setContent('');
                            })
                            // $('.loader_back').css('display', 'none');
                            // window.location.reload();
                            $.ajax({
                                type: 'POST',
                                url: '',
                                crossDomain: true,
                                dataType: 'HTML',
                                data: {
                                    flag: 'ViewFolder',
                                    FolderID: sessionStorage.getItem('CURRENT_FOLDER'),
                                },
                                success: function(msg) {
                                    document.querySelector('.materialsCenter').innerHTML = msg;
                                    $('.ToLeft').attr('id', id);
                                    $('.loader_back').css('display', 'none');
                                },
                            });
                        },
                        error: function() {
                            alert("error");
                            // $('.loader_back').css('display', 'none');
                            e.stopPropagation();
                            e.preventDefault()
                        }
                    })
                    $('.folderInner').show();
                    // $('.modalWindow').fadeOut(50);
                    // $('.addQuestionWindow').fadeOut(50);
                    $('input').val('')

                } else {
                    errors.forEach(element => {
                        document.querySelector(
                            '.addQuestionWindow .errors').innerHTML += `<p class="errorByJs" style="color: red">${element}</p>`
                    })
                    return false;
                }

                break;
            case "TASK_OR_QUESTION":
                //question
                question = '';
                if ($('.task .quest1 input[type="text"]').val() != '') {
                    question = $('.task .quest1 input[type="text"]').val();
                }
                if (question == '') {
                    errors.push(BX.message('ENTER_QUESTION'));
                }

                //correct answer version
                let arr = [];
                for (let i = 0; i < $('.task .variant li div input').length; i++) {
                    if ($('.task .variant li div input')[i].value != '') {
                        arr.push($('.task .variant li div input')[i].value)
                    }
                }
                correctAns = arr;
                if (correctAns.length < 1) {
                    errors.push(BX.message('AT_LIST_1_ANSWER'))
                }

                //ajax
                if (errors.length == 0) {
                    let files = $('input[name="questionForTask"]')[0].files[0];
                    fd.append('picture', files)
                    fd.append('flag', "setQuestion")
                    fd.append('type', "TASK_OR_QUESTION")
                    fd.append('typeID', xml_id)
                    fd.append('question', question)
                    fd.append('correctAns', JSON.stringify(correctAns))
                    fd.append('folderID', sessionStorage.getItem('CURRENT_FOLDER'))
                    fd.append('flag', "setQuestion")
                    $('.loader_back').css('display', 'flex');
                    $.ajax({
                        type: "POST",
                        url: "",
                        crossDomain: true,
                        contentType: false,
                        processData: false,
                        dataType: 'text',
                        data: fd,
                        success: function(msg) {
                            tinymce.editors.forEach(function(element){
                                tinymce.get(element.id).setContent('');
                            })
                            $.ajax({
                                type: 'POST',
                                url: '',
                                crossDomain: true,
                                dataType: 'HTML',
                                data: {
                                    flag: 'ViewFolder',
                                    FolderID: sessionStorage.getItem('CURRENT_FOLDER'),
                                },
                                success: function(msg) {
                                    document.querySelector('.materialsCenter').innerHTML = msg;
                                    $('.ToLeft').attr('id', id);
                                    $('.loader_back').css('display', 'none');
                                },
                            });
                            // $('.loader_back').css('display', 'none');
                            // window.location.reload();
                        },
                        error: function() {
                            // $('.loader_back').css('display', 'none');
                        }
                    })
                    $('.folderInner').show();
                    // $('.modalWindow').fadeOut(50);
                    // $('.addQuestionWindow').fadeOut(50);
                    $('input').val('')

                } else {
                    errors.forEach(element => {
                        document.querySelector(
                            '.addQuestionWindow .errors').innerHTML += `<p class="errorByJs" style="color: red">${element}</p>`
                    })
                    return false;
                }
                break;
            case "CORRECT_MISTAKE":
                //question
                question = '';
                if ($('.correctMistake .quest1 textarea').val() != '') {
                    question = $('.correctMistake .quest1 textarea').val();
                }
                if (question == '') {
                    errors.push(BX.message('ENTER_QUESTION'));
                }
                //answer version
                let arr1 = [];
                for (let i = 0; i <
                $('.correctMistake .variant li div input').length; i++) {
                    if ($('.correctMistake .variant li div input')[i].value !=
                        '') {
                        arr1.push(
                            $('.correctMistake .variant li div input')[i].value)
                    }
                }
                correctAns = arr1;
                if (correctAns.length < 1) {
                    errors.push(BX.message('AT_LIST_1_ANSWER'))
                }

                //ajax
                if (errors.length == 0) {
                    let files = $('input[name="questionForMistake"]')[0].files[0];
                    fd.append('picture', files)
                    fd.append('flag', "setQuestion")
                    fd.append('type', "CORRECT_MISTAKE")
                    fd.append('typeID', xml_id)
                    fd.append('question', question)
                    fd.append('correctAns', JSON.stringify(correctAns))
                    fd.append('folderID', sessionStorage.getItem('CURRENT_FOLDER'))
                    fd.append('flag', "setQuestion")
                    $('.loader_back').css('display', 'flex');
                    $.ajax({
                        type: "POST",
                        url: "",
                        crossDomain: true,
                        dataType: 'text',
                        contentType: false,
                        processData: false,
                        data: fd,
                        success: function(msg) {
                            tinymce.editors.forEach(function(element){
                                tinymce.get(element.id).setContent('');
                            })
                            $.ajax({
                                type: 'POST',
                                url: '',
                                crossDomain: true,
                                dataType: 'HTML',
                                data: {
                                    flag: 'ViewFolder',
                                    FolderID: sessionStorage.getItem('CURRENT_FOLDER'),
                                },
                                success: function(msg) {
                                    document.querySelector('.materialsCenter').innerHTML = msg;
                                    $('.ToLeft').attr('id', id);
                                    $('.loader_back').css('display', 'none');
                                },
                            });
                            // $('.loader_back').css('display', 'none');
                            // window.location.reload();
                        },
                        error: function() {
                            // $('.loader_back').css('display', 'none');
                            alert("error")
                        }
                    })
                    $('.folderInner').show();
                    // $('.modalWindow').fadeOut(50);
                    // $('.addQuestionWindow').fadeOut(50);
                    $('input').val('')

                } else {
                    errors.forEach(element => {
                        document.querySelector(
                            '.addQuestionWindow .errors').innerHTML += `<p class="errorByJs" style="color: red">${element}</p>`
                    })
                    return false;
                }
                break;

            case "ESSE":

                //question
                question = '';
                if ($('.sharadrutyun .quest1 input').val() != '') {
                    question = $('.sharadrutyun .quest1 input').val();
                }
                if (question == '') {
                    errors.push(BX.message('ENTER_QUESTION'));
                }

                //ajax
                if (errors.length == 0) {
                    let files = $('input[name="sharadrutyun"]')[0].files[0];
                    fd.append('picture', files)
                    fd.append('flag', "setQuestion")
                    fd.append('type', "ESSE")
                    fd.append('typeID', xml_id)
                    fd.append('question', question)
                    fd.append('folderID', sessionStorage.getItem('CURRENT_FOLDER'))
                    fd.append('flag', "setQuestion")
                    $('.loader_back').css('display', 'flex');
                    $.ajax({
                        type: "POST",
                        url: "",
                        crossDomain: true,
                        dataType: 'text',
                        contentType: false,
                        processData: false,
                        data: fd,
                        success: function(msg) {
                            tinymce.editors.forEach(function(element){
                                tinymce.get(element.id).setContent('');
                            })
                            $.ajax({
                                type: 'POST',
                                url: '',
                                crossDomain: true,
                                dataType: 'HTML',
                                data: {
                                    flag: 'ViewFolder',
                                    FolderID: sessionStorage.getItem('CURRENT_FOLDER'),
                                },
                                success: function(msg) {
                                    document.querySelector('.materialsCenter').innerHTML = msg;
                                    $('.ToLeft').attr('id', id);
                                    $('.loader_back').css('display', 'none');
                                },
                            });
                            // window.location.reload();
                        },
                        error: function(){

                        }
                    })
                    $('.folderInner').show();
                    // $('.modalWindow').fadeOut(50);
                    // $('.addQuestionWindow').fadeOut(50);
                    $('input').val('')

                } else {
                    errors.forEach(element => {
                        document.querySelector(
                            '.addQuestionWindow .errors').innerHTML += `<p class="errorByJs" style="color: red">${element}</p>`
                    })
                    return false;
                }
                break;
        }
    })
    $(document).on("click", ".selectType", function() {
        if($('.selectType ul').css('display') == 'none'){
            $('.selectType ul').slideDown(100);
        } else {
            $('.selectType ul').slideUp(100);
        }
    })
})