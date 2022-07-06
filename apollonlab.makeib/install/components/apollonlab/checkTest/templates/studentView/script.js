$(document).ready(function () {
    let i = 'a'.charCodeAt(0);
    let j = 'z'.charCodeAt(0);
    let alphabet = [];
    for(; i <= j; ++i){
        alphabet.push(String.fromCharCode(i));
    }
    let blocksCount = $('.side2 ol').children().length;
    for(let i=0; i<blocksCount; i++){
        let a = alphabet[i] + $('.side2 ol').children()[i].innerHTML;
        $('.side2 ol').children()[i].innerHTML = a;
        Array.from($('.fileSelect')).forEach(function (element) {
            element.innerHTML += `<option>${alphabet[i]}</option>`
        })
    }
    $(document).on('click', '.finish a:last-child', () => {
        $('.modalBack').toggle();
        $('body').css({
            'overflow-y': 'scroll',
            'height': 'auto'
        })
    })
    $('.finishButton').click(() => {
        $('.loader_back').css('display', 'flex');
        let grades = [];
        for(let i=0; i < $('.pointInput').length; i++){
            grades.push($('.pointInput')[i].value);
        }
        $.ajax({
            type: "POST",
            url: "index.php",
            crossDomain: true,
            dataType: 'jsonp',
            data: {
                myAnswer: grades
            },
            success: function (msg) {
                $('.loader_back').css('display', 'none');
            },
            error: function(){
                $('.loader_back').css('display', 'none');
            }
        })
    })
})

$(document).on('click', '.test_results', function (e) {
    $('.loader_back').css('display', 'none');
    sessionStorage.setItem('data-id', this.getAttribute('data-test-id'))
    $.ajax({
        type: "POST",
        url: "",
        crossDomain: true,
        dataType: 'HTML',
        data: {
            flag: 'reviewPassesTest',
            test_id: $(this).attr('data-test-id'),
            student_id: $(this).attr('data-student-id'),
        },
        success: function (msg) {
            $('.modalBack').toggle();
            $('.finishButton').attr('data-id', $(this).attr('data-test-id'))
            $('body').css({
                'overflow': 'hidden',
                'height': '100vh'
            })
            $('.modalWindow').html(msg);
            $('.loader_back').css('display', 'none');
            e.preventDefault();
            e.stopPropagation();
        },
        error: function(){
            $('.loader_back').css('display', 'none');
        }
    })
})

$(document).on('click', '.finishButton', function(e){
    $('.loader_back').css('display', 'flex');
    e.preventDefault();
    e.stopPropagation();
    let points = {};
    let num = 0;
    let pointInput = document.querySelectorAll(".pointInput");
    
    for (let i=0; i<pointInput.length; i++){
        points[pointInput[i].getAttribute('data-id')] = pointInput[i].value
    }
    
    $.ajax({
        type: "POST",
        url: "",
        crossDomain: true,
        dataType: 'HTML',
        data: {
            flag: 'ACCEPT_TEST',
            points: points,
            test_id: sessionStorage.getItem('data-id')
        },
        success: function (msg) {
            $('.modalBack').hide();
            $('body').css({
                'overflow': 'auto',
                'height': 'height'
            })
            $('.loader_back').css('display', 'none');
        }
    })
})































