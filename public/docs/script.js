async function setup() {
    let configJ = await fetch("/api.json").then((response) => response.json());

    docContainer.innerHTML = `<elements-api  data-theme='dark' apidescriptiondocument='${JSON.stringify(
        configJ
    )
        .replaceAll('"', "&quot;")
        .replaceAll(
            "'",
            "&#39;"
        )}' layout="sidebar" router="hash"></elements-api>`;

    const stopligtScript = document.createElement("script");
    stopligtScript.setAttribute("src", "/docs/stoplight.min.js");
    document.head.appendChild(stopligtScript);

    const jqueryScript = document.createElement("script");
    jqueryScript.setAttribute("src", "/jquery.min.js");
    document.head.appendChild(jqueryScript);

    const searchString = document.createElement("script");
    searchString.setAttribute("src", "/sl-search.js");
    document.head.appendChild(searchString);

    setTimeout(() => {
        document.getElementById("loader").remove();
        document.getElementById("docContainer").style.display = "block";
    }, 1000);
}

setup();
