@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="row">
                    <div class="col-md-12">
                        <div class="py-2 px-4">
                            Hello! Here You can create any redirect.
                        </div>
                        <div class="py-2 px-4">
                            All links:
                            <ul id="links-list">

                                    <li data-id="test">
                                        <p class="mb-0">One</p>
                                        <button type="button" class="btn btn-sm btn-primary mr-2" data-toggle="modal" data-target="#exampleModal">
                                            Edit
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger deleteLink">
                                            Delete
                                        </button>
                                    </li>

                            </ul>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                Create new link
                            </button>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="linkForm">
                    <div class=" alert-success" id="form-success">

                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Full link</label>
                        <input name="old_slug" type="text" class="form-control" id="link" aria-describedby="linkHelp" placeholder="Enter link">
                        <small id="linkHelp" class="form-text text-muted">Enter full link, like: google.com</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Slug</label>
                        <input name="slug" type="text" class="form-control" id="slug" aria-describedby="slugHelp" placeholder="Enter slug">
                        <small id="slugHelp" class="form-text text-muted">Enter short slug</small>
                    </div>

                    <div id="form-errors">

                    </div>

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveLink">Submit</button>
                </form>


            </div>
        </div>
    </div>
</div>

@endsection
