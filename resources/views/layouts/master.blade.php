<!DOCTYPE html>
<html>

@include('layouts.partial.header')

<body class="theme-red">
<!-- Top Bar -->
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="index.html">ADMINBSB - MATERIAL DESIGN</a>
        </div>
    </div>
</nav>
<!-- #Top Bar -->
@include('layouts.partial.sidebar')
</section>

<section class="content">
    <div class="container-fluid">
        @yield('content')
    </div>

</section>

@include('layouts.partial.footer')

@stack('js')

</body>

</html>
