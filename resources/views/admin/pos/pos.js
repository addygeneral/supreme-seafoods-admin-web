function addtocart(addcarturl) {

    var item_id = $('#item_id').val();

    var item_name = $('#item_name').val();

    var item_type = $('#item_type').val();

    var image_name = $('#image_name').val();

    var item_tax = $('#item_tax').val();



    var item_price = $('#item_price').val();



    var variation_id = $("input[name='variation']:checked").attr('data-variation-id');

    var variation_name = $("input[name='variation']:checked").attr('data-variation-name');



    var addons_id = $('.addons-checkbox:checked').map(function() {

        return $(this).attr('data-addons-id');

    }).get().join(',');



    var addons_name = ($('.addons-checkbox:checked').map(function() {

        return $(this).attr('data-addons-name');

    }).get().join(','));



    var addons_price = ($('.addons-checkbox:checked').map(function() {

        return $(this).attr('data-addons-price');

    }).get().join(','));



    // alert('item_id --> '+ item_id +' :: item_name --> '+ item_name +' :: image_name --> '+ image_name +' :: item_tax --> '+ item_tax +' :: variation_id --> '+ variation_id +' :: variation_name --> '+ variation_name +' :: addons_id --> '+ addons_id +' :: addons_name --> '+ addons_name +' :: addons_price --> '+ addons_price );



    $('#preloader').show();

    $.ajax({

        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

        url: addcarturl,

        data: {

            item_id: item_id,

            item_name: item_name,

            item_type: item_type,

            image_name: image_name,

            tax: item_tax,

            item_price: item_price,

            variation_id: variation_id,

            variation_name: variation_name,

            addons_id: addons_id,

            addons_name: addons_name,

            addons_price: addons_price,

        },

        method: 'POST',

        dataType: 'json',

        success: function(response) {

            location.reload();

        },

        error: function(error) {

            $('#preloader').hide();

            alert("Wrong ...!");

        }

    })



};

function addcart(item_id, item_name, item_type, image_name, item_tax,item_price, addcarturl) {

    $('#preloader').show();

    $.ajax({

        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

        url: addcarturl,

        data: {

            item_id: item_id,

            item_name: item_name,

            item_type: item_type,

            image_name: image_name,

            tax: item_tax,

            item_price: item_price,

        },

        method: 'POST',

        dataType: 'json',

        success: function(response) {

            // $('#preloader').hide();

            location.reload();

        },

        error: function(error) {

            $('#preloader').hide();

            alert("Wrong ...!");

        }

    })

};

function showitem(id, showurl) {

    $('#preloader').show();

    $.ajax({

        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

        url: showurl,

        data: {id: id},

        method: 'POST',

        dataType: 'json',

        success: function(response) {

            $('#preloader').hide();

            $("input:checkbox").prop('checked', false);

            jQuery("#modalitemdetails").modal('show');

            $('#item_id').val(response.itemdata.id);

            $('#item_name').val(response.itemdata.item_name);

            $('#item_type').val(response.itemdata.item_type);

            $('#item_tax').val(response.itemdata.tax);

            $('#image_name').val(response.itemdata.image_name);

            $('.attribute').text(response.itemdata.attribute);

            $('.item_name').text(response.itemdata.item_name);

            $('#item_type_image').html("<img class='item-type-image mt-1' src=" + response.itemdata.item_type_image + ">");



            $('.varition-listing').html('');

            $('.addons-listing').html('');



            if (response.itemdata.addons != "") {

                $('#addons').show();

                let freehtml = '';

                for (p in response.itemdata.addons) {

                    freehtml += '<div class="form-check my-2"><input class="form-check-input addons-checkbox" type="checkbox" value="' + response.itemdata.addons[p].id + '" data-addons-id="' + response.itemdata.addons[p].id + '" data-addons-price="' + response.itemdata.addons[p].price +'" data-addons-name="' + response.itemdata.addons[p].name + '" onclick="getaddons(this)" id="addons'+ response.itemdata.addons[p].id +'"><label class="form-check-label mr-3 cursor-pointer" for="addons'+ response.itemdata.addons[p].id +'">'+ response.itemdata.addons[p].name + ' :- '+currency_format(response.itemdata.addons[p].price)+'</label></div>';

                }

                $('.addons-listing').html(freehtml);

            } else {

                $('#addons').hide();

            }



            if(response.itemdata.has_variation == 2){

                var itemprice = response.itemdata.price;

                $('#variation').hide();

            }else{

                $('#variation').show();

                let variationhtml = '';

                var itemprice = 0;

                for (i in response.itemdata.variation) {

                    var select = "";

                    if (i == 0) {

                        select = "checked";

                        itemprice = response.itemdata.variation[i].product_price;

                        variation_id = response.itemdata.variation[i].id;

                        variation_name = response.itemdata.variation[i].variation;

                    }

                    variationhtml +='<div class="custom-control custom-radio my-2"><input type="radio" data-variation-id="' +response.itemdata.variation[i].id + '" data-variation-name="'+response.itemdata.variation[i].variation+'" data-variation-price="' + response.itemdata.variation[i].product_price +'" class="custom-control-input" name="variation" id="variation-' + i + '-' +response.itemdata.variation[i].id + '" value="' + response.itemdata.variation[i].variation + '" ' + select +' onchange="getvaraitions(this)"><label class="custom-control-label cursor-pointer" for="variation-' + i + '-' + response.itemdata.variation[i].id + '">' + response.itemdata.variation[i].variation + ' :- ' + currency_format(response.itemdata.variation[i].product_price) + '</label></div>';

                }

                $('.varition-listing').html(variationhtml);

            }

            $('#item_price').val(itemprice);

            $('#subtotal').val(itemprice);

            $('.item_price').html(currency_format(itemprice));

            $('.subtotal').html(currency_format(itemprice));

        },

        error: function(error) {

            $('#preloader').hide();

            $("html, body").animate({

                scrollTop: 0

            }, 600);

            $('#emsg').html(error).fadeIn('slow');

            $('#emsg').delay(5000).fadeOut('slow');

        }

    })

}

