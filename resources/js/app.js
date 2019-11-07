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

$(document).on('submit', 'form#linkForm', function(e){
    var $t = $(this),
        target = $t[0].href || $t.data("target") || $t.parents('.modal') || [];
    $.ajax({
        type: "POST",
        url: "/links",
        data: $('form#linkForm').serialize(),
        success: function(msg){

            $( 'form#linkForm #form-errors' ).html( '' );
            $( 'form#linkForm #form-success' ).addClass( 'alert' );
            $( 'form#linkForm #form-success' ).html( 'Redirect link was saved!' );


            var str = '';
            str += '<li data-id="' + msg.id + '">';
            str += '<p class="mb-0">' + msg.old_slug + ' -> ' + msg.slug +'</p>';
            str += '<button type="button" class="btn btn-sm btn-primary mr-2" data-toggle="modal" data-target="#exampleModal">';
            str += 'Edit';
            str += '</button>';
            str += '<button type="button" class="btn btn-sm btn-danger deleteLink">';
            str += 'Delete';
            str += '</button>';
            str += '</li>';

            $('#links-list').append( str );

            setTimeout(function(){

                $('#exampleModal').modal('hide');

                $(target)
                    .find("input,textarea,select")
                    .val('')
                    .end()
                    .find("input[type=checkbox], input[type=radio]")
                    .prop("checked", "")
                    .end();

                $( 'form#linkForm #form-success' ).removeClass( 'alert' );
                $( 'form#linkForm #form-success' ).html( '' );

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
            $( 'form#linkForm #form-errors' ).html( errorsHtml );
        }
    });
   return false;
});

$(document).on('click', '.deleteLink', function(){
    console.log($(this).parent('li').data('id'));
})