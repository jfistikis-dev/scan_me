<div class="modal fade" id="brandModal" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Επιλογή Μάρκας</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">

                <div class="input-group">
                    <input type="text" class="form-control form-control-lg" autocomplete="off" id="brandName" placeholder="'Ονομα νέας μάρκας" aria-label="'Ονομα νέας μάρκας" aria-describedby="button-addon2">
                    <div class="position-absolute invisible z-index-4 mt-5" id="brandAutocompleteList" ></div>
                    <button class="btn btn-secondary btn-add" type="button">Προσθήκη</button>

                </div>

                <div class="mt-3">
                    Λίστα με Mάρκες
                    <ul class="dropdown-menu mt-1 py-0 sortable" style="display: block;position: static;min-width: 10rem;list-style: none;height: 300px; overflow: auto">
                    </ul>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Έξοδος</button>
            </div>
        </div>
    </div>
</div>
