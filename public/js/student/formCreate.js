function toggleComentario(selectElement) {
  // Obtener el div 'comentario' relacionado con el select
  var comentarioGroup = selectElement.closest(".group").nextElementSibling

  if (selectElement.value === "OTROS") {
    comentarioGroup.style.display = "block"
  } else {
    comentarioGroup.style.display = "none"
  }
}

document.addEventListener("DOMContentLoaded", function () {
  const steps = ["step-1", "step-2", "step-3", "step-4"]
  let currentStep = 0

  function showStep(index) {
    steps.forEach((step, i) => {
      const element = document.getElementById(step)
      if (element) {
        element.classList.toggle("hidden", i !== index)
      }
    })
  }

  document.querySelectorAll(".next-btn").forEach((button) => {
    button.addEventListener("click", () => {
      if (currentStep < steps.length - 1) {
        currentStep++
        showStep(currentStep)
      }
    })
  })

  document.querySelectorAll(".prev-btn").forEach((button) => {
    button.addEventListener("click", () => {
      if (currentStep > 0) {
        currentStep--
        showStep(currentStep)
      }
    })
  })

  showStep(currentStep) // Muestra el primer paso al cargar la página
})
