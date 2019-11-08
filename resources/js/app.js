/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).on('click', '.newLink', function(){
    $('#link').val('');
    $('#slug').val('');
});

$(document).on('submit', '#createModal form#linkForm', function(e){
    var $t = $(this),
        target = $t[0].href || $t.data("target") || $t.parents('.modal') || [];

    $.ajax({
        type: "POST",
        url: "/links",
        data: $('#createModal form#linkForm').serialize(),
        success: function(msg){

            $( '#createModal form#linkForm #form-errors' ).html( '' );
            $( '#createModal form#linkForm #form-success' ).addClass( 'alert' );
            $( '#createModal form#linkForm #form-success' ).html( 'Redirect link was saved!' );


            var str = '';
            str += '<div class="row mb-2 parent-row" id="row-' + msg.id + '" data-id="' + msg.id + '">';
            str += '<div class="col-md-6">';

            str += '<div>From:  <span class="from">' + msg.slug + '</span></div>';
            str += '<div>To: <span class="to">' + msg.old_slug + '</span></div>';

            str += '</div>';
            str += '<div class="col-md-6">';
            str += '<button type="button" class="btn btn-sm btn-primary mr-2 editLink" data-toggle="modal" data-target="#editModal">';
            str += 'Edit';
            str += '</button>';
            str += '<button type="button" data-status="1" class="btn btn-sm btn-danger mr-2 statusLink">';
            str += 'Change status';
            str += '</button>';
            str += '<button type="button" class="btn btn-sm btn-danger  deleteLink">Delete</button>';
            str += '</div>';
            str += '</div>';


            $('#links-list').append( str );

            setTimeout(function(){

                $('#createModal').modal('hide');

                $(target)
                    .find("input,textarea,select")
                    .val('')
                    .end()
                    .find("input[type=checkbox], input[type=radio]")
                    .prop("checked", "")
                    .end();

                $( '#createModal form#linkForm #form-success' ).removeClass( 'alert' );
                $( '#createModal form#linkForm #form-success' ).html( '' );
                $( '#createModal form#linkForm #id' ).val( 0 );

            }, 600);
        },
        error: function(data){
            var errors = data.responseJSON;
            console.log(errors);
            errorsHtml = '<div class="alert alert-danger"><ul>';
            $.each( errors.errors, function( key, value ) {
                errorsHtml += '<li>'+ value[0] + '</li>';
            });
            errorsHtml += '</ul></div>';
            $( '#createModal form#linkForm #form-errors' ).html( errorsHtml );
        }
    });
   return false;
});

$(document).on('submit', '#editModal form#linkForm', function(e){
    var $t = $(this),
        target = $t[0].href || $t.data("target") || $t.parents('.modal') || [];

    var id = $('#editModal form#linkForm #id').val();

    $.ajax({
        type: "PUT",
        url: "/links/" + id,
        data: $('#editModal form#linkForm').serialize(),
        success: function(msg){

            $( '#editModal form#linkForm #form-errors' ).html( '' );
            $( '#editModal form#linkForm #form-success' ).addClass( 'alert' );
            $( '#editModal form#linkForm #form-success' ).html( 'Redirect link was saved!' );

            $('#row-' + msg.id).find('.from').html(msg.slug);
            $('#row-' + msg.id).find('.to').html(msg.old_slug);

            setTimeout(function(){

                $('#editModal').modal('hide');

                $(target)
                    .find("input,textarea,select")
                    .val('')
                    .end()
                    .find("input[type=checkbox], input[type=radio]")
                    .prop("checked", "")
                    .end();

                $( '#editModal form#linkForm #form-success' ).removeClass( 'alert' );
                $( '#editModal form#linkForm #form-success' ).html( '' );
                $( '#editModal form#linkForm #id' ).val( 0 );

            }, 600);
        },
        error: function(data){
            var errors = data.responseJSON;
            console.log(errors);
            errorsHtml = '<div class="alert alert-danger"><ul>';
            $.each( errors.errors, function( key, value ) {
                errorsHtml += '<li>'+ value[0] + '</li>';
            });
            errorsHtml += '</ul></div>';
            $( '#editModal form#linkForm #form-errors' ).html( errorsHtml );
        }
    });
    return false;
});


$(document).on('click', '.statusLink', function(){
    var addClass = '';
    var removeClass = '';
    var el = $(this);
    var id = $(this).parents('.parent-row').data('id');
    var status = parseInt($(this).data('status'));
    status = (status == 1 ? 0 : 1);
    $.ajax({
        type: "PATCH",
        url: "/links/" + id,
        data: {
            status: status
        },
        success: function(msg){
            el.data('status', msg.status);
            if( msg.status == 1 ){
                addClass = 'btn-danger';
                removeClass = 'btn-primary';
            }else{
                addClass = 'btn-primary';
                removeClass = 'btn-danger';
            }
            el.removeClass(removeClass);
            el.addClass(addClass);
        },
        error: function(data){
            console.log(data);
        }
    });

});

$(document).on('click', '.deleteLink', function(){
    var el = $(this);
    var id = $(this).parents('.parent-row').data('id');

    $.ajax({
        type: "DELETE",
        url: "/links/" + id,
        data: {
            status: status
        },
        success: function(msg){
            el.parents('.parent-row').remove();
        },
        error: function(data){
            console.log(data);
        }
    });

});

$(document).on('click', '.editLink', function(){
    var el = $(this);
    var parent = $(this).parents('.parent-row');
    var id = parent.data('id');
    $( '#editModal form#linkForm #id' ).val( id );
    $('#editModal #link').val(parent.find('.from').html());
    $('#editModal #slug').val(parent.find('.to').html());

});
