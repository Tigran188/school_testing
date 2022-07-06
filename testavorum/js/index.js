$(Document).ready(function(){
    $('.selectList').hide();
    $(".openList").click(() => {
        $('.openList img').toggleClass('rotate');
        $('.openList').toggleClass('openColor');
        $('.selectList').slideToggle();
    })
    $('.activateTest').click(() => {
        $('.modalCalendar').show(0);
        return false;
    })
    // document.querySelector('textarea').addEventListener('keydown', e => e.preventDefault())
    $('.visible').click(() => {
        console.log()
        if($('.visible').text() == "ԴԱՐՁՆԵԼ ՏԵՍԱՆԵԼԻ"){
            document.querySelector('.visible').innerHTML = "ԴԱՐՁՆԵԼ ԱՆՏԵՍԱՆԵԼԻ"
        }else{
            document.querySelector('.visible').innerHTML = "ԴԱՐՁՆԵԼ ՏԵՍԱՆԵԼԻ";
        }
        return false;
    })
    
    
})