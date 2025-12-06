import "./bootstrap";

// THEME TOGGLE FUNCTIONALITY
document.addEventListener("DOMContentLoaded", function () {
    const themeToggle = document.getElementById("theme-toggle");
    const sunIcon = document.getElementById("sun-icon");
    const moonIcon = document.getElementById("moon-icon");
    const html = document.documentElement;

    // Get saved theme from localStorage or default to light
    const savedTheme = localStorage.getItem("theme") || "laravelChirper";
    html.setAttribute("data-theme", savedTheme);
    updateIcons(savedTheme);

    // Toggle theme when button is clicked
    if (themeToggle) {
        themeToggle.addEventListener("click", function () {
            const currentTheme = html.getAttribute("data-theme");
            const newTheme =
                currentTheme === "laravelChirper" ? "dark" : "laravelChirper";

            html.setAttribute("data-theme", newTheme);
            localStorage.setItem("theme", newTheme);
            updateIcons(newTheme);
        });
    }

    // Update icons based on current theme
    function updateIcons(theme) {
        if (sunIcon && moonIcon) {
            if (theme === "dark") {
                sunIcon.classList.remove("hidden");
                moonIcon.classList.add("hidden");
            } else {
                sunIcon.classList.add("hidden");
                moonIcon.classList.remove("hidden");
            }
        }
    }
});

// ==========================================
// AJAX LIKE/UNLIKE FUNCTIONALITY
// ==========================================
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".like-btn").forEach((button) => {
        button.addEventListener("click", async function () {
            const container = this.closest(".like-container");
            const chirpId = container.dataset.chirpId;
            const isLiked = this.dataset.liked === "true";

            const url = `/chirps/${chirpId}/like`;
            const method = isLiked ? "DELETE" : "POST";

            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                        Accept: "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                    },
                });

                const data = await response.json();

                // Update button text and state
                this.textContent = data.liked ? "Unlike" : "Like";
                this.dataset.liked = data.liked ? "true" : "false";

                // Update like count
                container.querySelector(
                    ".like-count"
                ).textContent = `${data.count} Likes`;
            } catch (error) {
                console.error("Error:", error);
            }
        });
    });
});
