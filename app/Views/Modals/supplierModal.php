<div class="modal fade" id="supplierModal" aria-hidden="true" aria-labelledby="exampleModalLabel"  tabindex="-1" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Επιλογή Προμηθευτή</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">

                <div class="input-group">
                    <input type="text" class="form-control form-control-lg" autocomplete="off"  id="supplierName" name="supplierName" placeholder="'Ονομα νέου προμηθευτή" aria-label="'Ονομα νέου προμηθευτή" aria-describedby="button-addon2">
                    <div class="position-absolute invisible z-index-4 mt-5" id="supplierAutocompleteList" ></div>
                    <button class="btn btn-secondary btn-add" type="button">Προσθήκη</button>

                </div>

                <div class="mt-3">
                    Λίστα Προμηθευτών
                    <ul class="dropdown-menu mt-1 py-0 sortable" style="display: block;position: static;min-width: 10rem;list-style: none;height: 500px; overflow: auto">
                    </ul>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Έξοδος</button>
            </div>
        </div>
    </div>
</div>