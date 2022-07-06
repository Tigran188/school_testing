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
    $('.grade a').click(function () {
        $('.modalBack').toggle();
        $('body').css({
            'overflow': 'hidden',
            'height': '100vh'
        })
    })
    $('.finish a:last-child').click(() => {
        $('.modalBack').toggle();
        $('body').css({
            'overflow-y': 'scroll',
            'height': 'auto'
        })
    })
    $('.finishButton').click(() => {
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
                console.log(1);
            }
        })
    })
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
})