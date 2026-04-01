
/* ------- MAIN.JS – Velvia Web ------ */

/* ---- MENÚ LATERAL ---- */
const menuBtn = document.getElementById("menuBtn");
const sideMenu = document.getElementById("sideMenu");

if (menuBtn && sideMenu) {
  menuBtn.addEventListener("click", () => {
    sideMenu.classList.toggle("active");
  });
}

/* ---- REVEAL ANIMATION ---- */
document.addEventListener("DOMContentLoaded", function() {

  function reveal() {
    const reveals = document.querySelectorAll(".reveal");
    for (let i = 0; i < reveals.length; i++) {
      const windowHeight = window.innerHeight;
      const elementTop = reveals[i].getBoundingClientRect().top;
      const elementVisible = 150;

      if (elementTop < windowHeight - elementVisible) {
        reveals[i].classList.add("active");
      } else {
        reveals[i].classList.remove("active");
      }
    }
  }

  // Ejecutar al cargar y al hacer scroll
  window.addEventListener("scroll", reveal);
  reveal();

});

/* ---- POPUP NEWSLETTER / DESCUENTO ---- */
const popup = document.getElementById("newsletterPopup");
const closeBtn = document.querySelector(".close-btn");

if (popup && closeBtn) {

  let popupTriggered = false;

  // Mostrar popup al cargar después de 2s
  window.addEventListener("load", () => {
    if (!localStorage.getItem("popupShown")) {
      setTimeout(() => {
        popup.style.display = "flex";
      }, 2000);
    }
  });

  // Mostrar popup al detectar intención de salida (solo desktop)
  document.addEventListener("mouseout", function (e) {
    if (
      e.clientY < 10 &&
      !popupTriggered &&
      !localStorage.getItem("popupShown")
    ) {
      popup.style.display = "flex";
      popupTriggered = true;
    }
  });

  // Mostrar después de 40% de scroll (mobile-friendly)
  window.addEventListener("scroll", () => {
    const scrollPercent =
      (window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100;

    if (
      scrollPercent > 40 &&
      !popupTriggered &&
      !localStorage.getItem("popupShown")
    ) {
      popup.style.display = "flex";
      popupTriggered = true;
    }
  });

  // Cerrar popup
  closeBtn.addEventListener("click", () => {
    popup.style.display = "none";
    localStorage.setItem("popupShown", "true");
  });

  // Cerrar al hacer click fuera
  window.addEventListener("click", (e) => {
    if (e.target === popup) {
      popup.style.display = "none";
      localStorage.setItem("popupShown", "true");
    }
  });

}