// //edit element
// $(document).ready(function(){
//
//     $(document).on("click", ".deleteVaryant", function(){
//         $(".correctList>option:last-child").remove();
//     })
//
//
//     $(document).on("click", ".editElem", function(){
//         $('.loader_back').css('display', 'flex');
//         setTimeout(function(){
//             tinymce.init({
//                 selector: 'input[name="question"], .question>textarea',
//                 menubar: true,
//                 plugins: [
//                     'advlist autolink lists link image charmap print preview anchor',
//                     'searchreplace visualblocks advcode fullscreen',
//                     'insertdatetime media table powerpaste hr code'
//                 ],
//                 toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code',
//                 powerpaste_allow_local_images: true,
//                 powerpaste_word_import: 'prompt',
//                 powerpaste_html_import: 'prompt',
//                 content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
//             })
//         }, 500)
//
//         let id = this.closest(".sectElement").dataset.id;
//         $('.addQuestionWindow').hide();
//         $('.folderInner').hide();
//         $('.editQuestion').attr("data-edit-elem-id", id)
//         $.ajax({
//             type: "POST",
//             url: "",
//             crossDomain: true,
//             dataType: 'HTML',
//             data: {
//                 flag: "updateQuestion",
//                 ID: id,
//             },
//             success: function (msg) {
//                 document.querySelector(".editQuestionWindow").outerHTML = msg;
//                 $('.editQuestionWindow').show();
//                 $('.loader_back').css('display', 'none');
//             },
//             error: function(){
//                 $('.loader_back').css('display', 'none');
//             }
//         })
//     })
//
//     $(document).on("click", ".delQ", function(){
//         $(".editQuestionWindow").hide();
//     })

    let fd = new FormData();
    $(document).on("click", ".editQuestion", function(e){
        e.preventDefault();
        e.stopPropagation();
        tinyMCE.triggerSave();
        let errors = [];
        let variantsMassiv = [];
        let correctAnswer = [];
        let question = '';
        $('.editQuestionWindow .errors').html('')


        switch ($('.editQuestion').attr("data-type")) {
            case "SINGLE_ANSWER":
                //question
                question = "";
                if ($('.OneAnswer .quest1 textarea').val() != '') {
                    question = $('.OneAnswer .quest1 textarea').val();
                }

                if (question.length == 0) {
                    errors.push('- Լրացրեք հարցը');
                }

                //answer version
                variantsMassiv = [];
                for (let i = 0; i < $('.OneAnswer .variant li div input').length; i++) {
                    if ($('.OneAnswer .variant li div input')[i].value != '') {
                        variantsMassiv.push($('.OneAnswer .variant li div input')[i].value)
                    }
                }

                if(variantsMassiv.length < 2){
                    errors.push('- Լրացրեք ամենաքիչը 2 պատասխան')
                }
                //correct answer
                correctAnswer = $('.OneAnswerEdit .correctAnswerList .correctAnswer .correctList').val();
                if(errors.length == 0) {
                    $('.loader_back').css('display', 'flex');
                    let files = $('input[name="oneCorrectQuestionFile"]')[0].files[0];
                    fd.append('picture', files)
                    fd.append('question', question)
                    fd.append('answers', JSON.stringify(variantsMassiv))
                    fd.append('correctAns', JSON.stringify(correctAnswer))
                    fd.append('flag', "editQuestion")
                    fd.append('ID', $(this).attr("data-id"))
                    $.ajax({
                        type: "POST",
                        url: "",
                        crossDomain: true,
                        dataType: 'text',
                        contentType: false,
                        processData: false,
                        data: fd,
                        success: function (msg) {
                            // document.querySelector(".editQuestionWindow").outerHTML = msg;
                            // window.location.reload();
                            $('.loader_back').css('display', 'none');


                        },
                        error: function() {
                            alert("error");
                        }
                    })
                    // $('.modalWindow').fadeOut(50);
                    $('.editQuestionWindow').fadeOut(50);
                    $('input').val('')
                } else {
                    errors.forEach(element => {
                        document.querySelector('.editQuestionWindow .errors').innerHTML += `<p class="errorByJs" style="color: red">${element}</p>`
                    })
                    return false;
                }
                break;
            case "MULTIPLE_ANSWER":

                //question
                question = "";
                if ($('.manyAnswersEdit .quest1 textarea').val() != '') {
                    question = $('.manyAnswers .quest1 textarea').val();
                }

                if ($('#imageFile').val()) {
                    image = $('#imageFile').val();
                }

                if (question == '') {
                    errors.push('- Լրացրեք հարցը');
                }

                //type ID
                let typeID =

                    //answer version
                    variantsMassiv = [];
                for (let i = 0; i < $('.manyAnswers .variant li div input').length; i++) {
                    if ($('.manyAnswers .variant li div input')[i].value != '') {
                        variantsMassiv.push($('.manyAnswers .variant li div input')[i].value)
                    }
                }
                if(variantsMassiv.length < 2){
                    errors.push('- Լրացրեք ամենաքիչը 2 պատասխան')
                }
                //correct answer
                let a = [];
                for(i = 0; i<$('.manyAnswers .correctAnswerList .correctAnswer .correctList').length; i++) {
                    a.push($('.manyAnswers .correctAnswerList .correctAnswer .correctList')[i].value);
                    correctAns = a;
                }

                if(errors.length == 0) {
                    let files = $('input[name="multFile"]')[0].files[0];
                    fd.append('picture', files)
                    fd.append('question', question)
                    fd.append('answers', JSON.stringify(variantsMassiv))
                    fd.append('correctAns', JSON.stringify(correctAnswer))
                    fd.append('flag', "editQuestion")
                    fd.append('ID', $(this).attr("data-id"))

                    $('.loader_back').css('display', 'flex');
                    $.ajax({
                        type: "POST",
                        url: "",
                        crossDomain: true,
                        contentType: false,
                        processData: false,
                        dataType: 'text',
                        data: {
                            flag: "editQuestion",
                            ID: $(this).attr("data-id"),
                            question: question,
                            answers: variantsMassiv,
                            correctAns: correctAns
                        },
                        success: function (msg) {
                            // document.querySelector(".editQuestionWindow").outerHTML = msg;
                            // window.location.reload();
                            $('.loader_back').css('display', 'none');
                        },
                        error: function() {
                            alert("error");
                        }
                    })
                    // $('.modalWindow').fadeOut(50);
                    $('.editQuestionWindow').fadeOut(50);
                    $('input').val('')

                }else{
                    errors.forEach(element => {
                        document.querySelector('.editQuestionWindow .errors').innerHTML += `<p class="errorByJs" style="color: red">${element}</p>`
                    })
                    return false;
                }

                break;
            case "TASK_OR_QUESTION":
                //question
                question = '';
                // for (let i = 0; i < 2; i++) {
                    if ($('.taskEdit .quest1 textarea').val() != '') {
                        question = $('.task .quest1 textarea').val();
                    }
                // }
                if (question == '') {
                    errors.push('- Լրացրեք հարցը');
                }
                //answer version
                let arr = [];
                for (let i = 0; i < $('.editQuestionWindow .task .variant li div input').length; i++) {
                    if ($('.editQuestionWindow .task .variant li div input')[i].value != '') {
                        arr.push($('.editQuestionWindow .task .variant li div input')[i].value)
                    }
                }
                correctAns = arr;
                if(correctAns.length < 1){
                    errors.push('- Լրացրեք ամենաքիչը 1 պատասխան')
                }

                //ajax
                if(errors.length == 0) {
                    let files = $('input[name="questionForTaskFile"]')[0].files[0];
                    fd.append('picture', files)
                    fd.append('question', question)
                    fd.append('correctAns', JSON.stringify(correcWtAnswer))
                    fd.append('flag', "editQuestion")
                    fd.append('ID', $(this).attr("data-id"))

                    $('.loader_back').css('display', 'flex');
                    $.ajax({
                        type: "POST",
                        url: "",
                        crossDomain: true,
                        dataType: 'text',
                        contentType: false,
                        processData: false,
                        data: fd,
                        success: function (msg) {
                            // window.location.reload();
                            $('.loader_back').css('display', 'none');
                        }
                    })
                    // $('.modalWindow').fadeOut(50);
                    $('.editQuestionWindow').fadeOut(50);
                    $('input').val('')

                }else{
                    errors.forEach(element => {
                        document.querySelector('.editQuestionWindow .errors').innerHTML += `<p class="errorByJs" style="color: red">${element}</p>`
                    })
                    return false;
                }
                break;
            case "CORRECT_MISTAKE":
                //question
                question = '';
                if ($('.correctMistakeEdit .quest1 textarea').val() != '') {
                    question = $('.correctMistake .quest1 textarea').val();
                }
                if (question == '') {
                    errors.push('- Լրացրեք հարցը');
                }
                //answer version
                let arr1 = [];
                for (let i = 0; i < $('.correctMistake .variant li div input').length; i++) {
                    if ($('.correctMistake .variant li div input')[i].value != '') {
                        arr1.push($('.correctMistake .variant li div input')[i].value)
                    }
                }
                correctAns = arr1;
                if(correctAns.length < 1){
                    errors.push('- Լրացրեք ամենաքիչը 1 պատասխան')
                }

                //ajax
                if(errors.length == 0) {

                    let files = $('input[name="questionForMistakeFile"]')[0].files[0];
                    fd.append('picture', files)
                    fd.append('question', question)
                    fd.append('correctAns', JSON.stringify(correctAnswer))
                    fd.append('flag', "editQuestion")
                    fd.append('ID', $(this).attr("data-id"))

                    $('.loader_back').css('display', 'flex');
                    $.ajax({
                        type: "POST",
                        url: "",
                        crossDomain: true,
                        dataType: 'text',
                        contentType: false,
                        processData: false,
                        data: fd,
                        success: function (msg) {
                            console.log(1);
                            // window.location.reload();
                            $('.loader_back').css('display', 'none');
                        },
                        error: function() {
                            $('.loader_back').css('display', 'none');
                            alert("error")
                        }
                    })
                    // $('.modalWindow').fadeOut(50);
                    $('.editQuestionWindow').fadeOut(50);
                    $('input').val('')

                }else{
                    errors.forEach(element => {
                        document.querySelector('.editQuestionWindow .errors').innerHTML += `<p class="errorByJs" style="color: red">${element}</p>`
                    })
                    return false;
                }
                break;
            case "ESSE":

                //question
                question = '';
                if ($('.sharadrutyunEdit .quest1 textarea').val() != '') {
                    question = $('.sharadrutyun .quest1 textarea').val();
                }
                if (question == '') {
                    errors.push('- Լրացրեք հարցը');
                }

                //ajax
                if(errors.length == 0) {
                    let files = $('input[name="sharadrutyunFile"]')[0].files[0];
                    fd.append('picture', files)
                    fd.append('question', question)
                    fd.append('flag', "editQuestion")
                    fd.append('ID', $(this).attr("data-id"))

                    $('.loader_back').css('display', 'flex');
                    $.ajax({
                        type: "POST",
                        url: "",
                        crossDomain: true,
                        dataType: 'text',
                        contentType: false,
                        processData: false,
                        data: {
                            flag: "editQuestion",
                            question: question,
                            ID: $(this).attr("data-id")
                        },
                        success: function (msg) {
                            // window.location.reload();
                            $('.loader_back').css('display', 'none');
                        }
                    })
                    // $('.modalWindow').fadeOut(50);
                    $('.editQuestionWindow').fadeOut(50);
                    $('input').val('')

                }else{
                    errors.forEach(element => {
                        document.querySelector('.editQuestionWindow .errors').innerHTML += `<p class="errorByJs" style="color: red">${element}</p>`
                    })
                    return false;
                }
                break;
        }
        $.ajax({
            type: "POST",
            url: "",
            crossDomain: true,
            dataType: 'HTML',
            data: {
                flag: "ViewFolder",
                FolderID: sessionStorage.getItem('CURRENT_FOLDER'),
            },
            success: function (msg) {
                $('.folderInner').show(20);
                document.querySelector(".materialsCenter").innerHTML = msg;
                $('.loader_back').css('display', 'none');
            },
            error: function(){
                $('.loader_back').css('display', 'none');
            }
        })
    })


    $(document).on("change", 'input[type="file"]', function() {
        if($(this)[0].files[0]) {
            $('.prevPic img').attr('src', window.URL.createObjectURL($(this)[0].files[0]))
        } else {
            $('.prevPic img').attr('src', '')
        }
    })






































