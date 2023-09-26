    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>


    <!-- Assets Plugins Datatables -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>


    <!-- export pdf -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>

    <script>
        function limitDigit(input) {
            if (input.value.length > 12) {
                input.value = input.value.slice(0, 12); // Menghapus digit ke-13 dan seterusnya
            }
        }



        $(document).ready(function() {
            var table = $('#table-gaji').DataTable({
                // dom: 'Bfrtip',
                buttons: [{
                    extend: 'pdf',
                    title: 'Data Gaji Karyawan PT Baroqah Tbk',
                    text: 'Export to PDF',
                    pageSize: 'Legal',
                    className: 'btn btn-success',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7]
                    }
                }]
            });

            $('#export-gaji-pdf').on('click', function() {
                table.button('.buttons-pdf').trigger();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var table = $('#table-karyawan').DataTable({
                // dom: 'Bfrtip',
                buttons: [{
                    extend: 'pdf',
                    title: 'Data Karyawan PT Baroqah Tbk',
                    text: 'Export to PDF',
                    pageSize: 'Legal',
                    className: 'btn btn-success',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5]
                    }
                }],
            });

            $('#export-karyawan-pdf').on('click', function() {
                table.button('.buttons-pdf').trigger();
            });
        });
    </script>



    </body>

    </html>