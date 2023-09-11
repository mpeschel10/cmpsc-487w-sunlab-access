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

        tbodyUsers.appendChild(rowUser);
    }

    function showUsers(users)
    {
        // console.log("Showing users", users);
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
        // const users = [
        //     {
        //         name: "Mark Peschel",
        //         id: "972607187",
        //         kind: "STUDENT",
        //         allowed: true,
        //     }
        // ];
        // showUsers(users);
        
    }

    function init()
    {
        document.getElementById("button-user-search")
            .addEventListener("click", onButtonUserSearch);
        document.getElementById("button-user-search").click();
        }

    window.addEventListener("load", init);
})();

