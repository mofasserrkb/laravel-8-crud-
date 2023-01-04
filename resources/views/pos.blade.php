
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Mini Sales</title>

      <!-- Favicon -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
      </head>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <body class="  ">
<form method="POST" action="{{ route('pos.store') }}">
    @csrf
    <table id="items-table">
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    @php

                        $items = \App\Models\Item::all();
                        //dd($items);
                        $customers = \App\Models\Customer::all();
                    @endphp
                    <select name="item_ids[]" class="form-control item-select">
                        <option value="">Select an item</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="quantities[]" class="form-control item-quantity" min="1" />
                </td>
                <td class="item-price">0</td>
                <td>
                    <button type="button" class="btn btn-danger remove-row">Remove</button>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">
                    <button type="button" class="btn btn-primary add-row">Add Item</button>
                </td>
            </tr>
        </tfoot>
    </table>
    <div class="form-group">
        <label for="subtotal">Subtotal:</label>
        <input type="text" name="subtotal" id="subtotal" class="form-control" readonly />
    </div>
    <div class="form-group">
        <label for="total">Total:</label>
        <input type="text" name="total" id="total" class="form-control" readonly />
    </div>
    <label for="customer_id">Customer</label>
    <select name="customer_id" id="customer_id" class="form-control">
        @foreach($customers as $customer)
            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
        @endforeach
    </select>
    <label for="new_customer_name">New Customer</label>
    <input type="text" name="new_customer_name" id="new_customer_name" class="form-control" />
    <button type="submit"  class="btn btn-primary">Place Order</button>
</form>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    $(document).ready(function() {
        // Add a new row to the table when the "Add Item" button is clicked
        $('.add-row').click(function() {
            var row = '<tr>' +
                '<td>' +
                    '<select name="item_ids[]" class="form-control item-select">' +
                        '<option value="">Select an item</option>' +
                        '@foreach($items as $item)' +
                            '<option value="{{ $item->id }}">{{ $item->name }}</option>' +
                        '@endforeach' +
                    '</select>' +
                '</td>' +
                '<td>' +
                    '<input type="number" name="quantities[]" class="form-control item-quantity" min="1" />' +
                '</td>' +
                '<td class="item-price">0</td>' +
                '<td>' +
                    '<button type="button" class="btn btn-danger remove-row">Remove</button>' +
                '</td>' +
            '</tr>';
            $('#items-table tbody').append(row);
        });

        // Remove the selected row when the "Remove" button is clicked
        $('#items-table').on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
            calculateTotal();
        });

        // Calculate the item price when the item or quantity is changed
        $('#items-table').on('change', '.item-select, .item-quantity', function() {
            var row = $(this).closest('tr');
            var itemId = row.find('.item-select').val();
            var quantity = row.find('.item-quantity').val();
            if (itemId && quantity) {
                $.ajax({
                    url: "{{ route('pos.item_price') }}",
                    data: { item_id: itemId, quantity: quantity },
                    success: function(price) {
                        row.find('.item-price').text(price);
                        calculateTotal();
                    }
                });
            } else {
                row.find('.item-price').text('0');
                calculateTotal();
            }
        });

        // Calculate the total price
        function calculateTotal() {
            var subtotal = 0;
            $('#items-table tbody tr').each(function() {
                subtotal += parseFloat($(this).find('.item-price').text());
            });
            $('#subtotal').val(subtotal.toFixed(2));
            $('#total').val(subtotal.toFixed(2));
        }
    });
    function printInvoice() {
        window.print();
    }
</script>



</body>
</html>
