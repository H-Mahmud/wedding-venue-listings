// Replace all instances of "http://koumparos.local" with the current website address
(function replaceLocalURL() {
    const currentBaseURL = `${window.location.protocol}//${window.location.host}`;

    // Update anchor tags
    // document.querySelectorAll('a[href]').forEach(anchor => {
    //     const href = anchor.getAttribute('href');
    //     if (href.startsWith('http://koumparos.local')) {
    //         anchor.setAttribute('href', href.replace('http://koumparos.local', currentBaseURL));
    //     }
    // });

    // // Update other attributes if needed (e.g., data attributes, forms, etc.)
    // // Example for forms:
    // document.querySelectorAll('form[action]').forEach(form => {
    //     const action = form.getAttribute('action');
    //     if (action.startsWith('http://koumparos.local')) {
    //         form.setAttribute('action', action.replace('http://koumparos.local', currentBaseURL));
    //     }
    // });

    // If you have hardcoded URLs in the page's text content
    document.body.innerHTML = document.body.innerHTML.replace(
        /http:\/\/koumparos\.local/g,
        currentBaseURL
    );
})();
