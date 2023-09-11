<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <h1 class="text-center">ajax crud operation</h1>

        <div class="col-8 m-auto">
            <form action="index.php" id="newForm" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Name <span class="text-danger" id="nameErr"></span></label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>
                <div class="form-group">
                    <label>Password <span class="text-danger" id="passwordErr"></span></label>
                    <input type="text" name="password" id="password" class="form-control">
                </div>
                <div class="form-group">
                    <label>Mobile <span class="text-danger" id="mobileErr"></span></label>
                    <input type="text" name="mobile" id="mobile" class="form-control">
                </div>
                <div class="">
                    <label>Photo<span class="text-danger" id="photoErr"></span></label>
                    <input type="file" name="photo" id="photo" class="form-control">
                </div>
                <input type="submit" class="btn btn-primary mt-3">
            </form>
        </div>
        <div class="mt-3">
            <h1 class="text-center">Data from Database</h1>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="index.php" id="editForm">
                            <input type="hidden" id="editUser" name="editUser">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Name <span class="text-danger" id="nameErr"></span></label>
                                    <input type="text" name="user" id="user" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Password <span class="text-danger" id="passwordErr"></span></label>
                                    <input type="password" name="pass" id="pass" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Mobile <span class="text-danger" id="mobileErr"></span></label>
                                    <input type="text" name="phone" id="phone" class="form-control">
                                </div>
                                <div class="form-control">
                                    <label>Photo <span class="text-danger" id="photoErr"></span></label>
                                    <input type="file" name="file" id="file" class="form-control">
                                    <input type="hidden" name="current_file" id="current_file">
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-bordered text-center">
            <thead>
                <th>S No</th>
                <th>name</th>
                <th>Password</th>
                <th>Mobile</th>
                <th>Photo</th>
                <th>Action</th>
            </thead>
            <tbody id="response">

            </tbody>
        </table>
    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            function validation() {
                $.ajax({
                    url: 'userGet.php',
                    type: 'POST',
                    dataType: 'JSON',
                    success: function(result) {

                        let a = 1;
                        let tbody = $('#response');
                        let html = "";
                        $.each(result, function(index, data) {
                            html += '<tr>';
                            html += '<td>' + a + '</td>';
                            html += '<td>' + data.name + '</td>';
                            html += '<td>' + data.password + '</td>';
                            html += '<td>' + data.mobile + '</td>';
                            html += '<td><img src="upload/' + data.photo +  '"width="100px"></td>';
                            html += '<td><a id="editBTN" data-bs-toggle="modal" data-bs-target="#exampleModal" value="' + data.id + '" class="btn btn-success">Edit</a> <a id="deleteBTN" value="' + data.id + '" class="btn btn-danger">Delete</a> </td>';
                            html += '</tr>';
                            a++;

                        });
                        tbody.html(html);
                    }
                });
            }
            validation();
            $(document).on("click", "#editBTN", function(e) {
                // alert("here");

                e.preventDefault();
                $.ajax({
                    url: 'userEdit.php',
                    type: 'GET',
                    dataType: 'JSON',
                    data: {
                        id: $(this).attr("value"),

                    },

                    success: function(data) {
                        $("#editUser").val(data.id);
                        $("#user").val(data.name);
                        $("#pass").val(data.password);
                        $("#phone").val(data.mobile);
                        $("#current_file").val(data.photo);


                    }
                });
            });
            $(document).on("click", "#deleteBTN", function(e) {
                e.preventDefault();
                var conf = confirm("Are You Sure");
                let one = $(this).attr('value');
                    if (conf == true) {
                    $.ajax({
                        url: "userDelete.php",
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            id: one
                        },
                        success: function(response) {
                            validation();
                        }
                    })
                }

            })
            $('#newForm').on('submit', function(e) {
                e.preventDefault();
                let formdata = new FormData(this);
                $.ajax({
                    url: 'userAdd.php',
                    type: 'POST',
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    data: formdata,

                    success: function(data) {
                        if (data.nameErr || data.passwordErr || data.mobileErr || data.photoErr) {
                            $('#nameErr') ? $('#nameErr').html(data.nameErr) : $('#nameErr').html('');
                            $('#passwordErr') ? $('#passwordErr').html(data.passwordErr) : $('#passwordErr').html('');
                            $('#mobileErr') ? $('#mobileErr').html(data.mobileErr) : $('#mobileErr').html('');
                            $('#photoErr') ? $('#photoErr').html(data.photoErr) : $('#photoErr').html('');
                        }
                        validation();
                    }
                })
            })
            $('#editForm').on('submit', function(e) {
                e.preventDefault();
                let formdata = new FormData(this);
                $.ajax({
                    url: 'userEdit.php',
                    type: 'POST',
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    data: formdata,
                    success: function(data) {
                        // if (data.nameErr || data.passwordErr || data.mobileErr || data.photoErr) {
                        //     $('#nameErr') ? $('#nameErr').html(data.nameErr) : $('#nameErr').html('');
                        //     $('#passwordErr') ? $('#passwordErr').html(data.passwordErr) : $('#passwordErr').html('');
                        //     $('#mobileErr') ? $('#mobileErr').html(data.mobileErr) : $('#mobileErr').html('');
                        //     $('#photoErr') ? $('#photoErr').html(data.photoErr) : $('#photoErr').html('');
                        // }

                        // alert(data);
                        validation();
                    }
                })
            });


        });
    </script>
</body>

</html>