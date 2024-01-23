function loadTimer() {
    let timer = document.getElementById("timer");
    let daysElements = document.getElementById(`days`);
    let hoursElements = document.getElementById(`hours`);
    let minutesElements = document.getElementById(`minutes`);
    let timerInterval = setInterval(function () {
        var now = new Date().getTime();
        var timeleft = new Date(timer.value) - now;
        // Calculating the days, hours, minutes and seconds left
        var days = Math.floor(timeleft / (1000 * 60 * 60 * 24));
        var hours = Math.floor(
            (timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
        );
        var minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));

        // Result is output to the specific element
        daysElements.innerHTML = days;
        hoursElements.innerHTML = hours;
        minutesElements.innerHTML = minutes;

        // Display the message when countdown is over
        if (timeleft < 0) {
            clearInterval(timerInterval);
            daysElements.innerHTML = "00";
            hoursElements.innerHTML = "00";
            minutesElements.innerHTML = "00";
        }
    }, 1000);
}
