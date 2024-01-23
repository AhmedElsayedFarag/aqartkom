function loadTimers() {
    let timers = document.querySelectorAll(".timer");
    let arr = [];
    timers.forEach((timer, index) => {
        arr[index] = setInterval(function () {
            var now = new Date().getTime();
            var timeleft = new Date(timer.value) - now;
            // Calculating the days, hours, minutes and seconds left
            var days = Math.floor(timeleft / (1000 * 60 * 60 * 24));
            var hours = Math.floor(
                (timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
            );
            var minutes = Math.floor(
                (timeleft % (1000 * 60 * 60)) / (1000 * 60)
            );

            // Result is output to the specific element
            document.getElementById(`days-${index + 1}`).innerHTML = days;
            document.getElementById(`hours-${index + 1}`).innerHTML = hours;
            document.getElementById(`minutes-${index + 1}`).innerHTML = minutes;

            // Display the message when countdown is over
            if (timeleft < 0) {
                clearInterval(arr[index]);
                document.getElementById(`days-${index + 1}`).innerHTML = "00";
                document.getElementById(`hours-${index + 1}`).innerHTML = "00";
                document.getElementById(`minutes-${index + 1}`).innerHTML =
                    "00";
            }
        }, 1000);
    });
}
