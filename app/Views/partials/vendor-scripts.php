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
    function loadQuestionalSwal(
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

                        if (response.isRedirect === true && response.redirectUrl) {
                            window.location.href = response.redirectUrl;
                        }

                        if (response.printData) {
                            console.log(response.printData, 'PRINT DATA');
                            // fetchEscposLogo().then(escposLogo => {
                            //     var receiptText = generatePlainTextReceipt(
                            //         response.printData.dataTransaksi,
                            //         response.printData.detailTransaksi,
                            //         response.printData.detailBayar,
                            //         escposLogo
                            //     );
                            //     BtPrint(receiptText);
                            // }).catch(error => {
                            //     console.error("Failed to load logo:", error);
                            // });
                            var receiptText = generatePlainTextReceipt(
                                response.printData.dataTransaksi,
                                response.printData.detailTransaksi,
                                response.printData.detailBayar
                            );
                            BtPrint(receiptText);
                            // BtPrint("Hello, World!");
                        }
                        
                    });
                }, 'json');
            }
        });
    }

    // swall  with form data
    function loadQuestionalSwalFormData(
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

    // swall loader
    function loadQuestionalSwalResetElement(
        path, data, title1, title2, text2, modalToHide="", isResetElement=true
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

                        if (isResetElement === true) {
                            resetTheseElement();
                        }

                        if (response.isRedirect === true && response.redirectUrl) {
                            window.location.href = response.redirectUrl;
                        }

                        if (response.printData) {
                            console.log(response.printData, 'PRINT DATA');
                            // fetchEscposLogo().then(escposLogo => {
                            //     var receiptText = generatePlainTextReceipt(
                            //         response.printData.dataTransaksi,
                            //         response.printData.detailTransaksi,
                            //         response.printData.detailBayar,
                            //         escposLogo
                            //     );
                            //     BtPrint(receiptText);
                            // }).catch(error => {
                            //     console.error("Failed to load logo:", error);
                            // });
                            var receiptText = generatePlainTextReceipt(
                                response.printData.dataTransaksi,
                                response.printData.detailTransaksi,
                                response.printData.detailBayar
                            );
                            BtPrint(receiptText);
                            // BtPrint("Hello, World!");
                        }
                        
                    });
                }, 'json');
            }
        });
    }

    // swall with error
    function loadQuestionalSwalWithError(
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
                    if (response.success) {
                        Swal.fire({
                            title: title2,
                            icon: 'success',
                            text: text2,
                            timer: 1000,
                            confirmButtonColor: "#5664d2"
                        }).then((result) => {
                            if(modalToHide !== ""){
                                $('#'+modalToHide).modal('hide');   
                            }

                            if(isTableReload === true){
                                mainDatatable();
                            }

                            if(isPageReload === true){
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            title: response.message_title,
                            icon: 'error',
                            text: response.message,
                            confirmButtonColor: "#d33"
                        });
                    }
                }, 'json').fail(function() {
                    Swal.fire({
                        title: 'Error',
                        icon: 'error',
                        text: 'An unexpected error occurred while processing the request.',
                        confirmButtonColor: "#d33"
                    });
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

    function ajax_print(url, btn) {
        $.get(url, function (data) {
            var ua = navigator.userAgent.toLowerCase();
            var isAndroid = ua.indexOf("android") > -1;
            if (isAndroid) {
                android_print(data);
            } else {
                pc_print(data);
            }
        });
    }

    function android_print(data) {
        // Android specific printing logic
        window.location.href = data;
    }

    function pc_print(data) {
        var socket = new WebSocket("ws://127.0.0.1:40213/");
        socket.binaryType = "arraybuffer";  // Fixed typo: bufferType -> binaryType
        socket.onerror = function(error) {
            alert("Error connecting to WebSocket");
        };
        socket.onopen = function() {
            socket.send(data);
            socket.close(1000, "Work complete");
        };
    }

    function BtPrint(prn) {
        var S = "#Intent;scheme=rawbt;";
        var P =  "package=ru.a402d.rawbtprinter;end;";
        var textEncoded = encodeURI(prn);
        window.location.href = "intent:" + textEncoded + S + P;
    }

    function generatePlainTextReceipt(dataTransaksi=[], detailTransaksi=[], detailBayar=[]) {
        let receipt = "";

        receipt += "           Cocodream\n\n";
        receipt += `${dataTransaksi[0].entitas_address}\nKota Pekanbaru, Riau 28289\nTelepon: +62 ${dataTransaksi[0].entitas_phone}\n`;
        receipt += "-------------------------------\n";
        receipt += `Invoice: ${dataTransaksi[0].no_invoice}\n`;
        receipt += `Waktu: ${formatDateTime(dataTransaksi[0].transaction_date)}\n`;
        receipt += "-------------------------------\n";

        detailTransaksi.forEach(item => {
            receipt += `${item.nama_item}\n`;
            receipt += `  ${item.quantity} ${item.nama_satuan} x Rp. ${thousand_separator(item.subtotal)}\n`;
        });

        receipt += "-------------------------------\n";
        receipt += `Total: Rp. ${thousand_separator(detailBayar[0].nominal_awal)}\n`;
        receipt += `Diskon: Rp. ${thousand_separator(detailBayar[0].diskon_tambahan)}\n`;
        receipt += `Tunai: Rp. ${thousand_separator(detailBayar[0].nominal_bayar)}\n`;
        receipt += `Kembali: Rp. ${thousand_separator(detailBayar[0].nominal_kembalian)}\n`;
        receipt += "-------------------------------\n";
        receipt += "Terima kasih atas kunjungan Anda\n";
        receipt += "Tiktok: cocodream_pku\n";
        receipt += "Instagram: almeiradeganjelly\n\n";

        return receipt;
    }

    function thousand_separator(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function formatDateTime(dateTimeStr) {
        const date = new Date(dateTimeStr);
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        const seconds = String(date.getSeconds()).padStart(2, '0');

        return `${day}-${month}-${year} ${hours}:${minutes}:${seconds}`;
    }

    function fetchEscposLogo() {
        return fetch('<?= base_url('get-logo-escpos') ?>') // Change this to your actual route
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    throw new Error(data.error);
                }
                return atob(data.escposLogo); // Decode base64 to binary string
            });
    }

    function resetElement(selectors) {
        if (!Array.isArray(selectors)) {
            selectors = [selectors];
        }
        selectors.forEach(function(selector) {
            var element = $(selector);
            if (element.is('input, textarea')) {
                element.val(''); // Reset the value of input or textarea
            } else {
                element.empty(); // Clear the contents of other elements
            }
        });
    }

    // thousand separator set
    function addThousandSeparator(value) {
        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    function keepOnlyNumbers(input) {
        return input.replace(/[^0-9]/g, '');
    }

    function formatThousand(value) {
        // Convert the number to a string
        let valueStr = value.toString();

        // Split the number into integer and decimal parts
        let parts = valueStr.split('.');

        // Format integer part with periods
        let integerPart = parts[0];
        let formattedInteger = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

        // Join back the decimal part with a comma if it exists
        return parts.length > 1 ? formattedInteger + ',' + parts[1] : formattedInteger;
    }

    function formatNumber(input) {
        input.value = input.value.replace(/[^0-9,]/g, '');
        // Remove all periods to handle changes correctly
        let value = input.value.replace(/\./g, '');

        // Split the number into integer and decimal parts
        let parts = value.split(',');

        // Format integer part with periods
        let integerPart = parts[0];
        let formattedInteger = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

        // Join back the decimal part if it exists
        input.value = parts.length > 1 ? formattedInteger + ',' + parts[1] : formattedInteger;
    }

    function getRawNumber(formattedValue) {
        let valueStr = formattedValue.toString();
        // Remove all periods to extract the raw number
        let rawValue = valueStr.replace(/\./g, '');

        // Convert to number
        return Number(rawValue.replace(',', '.')); // Handle decimal point if any
    }

</script>
