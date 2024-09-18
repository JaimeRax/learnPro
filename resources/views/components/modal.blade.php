@props(['id', 'title' => 'Modal', 'bstyle' => ''])



<!-- The button to open modal -->

<label for="{{ $id }}" class="btn {{ $bstyle }} bg-blue-600 text-white dark:hover:bg-blue-800">{{ $button }}</label>



<!-- Put this part before </body> tag -->

<input type="checkbox" id="{{ $id }}" class="modal-toggle " />

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

<label for="{{ $id }}" class="btn">Cerrar</label>

</div>

</div>

</div>
