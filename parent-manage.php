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
            <div class="row shadow p-3 mb-5 bg-white rounded">

                <div class="col-md-6 justify-content-center">
                    <form id="parentForm" class="bg-gray" method="POST">
                        <div class="alert alert-success none">
                            <p><strong>Success:</strong> Parent information is successfully submitted!</p>
                        </div>
                        <div class="alert alert-danger none">
                            <p><strong>Sorry!</strong> Parent information submit failed.</p>
                        </div>
                        <div class="filed-container">
                            <div class="col-md-12">
                                <h2>Set Parent Info</h2>
                            </div>
                            <div class="form-group">
                                <label for="name">Name: </label>
                                <input type="text" name="name" class="form-control validation"
                                    data-validation="alphabet" placeholder="parent name">
                            </div>
                            <div class="form-group">
                                <label for="name">Email: </label>
                                <input type="text" name="email" class="form-control" placeholder="E-mail">
                            </div>
                            <div class="form-group">
                                <label for="name">Balance: </label>
                                <input type="text" name="balance" class="form-control validation"
                                    data-validation="number" placeholder="starting balance">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="table" value="parents">
                            <input type="submit" value="Submit" class="btn btn-info">
                            <input type="hidden" class="action" name="insert" value="true">
                        </div>
                    </form>
                </div>

                <div class="col-md-12 mt-5">
                    <div class="row">
                        <div class="col-md-6">
                            <h2>Parent Data table</h2>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parent" class="label">Search Parent:</label>
                                <input type="text" class="form-control" placeholder="name / id" name="search_parent">
                            </div>
                        </div>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Starting Balance</th>
                            </tr>
                        </thead>
                        <tbody id="parentTbody">
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

        // load parents and child
        Request.get(`${url}?table=parents`, function(response) {
            storage.parents = response.data.parents;
            parentTableManage(storage.parents)
        });

        function formSubmitManage(event) {
            event.preventDefault();

            var thisForm = this;
            Request.post(url, thisForm, function(response) {
                messageControl(thisForm, response.action);

                if (response.action) {
                    afterActionResetForm(thisForm)
                    parentTableManage(newOrEdited(storage.parents, response.data))
                }
            });
        }

        var parentTbody = document.getElementById('parentTbody');
        var parentSearch = document.querySelector('input[name="search_parent"]');
        parentSearch.addEventListener('keyup', searchParent);

        function searchParent() {
            // w = keyword user input letter
            var w = this.value.toLowerCase();
            var parentData = storage.parents.filter(parent => {
                if (w.length > 0) {
                    var parentId = parent.id.toString();
                    if (parentId.includes(w) || parent.name.toLowerCase().includes(w)) {
                        return parent
                    }
                } else {
                    return parent
                }
            });
            parentTableManage(parentData)
        }

        function parentTableManage(data) {
            var output = '';
            if (data.length > 0) {
                data.map(parent => {
                    output += `<tr>
                    <td>${parent.id}</td>
                    <td>${parent.name}</td>
                    <td>${parent.email}</td>
                    <td>${parent.balance}</td>
                    <td>
                        <button onclick="edit(${parent.id}, 'parents', '#parentForm')" type="button" class="btn btn-sm btn-warning">Edit</button>
                        <button onclick="deleteRow(${parent.id}, 'parents')" type="button" class="btn btn-sm btn-danger">Delete</button>
                    </td>
                </tr>`;
                });
            }
            parentTbody.innerHTML = output;
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
                parentTableManage(storage[table]);
                Request.get(`${url}?id=${id}&table=${table}&delete=1`);
            }
        }
    </script>
</body>

</html>
