console.log("MAIN JS CARGADO");

document.addEventListener("DOMContentLoaded", function () {
  /* ---- MENÚ LATERAL ---- */
  const menuBtn = document.getElementById("menuBtn");
  const sideMenu = document.getElementById("sideMenu");

  if (menuBtn && sideMenu) {
    menuBtn.addEventListener("click", function () {
      sideMenu.classList.toggle("active");
    });
  }

  /* ---- REVEAL ANIMATION ---- */
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

  window.addEventListener("scroll", reveal);
  reveal();

  /* ---- POPUP NEWSLETTER / DESCUENTO ---- */
  const popup = document.getElementById("newsletterPopup");
  const closeBtn = document.querySelector(".close-btn");

  if (popup && closeBtn) {
    let popupTriggered = false;

    window.addEventListener("load", function () {
      if (!localStorage.getItem("popupShown")) {
        setTimeout(function () {
          popup.style.display = "flex";
        }, 2000);
      }
    });

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

    window.addEventListener("scroll", function () {
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

    closeBtn.addEventListener("click", function () {
      popup.style.display = "none";
      localStorage.setItem("popupShown", "true");
    });

    window.addEventListener("click", function (e) {
      if (e.target === popup) {
        popup.style.display = "none";
        localStorage.setItem("popupShown", "true");
      }
    });
  }

  /* ---- MENÚ DESPLEGABLE DE USUARIO ---- */
  const userMenuBtn = document.getElementById("userMenuBtn");
  const userDropdown = document.getElementById("userDropdown");

  console.log("BTN:", userMenuBtn);
  console.log("DROPDOWN:", userDropdown);

  if (userMenuBtn && userDropdown) {
    userMenuBtn.addEventListener("click", function (e) {
      e.stopPropagation();
      console.log("click usuario");
      userDropdown.classList.toggle("show");
    });

    document.addEventListener("click", function (e) {
      if (!userMenuBtn.contains(e.target) && !userDropdown.contains(e.target)) {
        userDropdown.classList.remove("show");
      }
    });
  }
});
