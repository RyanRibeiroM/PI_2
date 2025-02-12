const startupsSelect = document.getElementById("todos-startups");
const startupSelectContainer = document.getElementById("containerStartups");
startupSelectContainer.style.display = "none";

startupsSelect.addEventListener("change", function () {
  if (this.value === "sim") {
    startupSelectContainer.style.display = "none";
    document.querySelectorAll(".startup").forEach((startup) => {
      startup.setAttribute("checked", "checked");
    });
  } else {
    startupSelectContainer.style.display = "block";
    document.querySelectorAll(".startup").forEach((startup) => {
      startup.removeAttribute("checked");
    });
  }
});
