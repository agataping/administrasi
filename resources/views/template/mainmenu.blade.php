<!DOCTYPE html>
<html lang="en">

@include('components.header')

<body>



        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            @include('components.navbar')
            <!-- Navbar End -->


            @yield('content')


            <!-- Footer Start -->
            @include('components.footer')
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
    </div>

    @include('components.script')

    @yield('scripts')
</body>

</html>
