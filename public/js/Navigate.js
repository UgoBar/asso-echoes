export class NavigateJs {
    constructor(options = {}) {
        // Options and configuration parameters
        this.animationType = options.animationType || 'fade'; // Default animation type is fade
        this.customTag = 'navigate-js'; // Custom tag name
        this.currentPage = null;
        this.links = document.querySelectorAll('a[data-njs-href]');
        this.animationDuration = options.animationDuration || 500; // Default animation type is 500
        this.withAnimation = options.withAnimation || true;
        this.navigateJsCss = options.navigateJsCss || {
            'position': 'relative',
            'width': '100%',
            'height': '100vh',
            'display': 'block',
        };
        this.njsContainerCss = options.njsContainerCss ||{
            'position': 'absolute',
            'left': '0',
            'top': '0',
            'transition': `${this.animationDuration}ms cubic-bezier(.74,.08,.51,.95)`,
            'width': '100%'
        };

        // Initialize the library
        this.init();
    }

    init() {
        // Ensure that the custom tag is defined on the current page
        const customTagElements = document.getElementsByTagName(this.customTag);

        if (customTagElements.length !== 1) {
            console.error(`NavigateJs: There should be exactly one <${this.customTag}> tag on the page.`);
            // Emit the "njs:error-page-loading" event
            this.emitEvent('njs:error-page-loading');
            return;
        }

        this.currentPage = customTagElements[0];

        // Apply required style to animation
        this.initStyles();

        // Listen popstate to detect historic change
        window.addEventListener('popstate', (event) => {
            if (event.state && event.state.path) {
                const newUrl = event.state.path;
                this.navigate(newUrl);
            }
        });

        // Attach click event listener to all links with data-njs-href attribute
        if (this.links.length > 0) {
            this.links.forEach(link => {
                link.addEventListener('click', (event) => this.handleNavLinkClick(event));
            });

            // Emit the "njs:init" event
            this.emitEvent('njs:init');

        } else {
            console.log('Warning ! There is no links with data-njs-href attribute in your page')
        }
    }

    initStyles() {
        // Initialize the styles for the custom tag and njs-container
        const container = document.createElement('div');
        container.className = 'njs-container';

        // Styles for <navigate-js>
        for (const [property, value] of Object.entries(this.navigateJsCss)) {
            this.currentPage.style[property] = value;
        }

        // Styles for <div clas="njs-container">
        for (const [property, value] of Object.entries(this.njsContainerCss)) {
            container.style[property] = value;
        }

        // Move the content of this.currentPage into the new container div
        while (this.currentPage.firstChild) {
            container.appendChild(this.currentPage.firstChild);
        }

        // Append the new container div to this.currentPage
        this.currentPage.appendChild(container);
    }

    async handleNavLinkClick(e) {
        e.preventDefault();
        const targetUrl = e.target.getAttribute('data-njs-href');
        await this.navigate(targetUrl);

        // Construct the full URL by appending the target URL to the base URL
        const baseUrl = window.location.protocol + '//' + window.location.host;
        const fullUrl = baseUrl + targetUrl;

        // Change the URL in the browser's address bar
        window.history.pushState({ path: fullUrl }, '', fullUrl);
    }

    // Emit a custom event
    emitEvent(eventName) {
        const event = new Event(eventName);
        document.dispatchEvent(event);
    }

    async navigate(url) {
        try {

            // Emit the "njs:start" event
            this.emitEvent('njs:start');

            // Fetch the HTML content of the target page
            const response = await fetch(url);

            if (!response.ok) {
                throw new Error(`Error loading page: ${response.status}`);
            }

            const newPageHTML = await response.text();

            // Extract the content within the custom tag from the new page HTML
            const parser = new DOMParser();
            const newPageDOM = parser.parseFromString(newPageHTML, 'text/html');
            const newContent = newPageDOM.querySelector(this.customTag).innerHTML;

            // Apply animation before replacing the content
            await this.replaceContentAndAnimate(newContent);

            // Add to custom tag the .njs-page-load class
            this.currentPage.classList.add('njs-page-loaded');

            // Execute scripts and styles after the animation
            this.executeScriptsAndStyles(newContent);

            this.emitEvent('njs:done');

        } catch (error) {
            console.error('NavigateJs: Error during navigation:', error);
        }
    }

    replaceContainerHtml(container, newContent) {
        // CLean up previous page style and script
        this.cleanupPreviousPage();
        // replace HTML
        container.innerHTML = '';
        container.insertAdjacentHTML('beforeend', newContent);
    }

    // Animation logic based on the configured animation type
    replaceContentAndAnimate(newContent) {
        const container = this.currentPage.querySelector('.njs-container');

        if (this.withAnimation === false) {
            // Replace HTML
            this.replaceContainerHtml(container, newContent);
        } else {

            // Emit the "njs:animation-begin" event
            this.emitEvent('njs:animation-begin');

            switch (this.animationType) {

                case 'fade':
                    // Fade animation
                    container.style.opacity = '0';
                    // After the fade out animation, replace the content and fade in
                    setTimeout(() => {
                        this.replaceContainerHtml(container, newContent);
                        container.style.opacity = '1';
                    }, this.animationDuration);
                    break;

                case 'slide':
                    // Slide animation
                    container.style.transition = `transform ${this.animationDuration}ms ease-in-out, opacity ${this.animationDuration}ms ease-in-out`;

                    // Move the current page to the left
                    container.style.transform = 'translateX(-150px)';
                    container.style.opacity = '0';

                    // After the animation, replace the content and reset the position
                    setTimeout(() => {
                        this.replaceContainerHtml(container, newContent);
                        container.style.transform = 'translateX(0)';
                        container.style.opacity = '1';
                    }, this.animationDuration);
                    break;

                // Add more animation types as needed
                default:
                    console.error('Invalid animation type');
            }
        }

        return new Promise(resolve => {
            setTimeout(() => {
                this.emitEvent('njs:animation-end'); // Emit the "njs:animation-end" event
                resolve();
            }, this.animationDuration);
        });



    }

    executeScriptsAndStyles(newContent) {
        // Execute scripts and add styles only if the page has been loaded with animation
        if (this.currentPage.classList.contains('njs-page-loaded')) {
            const scripts = this.currentPage.querySelectorAll('script[data-njs]');
            const styles = Array.from(newContent.matchAll(/<style data-njs>([\s\S]*?)<\/style>/g)).map(match => match[1]);

            // Add styles
            styles.forEach(styleContent => {
                const style = document.createElement('style');
                style.textContent = styleContent;
                document.head.appendChild(style);
            });

            // Execute scripts
            scripts.forEach(script => {
                try {
                    // Use eval() to execute the script content
                    eval(script.textContent);
                } catch (error) {
                    console.error('Error executing script:', error);
                }
            });
        }
    }

    cleanupPreviousPage() {
        const scripts = document.querySelectorAll('script[data-njs]');
        const styles = document.querySelectorAll('style[data-njs]');

        scripts.forEach(script => {
            script.parentNode.removeChild(script);
        });

        styles.forEach(style => {
            style.parentNode.removeChild(style);
        });
    }
}
