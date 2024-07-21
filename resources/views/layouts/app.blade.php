<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('src/css/style.css') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>
    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- End Script SweetAlert -->

    <!-- Other scripts -->

    <!-- Script JavaScript SweetAlert -->
    <script>
        // Check if success message exists
        @if(session('success'))
            // Show success alert
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            });
        @endif

        @if(session('danger'))
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
        function confirmSubmit(form, text='Apakah anda yakin?') {
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
        async function printPDF(letter) {
          const element = document.querySelector('#my-pdf');
  
          if (!element) {
              console.error("Element not found");
              return;
          }
  
          html2canvas(element, { useCORS: true }).then(canvas => {
              const imgData = canvas.toDataURL('image/png');
              const { jsPDF } = window.jspdf;
              const doc = new jsPDF(letter);
  
              doc.addImage(imgData, 'PNG', 10, 10);
              const pdfUrl = doc.output('bloburl');
  
              // Open PDF in a new tab and print
              const printWindow = window.open(pdfUrl, '_blank');
              if (printWindow) {
                  printWindow.onload = function() {
                      printWindow.print();
                  };
              }
          }).catch(err => {
              console.error("Error generating PDF:", err);
          });
      }
    </script>
    <script src="{{ asset('/src/js/html2canvas.min.js') }}"></script>
    <script src="{{ asset('/src/js/jspdf.umd.min.js') }}"></script>
        
</body>
</html>
