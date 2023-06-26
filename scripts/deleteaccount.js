
// This block will run when the DOM is loaded (once elements exist), it's really only necessary as a IE 9 fallback for lack of support for defer
window.addEventListener("DOMContentLoaded", () => {
// Get the delete button and add a click event listener to show the confirmation dialog
const deleteButton = document.getElementById("deletebutton");
deleteButton.addEventListener("click", function() {
  // Show the confirmation dialog with a message and two buttons, delete and cancel
  const confirmed = confirm("Are you sure you want to delete your account?");
  if (confirmed) {
    // If the user clicked delete, redirect to the delete account script
    window.location.href = "deleteaccount.php";
  }
});
});
