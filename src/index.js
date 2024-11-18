import { createRoot } from "react-dom/client";
import React from "react";

jQuery(document).ready(function () {
    const root = createRoot(document.querySelector("body"));
    root.render(
        <React.StrictMode>
            <App />
        </React.StrictMode>
    );
});


function App() {
    return (
        <h1>Hello World!</h1>
    )
}
