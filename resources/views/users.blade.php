<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>UserSearch</title>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark">
        <a class="navbar-brand" href="/users">
            UserSearch <i class="fa fa-check"></i>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <form class="form-inline ml-auto" method="get" action="/users">
            <input class="form-control mr-sm-2" name="q" type="search" placeholder="Search name or email" aria-label="Search">
            <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
        </form>
    </nav>


    <div class="container">
        <h3 class="mt-5 text-center">View All Users</h3>
        <hr>

        <div class="row">
            <p class="col-md-9"><i>{{$message}}</i></p>
            <div class="col-md-3">
                <button class="btn-outline-primary btn btn-block" data-toggle="modal" data-target="#addUserModal">
                    <i class="fa fa-plus"></i> Add New
                </button>
            </div>
        </div>
        <table class="table table-sm table-bordered text-center mt-3">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>NAME</th>
                    <th>EMAIL</th>
                    <th>PHONE NUMBER</th>
                    <th>GENDER</th>
                    <th colspan="2">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{ucfirst($user->name)}}</td>
                        <td>{{strtolower($user->email)}}</td>
                        <td>{{$user->phone_number}}</td>
                        <td>{{ucfirst($user->gender)}}</td>
                        <td><button class="bg-transparent border-0" data-toggle="modal" data-target="#editUserModal{{$user->id}}"><i class="fa fa-pencil" title="Edit User"></i></button></td>
                        <td><button class="bg-transparent border-0" data-toggle="modal" data-target="#deleteUserModal{{$user->id}}"><i class="fa fa-close text-danger" title="Delete User"></i></button></td>
                    </tr>

                    <div class="modal fade" id="deleteUserModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteUserModalTitle">Delete User?</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                            Are you sure you want to delete this user (<strong>{{ucfirst($user->name)}}</strong>) from the database?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                <button type="button" class="btn btn-primary deleteUserBtn" data-user="{{$user->id}}">Yes, Confirm</button>
                            </div>
                            </div>
                        </div>
                    </div>


                    <div class="modal fade" id="editUserModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="editUserModalLabel">Update User Details</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <form id="updateUserForm" data-user="{{$user->id}}">

                                <div class="form-group">
                                  <label for="name" class="col-form-label">Name</label>
                                  <input type="text" required class="form-control" id="edit_name" value="{{$user->name}}" name="edit_name">
                                </div>
                                <div class="form-group">
                                  <label for="phone_number" class="col-form-label">Mobile Number</label>
                                  <input type="text" required class="form-control" value="{{$user->phone_number}}" name="edit_phone_number" id="edit_phone_number">
                                </div>
                                <div class="form-group">
                                  <label for="email" class="col-form-label">Email</label>
                                  <input type="email" required class="form-control" value="{{$user->email}}" name="email" id="edit_email">
                                </div>
                                <div class="form-group">
                                  <label for="gender" class="col-form-label">Gender</label>
                                  <select class="custom-select" id="edit_gender" value="{{$user->gender}}" required name="edit_gender">
                                      <option {{($user->gender == 'male' ) ? 'selected' : '' }} value="male">Male</option>
                                      <option {{($user->gender == 'female' ) ? 'selected' : '' }} value="female">Female</option>
                                    </select>
                                </div>
                              </form>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" id="updateUserSubmit" form="updateUserForm" class="btn btn-primary">Update User</button>
                            </div>
                          </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Modals --}}

<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addUserForm">

          <div class="form-group">
            <label for="name" class="col-form-label">Name</label>
            <input type="text" required class="form-control" id="name" name="name">
          </div>
          <div class="form-group">
            <label for="phone_number" class="col-form-label">Mobile Number</label>
            <input type="text" required class="form-control" name="phone_number" id="phone_number">
          </div>
          <div class="form-group">
            <label for="email" class="col-form-label">Email</label>
            <input type="email" required class="form-control" name="email" id="email">
          </div>
          <div class="form-group">
            <label for="gender" class="col-form-label">Gender</label>
            <select class="custom-select" id="gender" required name="gender">
                <option selected value="male">Male</option>
                <option value="female">Female</option>
              </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" id="addUserSubmit" form="addUserForm" class="btn btn-primary">Add User</button>
      </div>
    </div>
  </div>
</div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#addUserForm').submit(function(event) {
            event.preventDefault()
            $('#addUserSubmit').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>')
            $.ajax({
                url: '/users',
                method: 'post',
                data: {
                    name: $('#name').val(),
                    phone_number: $('#phone_number').val(),
                    gender: $('#gender').val(),
                    email: $('#email').val(),
                },
                success: function(response) {
                    alert("User added successfully")
                    window.location.reload()
                },
                error: function(error) {
                    $('#addUserSubmit').html('Submit')
                    console.error(error)
                }
            })
        })

        $('#updateUserForm').submit(function(event) {
            event.preventDefault()
            let id = $(this).attr('data-user')
            $('#updateUserSubmit').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>')
            $.ajax({
                url: `/users/${id}`,
                method: 'put',
                data: {
                    name: $('#edit_name').val(),
                    phone_number: $('#edit_phone_number').val(),
                    gender: $('#edit_gender').val(),
                    email: $('#edit_email').val(),
                },
                success: function(response) {
                    alert("User updated successfully")
                    window.location.reload()
                },
                error: function(error) {
                    $('#updateUserSubmit').html('Submit')
                    console.error(error)
                }
            })
        })

        $('.deleteUserBtn').click(function(event) {
            event.preventDefault()
            let id = $(this).attr('data-user')
            $('#deleteUserBtn').html('Please wait...')
            $.ajax({
                url: `/users/${id}`,
                method: 'delete',
                success: function(response) {
                    alert("User deleted successfully")
                    window.location.reload()
                },
                error: function(error) {
                    $('#deleteUserBtn').html('Yes, Confirm')
                    console.error(error)
                }
            })
        })
    </script>
</body>
</html>
