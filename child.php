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
        <div class="container mb-5">
            <div class="row mt-5 shadow p-3 mb-5 bg-white rounded">
                <div class="col-md-6 justify-content-center">
                    <form id="childForm" class="bg-gray" method="POST">
                        <div class="alert alert-success none">
                            <p><strong>Success:</strong> Child information is successfully submitted!</p>
                        </div>
                        <div class="alert alert-danger none">
                            <p><strong>Sorry!</strong> Child information submit failed.</p>
                        </div>
                        <div class="filed-container">
                            <div class="col-md-12">
                                <h2>Set Child Info</h2>
                            </div>
                            <div class="form-group">
                                <label for="name">Select Parent: </label>
                                <select name="parent_id" class="form-control"></select>
                            </div>
                            <div class="form-group">
                                <label for="name">Name: </label>
                                <input type="text" name="name" class="form-control validation"
                                    data-validation="alphabet" placeholder="Child name">
                            </div>
                            <div class="form-group">
                                <label for="name">Email: </label>
                                <input type="text" name="email" class="form-control" placeholder="E-mail">
                            </div>
                            <div class="form-group">
                                <label for="name">Student Roll: </label>
                                <input type="text" name="roll_no" class="form-control validation"
                                    placeholder="Enter Student Roll" data-validation="number">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="table" value="child">
                            <input type="submit" value="Submit" class="btn btn-info">
                            <input type="hidden" class="action" name="insert" value="true">
                        </div>
                    </form>
                </div>
            </div> <!-- Form part end-->

            <hr class="hr p-3">
            <div class="row shadow p-3 mb-5 bg-white rounded">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="parent" class="label">Select Parent:</label>
                        <select name="parent" id="parent" class="form-control"></select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="parent" class="label">Search Children:</label>
                        <input type="text" class="form-control" placeholder="name / id / roll" name="search_child">
                    </div>
                </div>
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Roll</th>
                                <th scope="col">Email</th>
                            </tr>
                        </thead>
                        <tbody id="children">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        var url = `${base_url}/App/api`;
        var storage = {
            parents: [],
            children: [],
        }

        function reloadTable() {
            parentSelectOption(storage.parents)
            manageChildTable(storage.child)
        }
        // load parents and child
        Request.get(`${url}?table=child,parents`, function(response) {
            storage.parents = response.data.parents;
            storage.child = response.data.child;
            reloadTable();
        });

        function formSubmitManage(event) {
            event.preventDefault();

            var thisForm = this;
            Request.post(url, thisForm, function(response) {
                messageControl(thisForm, response.action);

                console.log('response-> ', response);
                if (response.table === 'child') {
                    manageChildTable(newOrEdited(storage.child, response.data))
                } else {
                    parentTableManage(newOrEdited(storage.parents, response.data))
                }

                if (response.action) {
                    reloadTable();
                    thisForm.reset();
                    var submitButton = thisForm.querySelector('input[type="submit"]');
                    var forAction = thisForm.querySelector('input.action');
                    submitButton.className = 'btn btn-info'
                    submitButton.value = 'Submit';
                    forAction.name = 'insert';
                }

            });
        }

        var parentSelect = document.getElementById('parent');
        var childContainer = document.querySelector('table #children');
        var childSearch = document.querySelector('input[name="search_child"]');
        var parent_id;

        function parentSelectOption(data) {
            console.log('parent data-> ', data)
            var options = '<option selected disabled >Select Parent</option>';
            data.map(parent => {
                options += `<option value="${parent.id}">${parent.name}</option>`;
            })
            var parent_el = document.querySelector('select[name="parent_id"]');
            parent_el.innerHTML = options;
            parentSelect.innerHTML = options;
        }

        parentSelect.addEventListener('change', getChildrenByParentId);
        childSearch.addEventListener('keyup', searchChild);

        function searchChild() {
            // w = keyword user input letter
            var w = this.value.toLowerCase();
            var childData = storage.child.filter(child => {
                if (w.length > 0) {
                    var childId = child.id.toString();
                    var childRoll = child.roll_no.toString();
                    if (childRoll.includes(w) || childId.includes(w) || child.name.toLowerCase().includes(w)) {
                        return child
                    }
                } else if (parent_id && child.parent_id === parent_id) {
                    return child
                }
            });
            manageChildTable(childData)
        }

        function getChildrenByParentId(e) {
            parent_id = this.value;
            var childData = storage.child.filter(child => child.parent_id === parent_id);
            manageChildTable(childData)
        }

        function manageChildTable(data) {
            var output = '';
            if (data.length > 0) {
                data.map(child => {
                    output += `<tr>
                    <td>${child.id}</td>
                    <td>${child.name}</td>
                    <td>${child.roll_no}</td>
                    <td>${child.email}</td>
                    <td>
                        <button onclick="edit(${child.id}, 'child', '#childForm')" type="button" class="btn btn-sm btn-warning">Edit</button>
                        <button onclick="deleteRow(${child.id}, 'child')" type="button" class="btn btn-sm btn-danger">Delete</button>
                    </td>
                </tr>`;
                });
            }
            childContainer.innerHTML = output;
        }

        function edit(id, table, formId) {
            var item = storage[table].find(item => parseInt(item.id) === id);
            dynamicallySetValueOfElements(formId, item)
        }

        function show(id, table) {

        }

        function deleteRow(id, table) {
            if (confirm("Are you sure you want to delete this record?")) {
                var index = storage[table].findIndex(item => parseInt(item.id) === id);
                delete storage[table][index];
                manageChildTable(storage[table]);
                Request.get(`${url}?id=${id}&table=${table}&delete=1`);
            }
        }


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

</html>
