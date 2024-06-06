<!-- JAVASCRIPT -->
<script src="<?= base_url('assets/libs/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/libs/metismenu/metisMenu.min.js') ?>"></script>
<script src="<?= base_url('assets/libs/simplebar/simplebar.min.js') ?>"></script>
<script src="<?= base_url('assets/libs/node-waves/waves.min.js') ?>"></script>

<!-- Sweet Alerts js -->
<script src="<?= base_url('assets/libs/sweetalert2/sweetalert2.min.js') ?>"></script>

<!-- Sweet alert init js-->
<script src="<?= base_url('assets/js/pages/sweet-alerts.init.js') ?>"></script>

<!-- fontawesome icons init -->
<script src="<?= base_url('assets/js/pages/fontawesome.init.js') ?>"></script>

<!-- custome script -->
<script>
    // swall loader
    function loadQuestionalSwal_old(
        path, data, title1, title2, text2, modalToHide="", isTableReload=true, isPageReload=false
    ) {
        Swal.fire({
            title: title1,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then(function (result) {
            if (result.value) {
                $.post(path, data, function (response) {
                    Swal.fire({
                        title: title2,
                        icon: 'success',
                        text: text2,
                        timer: 1000,
                        confirmButtonColor: "#5664d2"
                    }).then((result) => {
                        if(modalToHide!==""){
                            $('#'+modalToHide).modal('hide');   
                        }

                        if(isTableReload === true){
                            mainDatatable();
                        }

                        if(isPageReload === true){
                            location.reload();
                        }
                        
                    });
                }, 'json');
            }
        });
    }

    function loadQuestionalSwal(
        path, data, title1, title2, text2, modalToHide = "", isTableReload = true, isPageReload = false
    ) {
        Swal.fire({
            title: title1,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            title: title2,
                            icon: 'success',
                            text: text2,
                            timer: 1000,
                            confirmButtonColor: "#5664d2"
                        }).then((result) => {
                            if (modalToHide !== "") {
                                $('#' + modalToHide).modal('hide');
                            }

                            if (isTableReload === true) {
                                mainDatatable();
                            }

                            if (isPageReload === true) {
                                location.reload();
                            }
                        });
                    },
                    dataType: 'json'
                });
            }
        });
    }

    // searchable dropdown initiator
    function setSearchableDropdown(id, minimumLength, path) {
        $('#' + id).select2({
            minimumInputLength: minimumLength,
            ajax: {
                url: path,
                delay: 250,
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    }

    // set input on select 
    function setInputBySelect(selectOptionId, inputId) {
        $('#' + selectOptionId).on('change', function() {
            // Get the selected option text
            var selectedOptionText = $(this).find('option:selected').text();
            
            // Update the value of the hidden input field with the selected option text
            $('#' + inputId).val(selectedOptionText);
        });
    }
    
    // clear fields value
    function clearFieldValue(fieldIds) {
        fieldIds.forEach(function(id) {
            $('#' + id).val('');
        });
    }

    // reset select 2
    function resetSelect2(id, defaultText) {
        $('#' + id).select2({
            data: [{ id: "", text: defaultText }],
        }).val("").trigger('change');
    }

    $(document).ready(function() {
        $('.num-only').on('input', function() {
            this.value = this.value.replace(/\D/g,'');
        });
    });

    // reset element content
    function resetElementValue(elementId) {
        $('#' + elementId).empty();
    }

    // thousand separator
    function thousandSeparator(number, decimalPlaces) {
        number = parseFloat(number);
        var formattedNumber = number.toFixed(decimalPlaces);

        formattedNumber = formattedNumber.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        // formattedNumber = formattedNumber.replace(".", ",");

        return formattedNumber;
    }

    function removeThousandSeparator(value) {
        // Remove both commas and dots from the string
        return value.replace(/[.]/g, '');
    }


</script>
