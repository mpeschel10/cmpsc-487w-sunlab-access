setStatus = text => {
    document.getElementById("span-status").innerText = text;
}

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
    setStatus("My name is");
}