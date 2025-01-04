class StarRating extends HTMLElement {
    constructor() {
        super();

        // Attach Shadow DOM
        this.attachShadow({ mode: "open" });

        // Initialize properties
        this.min = parseInt(this.getAttribute("min") || 0, 10);
        this.max = parseInt(this.getAttribute("max") || 5, 10);
        this.value = parseFloat(this.getAttribute("value") || 0);
        this.editable = this.hasAttribute("editable")
            ? this.getAttribute("editable") === "true"
            : false;

        // Render the component
        this.render();
    }

    render() {
        // Include Font Awesome stylesheet in the Shadow DOM
        const style = `
        <style>
          :host {
            --full-star-color: #FAAD14;  /* Default full star color */
            --half-star-color: #FAAD14;  /* Default half star color */
            --empty-star-color: #c9c9c9; /* Default empty star color */
            --font-size: 14px; /* Default font size */
          }
  
          .star-rating {
            display: inline-flex;
            cursor: ${this.editable ? "pointer" : "default"};
          }
          .star {
            font-size: 14px;
            transition: color 0.2s ease-in-out;
            cursor: inherit;
          }
            
        </style>
      `;

        // Font Awesome CDN link for Shadow DOM
        const fontAwesomeLink = `
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
      `;

        // Generate stars
        const stars = Array.from({ length: this.max }, (_, i) => {
            const isFilled = i + 1 <= Math.floor(this.value);
            const isHalf = i + 1 > this.value && i + 1 - 1 < this.value;
            const className = isFilled ? "fa-solid fa-star" : isHalf ? "fa-regular fa-star-half-stroke" : "fa-regular fa-star";
            return `<i class="star ${className}" data-value="${i + 1}"></i>`;
        }).join("");

        // Template
        this.shadowRoot.innerHTML = `
        ${fontAwesomeLink}
        ${style}
        <div class="star-rating">
          ${stars}
        </div>
      `;

        // Apply the correct colors based on value, even if not editable
        this.applyStarColors();

        if (this.editable) {
            this.attachEventListeners();
        }
    }

    attachEventListeners() {
        const stars = this.shadowRoot.querySelectorAll(".star");

        // Hover effect
        stars.forEach((star) => {
            star.addEventListener("mouseover", () => {
                const value = parseInt(star.dataset.value, 10);
                this.highlightStars(value);
            });

            star.addEventListener("mouseout", () => {
                this.highlightStars(this.value);
            });

            // Click to set value
            star.addEventListener("click", () => {
                this.value = parseInt(star.dataset.value, 10);
                this.dispatchEvent(
                    new CustomEvent("change", {
                        detail: { value: this.value },
                        bubbles: true,
                        composed: true,
                    })
                );
                this.render();
            });
        });
    }

    highlightStars(value) {
        const stars = this.shadowRoot.querySelectorAll(".star");
        stars.forEach((star, index) => {
            const isFilled = index < value;
            const isHalf = !isFilled && index + 1 > value && index + 1 - 0.5 <= value;
            const fullStarColor = this.getCSSVariableValue('--full-star-color');
            const halfStarColor = this.getCSSVariableValue('--half-star-color');
            const emptyStarColor = this.getCSSVariableValue('--empty-star-color');

            star.style.fontSize = this.getCSSVariableValue('--font-size');

            if (isFilled) {
                star.className = "star fa-solid fa-star";
                star.style.color = fullStarColor;
            } else if (isHalf) {
                star.className = "star fa-regular fa-star-half-stroke";
                star.style.color = halfStarColor;
            } else {
                star.className = "star fa-regular fa-star";
                star.style.color = emptyStarColor;
            }
        });
    }

    // Function to get CSS variable values from the Shadow DOM
    getCSSVariableValue(variable) {
        const style = getComputedStyle(this.shadowRoot.host);
        return style.getPropertyValue(variable).trim() || "#FFD43B";  // Default fallback color if not set
    }

    // Apply the colors based on value, even when not editable
    applyStarColors() {
        const stars = this.shadowRoot.querySelectorAll(".star");
        stars.forEach((star, index) => {
            const isFilled = index < Math.floor(this.value);
            const isHalf = !isFilled && index + 1 > this.value && index + 1 - 0.5 <= this.value;
            const fullStarColor = this.getCSSVariableValue('--full-star-color');
            const halfStarColor = this.getCSSVariableValue('--half-star-color');
            const emptyStarColor = this.getCSSVariableValue('--empty-star-color');

            star.style.fontSize = this.getCSSVariableValue('--font-size');

            if (isFilled) {
                star.className = "star fa-solid fa-star";
                star.style.color = fullStarColor;
            } else if (isHalf) {
                star.className = "star fa-regular fa-star-half-stroke";
                star.style.color = halfStarColor;
            } else {
                star.className = "star fa-regular fa-star";
                star.style.color = emptyStarColor;
            }
        });
    }

    static get observedAttributes() {
        return ["value", "editable"];
    }

    attributeChangedCallback(name, oldValue, newValue) {
        if (name === "value") {
            this.value = parseFloat(newValue) || 0;
            this.render();
        } else if (name === "editable") {
            this.editable = newValue === "true";
            this.render();
        }
    }
}

// Define the custom element
customElements.define("star-rating", StarRating);
