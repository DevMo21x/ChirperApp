import "./bootstrap";


// THEME TOGGLE FUNCTIONALITY
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


// AJAX LIKE/UNLIKE FUNCTIONALITY

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

                // Update like text
                const likeText = this.querySelector(".like-text");
                if (likeText) {
                    likeText.textContent = data.liked ? "Liked" : "Like";
                }

                // Update like count - Search globally for containers with this chirp ID
                const chirpContainers = document.querySelectorAll(
                    `.like-container[data-chirp-id="${chirpId}"]`
                );

                chirpContainers.forEach((container) => {
                    const countSpan = container.querySelector(".like-count");
                    if (countSpan) {
                        const likeWord = data.count === 1 ? "like" : "likes";
                        countSpan.innerHTML = `
                            <svg class="w-3 h-3" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            ${data.count} ${likeWord}
                        `;
                    }
                });
            } catch (error) {
                console.error("Error:", error);
            }
        });
    });
});


// AJAX BOOKMARK FUNCTIONALITY

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".bookmark-btn").forEach((button) => {
        button.addEventListener("click", async function () {
            const container = this.closest(".bookmark-container");
            const chirpId = container.dataset.chirpId;
            const isBookmarked = this.dataset.bookmarked === "true";

            const url = `/chirps/${chirpId}/bookmark`;
            const method = isBookmarked ? "DELETE" : "POST";

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

                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }

                const data = await response.json();


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
