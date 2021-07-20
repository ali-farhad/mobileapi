//get difference between two dates
function getDate(date1, date2) {
    var d1 = new Date(date1);
    var d2 = new Date(date2);
    var diff = ((d1.getTime() - d2.getTime()) / 1000);
    return diff;
}