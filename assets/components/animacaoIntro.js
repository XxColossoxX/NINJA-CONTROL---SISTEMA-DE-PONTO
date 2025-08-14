setTimeout(() => {
    document.getElementById("welcome-message").classList.add("hidden");

    document.getElementById("animacaoCena").classList.remove("hidden");
    document.getElementById("ninja-img").classList.add("ninja-image-animate");
}, 2000);

setTimeout(() => {
    document.getElementById("animacaoCena").classList.add("hidden");
    document.getElementById("login-system").classList.remove("hidden");
    document.getElementById("login-system2").classList.remove("hidden");
}, 4000);