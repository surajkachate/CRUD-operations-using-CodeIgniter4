<!DOCTYPE html>
<html lang="en">
<head>
<title>Codeigniter 4 CRUD Jquery Ajax (Create, Read, Update and Delete) with Bootstrap 5 Modal</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
</head>
<body>
<div class="container"><br/><br/>
    <div class="row">
        <div class="col-lg-10">
            <h2>CRUD Operation using Codeigniter 4, Jquery, Ajax and Bootstrap 5</h2>
        </div>
        <div class="col-lg-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                Add New Student
            </button>
        </div>
    </div>
    <hr>
    <br>
 
    <table class="table table-bordered table-striped" id="studentTable">
        <thead>
            <tr>
                <th>id</th>
                <th>Name</th>
                <th>Age</th>
                <th width="280px">Action</th>
            </tr>
        </thead>  
        <tbody>
       <?php
        foreach($students_detail as $row){
        ?>
        <tr id="<?php echo $row['id']; ?>">
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['age']; ?></td>
            <td>
            <a data-id="<?php echo $row['id']; ?>" class="btn btn-primary btnEdit">Edit</a>
            <a data-id="<?php echo $row['id']; ?>" class="btn btn-danger btnDelete">Delete</a>
            </td>
        </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Add New Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addStudent" name="addStudent" action="<?php echo site_url('student/store');?>" method="post">
            <div class="modal-body">
                    <div class="form-group">
                        <label for="txtFirstName">Name:</label>
                        <input type="text" class="form-control" id="txtFirstName" placeholder="Enter Name" name="txtFirstName">
                    </div>
                    <div class="form-group">
                        <label for="txtLastName">Age:</label>
                        <input type="number" class="form-control" id="txtLastName" placeholder="Enter Age" name="txtLastName">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
            </div>
        </div>
    </div>
 
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Update Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateStudent" name="updateStudent" action="<?php echo site_url('student/update');?>" method="post">
            <div class="modal-body">
                <input type="hidden" name="hdnStudentId" id="hdnStudentId"/>
                <div class="form-group">
                    <label for="txtFirstName">Name:</label>
                    <input type="text" class="form-control" id="txtFirstName" placeholder="Enter Name" name="txtFirstName">
                </div>
                <div class="form-group">
                    <label for="txtLastName">Age:</label>
                    <input type="number" class="form-control" id="txtLastName" placeholder="Enter Age" name="txtLastName">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
            </div>
        </div>
    </div>
 
</div>
 
<script>
$(document).ready(function () {
    $('#studentTable').DataTable();
 
    $("#addStudent").validate({
        rules: {
            txtFirstName: "required",
            txtLastName: {
                required: true,
                number: true
            },
        },
        messages: {
            txtFirstName: "Please enter your name",
            txtLastName: {
                required: "Please enter your age",
                number: "Please enter a valid numeric age"
            }
        },
           
        submitHandler: function(form) {
            var form_action = $("#addStudent").attr("action");
            $.ajax({
                data: $('#addStudent').serialize(),
                url: form_action,
                type: "POST",
                dataType: 'json',
                success: function (res) {
                    var student = '<tr id="'+res.data.id+'">';
                    student += '<td>' + res.data.id + '</td>';
                    student += '<td>' + res.data.name + '</td>';
                    student += '<td>' + res.data.age + '</td>';
                    student += '<td><a data-id="' + res.data.id + '" class="btn btn-primary btnEdit">Edit</a>  <a data-id="' + res.data.id + '" class="btn btn-danger btnDelete">Delete</a></td>';
                    student += '</tr>';            
                    $('#studentTable tbody').prepend(student);
                    $('#addStudent')[0].reset();
                    $('#addModal').modal('hide');
                },
                error: function (xhr, status, error) {
                    // Code for handling error response
                    console.log(xhr.responseText); // Log the error response
                    console.log(status); // Log the status
                    console.log(error); // Log the error
            
                    // Additional error handling logic if needed
                }
            });
        }
    });
 
    $('body').on('click', '.btnEdit', function () {
        var student_id = $(this).attr('data-id');
        $.ajax({
            url: 'student/edit/'+student_id,
            type: "GET",
            dataType: 'json',
            success: function (res) {
                $('#updateModal').modal('show');
                $('#updateStudent #hdnStudentId').val(res.data.id); 
                $('#updateStudent #txtFirstName').val(res.data.name);
                $('#updateStudent #txtLastName').val(res.data.age);
            },
                error: function (data) {
            }
        });
    });
     
    $("#updateStudent").validate({
        rules: {
            txtFirstName: "required",
            txtLastName: "required",
        },
            messages: {
        },
        submitHandler: function(form) {
            var form_action = $("#updateStudent").attr("action");
            $.ajax({
                data: $('#updateStudent').serialize(),
                url: form_action,
                type: "POST",
                dataType: 'json',
                success: function (res) {
                    var student = '<td>' + res.data.id + '</td>';
                    student += '<td>' + res.data.name + '</td>';
                    student += '<td>' + res.data.age + '</td>';
                    student += '<td><a data-id="' + res.data.id + '" class="btn btn-primary btnEdit">Edit</a>  <a data-id="' + res.data.id + '" class="btn btn-danger btnDelete">Delete</a></td>';
                    $('#studentTable tbody #'+ res.data.id).html(student);
                    $('#updateStudent')[0].reset();
                    $('#updateModal').modal('hide');
                },
                    error: function (data) {
                }
            });
        }
    }); 
 
    $('body').on('click', '.btnDelete', function () {
        var student_id = $(this).attr('data-id');
        $.get('student/delete/'+student_id, function (data) {
            $('#studentTable tbody #'+ student_id).remove();
        })
    });  
});   
</script>
</body>
</html>