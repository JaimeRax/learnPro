@props(['id', 'title' => 'Modal', 'bstyle' => '', 'closeButtonStyle' => 'btn'])

<!-- The button to open modal -->
<label for="{{ $id }}" class="btn {{ $bstyle }}">
    {{ $button }}
</label>

<!-- Put this part before </body> tag -->
<input type="checkbox" id="{{ $id }}" class="modal-toggle" />

<div class="modal" role="dialog">
    <div class="modal-box">
        <div
            style="background-color: #0284c7; color:white; text-align: center; border-top-left-radius: 10px; border-top-right-radius: 10px; height: 30px;">
            <h3 class="text-lg font-bold">{{ $title }}</h3>
        </div>
        <section id="modal-body-{{ $id }}">
            {{ $body }}
        </section>

        <div class="modal-action">
            @isset($footer)
                <section>
                    {{ $footer }}
                </section>
            @endisset

            <!-- Button to close modal -->
            <label for="{{ $id }}" style="background-color: #ef4444; color:white;"
                class="{{ $closeButtonStyle }}">
                Cerrar
            </label>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalToggle = document.getElementById('{{ $id }}');
        const modalBody = document.getElementById('modal-body-{{ $id }}');

        // Save the initial content of the modal
        const initialContent = modalBody.innerHTML;

        // Function to restore the initial content of the modal
        function restoreModalContent() {
            modalBody.innerHTML = initialContent;
        }

        // Listen for the checkbox (modal) change event
        modalToggle.addEventListener('change', function() {
            if (!modalToggle.checked) {
                // Modal is being closed, restore the initial content
                restoreModalContent();

            }
        });
    });
</script>
