$(document).ready(function () {
    $(document).on('change', 'input[type="radio"]', function () {
        // console.log($(this).parent().children()[0].childNodes[1])
        $('.checkLabel span').fadeOut(0);
        this.value ? console.log(this.previousElementSibling.children[0].style.display = "block") : console.log(this.previousElementSibling.children[0].style.display = "none")
    })
    $(document).on('change', 'input[type="checkbox"]', function () {
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
    $('.next').click(function () {
        let myAnswer = [];
        if($(this).parent().prev().children().children('input').length != 0){
            Array.from($(this).parent().prev().children().children('input')).forEach(function (element) {
                if(element.checked){
                    myAnswer.push(element.getAttribute('value'));
                }
            })
            // console.log(myAnswer)
            $.ajax({
                type: "POST",
                url: "index.php",
                crossDomain: true,
                dataType: 'jsonp',
                data: {
                    myAnswer: myAnswer
                },
                success: function (msg) {
                    console.log(1);
                }
            })
        }else{
            myAnswer.push($(this).parent().prev().children('textarea').val())
            // console.log(myAnswer)
            $.ajax({
                type: "POST",
                url: "index.php",
                crossDomain: true,
                dataType: 'jsonp',
                data: {
                    myAnswer: myAnswer
                },
                success: function (msg) {
                    console.log(1);
                }
            })
        }
    })
    // Set the date we're counting down to
    var countDownDate = new Date("Jan 5, 2022 15:37:25").getTime();

// Update the count down every 1 second
    var x = setInterval(function() {
        
        // Get today's date and time
        var now = new Date().getTime();
        
        // Find the distance between now and the count down date
        var distance = countDownDate - now;
        
        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        // Output the result in an element with id="demo"
        if(hours.toString().length < 2) {
            hours = '0' + hours
        };
        if(minutes.toString().length < 2) {
            minutes = '0' + minutes
        };
        if(seconds.toString().length < 2) {
            seconds = '0' + seconds
        };
        // console.log(seconds.toString().length)
        document.getElementById("demo").innerHTML = hours + ":"
            + minutes + ":" + seconds;
        
        // If the count down is over, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("demo").innerHTML = "EXPIRED";
        }
    }, 1000);
})