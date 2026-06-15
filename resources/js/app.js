import "./echo";

const userId = document.head
    .querySelector('meta[name="user-id"]')
    ?.getAttribute("content");

if (userId) {
    window.Echo.private(`App.Models.User.${userId}`).notification(
        (notification) => {
            const unreadBadge = document.querySelector("[data-unread-badge]");
            if (unreadBadge) {
                const count = parseInt(unreadBadge.textContent) + 1;
                unreadBadge.textContent = count > 9 ? "9+" : count;
                unreadBadge.classList.remove("hidden");
            }
        },
    );
}
