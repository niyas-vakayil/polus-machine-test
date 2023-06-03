<!DOCTYPE html>
<html>
<head>
    <title>Items</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Items</h1>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Tax</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->item }}</td>
                    <td>{{ $invoice->quantity }}</td>
                    <td>{{ $invoice->price }}</td>
                    <td>{{ $invoice->tax }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr>

    <h2>Add Item</h2>

    <form action="javascript:void(0)" class ="item-submit" method="POST">
        <!-- @csrf -->
        <label for="item">Item:</label>
        <input type="text" name="item" required>
        <br>
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" required min="1">
        <br>
        <label for="price">Price:</label>
        <input type="number" name="price" required min="0" step="0.01">
        <br>
        <label for="tax">Tax:</label>
        <select name="tax" required>
            <option value="0%">0%</option>
            <option value="1%">1%</option>
            <option value="5%">5%</option>
            <option value="10%">10%</option>
        </select>
        <br>
        <button type="submit">Add Invoice</button>
        <span class="text-danger" id="js-login-error"></span>
    </form>

    <hr>

    <a href="{{ route('invoices.show') }}">Generate Invoice</a>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<script>
    const STORE_URL= "{{route('invoices.store')}}";
    const DASHBOARD_URL= "{{route('list')}}";
    
$(function () {
        let validator = $('.item-submit').validate({
            rules: {
                item: {
                    required: true,
                },
                quantity: {
                    required: true,
                },
                price: {
                    required: true,
                },
                tax: {
                    required: true,
                },
            },
            messages: {
                item: {
                    required: 'item field is required',
                },
                quantity: {
                    required: 'quantity field is required',
                },
                price: {
                    required: 'price field is required',
                },
                tax: {
                    required: 'tax field is required',
                }
            },
            errorClass: "is-invalid text-danger",
    
            submitHandler: function (form, event) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });
                var data = $('.item-submit')[0];
                var form_data = new FormData(data);
                $.ajax({
                    url: STORE_URL,
                    method:'post',
                    data: form_data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (response) {
                        if (response['success'] == true) {
                            location.href = DASHBOARD_URL;
                        } else {
                            $('#js-login-error').html(response.message);
                        }
                    },
                    error: function (response) {
                        $('#js-login-error').html(response.responseJSON.message);
                    }
                })
            }
        }
        );

        
})
</script>
</html>