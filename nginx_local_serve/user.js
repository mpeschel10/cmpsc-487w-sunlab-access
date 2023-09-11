(() => {
    function onButtonUserSearch(event)
    {
        event.preventDefault();
        const templateUserRow = document.getElementById("template-user-row");
        const rowUser = document.importNode(templateUserRow.content.querySelector("tr"), true);

        const dataId = rowUser.querySelector(".data-id");
        const dataName = rowUser.querySelector(".data-name");
        const dataKind = rowUser.querySelector(".data-kind");
        const dataAllowed = rowUser.querySelector(".data-allowed");

        dataId.innerText = "972607187";
        dataName.innerText = "Mark Peschel";
        dataKind.innerText = "STUDENT";
        dataAllowed.innerText = "1";

        const tbodyUsers = document.getElementById("tbody-users");
        tbodyUsers.replaceChildren();
        tbodyUsers.appendChild(rowUser);
    }

    function init()
    {
        document.getElementById("button-user-search")
            .addEventListener("click", onButtonUserSearch);
        document.getElementById("button-user-search").click();
        }

    window.addEventListener("load", init);
})();

