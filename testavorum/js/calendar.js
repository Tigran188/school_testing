let date = new Date();
let month;
let setYear = document.querySelector(".setYear");
let thisYear = new Date();
// document.querySelector('.inputTime').value = `${date.getHours()}:${date.getMinutes()}`
function renderCalendar(){
    month = document.querySelector(".month span");
    let monthDays = document.querySelector(".days");

    date.setDate(1);
// console.log(date)

    let lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();
    const firstDayIndex = date.getDay();
    const prevLastDay = new Date(date.getFullYear(), date.getMonth(), 0).getDate();
    const lastDayIndex = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDay();
    const nextDays = 7 - lastDayIndex - 1;
//getting month
    let monthNum = date.getMonth();
    const months = ["Հունվար", "Փետրվար", "Մարտ", "Ապրիլ", "Մայիս", "Հունիս", "Հուլիս", "Օգոստոս", "Սեպտեմբեր", "Հոկտեմբեր", "Նոյեմբեր", "Դեկտեմբեր"];
//setting default month
    
    month.innerHTML = months[date.getMonth()];
//setting days
    let days = '<span>Երկ</span>' +
'               <span>Երք</span>\n' +
'               <span>Չրք</span>\n' +
'               <span>Հնգ</span>\n' +
'               <span>Ուր</span>\n' +
'               <span>Շբտ</span>\n' +
'               <span>Կիր</span>';

    for(let x = firstDayIndex; x > 0; x--){
        days += `<div onclick="setDay(this)" class="prev-date">${prevLastDay - x + 1}</div>`;
    }

    for(let i=1; i <= lastDay; i++){
        if(i === new Date().getDate() && date.getMonth() === new Date().getMonth()){
            days += `<div onclick="setDay(this)" class="today">${i}</div>`;
        }else {
            days += `<div onclick="setDay(this)">${i}</div>`;
        }
    }

    for(let j = 1; j <= nextDays; j++){
        days += `<div onclick="setDay(this)" class="next-date">${j}</div>`;
        monthDays.innerHTML = days;
    }
    //attributes for year
    setYear.setAttribute("value", date.getFullYear());
    setYear.setAttribute("min", thisYear.getFullYear());
}
//changing year
$('.setYear').change(function(){
    date.setFullYear(this.value, 0, 1);
    renderCalendar();
})


//changeing month
$('.fa-caret-left').click(() => {
    date.setMonth(date.getMonth() - 1);
    renderCalendar();
})

$('.fa-caret-right').click(() => {
    date.setMonth(date.getMonth() + 1);
    renderCalendar();
})




function setDay(value){
    if(document.querySelector('.today')) {
        document.querySelector('.today').setAttribute("class", "");
        value.classList.add('today');
    }else{
        value.classList.add('today');
    }
}


$(".activate").click(() => {
    $.ajax({
        type: "POST",
        url: "",
        crossDomain: true,
        dataType: 'jsonp',
        data: {
            day: $('.today')[0]['innerHTML'],
            month: month.innerHTML,
            year: setYear.value,
            time: document.querySelector('.inputTime').value
        },
        success: function (msg){
            console.log(1);
        }
    })
    $('.modalCalendar').hide(0);
})
renderCalendar()

$(".cancel").click(() => {
    $('.modalCalendar').hide(0);
})