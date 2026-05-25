import { Alpine } from "alpinejs";
import axios from "axios";

window.Alpine = Alpine;
Alpine.start();

window.axios = axios;
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

document.addEventListener("DOMContentLoaded", () => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (csrfToken) {
        axios.defaults.headers.common["X-CSRF-TOKEN"] = csrfToken.getAttribute("content");
    }

    const stepButtons = document.querySelectorAll("[data-step-button]");

    // "this" only works with normal functions, not with arrow functions
    stepButtons.forEach((button) => {
        button.addEventListener("click", async function (event) {
            const stepId = this.dataset.stepId;
            const stepState = this.dataset.stepState === '1';
            const newState = !stepState;
            const span = this.nextElementSibling;

            // Optimistically update the UI
            applyState(this, span, newState);

            try {
                const response = await axios.patch(`/steps/${stepId}`);
                const actualState = response.data.completed;
                this.dataset.stepState = actualState ? '1' : '0';

                // If the server state differs from our optimistic update, correct it
                if (actualState !== newState) {
                    applyState(this, span, actualState);
                }
            } catch (error) {
                applyState(this, span, stepState);
                console.error("Error updating step:", error);
            }
        });
    });

    function applyState(button, span, completed) {
        button.setAttribute('aria-checked', completed ? 'true' : 'false');
        button.classList.toggle('bg-primary', completed);
        button.classList.toggle('border', !completed);
        button.classList.toggle('border-primary', !completed);

        span.classList.toggle('line-through', completed);
        span.classList.toggle('text-muted-foreground', completed);
    }
});