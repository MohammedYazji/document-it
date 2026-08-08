import "./echo";

const userId = document.head
    .querySelector('meta[name="user-id"]')
    ?.getAttribute("content");

if (userId) {
    window.Echo.private(`App.Models.User.${userId}`).notification(
        (notification) => {
            const badge = document.querySelector("[data-unread-badge]");
            if (badge) {
                badge.classList.remove("hidden");
            }
        },
    );
}
