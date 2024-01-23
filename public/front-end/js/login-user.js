function loginUser() {
    let nationalityID = document.getElementById("verify-nationality").value;
    let regex = /^(10|20)([0-9]{8})$/;
    if (!regex.test(nationalityID)) {
        document
            .getElementById("error-verification")
            .classList.remove("d-none");
        return;
    }
    document.getElementById("nafath-btn").disabled = true;
    fetch("/api/v1/auth/nafath-login", {
        method: "POST",
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            national_number: nationalityID,
            source: "web",
        }),
    })
        .then((res) => res.json())
        .then((data) => {
            document.getElementById("nafath-btn").disabled = false;
            console.log(data);
            if (data.random) {
                document
                    .getElementById("modal-head-verify")
                    .classList.add("d-none");
                document
                    .getElementById("modal-body-verify")
                    .classList.add("d-none");
                document
                    .getElementById("verify-section")
                    .classList.remove("d-none");
                document.getElementById("verify-number").innerText =
                    data.random;
                Pusher.logToConsole = false;

                var pusher = new Pusher("7f90d69f7652301930de", {
                    cluster: "eu",
                });

                var channel = pusher.subscribe("LoginChannel");
                channel.bind("LoginEvent", function (data) {
                    console.log(data);
                    if (data.user == nationalityID) {
                        window.location.href =
                            "/login-nafath?user=" +
                            nationalityID +
                            "&random=" +
                            data.token;
                    }
                });
                //listen on event to hide the popup and show the success message
            } else {
                document
                    .getElementById("error-verification")
                    .classList.remove("d-none");
                document.getElementById("error-verification").innerText =
                    data.message;
            }
        });
}
