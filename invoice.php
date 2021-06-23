<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/bootstrap4.5.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/request.js"></script>
    <script src="assets/js/common-scripts.js"></script>
</head>

<body>

    <div class="container-fluid">
    <br><?php include('menu.php');?>
        <div class="container mb-5">

            <div class="row shadow p-3 mb-5 bg-white rounded">
                <div class="col-md-12">
                    <h2>Invoice Manage</h2>
                </div>
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="20%" scope="col">Product</th>
                                <th width="20%" scope="col">Quantity</th>
                                <th width="20%" scope="col">Sub total</th>
                                <th width="10%" scope="col">Add more</th>
                            </tr>
                        </thead>
                        <tbody id="invoice">
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <select onchange="productSelect(this)" name="product[]" class="form-control">
                                            <option hidden value="0">Select Product</option>
                                            <option data-price="2380" value="1">Panjabi</option>
                                            <option data-price="1860" value="2">Shirt</option>
                                            <option data-price="530" value="3">T-Shirt</option>
                                            <option data-price="2650" value="4">Pent</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="price[]">
                                    <input type="hidden" name="quantity[]">
                                    <input type="hidden" name="sub_total[]">
                                </td>
                                <td>
                                    <button class="btn btn-xs border border-info inc-dec" type="button"
                                        onclick="countManage(1, this)">+</button>
                                    <span class="qty m-4">0</span>
                                    <button class="btn btn-xs border border-warning inc-dec" type="button"
                                        onclick="countManage(-1, this)">-</button>
                                </td>
                                <td class="subTotal">0</td>
                                <td>
                                    <button onclick="appendOrRemove(1, this)" type="button"
                                        class="btn btn-info btns">+</button>
                                    <button onclick="appendOrRemove(-1, this)" type="button"
                                        class="btn btn-danger btns minus">-</button>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="2"></th>
                                <th id="subTotal"></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <script>
        var subTotalContainer = document.querySelector('table #subTotal');
        // invoice manage
        function productSelect(select) {
            var tr = select.offsetParent.parentElement;
            var option = select.options[select.selectedIndex];
            var price = parseFloat(option.dataset.price);
            var inputs = tr.querySelectorAll('input');
            var data = [price, 1, price];
            inputs.forEach((input, i) => {
                input.value = data[i];
            });
            tr.querySelector('td .qty').textContent = 1;
            tr.querySelector('td.subTotal').textContent = price;
            totalCount();
        }

        function countManage(plusMinus, btn) {
            var tr = btn.offsetParent.parentElement;
            var select = tr.querySelector('select');
            var option = select.options[select.selectedIndex];
            var price = parseFloat(option.dataset.price);
            if (price && price > 0) {
                var inputs = tr.querySelectorAll('input');
                var quantityContainer = tr.querySelector('td .qty');
                var quantity = parseInt(quantityContainer.textContent);

                quantity = quantity + plusMinus;
                quantity = quantity > 0 ? quantity : 1;
                var subTotal = quantity * price;
                var data = [price, quantity, subTotal];
                inputs.forEach((input, i) => {
                    input.value = data[i];
                });
                quantityContainer.textContent = quantity;
                tr.querySelector('td.subTotal').textContent = subTotal;
            }
            totalCount();
        }

        function appendOrRemove(action, btn) {
            var tr = btn.offsetParent.parentElement;
            var rows = tr.offsetParent.querySelectorAll('tr');
            if (action > 0) {
                var newRow = tr.cloneNode(true)
                newRow.querySelector('select').value = 0;
                newRow.querySelector('td .qty').textContent = 0;
                newRow.querySelector('td.subTotal').textContent = 0;
                newRow.querySelectorAll('input').forEach(input => input.value = 0);

                rows[rows.length - 2].insertAdjacentElement('afterend', newRow)
            } else if (rows.length > 3) {
                tr.remove();
            }
            totalCount();
        }

        function totalCount() {
            subTotal = 0;
            document.querySelectorAll('input[name="sub_total[]"]').forEach(input => {
                subTotal += parseInt(input.value)
            });
            subTotalContainer.textContent = `Total: ${subTotal > 0 ? subTotal:0}`;
        }
    </script>
</body>
