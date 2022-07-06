$(document).ready(function() {
    $(document).on('click', '.ToLeft', function() {
        let id_old = $(this).attr('id');
        let el = $(`.left_folder#${id_old}`).parent();
        while (!el.hasClass('left_folder')) {
            if (el.hasClass('catalog-section-list')) {
                el = false;
                break;
            } else {
                el = el.parent();
            }
        }
        if (el) {
            let id = el.attr('id');
            $('.addQuestion').attr('data-id', id);
            $('.addInFolder').attr('data-id', id);
            $.ajax({
                type: 'POST',
                url: '',
                crossDomain: true,
                dataType: 'HTML',
                data: {
                    flag: 'ViewFolder',
                    FolderID: id,
                },
                success: function(msg) {
                    document.querySelector('.mainmaterials').innerHTML = msg;
                    sessionStorage.setItem('CURRENT_FOLDER', id);
                    $('.ToLeft').attr('id', id);
                },
            });
        }
    });
    
    $(document).on('click', '.addFileOrFolder', function() {
        $('.add ul').slideToggle();
    });
    
    $('.add ul li').click(() => {
        $('.add ul').slideUp();
    });
    
    $(document).on('click', '.b2', () => {
        $('.ToLeft').attr('id', '');
        sessionStorage.removeItem('CURRENT_FOLDER');
        $('.addInFolder').attr('data-id', '');
        $('.modalWindow').fadeOut(100);
        $('.folderInner').fadeOut(100);
    });

    $(document).on('click', '.addQuestion1', function (){

        $('.folderInner').hide();
        $('.addQuestionWindow').show();
        $('.correctList').html('<option value="1"> 1 տարբերակ </option>' +
            '<option value="2"> 2 տարբերակ </option>' +
            '<option value="3"> 3 տարբերակ </option>' +
            '<option value="4"> 4 տարբերակ </option>');
    });
    
    $('.foldersList ul li .dropSymbol').click(function() {
        $(this).next().toggle();
    });
    
    let cancel = document.querySelector('.cancel');
    let nameInput = document.querySelector('.folderName input');
    
    $(document).on('click', '.addInFolder', function(e) {
        let id = $(this).attr('data-id')
        e.preventDefault();
        e.stopPropagation();
        if (!nameInput.value) {
            document.querySelector(
                '.errors').innerHTML = '- Լրացրեք թղթապանակի անունը';
        } else {
            let elem = $(this).attr('data-id');
            document.querySelector('.errors').innerHTML = '';
            $.ajax({
                type: 'POST',
                url: '',
                crossDomain: true,
                dataType: 'HTML',
                data: {
                    flag: 'addFolder',
                    folderName: nameInput.value,
                    folderID: elem,
                },
                success: function(msg) {
                    document.querySelector('.foldersContainer').innerHTML = msg;
                    console.log(msg);
                },
            });
            
            $('.modalWindow').fadeIn(60);
            $('.makeFolderName').fadeOut(60);
            if (sessionStorage.getItem('CURRENT_FOLDER') != '') {
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
                        document.querySelector(
                            '.materialsCenter').innerHTML = msg;
                        $('.ToLeft').attr('id', id);
                    },
                });
            } else {
                $('.makeFolderName').fadeOut(100);
                $('.modalWindow').fadeOut(100);
            }
            $.ajax({
                type: 'POST',
                url: '',
                crossDomain: true,
                dataType: 'HTML',
                data: {
                    flag: 'update_left_section',
                },
                success: function(msg) {
                    document.querySelector('.foldersList').innerHTML = msg;
                },
            });
        }
        e.preventDefault();
        e.stopPropagation();
        $('input').val('');
    });
    
    $(document).on('click', '.cancel', function() {
        if (document.querySelector('.folderInner').style.display != 'flex') {
            $('.modalWindow').fadeOut(100);
        }
        $('.makeFolderName').fadeOut(100);
        $('.editFolderNameModal').fadeOut(100);
    });
    
    $(document).on('click', '.deleteFolder', function() {
        let id = $(this).parent().data('id');
        $.ajax({
            type: 'POST',
            url: '',
            crossDomain: true,
            dataType: 'HTML',
            data: {
                flag: 'delFolder',
                id: id,
            },
            success: function(msg) {
                document.querySelector('.foldersContainer').innerHTML = msg;
            },
        });
    });
    
    $(document).on('click', '.delElem', function() {
        let elem = $(this);
        let id = $(this).parent().data('id');
        $.ajax({
            type: 'POST',
            url: '',
            crossDomain: true,
            dataType: 'HTML',
            data: {
                flag: 'delElem',
                id: id,
            },
            success: function(msg) {
                elem.parent().remove();
            },
        });
    });
    
    $(document).on('click', '.del', function() {
        let id = $(this).parent().data('id');
        let elem = $(this);
        $.ajax({
            type: 'POST',
            url: '',
            crossDomain: true,
            dataType: 'HTML',
            data: {
                flag: 'delFolderIn',
                id: id,
            },
            success: function() {
                elem.parent().remove();
                
            },
        });
    
        $.ajax({
            type: 'POST',
            url: '',
            crossDomain: true,
            dataType: 'HTML',
            data: {
                flag: 'update_left_section',
            },
            success: function(msg) {
                document.querySelector('.foldersList').innerHTML = msg;
            },
        });
    });
    
    $(document).on('click', '.editFolderName', function() {
        let id = $(this).closest('.folder').data('id');
        $('.modalWindow').fadeIn(50);
        $('.editFolderNameModal').fadeIn(50);
        $('.editFolderNameModal').attr('data-id', id.toString());
        return false;
    });
    
    $(document).on('click', '.editFolderIn', function() {
        let id = $(this).closest('.fold').data('id');
        $('.modalWindow').fadeIn(50);
        $('.editFolderNameModal').fadeIn(50);
        $('.editFolderNameModal').attr('data-id', id.toString());
        return false;
    });
    $(document).on('click', '.update', function() {
        if (!$('input[name=\'editFolderName\']').val()) {
            $('.errors').html(BX.message('INPUT_FOLDER_NAME'));
        } else {
            let id = $(this).closest('.editFolderNameModal').data('id');
            $('.errors').html('');
            $.ajax({
                type: 'POST',
                url: '',
                crossDomain: true,
                dataType: 'HTML',
                data: {
                    flag: 'updateFolder',
                    newFolderName: $('input[name=\'editFolderName\']').val(),
                    folderId: id,
                },
                success: function(msg) {
                    // document.querySelector('.foldersContainer').innerHTML = msg;
                    if($('.folderInner').css('display') == 'flex'){
                        $.ajax({
                            type: 'POST',
                            url: '',
                            crossDomain: true,
                            dataType: 'HTML',
                            data: {
                                flag: 'ViewFolder',
                                FolderID: id,
                            },
                            success: function(msg) {
                                document.querySelector('.materialsCenter').innerHTML = msg;
                                $('.ToLeft').attr('id', id);
                            },
                        });
                    } else {
                        window.location.reload();
                    }
                    
                    
                    
                    id = '#' + id;
                    $(`${id} a p span`).
                        html($('input[name=\'editFolderName\']').val());
                },
            });
            // $('.modalWindow').fadeOut(60);
            $('.editFolderNameModal').fadeOut(60);
        }
        
        return false;
    });
    
    $('input[name=\'manyAnswers\']').attr('id', 'manyAnswers');
    $('input[name=\'OneAnswer\']').attr('id', 'OneAnswer');
    $('input[name=\'questionForTask\']').attr('id', 'questionForTask');
    $('input[name=\'questionForMistake\']').attr('id', 'questionForMistake');
    $('input[name=\'sharadrutyun\']').attr('id', 'sharadrutyun');
    
    $('.addQuestionWindow').on('change', 'input[type=\'file\']', function() {
        if ($(this).val() != '') {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
    
    $(document).on('change', '.correctList', function(event) {
    
    });

// left folders
    
    $(document).on('click', '.left_folder', function(e) {
        e.stopPropagation();
        e.preventDefault();
        $('.left_folder').addClass('c-black');
        $('.left_folder').removeClass('c-blue');
        $(this).addClass('c-blue');
        console.log($(this).attr('id'));
        let id = $(this).attr('id');
        $.ajax({
            type: 'POST',
            url: '',
            crossDomain: true,
            dataType: 'HTML',
            data: {
                flag: 'ViewFolder',
                FolderID: id,
            },
            success: function(msg) {
                document.querySelector('.mainmaterials').innerHTML = msg;
                $('.ToLeft').attr('id', id);
            },
        });
    });
    
    $(document).on('click', '.editElem', function() {
        let id = this.closest('.sectElement').dataset.id;
        $('.addQuestionWindow').hide();
        $('.folderInner').hide();
        $('.editQuestion').attr('data-edit-elem-id', id);
        $.ajax({
            type: 'POST',
            url: '',
            crossDomain: true,
            dataType: 'HTML',
            data: {
                flag: 'updateQuestion',
                ID: id,
            },
            success: function(msg) {
                document.querySelector('.editQuestionWindow').outerHTML = msg;
                $('.editQuestionWindow').show();
                tinymce.init({
                    selector: ".editQuestionWindow input[name='question2'], .quest1 input[type='text'], .question>textarea",
                    menubar: true,
                    plugins: [
                        'advlist autolink lists link image charmap print preview anchor',
                        'searchreplace visualblocks fullscreen',
                        'insertdatetime media table hr code',
                    ],
                    toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code | paste',
                    powerpaste_allow_local_images: true,
                    powerpaste_word_import: 'prompt',
                    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
                    image_file_types: 'jpg,svg,webp,png',
                    smart_paste: true
                });
            },
        });
    });
    
    // $(document).on('click', '.editQuestion', function() {
    //     tinyMCE.triggerSave();
    //     let errors = [];
    //     $('.editQuestionWindow .errors').html('');
    //
    //     let question = '';
    //     let image = '';
    //     switch ($('.editQuestion').attr('data-type')) {
    //         case 'SINGLE_ANSWER':
    //             //question
    //             question = '';
    //             if ($('.OneAnswer .quest1 textarea').val() != '') {
    //                 question = $('.OneAnswer .quest1 input').val();
    //             }
    //
    //             if (question.length == 0) {
    //                 errors.push('- Լրացրեք հարցը');
    //             }
    //
    //             //answer version
    //             variantsMassiv = [];
    //             for (let i = 0; i <
    //             $('.OneAnswer .variant li div input').length; i++) {
    //                 if ($('.OneAnswer .variant li div input')[i].value != '') {
    //                     variantsMassiv.push(
    //                         $('.OneAnswer .variant li div input')[i].value);
    //                 }
    //             }
    //
    //             if (variantsMassiv.length < 2) {
    //                 errors.push('- Լրացրեք ամենաքիչը 2 պատասխան');
    //             }
    //             //correct answer
    //             let correctAnswer = $(
    //                 '.OneAnswerEdit .correctAnswerList .correctAnswer .correctList').
    //                 val();
    //             if (errors.length == 0) {
    //                 $.ajax({
    //                     type: 'POST',
    //                     url: '',
    //                     crossDomain: true,
    //                     dataType: 'text',
    //                     data: {
    //                         flag: 'editQuestion',
    //                         ID: $(this).attr('data-id'),
    //                         question: question,
    //                         answers: variantsMassiv,
    //                         correctAns: correctAnswer,
    //                     },
    //                     success: function(msg) {
    //                         document.querySelector(
    //                             '.editQuestionWindow').outerHTML = msg;
    //                         // window.location.reload();
    //                     },
    //                     error: function() {
    //                         alert('error');
    //                     },
    //                 });
    //                 $('.modalWindow').fadeOut(50);
    //                 $('.editQuestionWindow').fadeOut(50);
    //                 $('input').val('');
    //             } else {
    //                 errors.forEach(element => {
    //                     document.querySelector(
    //                         '.editQuestionWindow .errors').innerHTML += `<p class="errorByJs" style="color: red">${element}</p>`;
    //                 });
    //                 return false;
    //             }
    //             break;
    //         case 'MULTIPLE_ANSWER':
    //
    //             //question
    //             if ($('.manyAnswers .quest1 input[name="question2"]').val() !=
    //                 '') {
    //                 question = $('.manyAnswers .quest1 input').val();
    //             }
    //
    //             if ($('#imageFile').val()) {
    //                 image = $('#imageFile').val();
    //             }
    //
    //             if (question == '') {
    //                 errors.push('- Լրացրեք հարցը');
    //             }
    //
    //             //answer version
    //             variantsMassiv = [];
    //             for (let i = 0; i <
    //             $('.manyAnswers .variant li div input').length; i++) {
    //                 if ($('.manyAnswers .variant li div input')[i].value !=
    //                     '') {
    //                     variantsMassiv.push(
    //                         $('.manyAnswers .variant li div input')[i].value);
    //                 }
    //             }
    //             if (variantsMassiv.length < 2) {
    //                 errors.push('- Լրացրեք ամենաքիչը 2 պատասխան');
    //             }
    //             //correct answer
    //             let a = [];
    //             for (i = 0; i <
    //             $('.manyAnswers .correctAnswerList .correctAnswer .correctList').length; i++) {
    //                 a.push(
    //                     $('.manyAnswers .correctAnswerList .correctAnswer .correctList')[i].value);
    //                 correctAns = a;
    //             }
    //
    //             if (errors.length == 0) {
    //                 $.ajax({
    //                     type: 'POST',
    //                     url: '',
    //                     crossDomain: true,
    //                     dataType: 'text',
    //                     data: {
    //                         flag: 'editQuestion',
    //                         ID: $(this).attr('data-id'),
    //                         question: question,
    //                         answers: variantsMassiv,
    //                         correctAns: correctAns,
    //                     },
    //                     success: function(msg) {
    //                         document.querySelector(
    //                             '.editQuestionWindow').outerHTML = msg;
    //                         // window.location.reload();
    //                     },
    //                     error: function() {
    //                         alert('error');
    //                     },
    //                 });
    //                 $('.modalWindow').fadeOut(50);
    //                 $('.editQuestionWindow').fadeOut(50);
    //                 $('input').val('');
    //
    //             } else {
    //                 errors.forEach(element => {
    //                     document.querySelector(
    //                         '.editQuestionWindow .errors').innerHTML += `<p class="errorByJs" style="color: red">${element}</p>`;
    //                 });
    //                 return false;
    //             }
    //
    //             break;
    //         case 'TASK_OR_QUESTION':
    //
    //             //question
    //             question = '';
    //             for (let i = 0; i < 2; i++) {
    //                 if ($('.taskEdit .quest1 input')[i].value != '') {
    //                     question = $('.task .quest1 input')[i].value;
    //                 }
    //             }
    //             if (question == '') {
    //                 errors.push('- Լրացրեք հարցը');
    //             }
    //             //answer version
    //             let arr = [];
    //             for (let i = 0; i <
    //             $('.task .variant li div input').length; i++) {
    //                 if ($('.task .variant li div input')[i].value != '') {
    //                     arr.push($('.task .variant li div input')[i].value);
    //                 }
    //             }
    //             correctAns = arr;
    //             if (correctAns.length < 1) {
    //                 errors.push('- Լրացրեք ամենաքիչը 1 պատասխան');
    //             }
    //
    //             //ajax
    //             if (errors.length == 0) {
    //                 $.ajax({
    //                     type: 'POST',
    //                     url: '',
    //                     crossDomain: true,
    //                     dataType: 'text',
    //                     data: {
    //                         flag: 'editQuestion',
    //                         ID: $(this).attr('data-id'),
    //                         question: question,
    //                         answers: correctAns,
    //                     },
    //                     success: function(msg) {
    //                         console.log(1);
    //                         // window.location.reload();
    //                     },
    //                 });
    //                 $('.modalWindow').fadeOut(50);
    //                 $('.editQuestionWindow').fadeOut(50);
    //                 $('input').val('');
    //
    //             } else {
    //                 errors.forEach(element => {
    //                     document.querySelector(
    //                         '.editQuestionWindow .errors').innerHTML += `<p class="errorByJs" style="color: red">${element}</p>`;
    //                 });
    //                 return false;
    //             }
    //             break;
    //         case 'CORRECT_MISTAKE':
    //             //question
    //             question = '';
    //             if ($('.correctMistakeEdit .quest1 textarea').val() != '') {
    //                 question = $('.correctMistake .quest1 textarea').val();
    //             }
    //             if (question == '') {
    //                 errors.push('- Լրացրեք հարցը');
    //             }
    //             //answer version
    //             let arr1 = [];
    //             for (let i = 0; i <
    //             $('.correctMistake .variant li div input').length; i++) {
    //                 if ($('.correctMistake .variant li div input')[i].value !=
    //                     '') {
    //                     arr1.push(
    //                         $('.correctMistake .variant li div input')[i].value);
    //                 }
    //             }
    //             correctAns = arr1;
    //             if (correctAns.length < 1) {
    //                 errors.push('- Լրացրեք ամենաքիչը 1 պատասխան');
    //             }
    //
    //             //ajax
    //             if (errors.length == 0) {
    //                 $.ajax({
    //                     type: 'POST',
    //                     url: '',
    //                     crossDomain: true,
    //                     dataType: 'text',
    //                     data: {
    //                         flag: 'editQuestion',
    //                         ID: $(this).attr('data-id'),
    //                         question: question,
    //                         answers: correctAns,
    //                     },
    //                     success: function(msg) {
    //                         console.log(1);
    //                         // window.location.reload();
    //                     },
    //                     error: function() {
    //                         alert('error');
    //                     },
    //                 });
    //                 $('.modalWindow').fadeOut(50);
    //                 $('.editQuestionWindow').fadeOut(50);
    //                 $('input').val('');
    //
    //             } else {
    //                 errors.forEach(element => {
    //                     document.querySelector(
    //                         '.editQuestionWindow .errors').innerHTML += `<p class="errorByJs" style="color: red">${element}</p>`;
    //                 });
    //                 return false;
    //             }
    //             break;
    //         case 'COMPARE':
    //
    //             //question
    //             question = '';
    //             errors = [];
    //             for (let i = 0; i < 2; i++) {
    //                 if ($('.hamematutyunEdit .quest1 input')[i].value != '') {
    //                     question = $('.hamematutyun .quest1 input')[i].value;
    //                 }
    //             }
    //             if (question == '') {
    //                 errors.push('- Լրացրեք հարցը');
    //             }
    //
    //             //answer versions
    //             variantsMassiv = [];
    //             let s1 = [];
    //             let s2 = [];
    //             if ($('.comparisonTypeSelect').val() == 'տեքստ') {
    //                 let side1Count = $('.textType .side1 li div input').length;
    //                 for (i = 0; i < side1Count; i++) {
    //                     if ($('.textType .side1 li div input')[i].value != '') {
    //                         s1.push($('.textType .side1 li div input')[i].value);
    //                     }
    //                 }
    //
    //                 for (i = 0; i < side1Count; i++) {
    //                     if ($('.textType .side2 li div input')[i].value != '') {
    //                         s2.push($('.textType .side2 li div input')[i].value);
    //                     }
    //                 }
    //
    //                 if (s1.length < $('.textType .side1 li div input').length /
    //                     2 || s2.length <
    //                     $('.textType .side1 li div input').length / 2) {
    //                     errors.push('-Լրացրեք բոլոր դաշտերը');
    //                 } else {
    //                     variantsMassiv.push(s1, s2);
    //                 }
    //             } else {
    //                 let side1Count = $('.fileType .side1 li div input').length;
    //                 for (i = 0; i < side1Count; i++) {
    //                     if ($('.fileType .side1 li div input')[i].value != '') {
    //                         s1.push($('.fileType .side1 li div input')[i].value);
    //                     }
    //                 }
    //
    //                 for (i = 0; i < side1Count; i++) {
    //                     if ($('.fileType .side2 li div input')[i].value != '') {
    //                         s2.push($('.fileType .side2 li div input')[i].value);
    //                     }
    //                 }
    //
    //                 if (s1.length < $('.fileType .side1 li div input').length /
    //                     2 || s2.length <
    //                     $('.fileType .side1 li div input').length / 2) {
    //                     errors.push('-Լրացրեք բոլոր դաշտերը');
    //                 } else {
    //                     variantsMassiv.push(s1, s2);
    //                 }
    //             }
    //
    //             //answers
    //             correctAns = [];
    //             Array.from($('.allCorrectnswers').children('.Correctnswers')).
    //                 forEach(element => {
    //                     let arr = [];
    //                     Array.from(element.children).forEach(option => {
    //                         arr.push(option.value);
    //                     });
    //                     correctAns.push(arr);
    //                 });
    //
    //             //ajax
    //             if (errors.length) {
    //                 errors.forEach(element => {
    //                     document.querySelector(
    //                         '.editQuestionWindow .errors').innerHTML += `<p class="errorByJs" style="color: red">${element}</p>`;
    //                 });
    //             } else {
    //                 $.ajax({
    //                     type: 'POST',
    //                     url: '',
    //                     crossDomain: true,
    //                     dataType: 'text',
    //                     data: {
    //                         flag: 'editQuestion',
    //                         question: question,
    //                         answers: variantsMassiv,
    //                         correctAns: correctAns,
    //                         ID: $(this).attr('data-id'),
    //                     },
    //                     success: function(msg) {
    //                         console.log(1);
    //                         window.location.reload();
    //                     },
    //                 });
    //                 $('.modalWindow').fadeOut(50);
    //                 $('.editQuestionWindow').fadeOut(50);
    //                 $('input').val('');
    //
    //             }
    //             break;
    //
    //         case 'ESSE':
    //
    //             //question
    //             question = '';
    //             if ($('.sharadrutyunEdit .quest1 input').val() != '') {
    //                 question = $('.sharadrutyun .quest1 input').val();
    //             }
    //             if (question == '') {
    //                 errors.push('- Լրացրեք հարցը');
    //             }
    //
    //             //ajax
    //             if (errors.length == 0) {
    //                 $.ajax({
    //                     type: 'POST',
    //                     url: '',
    //                     crossDomain: true,
    //                     dataType: 'text',
    //                     data: {
    //                         flag: 'editQuestion',
    //                         question: question,
    //                         ID: $(this).attr('data-id'),
    //                     },
    //                     success: function(msg) {
    //                         console.log(1);
    //                         // window.location.reload();
    //                     },
    //                 });
    //                 $('.modalWindow').fadeOut(50);
    //                 $('.editQuestionWindow').fadeOut(50);
    //                 $('input').val('');
    //
    //             } else {
    //                 errors.forEach(element => {
    //                     document.querySelector(
    //                         '.editQuestionWindow .errors').innerHTML += `<p class="errorByJs" style="color: red">${element}</p>`;
    //                 });
    //                 return false;
    //             }
    //             break;
    //     }
    // });
});