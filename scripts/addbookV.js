// This block will run when the DOM is loaded (once elements exist), it's really only necessary as a IE 9 fallback for lack of support for defer
window.addEventListener("DOMContentLoaded", () => {

    const registerForm = document.querySelector("#Addbook_user");
    
    registerForm.addEventListener("submit", (ev) => { 
    
    //declare a boolean flag valid set to false for determining if there were any errors found below
        let error = false;

    const bookTitle = document.querySelector("input[name='bookTitle']");
    const bookAuthor = document.querySelector("input[name='bookAuthor']");
    const pubdata = document.querySelector("input[name='pubdata']");
    const isbn  = document.querySelector("input[name='isbn']");

    const bookTitleE = bookTitle.nextElementSibling;
    const bookAuthorE = bookAuthor.nextElementSibling;
    const pubdataE = pubdata.nextElementSibling;
    const isbnE  = isbn.nextElementSibling;


    // Vaildate book title
    if (bookTitle.value.length < 1 ) {

        bookTitleE.classList.remove("hidden");
        bookTitleE.classList.add("error");
        error = true;
    }  else {
        bookTitleE.classList.add("hidden");
        bookTitleE.classList.remove("error");
    }
    // Vaildate book author 

    if (bookAuthor.value.length < 1 ) {

        bookAuthorE.classList.remove("hidden");
        bookAuthorE.classList.add("error");
        error = true;
    }  else {
        bookAuthorE.classList.add("hidden");
        bookAuthorE.classList.remove("error");
    }
        // Vaildate data
    if (pubdata.value === '' ) {

        pubdataE.classList.remove("hidden");
        pubdataE.classList.add("error");
        error = true;
    }  else {
        pubdataE.classList.add("hidden");
        pubdataE.classList.remove("error");
    }

        // Vaildate ISBN 

    if (isbn.value.length < 10 ) {

        isbnE.classList.remove("hidden");
        isbnE.classList.add("error");
        error = true;
    }  else {
        isbnE.classList.add("hidden");
        isbnE.classList.remove("error");
    }
    if (error) {
        ev.preventDefault(); //STOP FORM SUBMISSION IF THERE ARE ERRORS
         }
    });

});