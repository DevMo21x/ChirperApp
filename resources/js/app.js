import "./bootstrap";

// ==========================================
// THEME TOGGLE FUNCTIONALITY
// ==========================================
document.addEventListener("DOMContentLoaded", function () {
    const themeToggle = document.getElementById("theme-toggle");
    const sunIcon = document.getElementById("sun-icon");
    const moonIcon = document.getElementById("moon-icon");
    const html = document.documentElement;

    const savedTheme = localStorage.getItem("theme") || "lofi";
    html.setAttribute("data-theme", savedTheme);
    updateIcons(savedTheme);

    if (themeToggle) {
        themeToggle.addEventListener("click", function () {
            const currentTheme = html.getAttribute("data-theme");
            const newTheme = currentTheme === "lofi" ? "dark" : "lofi";

            html.setAttribute("data-theme", newTheme);
            localStorage.setItem("theme", newTheme);
            updateIcons(newTheme);
        });
    }

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

                // Update button state
                this.dataset.liked = data.liked ? "true" : "false";

                // Update heart icon fill
                const heartIcon = this.querySelector("svg");
                if (heartIcon) {
                    heartIcon.setAttribute(
                        "fill",
                        data.liked ? "currentColor" : "none"
                    );
                }

                // Update like count
                container.querySelector(".like-count").textContent = data.count;
            } catch (error) {
                console.error("Error:", error);
            }
        });
    });
});

// ==========================================
// NEW: AJAX BOOKMARK FUNCTIONALITY
// ==========================================
document.addEventListener("DOMContentLoaded", function () {
    // Find all bookmark buttons on the page
    document.querySelectorAll(".bookmark-btn").forEach((button) => {
        // When a bookmark button is clicked...
        button.addEventListener("click", async function () {
            // Get the container and chirp ID
            const container = this.closest(".bookmark-container");
            const chirpId = container.dataset.chirpId;

            // Check if already bookmarked
            const isBookmarked = this.dataset.bookmarked === "true";

            // Set URL and method based on current state
            const url = `/chirps/${chirpId}/bookmark`;
            const method = isBookmarked ? "DELETE" : "POST";

            try {
                // Send AJAX request to server
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

                // Update button state
                this.dataset.bookmarked = data.bookmarked ? "true" : "false";

                // Update bookmark icon fill
                const bookmarkIcon = this.querySelector("svg");
                if (bookmarkIcon) {
                    bookmarkIcon.setAttribute(
                        "fill",
                        data.bookmarked ? "currentColor" : "none"
                    );
                }

                // Update button text
                const textSpan = this.querySelector(".bookmark-text");
                if (textSpan) {
                    textSpan.textContent = data.bookmarked ? "Saved" : "Save";
                }
            } catch (error) {
                console.error("Error:", error);
            }
        });
    });
});
