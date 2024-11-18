import { createRoot } from "react-dom/client";
import React from "react";
import "./style.css";

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
        <h1 className="text-3xl font-bold underline">Hello World!</h1>
    )
}
