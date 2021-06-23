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
                <div class="col-md-12">
                    <h2>Hide Show Control</h2>
                    <nav>
                        <ul id="tabManage">
                            <li><label class="shadow bg-white rounded" data-target="#first" for="first_">First <input
                                        type="checkbox" id="first_"></label></li>
                            <li><label class="shadow bg-white rounded" data-target="#second" for="second_">Second <input
                                        type="checkbox" id="second_"></label></li>
                            <li><label class="shadow bg-white rounded" data-target="#third" for="third_">Third <input
                                        type="checkbox" id="third_"></label></li>
                            <li><label class="shadow bg-white rounded" data-target="#forth" for="forth_">Forth <input
                                        type="checkbox" id="forth_"></label></li>
                        </ul>
                    </nav>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div id="first" class="div-select none">
                            <h4>First</h4>
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum repellendus dolore
                                qui
                                voluptates libero! Accusantium tempora deserunt in doloribus porro impedit, possimus
                                voluptatum recusandae dolore ad reiciendis ab quia ipsa.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div id="second" class="div-select none">
                            <h4>Second</h4>
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum repellendus dolore
                                qui
                                voluptates libero! Accusantium tempora deserunt in doloribus porro impedit, possimus
                                voluptatum recusandae dolore ad reiciendis ab quia ipsa.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div id="third" class="div-select none">
                            <h4>Third</h4>
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum repellendus dolore
                                qui
                                voluptates libero! Accusantium tempora deserunt in doloribus porro impedit, possimus
                                voluptatum recusandae dolore ad reiciendis ab quia ipsa.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div id="forth" class="div-select none">
                            <h4>Forth</h4>
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum repellendus dolore
                                qui
                                voluptates libero! Accusantium tempora deserunt in doloribus porro impedit, possimus
                                voluptatum recusandae dolore ad reiciendis ab quia ipsa.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    </div>
    </div>
    <script>
        var tabManage = document.querySelectorAll('#tabManage li label');
        var checkBoxes = document.querySelectorAll('#tabManage li label input');
        tabManage.forEach(liElement => liElement.addEventListener('click', hideShowManage));

        function hideShowManage() {
            var target = this.dataset.target;
            var targetDibs = document.querySelectorAll('.div-select');
            targetDibs.forEach(div => div.className = 'div-select none');
            var thisCheckBox = this.querySelector('input');
            checkBoxes.forEach(checkBox => {
                if (thisCheckBox !== checkBox) {
                    checkBox.checked = false;
                }
            });
            if (thisCheckBox.checked) {
                document.querySelector(target).className = 'div-select';
            }
        }
    </script>
</body>

</html>
