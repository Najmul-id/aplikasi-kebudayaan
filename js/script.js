// Matikan scroll restoration browser
if (history.scrollRestoration) {
  history.scrollRestoration = "manual";
}

// Scroll ke atas saat load / refresh
window.onbeforeunload = function () {
  window.scrollTo(0, 0);
};

window.onload = function () {
  window.scrollTo({ top: 0, left: 0, behavior: "instant" });
};


/* ===============================
         SEARCH FILTER
         =============================== */
const searchInput = document.getElementById("searchInput");

if (searchInput) {
  searchInput.addEventListener("keyup", () => {
    const filter = searchInput.value.toLowerCase();
    const allCards = document.querySelectorAll(".budaya-card");

    allCards.forEach((card) => {
      const title = card.querySelector("h3")?.innerText.toLowerCase() || "";
      const desc = card.querySelector("p")?.innerText.toLowerCase() || "";

      if (title.includes(filter) || desc.includes(filter)) {
        card.style.display = "block";
      } else {
        card.style.display = "none";
      }
    });
  });
}

// ================= MODAL DETAIL =================
const detailModal = document.getElementById("detailModal");
const detailTitle = document.getElementById("detailTitle");
const detailRegion = document.getElementById("detailRegion");
const detailDesc = document.getElementById("detailDesc");

// Tambahkan elemen img di modal
let detailImg = document.createElement("img");
detailImg.style.width = "100%";
detailImg.style.height = "250px";
detailImg.style.objectFit = "cover";
detailImg.style.borderRadius = "10px";
detailImg.style.marginBottom = "15px";
document.querySelector(".modal-content").insertBefore(detailImg, detailTitle);

function showDetail(title, region, desc, imgUrl) {
  detailTitle.textContent = title;
  detailRegion.textContent = region;
  detailDesc.textContent = desc;
  if(imgUrl){
    detailImg.src = imgUrl;
    detailImg.style.display = "block";
  } else {
    detailImg.style.display = "none";
  }
  detailModal.style.display = "flex";
}

function closeDetail() {
  detailModal.style.display = "none";
}

// Tutup modal saat klik di luar konten
window.onclick = function(event) {
  if (event.target == detailModal) {
    closeDetail();
  }
};

function scrollReveal() {
  const reveals = document.querySelectorAll(".reveal");
  const windowHeight = window.innerHeight;
  const revealPoint = 120;

  reveals.forEach(el => {
    const elementTop = el.getBoundingClientRect().top;
    if (elementTop < windowHeight - revealPoint) {
      el.classList.add("active");
    }
  });
}

window.addEventListener("scroll", scrollReveal);
window.addEventListener("load", scrollReveal);


window.addEventListener("scroll", scrollReveal);
window.addEventListener("load", scrollReveal);
