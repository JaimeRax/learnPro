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
        element.classList.toggle("activo", i === index) // Asegúrate de usar la clase 'activo' para la sección visible
      }
    })
  }

  document.querySelectorAll(".next-btn").forEach((button) => {
    button.addEventListener("click", () => {
      if (validateSection(currentStep + 1)) {
        // Validar antes de avanzar
        if (currentStep < steps.length - 1) {
          currentStep++
          showStep(currentStep)
        }
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

function validateSection(sectionNumber) {
  let isValid = true

  // Ocultamos todos los mensajes de error primero
  document.querySelectorAll(".error-message").forEach(function (msg) {
    msg.style.display = "none"
  })

  // Revisamos todos los campos obligatorios en la sección correspondiente
  let requiredFields = document.querySelectorAll(
    `#step-${sectionNumber} input[required], #step-${sectionNumber} select[required]`,
  )
  requiredFields.forEach(function (field) {
    if (!field.value) {
      isValid = false
      let errorMessage = document.getElementById(`${field.id}_error`)
      if (errorMessage) {
        errorMessage.style.display = "block" // Mostrar mensaje de error
      }
    }
  })

  // Si no hay errores, avanzar a la siguiente sección
  if (isValid) {
    // Encuentra el siguiente paso y muéstralo
    let nextStep = document.querySelector(
      `[data-next-step="step-${sectionNumber + 1}"]`,
    )
    if (nextStep) {
      nextStep.closest(".steps").classList.remove("activo") // Ocultar la sección actual
      document
        .getElementById(`step-${sectionNumber + 1}`)
        .classList.add("activo") // Mostrar la siguiente sección
    }
  }

  return isValid
}
