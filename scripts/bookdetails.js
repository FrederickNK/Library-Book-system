// This block will run when the DOM is loaded (once elements exist), it's really only necessary as a IE 9 fallback for lack of support for defer
window.addEventListener("DOMContentLoaded", () => {

const detailsLink = document.querySelectorAll("a[href*='details.php']");

detailsLink.forEach(link => {
  link.addEventListener("click", event => {
    event.preventDefault();
    const bookDetailsUrl = event.target.getAttribute("href");
      
    // Creates a new <div> element and adds the 'modal-content' class to it and the close button.
    const modal = document.createElement("div");
    modal.classList.add("modal");
    const closeButton = document.createElement("button");
    closeButton.classList.add("close-button");
    closeButton.textContent = "Close";
    const modalContent = document.createElement("div");
    modalContent.classList.add("modal-content");

  // Creates a new <iframe> element and sets its 'src' attribute to the URL of the book details page.
    const iframe = document.createElement("iframe");
    iframe.src = bookDetailsUrl;

    // Appends the <iframe> and <button> elements to the <div> with the 'modal-content' class.
    modalContent.appendChild(iframe);
    modalContent.appendChild(closeButton);
    modal.appendChild(modalContent);
    document.body.appendChild(modal);

      // Adds an event listener to the 'closeButton' element that removes the modal 
    closeButton.addEventListener("click", () => {
      modal.remove();
    });
  });
});
});
