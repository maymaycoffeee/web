document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('container');
    const registerBtn = document.getElementById('register');
    const loginBtn = document.getElementById('login');

    
    if (registerBtn && loginBtn) {
        registerBtn.addEventListener('click', () => { 
            container.classList.add("active"); 
        });

        loginBtn.addEventListener('click', () => { 
            container.classList.remove("active"); 
        });
    }
});


function regresar() {
    window.location.href = 'maymay.html';
}
