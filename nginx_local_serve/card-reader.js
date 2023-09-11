(() => {
    function onButtonId(event)
    {
        event.preventDefault();
        
        const inputId = document.getElementById("input-id");
        const id = inputId.value.replace(/^%A/, "").split("=")[0];
        inputId.value = id;

        const inputTimestamp = document.getElementById("input-timestamp");
        const timestamp = Math.round(Date.now() / 1000);
        inputTimestamp.value = timestamp;

        const formData = new FormData(document.getElementById("form-card-reader"));
        console.log("Sending", id);
        fetch("/access.php", {
                method: "POST",
                body: formData,
        })
        .then(response => response.text())
        .then(result => {
            console.log("Result of submitting", id, " -> ", result);
        });

        inputId.value = "";
        inputId.focus();
    }

    function init()
    {
        document.getElementById("button-id").addEventListener("click", onButtonId);
        document.getElementById("input-id").focus();
    }
    window.addEventListener("load", init);
})();
