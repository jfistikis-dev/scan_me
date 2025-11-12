<?=$this->extend("common/main")?>

<?=$this->section("content")?>
	
	
	<!-- HEADER TOP BLACK -->
	<div class="row navbar navbar-dark sticky-top bg-dark p-0 shadow">&nbsp;</div>
		
	<div class="p-3 g-3 " >

        <!-- Title & Exit buttons -->
        <div class="d-flex pb-2 justify-content-between position-relative" >

            <div class="display-5">
                <button class="btn btn-primary fs-3" type="button" data-bs-toggle="offcanvas" data-bs-backdrop="true" data-bs-target="#basketOffCanvas" aria-controls="basketOffCanvas">
                    <i class="bi bi-card-checklist" style="pointer-events: none;"></i>
                </button>
                - Προϊοντα
            </div>
            
            <div class="card border-0">
                <button onclick="location=window.location='<?= base_url(); ?>'" class="btn btn-primary mt-2 btn-lg gap-2 btn-exit" type="button">
                    <i class="bi bi-arrow-bar-left"></i> Έξοδος
                </button>
            </div>
        </div>
        
        <div class="border rounded row p-3">
            <!-- MAIN PANEL -->
            <div class="col-md-8 " >
                <div class="card mt-3 h-100 mh-100" > 
                    <div class="card-body" >
                    <div class="row mb-3">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="searchName" class="form-control" placeholder="Εύρεση από περιγραφής...">
                                        <button id="btnSearch" class="btn btn-primary btn-medium">Αναζήτηση</button>
                                        <button id="btnClear" class="btn btn-outline-secondary btn-medium">Καθάρισμός</button>
                                    </div>
                                </div>
                                <div class="col-md-4 text-end">
                                    <a id="exportBtn" class="btn btn-success btn-medium" href="#">Export to Excel</a>
                                </div>
                        </div>
                        <hr/>
                        <table id="productTable" class="table table-responsive display mb-2 fs-7" style="width:100%">
                            <thead>
                                <tr>
                                    <th data-data="id">ID</th>
                                    <th data-data="barcode">Barcode</th>
                                    <th data-data="description">Περιγραφή</th>
                                    <th data-data="stock">Στοκ</th>
                                    <th data-data="measuring_unit">Μ.Μέτρησης</th>
                                    <th data-data="reorder_quantity">Ποσ. αναπ/λιας</th>
                                    <th data-data="buying_price">Τιμή αγοράς</th>
                                    <th data-data="actions">Ενέργειες</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>		
                </div>
            </div>

            <!-- RIGHT PANEL -->
            <div class="col-md-4">

                <!-- Product Log -->
                <div class="card mt-3" >
                    <div class="card-body" >
                        <?= view("components/product_log", [
                        'url'       => base_url('products/ajaxBarcodeSearch/'),
                        'height'    => 'calc(100vh - 350px)'
                    ]) ?>
                    </div>
                        
                </div>

            
            </div>
        </div>

        <!-- Toast messages -->
		<?= $this->include('common/toast') ?>

    </div>



    <script>

        $(document).ready(function(){
            
            let barcode = '';
            let timer;
            
            var table = $('#productTable').DataTable({
                serverSide: true,
                processing: true,
                searching: false,
                ajax: {
                    url: '/products/ajaxList',
                    type: 'POST',
                    data: function(d){
                        // DataTables sends lots of params; we only need to attach name filter
                        d.search.value = $('#searchName').val();
                    }
                },
                columns: [
                    { data: 'id' },
                    { data: 'barcode' },
                    { data: 'description' },
                    { data: null, 
                        orderable: true,
                        searchable: false,
                        render: function(data, type, row){
                            return SFNumberFunctions._displayNumber(row.stock) ;
                        }
                    },
                    { data: 'measuring_unit' },
                    { data: null, 
                        orderable: true,
                        searchable: false,
                        render: function(data, type, row){
                            return SFNumberFunctions._displayNumber(row.reorder_quantity) ;
                        }
                    },
                    { data: null, 
                        orderable: true,
                        searchable: false,
                        render: function(data, type, row){
                            return SFNumberFunctions._displayNumber(row.buying_price) ;
                        }
                    },

                    {
                        data: null,
                        title: 'Ενέργειες',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row){
                            return `
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-danger btn-delete fs-7" data-id="${row.id}">Διαγραφή</button>
                                </div>
                            `;
                        }
                    }
                ],
                pageLength: 10,
                lengthMenu: [ 10, 25, 50, 100 ],
                order: [[0, 'desc']],
            });
                
            // Search button
            $('#btnSearch').on('click', function(){
                table.ajax.reload();
            });

            // Clear button
            $('#btnClear').on('click', function(){
                $('#searchName').val('');
                table.ajax.reload();
            });

            // Barcode scanner on search
            $(document).on('keydown', function(e) {
                // Reset timer if the user types/scans again soon
                clearTimeout(timer);

                // Check if key is Enter or Tab — scanner done
                if (e.key === 'Enter' || e.key === 'Tab') {
                    if (barcode.length > 3) { // avoid false triggers
                        
                        console.log('Scanned barcode:', barcode);
                        
                        $barcodeStr = barcode.substring (1);
                        $("#searchName").val($barcodeStr);
                        table.ajax.reload();
                    
                    }
                    barcode = '';
                    return;
                }

                // Ignore special keys
                if (e.key.length === 1) {
                    barcode += e.key;
                }

                // Reset if no key pressed for 100ms (manual typing cutoff)
                timer = setTimeout(() => barcode = '', 100);
            });
        
            // Export button
            $('#exportBtn').on('click', function(e){
                e.preventDefault();
                var s = $('#searchName').val();
                var url = '/products/export' + (s ? ('?search=' + encodeURIComponent(s)) : '');
                window.location.href = url;
            });

            // handle delete
            $('#productTable').on('click', '.btn-delete', function( event ){
                
                event.preventDefault();
                event.stopPropagation();

                var id = $(this).data('id');

                if (confirm('Είστε σίγουρος για αυτήν την διαγραφή ?')) {
                    $.ajax({
                        url: "<?= base_url ('/products' ) ?>/" + id,
                        type: 'POST',
                        data: { _method: 'DELETE' },
                        success: function(resp){
                            table.ajax.reload(null, false); // reload without resetting page
                            show_toast (resp.success, 'success');
                        },
                        error: function(){
                            show_toast ('Πρόβλημα με την διαγραφή του προϊόντος.', 'error');
                        }
                    });
                }
            });

            // handle product log
            $('#productTable').on('click', 'tr', function(){
                __ajaxGetProductLog ( $(this).find('td:eq(1)').text() );
            })


        });

    </script>



<?=$this->endSection()?>
