<script>
    let destinationasset = document.getElementById('destinationasset');
    let sourceasset = document.getElementById('sourceasset');
    let amount = document.getElementById('amount');
    let quatity = document.getElementById('quantity');
    // console.log(destinationasset);
    let loader = document.querySelector('#spinload');
    let swapbtn = document.querySelector('#swapbtn');
    var toastOptions = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    destinationasset.addEventListener('change', validate);
    sourceasset.addEventListener('change', validate);
    if (destinationasset.value == sourceasset.value) {
        Command: toastr["error"]("Source and Destination account cannot be thesame", "Error")
        toastr.options = toastOptions;
    }
    else {
        amount.placeholder = `Enter amount of ${sourceasset.value}`;
        quatity.placeholder = `Quantity of ${destinationasset.value}`;

    }

    function validate() {
        amount.value = '';
        quatity.value = '';
        if (destinationasset.value == sourceasset.value) {
            Command: toastr["error"]("Source and Destination account cannot be thesame", "Error")
            toastr.options = toastOptions;
        }
        else {
            amount.placeholder = `Enter amount of ${sourceasset.value}`;
            quatity.placeholder = `Quantity of ${destinationasset.value}`;

        }
    }

    amount.addEventListener('keyup', getQuantity);

    function getQuantity() {
        // remove class from loader
        loader.classList.remove('d-none');
        // disable swap button
        swapbtn.disabled = true;
        let uurl = "{{ url('/dashboard/asset-price/') }}" + '/' + sourceasset.value + '/' + destinationasset.value +
            '/' + amount.value;
        $.ajax({
            url: uurl,
            type: 'GET',

            success: function(response) {
                if (response.status === 200) {
                    quatity.value = response.data + ' ' + destinationasset.value;
                    document.getElementById('realquantity').value = response.data;
                    // add class to loader
                    loader.classList.add('d-none');
                    // enable swap button
                    swapbtn.disabled = false;
                }
            },
            error: function(error) {
                console.log(error);
                // add class to loader
                loader.classList.add('d-none');
                // enable swap button
                swapbtn.disabled = false;
            },

        });
    }

    document.getElementById('exchnageform').addEventListener('submit', exchangeNow)

    function exchangeNow(event) {
        // alert('hey');
        event.preventDefault();
        if (amount.value == '') {
            Command: toastr["error"]("Please Enter an Amount to Exchange", "Something went wrong")
            toastr.options = toastOptions;
        }
        else {
            $.ajax({
                url: "{{ route('exchangenow') }}",
                type: 'POST',
                data: $('#exchnageform').serialize(),
                success: function(response) {
                    if (response.status === 200) {
                        Command: toastr["success"](response.success, "Success")
                        toastr.options = toastOptions;

                        setTimeout(function() {
                            window.location.reload(true);
                        }, 3000);
                    }
                    else {
                        Command: toastr["error"](response.message, "Something went wrong")
                        toastr.options = toastOptions;
                    }
                },
                error: function(data) {
                    console.log(data);
                },

            });
        }
    };

    function getcurrbalance() {
        let usdelement = document.querySelectorAll('.usdelement');
        //console.log(usdelement);
        usdelement.forEach(element => {
            let coin = element.id;
            $.ajax({
                url: "{{ url('dashboard/balances/') }}" + '/' + coin,
                type: 'GET',
                success: function(response) {
                    element.textContent = "{{ $settings->currency }}" + response.data;
                },
                error: function(error) {
                    console.log(error);
                },
            });
        });
    }
    getcurrbalance();
    setTimeout(function() {
        getcurrbalance();
    }, 60000);
</script>
