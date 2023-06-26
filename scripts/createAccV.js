// This block will run when the DOM is loaded (once elements exist), it's really only necessary as a IE 9 fallback for lack of support for defer
window.addEventListener("DOMContentLoaded", () => {

const registerForm = document.querySelector("#register");

registerForm.addEventListener("submit", (ev) => { 

//declare a boolean flag valid set to false for determining if there were any errors found below
    let error = false;

    const username = document.querySelector("input[name='username']");
    const firstname = document.querySelector("input[name='firstname']");
    const lastname = document.querySelector("input[name='lastname']");
    const email = document.querySelector("input[name='emailaddress']");
    const password = document.querySelector("input[name='passwd']");
    const Vpassword = document.querySelector("input[name='passwdv']");

    const userError =  username.nextElementSibling;
    const firstError =  firstname.nextElementSibling;
    const lastError =  lastname.nextElementSibling;
    const emailError =  email.nextElementSibling;
    const passError =  password.nextElementSibling;
    const VpassError =  Vpassword.nextElementSibling;

        // Vaildate User name 

        if (username.value.length < 1 ) {

            userError.classList.remove("hidden");
            userError.classList.add("error");
            error = true;
        }  else {
            userError.classList.add("hidden");
            userError.classList.remove("error");
        }

        // Vaildate first  name 
        if (firstname.value.length < 1 ) {

            firstError.classList.remove("hidden");
            firstError.classList.add("error");
            error = true;
        }  else {
            firstError.classList.add("hidden");
            firstError.classList.remove("error");
        }

        // Vaildate last  name 
        if (lastname.value.length < 1 ) {

                lastError.classList.remove("hidden");
                lastError.classList.add("error");
                error = true;
        }  else {
                lastError.classList.add("hidden");
                lastError.classList.remove("error");
        }

        // Vaildate email name 
        if (email.value.length < 1 ) {

            emailError.classList.remove("hidden");
            emailError.classList.add("error");
            error = true;
        }  else {
            emailError.classList.add("hidden");
                emailError.classList.remove("error");
        }

        // Vaildate password 
        if (password.value.length < 1 ) {

            passError.classList.remove("hidden");
            passError.classList.add("error");
            error = true;
        }  else {
            passError.classList.add("hidden");
            passError.classList.remove("error");
        }

        // Vaildate confirm password
        if (password.value != Vpassword.value || Vpassword.value.length < 1 ) {

            VpassError.classList.remove("hidden");
            VpassError.classList.add("error");
            error = true;
        }  else {
            VpassError.classList.add("hidden");
            VpassError.classList.remove("error");
        }

   if (error) {
    ev.preventDefault(); //STOP FORM SUBMISSION IF THERE ARE ERRORS
     }

});

});