// //  !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!     avelacnel tarberak      !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// let count = 5;
// let num = 5;
// let newElem;
// // $(document).on("click", ".addAnswer", function () {
// //     num++;
// //     newElem = document.createElement('li');
// //     newElem.innerHTML = `                <div class=\"question quest${num}\">\n` +
// //         "                    <input type=\"text\" placeholder=\"Գրել տարբերակ\" name=\"question\" class=\"questionByText\">\n" +
// //         "                    <div><a href=\"#\"><img src=\"images/sum-sign%201.png\" alt=\"error\"></a>\n" +
// //         "                    <a href=\"#\"><img src=\"images/T.png\" alt=\"error\"></a></div>\n" +
// //         "                </div>\n" +
// //         "\n" +
// //         "<span class='deleteVaryant'>X</span>"
// //     this.previousElementSibling.appendChild(newElem);
// //     count = document.querySelector('.variant1').children.length;
// //     let a = '';
// //     for(let i=1; i <= count; i++){
// //         a += `<option data-id="${i}"> ${i} տարբերակ </option>`;
// //     }
// //     Array.from($(this).next().next().children()).forEach(function(elem){
// //         Array.from(elem.children).forEach(function(item){
// //             if(item.tagName == 'SELECT'){
// //                 item.innerHTML = a;
// //             }
// //         })
// //     })
// //     tinymce.init({
// //         selector: 'input[name="question"], .question>textarea',
// //         menubar: true,
// //         plugins: [
// //             'advlist autolink lists link image charmap print preview anchor',
// //             'searchreplace visualblocks advcode fullscreen',
// //             'insertdatetime media table powerpaste hr code'
// //         ],
// //         toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code',
// //         powerpaste_allow_local_images: true,
// //         powerpaste_word_import: 'prompt',
// //         powerpaste_html_import: 'prompt',
// //         content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
// //     });
// // })
//
//
//
// //      CORRECT ANSWERS OPTIONS
//
// $('.textType .side1').on('click', "span", function () {
//     $(this).parent().remove();
//     $('.textType ol').last().children().last().remove()
//     $('.allCorrectnswers').children().last().remove();
//     Array.from($('.Correctnswers').children()).forEach(function(element){
//         element.lastChild.previousElementSibling.remove()
//     })
// })
// $('.textType .side2').on('click', "span", function () {
//     $(this).parent().remove();
//     $('.textType ol').first().children().last().remove()
//     $('.allCorrectnswers').children().last().remove();
//     Array.from($('.Correctnswers').children()).forEach(function(element){
//         element.lastChild.remove()
//     })
// })
//
// //delete element
// $(document).on('click', ".deleteVaryant", function () {
//     $(this).closest("li").remove();
//     Array.from($(this).closest('ol').parent().children('.correctAnswerList').children()).forEach(function(elem) {
//         elem.childNodes.forEach(function(item) {
//             if(item.tagName == "SELECT") {
//                 item.lastChild.remove();
//             }
//         })
//     })
//     $(this).parent().remove();
// })
// $(document).on('click', ".deleteCorrectAnswer", function () {
//     $(this).parent().remove()
// })
// // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!   chisht patasxanner    !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// // $(document).on('click', ".addCorrectAnswer", function () {
// //     let count = document.querySelector('.variant').children.length;
// //     this.previousElementSibling.innerHTML += "<div class=\"correctAnswer\">\n" +
// //         "                <span>Ընտրել ճիշտ պատասխանը</span>\n" +
// //         "                <select class=\"correctList\"></select>\n" +
// //         "                       <span class=\"deleteCorrectAnswer\">X</span>         </div>"
// //     document.querySelectorAll('.manyAnswers .correctAnswerList .correctAnswer .correctList').forEach(function(element)
// //     {
// //         let a = '';
// //         for(let i=1; i<=count; i++) {
// //             a += `<option data-id="${i}" value="${i}>${i} տարբերակ</option>`
// //         }
// //         element.innerHTML = a;
// //     })
// //
// // })
// // !!!!!!!!!!!!!  harci kargavorumner !!!!!!!!!!!!!!!!!!!!!!!!!
// $(document).on("click", ".delQ", function() {
//     $('.addQuestionWindow').hide();
//     $('.modalWindow').hide();
//     $("input").val(null);
// })
// $('#sharadrutyun, #questionForMistake, #hamematutyunQuestion, #questionForTask, #imageFile, #oneCorrectQuestion').change(function(){
//     $(this).removeClass('d-none');
// })
//
// // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!  harci tesaki yntrutyun  !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// $(document).on("click", '.list li', function () {
//     $('.addQuestionWindow .errors').html('')
//     $('.selectType span').html($(this).html() + '<span uk-icon="icon: triangle-down"></span>');
//     $('.selectType span').attr("date-type-id", $(this).attr("data-code"));
//     $('.selectType span').attr("data-type-xml-id", $(this).attr("data-id"));
//     switch ($(this).attr("data-code")){
//         case "MULTIPLE_ANSWER":
//             $('.OneAnswer, .task, .correctMistake, .hamematutyun, .sharadrutyun').addClass('d-none');
//             $('.manyAnswers').removeClass('d-none');
//             $('.question').css('align-items', 'center');
//             $('input').val(null);
//             break;
//         case "SINGLE_ANSWER":
//             $('.OneAnswer').removeClass('d-none');
//             $('.manyAnswers, .task, .correctMistake, .hamematutyun, .sharadrutyun').addClass('d-none');
//             $('.question').css('align-items', 'center');
//             $('input').val(null);
//             break;
//         case "TASK_OR_QUESTION":
//             $('.task').removeClass('d-none');
//             $('.manyAnswers, .correctMistake, .OneAnswer, .hamematutyun, .sharadrutyun').addClass('d-none');
//             $('.question').css('align-items', 'center');
//             $('input').val(null);
//             break;
//         case "CORRECT_MISTAKE":
//             $('.correctMistake').removeClass('d-none');
//             $('.manyAnswers, .task, .OneAnswer, .hamematutyun, .sharadrutyun').addClass('d-none');
//             $('.question').css('align-items', 'flex-end');
//             $('input').val(null);
//             break;
//         case "ESSE":
//             $('.manyAnswers, .task, .OneAnswer, .hamematutyun, .correctMistake').addClass('d-none');
//             $('.sharadrutyun').removeClass('d-none');
//             $('input').val(null);
//             break;
//         default:
//             $('.OneAnswer, .task, .correctMistake, .hamematutyun, .sharadrutyun').addClass('d-none');
//             $('.manyAnswers').removeClass('d-none');
//             $('.question').css('align-items', 'center');
//             $('input').val(null);
//     }
// })
//
// $(document).on("click", ".selectType", function() {
//     $('.selectType ul').slideToggle(100);
// })