function toggleComentario() {
    var select = document.getElementById("parentesco");
    var comentarioGroup = document.getElementById("comentario");

    if (select.value == "OTROS") { // "otros" tiene valor 9
        comentarioGroup.style.display = "block";
    } else {
        comentarioGroup.style.display = "none";
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const steps = ['step-1', 'step-2', 'step-3', 'step-4'];
    let currentStep = 0;

    function showStep(index) {
        steps.forEach((step, i) => {
            const element = document.getElementById(step);
            if (element) {
                element.classList.toggle('hidden', i !== index);
            }
        });
    }

    document.querySelectorAll('.next-btn').forEach(button => {
        button.addEventListener('click', () => {
            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            }
        });
    });

    document.querySelectorAll('.prev-btn').forEach(button => {
        button.addEventListener('click', () => {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });
    });

    showStep(currentStep); // Muestra el primer paso al cargar la página
});



function tipoAccionista() {
    const accionistaIndividual = document.getElementById('accionista_individual').checked;
    const accionistaEmpresarial = document.getElementById('accionista_empresarial').checked;

    const formEmpresarial = document.getElementById('form_empresarial');
    const contMonthlyIncome = document.getElementById('cont_monthly_income');
    const estado_cuenta_empresa = document.getElementById('estado_cuenta_empresa');
    const estado_cuenta = document.getElementById('estado_cuenta');
    const employmentStatus = document.getElementById('employment_status');

    if (accionistaEmpresarial) {
        formEmpresarial.classList.remove('invisible');
        contMonthlyIncome.classList.add('invisible');
        estado_cuenta_empresa.classList.remove('invisible');
        estado_cuenta.classList.add('invisible');
        employmentStatus.classList.add('invisible');
    } else if (accionistaIndividual) {
        formEmpresarial.classList.add('invisible');
        contMonthlyIncome.classList.remove('invisible');
        estado_cuenta_empresa.classList.add('invisible');
        estado_cuenta.classList.remove('invisible');
        employmentStatus.classList.remove('invisible');
    }
}

function mostrarDoc() {
    const docDpi = document.getElementById('doc_dpi').checked;
    const uno = document.getElementById('dorso');
    const codeSwift = document.getElementById('code_swift');
    const nit = document.getElementById('nit');

    if (docDpi) {
        uno.classList.remove('invisible');
        codeSwift.classList.remove('invisible');
        codeSwift.disabled = true;
        nit.disabled = false;
    } else {
        uno.classList.add('invisible');
        codeSwift.disabled = false;
        nit.disabled = true;
    }
}


function forma_juridica() {
    const specifyInput = document.getElementById('specify');
    if (document.getElementById('otra_forma_juridica').checked) {
        specifyInput.disabled = false;
    } else if (document.getElementById('sociedad_anonima').checked) {
        specifyInput.disabled = true;
    }
}

