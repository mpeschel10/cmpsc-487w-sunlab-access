import trimIdImport from "./trim-id.js";
const { trimId } = trimIdImport;

(() => {
    function refresh() { document.getElementById("button-user-search").click(); }
    function showUser(user)
    {
        const tbodyUsers = document.getElementById("tbody-users");
        const templateUserRow = document.getElementById("template-user-row");
        const rowUser = document.importNode(templateUserRow.content.querySelector("tr"), true);
        console.log(rowUser);

        rowUser.querySelector(".data-id")     .value   = user.id;
        rowUser.querySelector(".data-name")   .value   = user.name;
        rowUser.querySelector(".data-kind")   .value   = user.kind;
        rowUser.querySelector(".data-allowed").checked = user.allowed;
        
        const buttonUserUpdate = rowUser.querySelector(".button-user-update");
        buttonUserUpdate.addEventListener("click", onButtonUserUpdate);
        buttonUserUpdate.buttonUserUpdateData = rowUser;
        
        const buttonUserDelete = rowUser.querySelector(".button-user-delete");
        buttonUserDelete.addEventListener("click", onButtonUserDelete);
        buttonUserDelete.buttonUserDeleteData = user.id;

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

    function onButtonUserUpdate(event)
    {
        const row = event.target.buttonUserUpdateData;
        
        const formData = new FormData();
        formData.append("id",   row.querySelector(".data-id")     .value);
        formData.append("name", row.querySelector(".data-name")   .value);
        formData.append("kind", row.querySelector(".data-kind")   .value);
        formData.append("exist-ok", "on");
        if (row.querySelector(".data-allowed").checked)
            formData.append("allowed", "on");
        
            fetch("/user.php", {
            method: "POST",
            body: formData,
        })
        .then(result => {
            console.log("Printing results of onButtonUserUpdate");
            result.text().then(text => console.log(text));
            refresh();
        });
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
            refresh();
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
                refresh();
            } else {
                console.log("Error! User already exists");
            }
        })
    }

    function init()
    {
        document.getElementById("button-user-search")
            .addEventListener("click", onButtonUserSearch);
        document.getElementById("button-user-create")
            .addEventListener("click", onButtonUserCreate);
        refresh();
    }

    window.addEventListener("load", init);
})();

