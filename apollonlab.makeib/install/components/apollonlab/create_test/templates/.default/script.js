$(document).ready(function () {
    
    
    $(".backgroundBlack").hide()
    
    $('.save').click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        if (parseInt($('.folderForQuestion>a:first-child').attr('data-section-id')) > 0 && $('.testNameInput').val() != '' && parseInt($('input[name="minutes"]').val()) > 9) {
            $('.loader_back').css('display', 'flex');
            let testName = $('.testNameInput').val();
            let hours = '';
            if($('input[name="hours"]').val().length == 1){
                hours = "0" + $('input[name="hours"]').val()
            } else {
                hours = $('input[name="hours"]').val()
            }
            let minutes = '';
            if($('input[name="minutes"]').val().length == 1){
                minutes = "0" + $('input[name="minutes"]').val()
            } else {
                minutes = $('input[name="minutes"]').val()
            }
            let time = hours + ":" + minutes;
            let isOpen = document.querySelector('input[name="isOpen"]').checked;
            let back = document.querySelector('input[name="back"]').checked;
            let sections = [];
            $('.folderForQuestion').each(function(el) {
                sections.push({
                    "section_id": $(this).children('a:first-child').attr('data-section-id'),
                    "points":  $(this).children('label').children('.point').val(),
                    "count_questions": $(this).children('label').children('.countOfQuestions').val()
                });
            })
            $.ajax({
                type: "POST",
                url: "",
                crossDomain: true,
                data: {
                    flag: 'create_test',
                    testName: testName,
                    time: time,
                    isOpen: isOpen,
                    back: back,
                    sections_and_options: sections,
                },
                success: function() {
                    $('.save').addClass('disabled-link');
                    $('.loader_back').css('display', 'none');
                    alert(BX.message('TEST_IS_READY'));
                    let link = document.location.href;
                    window.location.href = link.split('reference=')[1]
                },
                error: function(){
                    $('.loader_back').css('display', 'none');
                }
            })
        }else{
            $('.loader_back').css('display', 'none');
            e.preventDefault();
            e.stopPropagation();
        }
    })
    $('.number span img:first-child').click(function () {
        let num = Number(this.parentElement.previousElementSibling.value) + 1;
        this.parentElement.previousElementSibling.value = num;
        let newFolder = document.createElement('div');
        newFolder.innerHTML =
            "<a href=\"#\" class=\"arial\">" + BX.message('SELECT_SECTION') + "</a>\n" +
            "                        <img src=\"images/Screenshot_1.png\" alt=\"error\">\n" +
            "                        <label class=\"points arial\">\n" +
            "                            " + BX.message('POINT') + "\n" +
            "                            <input type=\"number\" min=\"1\" value='1' class=\"d-block point\">\n" +
            "                        </label>\n" +
            "\n" +
            "                        <img src=\"images/Screenshot_1.png\" alt=\"error\">\n" +
            "\n" +
            "                        <label class=\"questionsCount arial\">\n" +
            "                           <span>" + BX.message('SELECT_QUESTIONS_COUNT') + "</span>\n" +
            "                            <input type=\"number\" value=\"1\" min=\"1\" name=\"countOfQuestions\" class=\"countOfQuestions\">\n" +
            "                        </label>\n" +
            "                        <span class=\"del arial\">X</span>"
        ;
        newFolder.classList.add('folderForQuestion');
        document.querySelector('.mainSettingsRow2').appendChild(newFolder);
    })
    
    $('.number span img:last-child').click(function () {
        let num = Number(this.parentElement.previousElementSibling.value) - 1;
        if(num > 0) {
            this.parentElement.previousElementSibling.value = num;
            document.querySelector('.mainSettingsRow2').lastChild.remove()
        }
    })
    
    $('.mainSettingsRow2>a').click(() => {
        $('.modalWindow').fadeIn(100);
        $('.folderInner').css({display: 'flex'});
        return false;
    })
    
    
    $('.mainSettingsRow2').on('click', '.folderForQuestion a', function() {
        $('.modalWindow').fadeIn(50);
        $('.folderInner').css("display", 'flex');
        $(".backgroundBlack").show()
        $(this).addClass('activeSection');
    })
    $('.mainSettingsRow2').on('click', '.del', function() {
        if(Array.from($('.folderForQuestion')).length > 1) {
            document.querySelector('input[name="countOfQuestions"]').value = Number(document.querySelector('input[name="countOfQuestions"]').value) - 1
            $(this).parent().remove();
        }
    })
    $('.b2').click(() => {
        $('.modalWindow').fadeOut(50);
        $('.folderInner').fadeOut(50);
        $(".backgroundBlack").hide();
    })
    
    $(document).on('click', ".b1", function(){
        $('.modalWindow').hide();
        $('.activeSection').html($('.fold label input[name="section"]:checked').closest('.fold').find(".section_name").text());
        console.log($('.activeSection').next().next().next().next().find('input').attr('max', $('.fold label input[name="section"]:checked').closest('.fold').attr('data-count')))
        $('.activeSection').attr('data-section-id', $('.fold label input[name="section"]:checked').val());
        $('.activeSection').removeClass('activeSection')
    })
    
    $(document).on('click', '.update', function(e){
        $('.loader_back').css('display', 'flex');
        e.preventDefault();
        e.stopPropagation();
        if (parseInt($('.folderForQuestion>a:first-child').attr('data-section-id')) > 0 && $('.testNameInput').val() != '') {
            let testName = $('.testNameInput').val();
            let hours = '';
            if($('input[name="hours"]').val().length == 1){
                hours = "0" + $('input[name="hours"]').val()
            } else {
                hours = $('input[name="hours"]').val()
            }
            let minutes = '';
            if($('input[name="minutes"]').val().length == 1){
                minutes = "0" + $('input[name="minutes"]').val()
            } else {
                minutes = $('input[name="minutes"]').val()
            }
            let time = hours + ":" + minutes;
            let isOpen = document.querySelector('input[name="isOpen"]').checked;
            let back = document.querySelector('input[name="back"]').checked;
            let sections = [];
            $('.folderForQuestion').each(function() {
                sections.push({
                    "section_id": $(this).children('a:first-child').attr('data-section-id'),
                    "points":  $(this).children('label').children('.point').val(),
                    "count_questions": $(this).children('label').children('.countOfQuestions').val()
                });
            })
            $.ajax({
                type: "POST",
                url: "",
                crossDomain: true,
                data: {
                    flag: 'EDIT_TEST2',
                    testName: testName,
                    time: time,
                    isOpen: isOpen,
                    back: back,
                    sections_and_options: sections,
                },
                success: function(msg) {
                    $('.loader_back').css('display', 'none');
                },
                error: function(){
                    $('.loader_back').css('display', 'none');
                }
            })
        }else{
            alert("fill in all empty fields!");
        }
    })
    
    
})






