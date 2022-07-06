function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
$(document).ready(function () {
    $(document).on('change', 'input[type="radio"]', function () {
        // console.log($(this).parent().children()[0].childNodes[1])
        $('.checkLabel span').fadeOut(0);
        this.value ? console.log(this.previousElementSibling.children[0].style.display = "block") : console.log(this.previousElementSibling.children[0].style.display = "none")
    })
    $(document).on('change', 'input[type="checkbox"]', function(){
        this.checked ? console.log(this.previousElementSibling.children[0].style.display = "block") : console.log(this.previousElementSibling.children[0].style.display = "none")
    })
    
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
    $(document).on('click', '.next', function () {
        let last = false;
        if($(this).hasClass('finish_Test')){last = true}
        // $('.loader_back').css('display', 'flex');
        let myAnswer = [];
        if($(this).parent().parent().prev().children().children('input').length != 0){
            
            Array.from($(this).parent().parent().prev().children().children('input')).forEach(function (element) {
                if(element.checked){
                    myAnswer.push(element.getAttribute('value'));
                }
            })
            if(myAnswer.length > 0) {
                $.ajax({
                    type: 'POST',
                    url: '',
                    crossDomain: true,
                    dataType: 'html',
                    data: {
                        order: last,
                        flag: 'NEXT_QUESTION',
                        myAnswer: myAnswer,
                        question_id: $('.question_block').attr('data-id'),
                        point: $('.question_point').text()
                    },
                    success: function(msg) {
                        document.querySelector('.middleMain').innerHTML = msg;
                        $('.loader_back').css('display', 'none');
                    },
                    error: function(){
                        $('.loader_back').css('display', 'none');
                    }
                });
            }
        } else if ($('.banner textarea')){
            myAnswer.push($('.banner textarea').val());
            if(myAnswer.length > 0) {
                $.ajax({
                    type: 'POST',
                    url: '',
                    crossDomain: true,
                    dataType: 'html',
                    data: {
                        order: last,
                        flag: 'NEXT_QUESTION',
                        myAnswer: myAnswer,
                        question_id: $('.question_block').attr('data-id'),
                        point: $('.question_point').text()
                    },
                    success: function(msg) {
                        document.querySelector('.middleMain').innerHTML = msg;
                        $('.loader_back').css('display', 'none');
                    },
                    error: function(){
                        $('.loader_back').css('display', 'none');
                    }
                });
            }
        }
    })
    let ansers = [];
    $(document).on('click', '.start_test', function(e){
        e.preventDefault();
        e.stopPropagation();
        let params = (new URL(document.location)).searchParams;
        // setCookie("test_" + $(this).attr('data-id'), $('.gave_time').attr('data-time'), 365);
        $.ajax({
            type: 'POST',
            url: '',
            crossDomain: true,
            dataType: 'html',
            data: {
                flag: 'START_TEST',
                test_id: params.get("TEST_ID"),
            },
            success: function(){
                window.location.reload();
                $('.loader_back').css('display', 'none');
            },
            error: function() {
                alert("Փորձեք կրկին");
                $('.loader_back').css('display', 'none');
            }
        });
    })
    
    
    //timer
    
    
    
    let seconds = $('.hours').text().split(":")[2].trim()
    let minutes = $('.hours').text().split(":")[1].trim()
    let hours = $('.hours').text().split(":")[0].trim()
    
    
    if (hours.toString().length < 2) {
        hours = '0' + hours;
    }
    if (minutes.toString().length < 2) {
        minutes = '0' + minutes;
    }
    if (seconds.toString().length < 2) {
        seconds = '0' + seconds;
    }
    $('.hours').text(hours + ":" + minutes + ":" + seconds)
    let timer = setInterval(function(){
        if(parseInt(seconds) > 0 || parseInt(hours) > 0 || parseInt(minutes) > 0) {
            if (seconds > 0) {
                seconds--;
            } else {
                if (minutes > 0) {
                    seconds = 59;
                    minutes--;
                } else {
                    if (hours > 0) {
                        minutes = 59;
                        seconds = 59;
                        hours--;
                    } else {
                        hours = 'Ժամանակը սպառվել է';
                        minutes = '';
                        seconds = '';
                        clearInterval(timer);
                        return;
                    }
                }
            }
            if (hours.toString().length < 2) {
                hours = '0' + hours;
            }
            if (minutes.toString().length < 2) {
                minutes = '0' + minutes;
            }
            if (seconds.toString().length < 2) {
                seconds = '0' + seconds;
            }
            $('.hours').text(hours + ':' + minutes + ':' + seconds);
        } else{
            clearInterval(timer);
            $('.hours').text('Expired!');
            $.ajax({
                type: 'POST',
                url: '',
                crossDomain: true,
                dataType: 'html',
                data: {
                    flag: 'END_TEST',
                    test: $('.hours').attr('data-id')
                },
                success: function(msg) {
                    $('.middleMain').text("EXPIRED!");
                    $('.loader_back').css('display', 'none');
                },
                error: function() {
                    alert('Փորձեք կրկին');
                    $('.loader_back').css('display', 'none');
                },
            });


            // if(myAnswer.length > 0) {
                $.ajax({
                    type: 'POST',
                    url: '',
                    crossDomain: true,
                    dataType: 'html',
                    data: {
                        order: true,
                        flag: 'NEXT_QUESTION',
                        myAnswer: [],
                        question_id: '',
                        point: 0
                    },
                    success: function(msg) {
                        document.querySelector('.middleMain').innerHTML = msg;
                        $('.loader_back').css('display', 'none');
                    },
                    error: function(){
                        $('.loader_back').css('display', 'none');
                    }
                });


        }
    }, 1000)
    
    
    $(document).on('click', '.previous_question', function(){
        $('.loader_back').css('display', 'flex');
        $.ajax({
            type: 'POST',
            url: '',
            crossDomain: true,
            dataType: 'html',
            data: {
                flag: 'PREVIOUS_QUESTION',
                test: $('.hours').attr('data-id')
            },
            success: function(msg) {
                document.querySelector('.middleMain').innerHTML = msg;
                $('.loader_back').css('display', 'none');
            },
            error: function() {
                alert('Փորձեք կրկին');
                $('.loader_back').css('display', 'none');
            },
        });
    })
    
    
})