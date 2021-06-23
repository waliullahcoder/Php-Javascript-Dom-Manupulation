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
    <script defer src="assets/js/common-scripts.js"></script>
</head>

<body>

    <div class="container-fluid">
    <br><?php include('menu.php');?>
        <div class="container mt-5">
            <div class="row shadow p-3 mb-5 bg-white rounded">
                <div class="col-md-10">
                    <h2>Calculation</h2>
                    <div class="row calculation-inputs">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" class="form-control validation first" data-validation="number"
                                    placeholder="number ...">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" class="form-control validation second" data-validation="number"
                                    placeholder="number ...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control validation operator"
                                    data-validation="math operation" placeholder="* / - +">
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <input type="number" readonly id="result">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        var calculationContainer = document.querySelector('.calculation-inputs');
        calculationContainer.addEventListener('keyup', calculation);

        function calculation() {
            var result = 0,
                letters = /^[a-zA-Z\s]+$/,
                numbers = /^[-+]?[0-9]+$/,
                first = this.querySelector('.first'),
                second = this.querySelector('.second'),
                operator = this.querySelector('.operator').value.trim(),
                resultContainer = this.querySelector('#result');

            first = first.value.match(numbers) ? parseFloat(first.value) : 0;
            second = second.value.match(numbers) ? parseFloat(second.value) : 0;

            switch (operator) {
                case '+':
                    result = first + second;
                    break;
                case '-':
                    result = first - second;
                    break;
                case '*':
                    result = first * second;
                    break;
                case '/':
                    result = first / second;
                    break;

                default:
                    result = ''
            }
            result = result !== '' ? result : '';
            resultContainer.value = result.toString().includes('.') ? result.toFixed(2) : result;
        }
    </script>
</body>

</html>
