<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/chartjs.min.js') }}"></script>

    <script src="{{ asset('js/app.js') }}" defer></script>

    <link href="{{ asset('css/select-2.min.css') }}" rel="stylesheet" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/tailwind.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('src/css/style.css') }}">
    <script defer src="{{ asset('js/alpine.min.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <style>
        .select2-container .select2-selection--single {
            height: 40px;
            /* Tailwind h-[40px] */
            padding: 0 12px;
            Tailwind px-3 border: 1px solid #e2e8f0;
            /* Tailwind border */
            border-radius: 0.375rem;
            /* Tailwind rounded-md */
            margin-top: 0.75rem;
            /* Tailwind mt-3 */
            /* margin-bottom: 1.25rem; Tailwind mb-5 */
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 70px;
            /* Slightly smaller to fit inside the select box */
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;
            /* Vertically center the text */
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #2E46BA;
            /* Tailwind bg-blue-500 */
            color: white;
            /* Tailwind text-white */
        }

        .select2-container--default .select2-results__option {
            padding: 0.5rem;
            Tailwind p-2
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding-left: 0.5rem;
            /* Tailwind pl-2 */
        }

        /* Media query for dynamic width */
        @media (max-width: 1024px) {
            .select2-container {
                width: 100% !important;
                /* Ensure full width on mobile and tablet */
            }
        }
    </style>
</head>

<body>
    <main>
        @yield('content')
    </main>

    <script src="{{ asset('js/sweetalert2.min.js') }}"></script>
    <!-- End Script SweetAlert -->

    <!-- Other scripts -->

    <!-- Script JavaScript SweetAlert -->
    <script>
        // Check if success message exists
        @if (session('success'))
            // Show success alert
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            });
        @endif

        @if (session('danger'))
            // Show success alert
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: '{{ session('danger') }}',
                showConfirmButton: false,
                timer: 1500
            });
        @endif
    </script>

    <script>
        function confirmSubmit(form, text = 'Apakah anda yakin?') {
            event.preventDefault();
            // Tampilkan SweetAlert konfirmasi
            Swal.fire({
                title: 'Konfirmasi',
                text: text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                } else {
                    return false;
                }
            });
            return false;
        }
    </script>
    <script>
        var fleetType = document.getElementById('fleet_type');
        var shipUuid = document.getElementById('ship_uuid');

        fleetType.addEventListener('change', function() {
            if (this.value === 'Kapal') {
                shipUuid.disabled = false;
            } else {
                shipUuid.disabled = true;
            }
        });
    </script>

    <script>
        function printPDF() {
            var printContents = document.getElementById('my-pdf').innerHTML;
            var originalContents = document.body.innerHTML;

            var printStyles = `
                <style>
                    @media print {
                       .body{
                            width: 100%;
                            height: 75%;
                            margin: 0;
                            padding: 0;
                            font-size: 12px; /* Adjust font size for better fit */
                            line-height: 1;
                            padding:30px;
                        }
                    }
                </style>
            `;

            document.body.innerHTML = printStyles + printContents;


            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select-2').select2()
            $('.select-2-tag').select2({
                tags: true,
            });
        });
    </script>
    <script>
        $('.select-inspection').change(function() {
            let name = $(this).val();
            let token = "{{ csrf_token() }}"

            $.ajax({
                method: "post",
                url: "{{ route('saveInspection') }}",
                data: {
                    _token: token,
                    name: name,
                },
                success: function(response) {

                    return true
                }
            })

        })
    </script>
    <script>
        $('.select-warehouse').change(function() {
            let name = $(this).val();
            let token = "{{ csrf_token() }}"

            $.ajax({
                method: "post",
                url: "{{ route('saveWarehouse') }}",
                data: {
                    _token: token,
                    name: name,
                },
                success: function(response) {

                    return true
                }
            })

        })
    </script>
    <script>
        $('.select-manager').change(function() {
            let name = $(this).val();
            let token = "{{ csrf_token() }}"

            $.ajax({
                method: "post",
                url: "{{ route('saveManager') }}",
                data: {
                    _token: token,
                    name: name,
                },
                success: function(response) {

                    return true
                }
            })

        })
    </script>
    <script>
        $('.select-disruption').change(function() {
            let name = $(this).val();
            let token = "{{ csrf_token() }}"

            $.ajax({
                method: "post",
                url: "{{ route('saveDisruption') }}",
                data: {
                    _token: token,
                    name: name,
                },
                success: function(response) {

                    return true
                }
            })

        })
    </script>
    @yield('scripts')
    <script src="{{ asset('js/select-2.min.js') }}"></script>
    <script src="{{ asset('js/html2pdf.min.js') }}"></script>


    <script>
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }
    </script>
</body>

</html>
