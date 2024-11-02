function toggleComentario(selectElement) {
    // Obtener el nombre del campo seleccionado
    const selectedValue = selectElement.value;

    // Identificar el grupo de comentario específico basado en el atributo 'name'
    let commentGroup;
    switch (selectElement.name) {
        case 'charge_relationship':
            commentGroup = document.querySelector('.charge_comment');
            break;
        case 'charge_relationship_2':
            commentGroup = document.querySelector('.charge_comment_2');
            break;
        case 'charge_relationship_3':
            commentGroup = document.querySelector('.charge_comment_3');
            break;
    }

    // Mostrar o ocultar el campo "Especifique" según la opción seleccionada
    if (selectedValue === 'OTROS') {
        commentGroup.style.display = 'block';
    } else {
        commentGroup.style.display = 'none';
    }
}

// Ejecutar el script al cargar la página para verificar si algún campo está en "OTROS"
document.addEventListener('DOMContentLoaded', function() {
    // Obtener todos los selectores con clase "parentesco"
    const selectElements = document.querySelectorAll('.select.parentesco');

    selectElements.forEach(select => {
        toggleComentario(select);
    });
});


document.addEventListener("DOMContentLoaded", function() {
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
