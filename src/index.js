import { createRoot } from "react-dom/client";
import React from "react";
import { BrowserRouter } from "react-router-dom";
import DashboardLayoutBasic from "./pages/dashboard";

// eslint-disable-next-line no-undef
jQuery(document).ready(function () {
    // Render your React component instead
    const root = createRoot(document.querySelector("body"));
    root.render(
        <React.StrictMode>
            <BrowserRouter>
                <DashboardLayoutBasic />
            </BrowserRouter>
        </React.StrictMode>
    );
});


function App() {
    return (
        <h1>Hello World! <ButtonUsage /></h1>
    )
}


function ButtonUsage() {
    return (
        <ul>
            {navMenus.map(item => {
                return (<li><a href={item.slug}>{item.title}</a></li>)
            })}
        </ul>
    )
}
