(() => {
    function onButtonUserSearch(event)
    {
        event.preventDefault();
    }

    function init()
    {
        document.getElementById("button-user-search", onButtonUserSearch)
            .addEventListener("click", onButtonUserSearch);
    }

    window.addEventListener("load", init);
})();

