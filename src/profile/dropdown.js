document.addEventListener("DOMContentLoaded", () => {
    const vendorChoices = new Choices("#vendor_type", {
        removeItemButton: true,
        maxItemCount: 3, // Limit to 3 items
        choices: WVL_DATA.vendorTypes, // Set whitelist
        searchResultLimit: 5, // Limit dropdown items
        searchEnabled: true, // Enable search
    });

    const eventChoices = new Choices("#event_type", {
        removeItemButton: true,
        maxItemCount: 3, // Limit to 3 items
        choices: WVL_DATA.eventTypes, // Set whitelist
        searchResultLimit: 5, // Limit dropdown items
        searchEnabled: true, // Enable search
    });
});
