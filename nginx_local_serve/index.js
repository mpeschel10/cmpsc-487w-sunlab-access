function say_hi() {
    const value = document.getElementById("input_param").value;
    fetch("/make_file.php?" + new URLSearchParams({'test_name':value}),
        {"method":"POST"})
        .then(result => { console.log("Received ", result); })
        .catch(error => { console.error("Error ", error); });
}
