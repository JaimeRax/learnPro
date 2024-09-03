// THEME STUFF
window.toggleTheme = function () {
  const inverted = getTheme(true)
  localStorage.setItem("current-theme", inverted)
}

window.getTheme = function (inverted) {
  let active = localStorage.getItem("current-theme") ?? "light"
  active = inverted ? (active === "light" ? "dark" : "light") : active
  return active
}

// GLOBAL EXPORTS
window.SlimSelect = SlimSelect
window.Swal = Swal

// GLOBAL EVENTS
document.addEventListener("DOMContentLoaded", function () {
  //theme logic
  const htmlNode = document.getElementsByTagName("html")
  const changer = document.getElementById("theme-changer")
  htmlNode[0].setAttribute("data-theme", getTheme())
  changer.setAttribute("value", getTheme(true))
  //theme logic end

  const maxSize = 5 * 1024 * 1024

  function validateFileSize(input) {
    const files = input.files

    if (!files) return

    for (const file of files) {
      if (file.size > maxSize) {
        alert(
          "Uno o mas archivos tienen un peso superior a 5MB, por favor comprimir el archivo",
        )
        input.value = ""
        break
      }
    }
  }
  // Seleccionar todos los inputs de tipo file y agregar el evento change
  const fileInputs = document.querySelectorAll('input[type="file"]')
  fileInputs.forEach((input) => {
    input.addEventListener("change", function () {
      validateFileSize(this)
    })
  })
})
