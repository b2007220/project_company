// document.addEventListener("DOMContentLoaded", function () {
//     document.querySelectorAll("form").forEach(function (form) {
//         form.addEventListener("submit", function (e) {
//             e.preventDefault();
//             const method = form.getAttribute("method");
//             const action = form.getAttribute("action");
//             const formData = new FormData(form);

//             fetch(action, {
//                 method: method,
//                 body: formData,
//                 headers: {
//                     "X-Requested-With": "XMLHttpRequest",
//                 },
//             })
//                 .then((response) => response.json())
//                 .then((data) => {
//                     console.log(data);
//                 })
//                 .catch((error) => {
//                     console.error("Error:", error);
//                 });
//         });
//     });
// });
