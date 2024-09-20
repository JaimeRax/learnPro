@if (session('message'))
    <script>
        swal("Éxito", "{{ session('message') }}", 'success', {
            button: true,
            button: "OK",
        });
    </script>
@endif

@if (session('error'))
    <script>
        swal("Error", "{{ session('error') }}", 'error', {
            button: true,
            button: "OK",
        });
    </script>
@endif
