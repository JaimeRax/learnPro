@props(['id', 'title' => 'Modal', 'bstyle' => '', 'closeButtonStyle' => 'btn'])

<!-- The button to open modal -->
<label for="{{ $id }}" class="btn {{ $bstyle }}">
    {{ $button }}
</label>

<!-- Put this part before </body> tag -->
<input type="checkbox" id="{{ $id }}" class="modal-toggle" />

<div class="modal" role="dialog">
    <div class="modal-box">
        <h3 class="text-lg font-bold">{{ $title }}</h3>
        <section>
            {{ $body }}
        </section>

        <div class="modal-action">
            @isset($footer)
                <section>
                    {{ $footer }}
                </section>
            @endisset

            <!-- Button to close modal -->
            <label for="{{ $id }}" class="{{ $closeButtonStyle }}">
                Cerrar
            </label>
        </div>
    </div>
</div>
