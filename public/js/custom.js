let ajaxMessageTimeout;
let isFadingOut = false;
let lastShownTime = 0;

function showMessage(html) {
    if (ajaxMessageTimeout) {
        clearTimeout(ajaxMessageTimeout);
    }

    if (isFadingOut) {
        $('#ajax-message').stop(true, true).show();
        isFadingOut = false;
    }

    $('#ajax-message').hide().empty().html(html).fadeIn(400);

    lastShownTime = Date.now();

    function fadeOutHandler() {
        const now = Date.now();
        const timeSinceShown = now - lastShownTime;

        if (timeSinceShown < 3000) {
            ajaxMessageTimeout = setTimeout(fadeOutHandler, 3000 - timeSinceShown);
            return;
        }

        isFadingOut = true;
        $('#ajax-message').fadeOut(400, function() {
            $(this).empty().show();
            isFadingOut = false;
        });
        ajaxMessageTimeout = null;
    }

    ajaxMessageTimeout = setTimeout(fadeOutHandler, 3000);
}

// add to cart
$(document).on('submit', '.add-to-cart-form', function (e) {
    e.preventDefault();

    let form = $(this);
    let button = form.find('button');
    let originalHtml = button.html();

    button.addClass('btn-animate').html('✔ Added!');
    button.prop('disabled', true);

    $.ajax({
        url: form.attr('action'),
        method: 'POST',
        data: form.serialize(),
        success: function (response) {
        },
        error: function () {
            showMessage(`
                <div class="alert alert-danger text-center" role="alert">
                    Something went wrong.
                </div>
            `);
        },
        complete: function () {
            
            setTimeout(function () {
                button.removeClass('btn-animate').html(originalHtml);
                button.prop('disabled', false);
            }, 700);
        }
    });
});

// Generic AJAX handler for cart actions
$(document).on('submit', '.ajax-cart-action', function(e) {
    e.preventDefault();

    let form = $(this);
    let url = form.attr('action');
    let method = form.find('input[name="_method"]').val() || form.attr('method') || 'POST';
    let token = form.find('input[name="_token"]').val();
    let productId = form.data('product-id');

    $.ajax({
        url: url,
        method: method,
        data: { _token: token },
        success: function(response) {
            showMessage(`
                <div class="alert alert-success text-center" role="alert">
                    ${response.message}
                </div>
            `);

            if (response.removed) {
                $(`#product-row-${response.product_id}`).remove();
            }

            if (response.quantity !== undefined) {

               $(`.quantity-input[data-product-id="${productId}"]`).val(response.quantity); 
               $(`#item-total-${productId}`).text(`$${response.item_total}`);

            }

            if (response.cart_total !== undefined) {
                $('#cart-total').text(response.cart_total);
            }

            if (response.cleared) {
                $('tbody').empty();
                $('#cart-total').text('0.00');
            }

            if (response.cart_count === 0) {
                $('.table-responsive').remove();
                $('.d-flex.justify-content-between').remove();
                $('.mt-4').remove();

                $('.container.mt-5').append('<p>Your cart is empty.</p>');
            }
        },
        error: function() {
            showMessage(`
                <div class="alert alert-danger text-center" role="alert">
                    Something went wrong.
                </div>
            `);
        }
    });
});

$(document).on('change', '.quantity-input', function() {
    let input = $(this);
    let newQty = parseInt(input.val());
    let productId = input.data('product-id');

    if (isNaN(newQty) || newQty < 1) {
        newQty = 1;
        input.val(newQty);
    }

    $.ajax({
        url: `/cart/update/${productId}`,  
        method: 'PATCH',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            quantity: newQty
        },
        success: function(response) {
            showMessage(`
                <div class="alert alert-success text-center" role="alert">
                    ${response.message}
                </div>
            `);

            $(`#item-total-${productId}`).text(`$${response.item_total}`);
            $('#cart-total').text(response.cart_total);
        },
        error: function() {
            showMessage(`
                <div class="alert alert-danger text-center" role="alert">
                    Could not update quantity.
                </div>
            `);
        }
    });
});











