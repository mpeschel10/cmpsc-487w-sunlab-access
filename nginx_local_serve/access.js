"use strict";

(() => {
    function showAccess(access)
    {
        const templateRowAccess = document.getElementById("template-row-access");
        const rowAccess = document.importNode(templateRowAccess.content.querySelector("tr"), true);

        rowAccess.querySelector(".data-timestamp").innerText = new Date(access.timestamp * 1000).toLocaleString();
        rowAccess.querySelector(".data-name"     ).innerText = access.name;
        rowAccess.querySelector(".data-user-id"  ).innerText = access.userId;
        rowAccess.querySelector(".data-kind"     ).innerText = access.kind;
        rowAccess.querySelector(".data-allowed"  ).innerText = access.allowed;

        document.getElementById("tbody-access").appendChild(rowAccess);
    }

    function showAccesses(accesses)
    {
        document.getElementById("tbody-access").replaceChildren();
        for (const access of accesses)
        {
            showAccess(access);
        }
    }

    function onButtonAccessSearch(event)
    {
        event.preventDefault();

        fetch("/access.php?" + new URLSearchParams({}))
            .then(response => response.json())
            .then(accesses => showAccesses(accesses));
    }

    function init()
    {
        document.getElementById("button-access-search")
            .addEventListener("click", onButtonAccessSearch);
            document.getElementById("button-access-search").click();
    }

    window.addEventListener("load", init);
})();
