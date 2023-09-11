import trimIdImport from "./trim-id.js";
const { trimId } = trimIdImport;

(() => {
    function showUser(user)
    {
        const tbodyUsers = document.getElementById("tbody-users");
        const templateUserRow = document.getElementById("template-user-row");
        const rowUser = document.importNode(templateUserRow.content.querySelector("tr"), true);

        rowUser.querySelector(".data-id")     .innerText = user.id;
        rowUser.querySelector(".data-name")   .innerText = user.name;
        rowUser.querySelector(".data-kind")   .innerText = user.kind;
        rowUser.querySelector(".data-allowed").innerText = user.allowed;
        
        const buttonDeleteUser = rowUser.querySelector(".button-delete-user");
        buttonDeleteUser.addEventListener("click", onButtonUserDelete);
        buttonDeleteUser.buttonUserDeleteData = user.id;

        tbodyUsers.appendChild(rowUser);
    }

    function showUsers(users)
    {
        const tbodyUsers = document.getElementById("tbody-users");
        tbodyUsers.replaceChildren();
        
        for (const user of users)
        {
            showUser(user);
        }        
    }

    function onButtonUserSearch(event)
    {
        event.preventDefault();
        
        fetch("/user.php")
        .then(response => response.json())
        .then(users => showUsers(users));
        
    }

    function onButtonUserDelete(event)
    {
        const id = event.target.buttonUserDeleteData;
        fetch(
            "/user.php?" + new URLSearchParams({id:id}),
            {method: "DELETE"}
        )
        .then(result => result.text())
        .then(result => {
            console.log(result);
            document.getElementById("button-user-search").click();
        });
    }

    function onButtonUserCreate(event)
    {
        event.preventDefault();
        
        const inputUserId = document.getElementById("input-user-id");
        inputUserId.value = trimId(inputUserId.value);

        const formData = new FormData(document.getElementById("form-user-create"));
        fetch("/user.php",
            {
                method: "POST",
                body: formData,
            }
        )
        .then(result => {
            if (result.ok)
            {
                document.getElementById("form-user-create").reset();
                document.getElementById("button-user-search").click();
            } else {
                console.log("Error! User already exists");
            }
        })
    }

    function init()
    {
        document.getElementById("button-user-search")
            .addEventListener("click", onButtonUserSearch);
        document.getElementById("button-user-search").click();
        document.getElementById("button-user-create")
            .addEventListener("click", onButtonUserCreate);
    }

    window.addEventListener("load", init);
})();

