import "./bootstrap";

// AJAX Like/Unlike functionality
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
