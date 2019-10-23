
function doUpdate(updateJulian) {
    // added because of error when defining updateJulian = true in function def.
    updateJulian = typeof updateJulian !== 'undefined' ? updateJulian : true;
    var days = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    var f = document.forms["ordinal"].elements;
    var month = parseInt(f["month"].options[f["month"].selectedIndex].value);
    var day = parseInt(f["day"].value);
    var year = parseInt(f["nameYear"].value);

    // calc julian date
    if (isLeapYear(year))
        days[1] += 1;

    if ((day <= 0) || (day > days[month]) || year < 2012) {
        alert("Invalid data: Day incorrect or Not a valid day of month or year incorrect");
        return false;
    }
    var jDate = 0;
    for (var i = 0; i < month; i++)
        jDate += days[i];
    jDate += day;
    if (jDate < 100)
        jDate = "0" + jDate;
    if (jDate < 10)
        jDate = "0" + jDate;

    // calc gmt
    //var gmtTime = time + zone*100;
    //if (gmtTime>=2400) gmtTime-=2400;
    ///if (gmtTime<1000) gmtTime="0"+gmtTime;
    //if (gmtTime<100) gmtTime="0"+gmtTime;
    //if (gmtTime<10) gmtTime="0"+gmtTime;

    // update form

    if(updateJulian) {
        f["julian"].value = jDate;
    }

    // f["gmttime"].value = gmtTime;
}

function isLeapYear(y) {
    if (y % 4 == 0) {
        if (y % 100 == 0)
            return (y % 400 == 0) ? true : false;
        return true;
    }
    return false;
}

function ord() {

    var days = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    var t = new Date();
    var yr = t.getFullYear();
    var mon = t.getMonth();
    var day = t.getDate();

    // calc julian date
    // if leap year add + 1 day to february days value
    if (isLeapYear(yr))
        days[1] += 1;
    var jDate = 0;
    for (var i = 0; i < mon; i++)
        jDate += days[i];
    jDate += day;
    if (jDate < 100)
        jDate = "0" + jDate;
    if (jDate < 10)
        jDate = "0" + jDate;

    var myOrd = document.getElementById("ord_today")
    myOrd.innerHTML = jDate;
}

function init() {
    var f = document.forms["ordinal"].elements;

    today = new Date();
    f["month"].value = today.getMonth();
    f["day"].value = today.getDate();
    if (today.getFullYear()) {
        f["nameYear"].value = today.getFullYear();
    }

    doUpdate(false);
}

$(function () {
    init();
    ord();
});