function getaddons(x){

    var price = parseFloat($(x).attr('data-addons-price'));

    var addonstotal = parseFloat($('#addonstotal').val());

    var item_price = parseFloat($('#item_price').val());

    var subtotal = parseFloat($('#subtotal').val());

    if($(x).is(':checked')){

        addonstotal += price;

        subtotal = item_price + addonstotal;

    }else{

        addonstotal -= price;

        subtotal = item_price + addonstotal;

    }

    $('#addonstotal').val(addonstotal);

    $('#subtotal').val(subtotal);

    // $('.item_price').text(currency_format(subtotal));

    $('.subtotal').text(currency_format(subtotal));

}

function getvaraitions(x){

    var price = parseFloat($(x).attr('data-variation-price'));

    var addonstotal = parseFloat($('#addonstotal').val());

    $('#item_variants_name').val($(x).attr('data-variation-name'));

    $('#item_price').val(price);

    $('#subtotal').val(addonstotal+price);

    // $('.item_price').text(currency_format(addonstotal+price));

    $('.subtotal').text(currency_format(addonstotal+price));

}



function deletecartitem(id,deleteurl) {

    $('#preloader').show();

    $.ajax({

        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

        url: deleteurl,

        data: {id: id},

        method: 'POST',

        dataType: 'json',

        success: function(response) {

            location.reload();

        },

        error: function(error) {

            $('#preloader').hide();

            $("html, body").animate({

                scrollTop: 0

            }, 600);

            $('#cartemsg').html(error).fadeIn('slow');

            $('#cartemsg').delay(5000).fadeOut('slow');

        }

    })

}

function qtyupdate(id, type, qtyurl) {

    $('#preloader').show();

    $.ajax({

        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

        url: qtyurl,

        data: {id: id,type: type,},

        method: 'POST',

        dataType: 'json',

        success: function(response) {

            location.reload();

        },

        error: function(error) {

            $('#preloader').hide();

            $("html, body").animate({

                scrollTop: 0

            }, 600);

            $('#cartemsg').html(error).fadeIn('slow');

            $('#cartemsg').delay(5000).fadeOut('slow');

        }

    })

}

function placeorder(orderurl,sucecssurl)

{

    var tax = parseFloat($('#tax').val());

    var discount_amount = parseFloat($('#discount_amount').val());

    var grand_total = parseFloat($('#grand_total').val());



    $('#preloader').show();

    $.ajax({

        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

        url:orderurl,

        data: {

            tax:tax,

            discount_amount:discount_amount,

            grand_total:grand_total,

        }, 

        method: 'POST',

        success: function(response) {

            $('#preloader').hide();

            if (response.status == 1) {

                window.location.href = sucecssurl;

            } else {

                $("html, body").animate({ scrollTop: 50 }, 600);

                $('#emsg').html(response.message).addClass('alert alert-danger my-3').fadeIn('slow');

                $('#emsg').delay(5000).fadeOut('slow');

            }

        },

        error: function(error) {

            $('#preloader').hide();

            $("html, body").animate({ scrollTop: 50 }, 600);

            $('#emsg').html(error).fadeIn('slow');

            $('#emsg').delay(5000).fadeOut('slow');

        }

    });

}