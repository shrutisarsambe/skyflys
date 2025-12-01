// run after page load
document.addEventListener("DOMContentLoaded", function () {
  // -------- HOME PAGE SEARCH FORM --------
  const homeSearchForm = document.querySelector(".hero .search-form");
  if (homeSearchForm) {
    homeSearchForm.addEventListener("submit", function (e) {
      const inputs = homeSearchForm.querySelectorAll("input");
      const from = inputs[0].value.trim();
      const to = inputs[1].value.trim();
      const date = inputs[2].value;

      if (!from || !to || !date) {
        e.preventDefault();
        alert("Please enter FROM city, TO city and DATE before searching.");
      }
    });
  }

  // -------- BOOKING FORM --------
  const bookingForm = document.querySelector(".booking-card form");
  if (bookingForm) {
    bookingForm.addEventListener("submit", function (e) {
      const name = bookingForm.querySelector('input[type="text"]').value.trim();
      const email = bookingForm.querySelector('input[type="email"]').value.trim();
      const phone = bookingForm.querySelector('input[type="tel"]').value.trim();

      if (!name || !email || !phone) {
        e.preventDefault();
        alert("Please fill passenger name, email and phone.");
      }
    });
  }

  // -------- PASSENGER LOGIN FORM --------
  const passengerLoginForm = document.querySelector(".login-card form");
  if (passengerLoginForm) {
    passengerLoginForm.addEventListener("submit", function (e) {
      const email = passengerLoginForm.querySelector('input[type="email"]').value.trim();
      const password = passengerLoginForm.querySelector('input[type="password"]').value.trim();

      if (!email || !password) {
        e.preventDefault();
        alert("Please enter email and password to login.");
      }
    });
  }

  // -------- ADMIN LOGIN FORM --------
  const adminLoginForm = document.querySelector(".admin-card form");
  if (adminLoginForm) {
    adminLoginForm.addEventListener("submit", function (e) {
      const user = adminLoginForm.querySelector('input[type="text"]').value.trim();
      const pass = adminLoginForm.querySelector('input[type="password"]').value.trim();

      if (!user || !pass) {
        e.preventDefault();
        alert("Please enter admin username and password.");
      }
    });
  }
});