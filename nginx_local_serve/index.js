function say_hi() {
    const value = document.getElementById("input_param").value;
    fetch("/make_file.php?" + new URLSearchParams({'test_name':value}),
        {"method":"POST"})
        .then(result => { console.log("Received ", result); })
        .catch(error => { console.error("Error ", error); });
}

function setLogin() {
    const username = document.getElementById('input-username').value;
    const password = document.getElementById('input-password').value;
    console.log("My name is", username, password);
    credentials = btoa(`${username}:${password}`);
    fetch('/status.txt', 
        {headers: {'Authorization': `Basic ${credentials}`}}
    )
        .then(result => result.text())
        .then(text => console.log(text))
        .catch(result => { console.warn(result); });
}

(() => {
    function setStatus(s)
    {
        document.getElementById("span-status").textContent = s;
    }

    function onButtonAddUser(event)
    {
        event.preventDefault();
        const inputUserId = document.getElementById("input-user-id");
        const inputUserKind = document.getElementById("select-user-kind");
        const inputUserAllowed = document.getElementById("input-user-allowed");
        const result = {
            id: inputUserId.value,
            kind: inputUserKind.value,
            allowed: inputUserAllowed.checked,
        };
        
        const formData = new FormData(document.getElementById("form-add-user"));
        const params = new URLSearchParams(formData);
        fetch('/user.php?' + params, {
            method: "DELETE",
        })
        .then(result => result.text())
        .then(text => console.log(text));
    }

    function onButtonReset()
    {
        fetch('/reset.php', {
            method: "POST",
        })
        .then(result => result.text())
        .then(text => setStatus(text));
    }

    function init()
    {
        console.log("Window is loaded");
        const buttonAddUser = document.getElementById("button-add-user");
        buttonAddUser.addEventListener("click", onButtonAddUser);
        const buttonReset = document.getElementById("button-reset");
        buttonReset.addEventListener("click", onButtonReset);
    }

    window.addEventListener("load", init);
})();