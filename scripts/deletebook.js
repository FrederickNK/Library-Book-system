// This block will run when the DOM is loaded (once elements exist), it's really only necessary as a IE 9 fallback for lack of support for defer
window.addEventListener("DOMContentLoaded", () => {
const deleteButton = document.querySelectorAll("a[href*='deletebook.php']");

deleteButton.forEach(button => {
    button.addEventListener("click", event => {
        const confirmDelete = confirm("Are you sure you want to delete this book?");
        if (!confirmDelete) {
            event.preventDefault();
        }
    });
});

});

