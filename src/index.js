import { createRoot } from "react-dom/client";
import React from "react";
import { BrowserRouter } from "react-router-dom";

// eslint-disable-next-line no-undef
jQuery(document).ready(function () {
    // Prepend root div on document body
    const appElement = document.createElement("div");
    appElement.setAttribute("id", "app");
    document.body.prepend(appElement);

    // Render your React component instead
    const root = createRoot(document.getElementById("app"));
    root.render(
        <React.StrictMode>
            <BrowserRouter>
                <App />
            </BrowserRouter>
        </React.StrictMode>
    );
});


function App() {
    return (
        <h1>Hello World!</h1>
    )
}
