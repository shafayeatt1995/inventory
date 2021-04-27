<!-- Jquery Core Js -->
<script src="{{ asset('public/backend/plugins/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap Core Js -->
<script src="{{ asset('public/backend/plugins/bootstrap/js/bootstrap.js') }}"></script>

<!-- Slimscroll Plugin Js -->
<script src="{{ asset('public/backend/plugins/jquery-slimscroll/jquery.slimscroll.js') }}"></script>

<!-- Waves Effect Plugin Js -->
<script src="{{ asset('public/backend/plugins/node-waves/waves.js') }}"></script>

<!-- Custom Js -->
<script src="{{ asset('public/backend/js/admin.js') }}"></script>

<script src="{{ asset('public/backend/js/sweet-aleart.js') }}"></script>

<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    @if($errors->any())
        @foreach($errors->all()  as $error)
            Toast.fire({
                icon: 'error',
                title: '{{$error}}'
            });
        @endforeach
    @endif
    @if (session('success'))
        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}',
        });
    @endif
    @if (session('error'))
        Toast.fire({
            icon: 'error',
            title: '{{ session('error') }}',
        });
    @endif
</script>


