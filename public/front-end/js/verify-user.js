function verifyUser() {
    let nationalityID = document.getElementById("verify-nationality");
    let regex = /^(10|20)([0-9]{8})$/;
    if (!regex.test(nationalityID.value)) {
        document
            .getElementById("error-verification")
            .classList.remove("d-none");
        return;
    }
    fetch("/api/v1/auth/change/verify-account", {
        method: "POST",
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
            Authorization:
                "Bearer " + document.getElementById("user-token").value,
        },
        body: JSON.stringify({
            national_number: nationalityID.value,
            source: "web",
        }),
    })
        .then((res) => res.json())
        .then((data) => {
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

                var channel = pusher.subscribe("VerifyChannel");
                channel.bind("VerifyEvent", function (data) {
                    if (document.getElementById("user-id").value == data.userID)
                        window.location.reload();
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
