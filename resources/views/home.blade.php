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
                            <p>All links:</p>
                            <div id="links-list">
                                @if(isset($links))
                                    @foreach($links as $link)
                                        @php
                                            if( $link->status == 1 ){
                                                $class = 'btn-danger';
                                            }else{
                                                $class = 'btn-primary';
                                            }
                                        @endphp
                                        <div class="row mb-2 parent-row" id="row-{{ $link->id }}" data-id="{{ $link->id }}">
                                            <div class="col-md-6">
                                                <div>From: <span class="to">{{ $link->slug }}</span></div>
                                                <div>To: <span class="from">{{ $link->old_slug }}</span></div>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-sm btn-primary mr-2 editLink" data-toggle="modal" data-target="#editModal">Edit</button>
                                                <button type="button" class="btn btn-sm {{ $class }} mr-2  statusLink" data-status="{{ $link->status }}">Change status</button>
                                                <button type="button" class="btn btn-sm btn-danger mr-2  deleteLink">Delete</button>

                                                <button type="button" class="btn btn-sm btn-primary mr-2  getLinkStatistic">Get statistic</button>

                                                <span class="count_redirects"></span>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" class="btn btn-primary newLink" data-toggle="modal" data-target="#createModal">
                                Create new link
                            </button>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Creating redirect</h5>
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


<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editing redirect</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body">

                <form id="linkForm">
                    <div class=" alert-success" id="form-success">

                    </div>
                    <input type="hidden" name="id" id="id" value="0">
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
