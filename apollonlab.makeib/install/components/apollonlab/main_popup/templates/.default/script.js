$(document).ready(() => {
    $(document).on('click', ".notification_panel", function() {
        $('.popup_for_nots').slideToggle();
        $('.notification_panel>span:first-child').toggleClass('rotate180');
    })
    
    $(document).on('click', '.popup-class button', function() {
        let id = $(this).attr('id');
        sessionStorage.setItem('popup_class_name', this.previousElementSibling.innerHTML);
        let name = this.previousElementSibling.innerHTML;
        $.ajax({
            type: "POST",
            url: "",
            crossDomain: true,
            dataType: 'text',
            data: {
                flag: "viewClass",
                className: name,
                classID: id
            },
            success: function (msg) {
                $('.notification_popup_inner').html(msg)
                $('.add_door_outer a:first-child').attr('href', `/virtual_room/create.php?class=${name}` )
                $('.add_door_outer a:last-child').attr('href', `/virtual_room/create.php?class=${name}` )
                sessionStorage.setItem('popup_class', id);
            }
        })
    })
    
    $(document).on('click', '.previous_class button', function() {
        $('.add_room_popUp a:first img').attr('src', '/local/components/apollonlab/main_popup/images/addDoor.png');
        $('.add_room_popUp a:last img').attr('src', '/local/components/apollonlab/main_popup/images/addRoom2.png');
        $('.add_room_popUp a').addClass('p-e-none');
        $.ajax({
            type: "POST",
            url: "",
            crossDomain: true,
            dataType: 'text',
            data: {
                flag: "viewAllClasses"
            },
            success: function (msg) {
                $('.notification_popup_inner').html(msg)
            }
        })
    })

    $(document).on('click', '.previous_subjects button', function() {
        $('.add_room_popUp a:first img').attr('src', '/local/components/apollonlab/main_popup/images/addDoor.png');
        $('.add_room_popUp a:last img').attr('src', '/local/components/apollonlab/main_popup/images/addRoom2.png');
        $('.add_room_popUp a').addClass('p-e-none');
        $.ajax({
            type: "POST",
            url: "",
            crossDomain: true,
            dataType: 'text',
            data: {
                flag: "viewClass",
                classID: sessionStorage.getItem('popup_class'),
                className: sessionStorage.getItem('popup_class_name')
            },
            success: function (msg) {
                $('.notification_popup_inner').html(msg)
            }
        })
    })

    $(document).on('click', '.previous_lessons button', function() {
        $('.add_room_popUp a:first img').attr('src', '/local/components/apollonlab/main_popup/images/addDoor.png');
        $('.add_room_popUp a:last img').attr('src', '/local/components/apollonlab/main_popup/images/addRoom2.png');
        $('.add_room_popUp a').addClass('p-e-none');
        $.ajax({
            type: "POST",
            url: "",
            crossDomain: true,
            dataType: 'text',
            data: {
                flag: "viewLessons",
                classID: sessionStorage.getItem('popup_class'),
                className: sessionStorage.getItem('popup_class_name'),
                subjectID: sessionStorage.getItem('subjectID')
            },
            success: function (msg) {
                $('.notification_popup_inner').html(msg)
            }
        })
    })
    
    
    $(document).on('click', '.popup_element_subject span', function(){
        $('.previous_class').addClass('previous_subjects');
        let class_id = $(this).attr('data-class_id');
        let name = this.innerHTML.split(" ")[1];
        let subject_id = $(this).attr('data-subjectID');
        $.ajax({
            type: "POST",
            url: "",
            crossDomain: true,
            dataType: 'text',
            data: {
                flag: "viewLessons",
                subjectID: subject_id,
                classID: $(this).attr('data-classID'),
                className: name
            },
            success: function (msg) {
                $('.notification_popup_inner').html(msg)
                $('.popup_element_back_subjects button').attr("data-class_id", class_id);
                $('.popup_element_back_subjects button').attr("data-class_name", name);
                sessionStorage.setItem('popup_subject', subject_id);
            }
        })
    })
    
    
    
    $(document).on('click', '.popup_element_back_subjects button', function() {
        
        $.ajax({
            type: "POST",
            url: "",
            crossDomain: true,
            dataType: 'text',
            data: {
                flag: "viewClass",
                className: $(".popup_element_subject span").attr('data-classname'),
                classID: $(".popup_element_subject span").attr('data-classid')
            },
            success: function (msg) {
                $('.notification_popup_inner').html(msg)
            }
        })
    })
    
    
    $(document).on('click', '.popUp_lesson', function(){
        sessionStorage.setItem('lesson_start', $(this).text());
        let startTime = $(this).attr('data-startTime');
        let startDate = $(this).attr('data-date');
        let classID = $(this).attr('data-classID');
        let lessonID = $(this).attr("id");
        let subjectID = $(this).attr("data-subjectID");
        let lessonDetailPage = $(this).attr('data-detail');
        
        $.ajax({
            type: "POST",
            url: "",
            crossDomain: true,
            dataType: 'text',
            data: {
                flag: "openLesson",
                startTime: startTime,
                startDate: startDate,
                classID: classID
            },
            success: function (msg) {
                $('.notification_popup_inner').html(msg)
                $('.add_door_outer').addClass('add_room_popUp');
                $('.add_door_outer a:first-child img').attr('src', '/local/components/apollonlab/main_popup/images/activeOpenDoor.png');
                $('.add_door_outer a:last-child img').attr('src', '/local/components/apollonlab/main_popup/images/closeDoorActive.png');
                $('.add_door_outer a').removeClass('p-e-none');
                let href = $('.add_door_outer a:first-child').attr('href');
                $('.add_door_outer a:first-child').attr('href', href + "&lesson=" + lessonID + `&back_url=/teacher/logs/${classID}/${subjectID}/${lessonID}/`)
                $('.add_door_outer a:last-child').attr('href', href + "&lesson=" + lessonID + `&close=Y&back_url=/teacher/logs/${classID}/${subjectID}/${lessonDetailPage}/`)
            }
        })
    })
})






















