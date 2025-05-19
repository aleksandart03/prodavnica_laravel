$(document).ready(function() {

    function fetchProducts(page = 1) {
        let form = $('#filter-form');
        let data = form.serializeArray();
        data.push({
            name: 'page',
            value: page
        });

        $.ajax({
            url: form.attr('action'),
            data: $.param(data),
            dataType: 'json',
            success: function(response) {
                $('#product-list').html(response.products);
                $('#pagination-container').html(response.pagination);
                $('html, body').animate({
                    scrollTop: $('#product-list').offset().top - 100
                }, 300);
            }
        });
    }

    $('#filter-form').on('submit', function(e) {
        e.preventDefault();
        fetchProducts(1);
    });

    $(document).on('click', '#pagination-container .pagination a', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');
        let page = url.split('page=')[1];
        if (page) {
            fetchProducts(page);
        }
    });

    $('#filter-form a.btn-secondary').on('click', function(e) {
        e.preventDefault();
        let form = $('#filter-form')[0];
        form.reset();
        fetchProducts(1);
    });
});


$(document).ready(function () {
    let currentRequest = null;

    function debounce(func, delay) {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), delay);
        };
    }

    function openDropdown() {
        const $results = $('#search-results');
        $results.css('pointer-events', 'auto');

        $results.css('height', 'auto');
        const height = $results.outerHeight();

        $results.height(0);

        setTimeout(() => {
            $results.css('height', height);
        }, 20); 
    }

    function closeDropdown() {
        const $results = $('#search-results');

        $results.height(0);

        $results.one('transitionend', function () {
            $results.css('pointer-events', 'none').empty();
        });
    }

    const handleSearch = debounce(function () {
        const query = $('#product-search').val().trim();

        if (query.length < 2) {
            closeDropdown();
            return;
        }

        if (currentRequest) {
            currentRequest.abort();
        }

        currentRequest = $.ajax({
            url: window.routes.productSearch,
            data: { query: query },
            success: function (data) {
                let results = '';

                if (data.length === 0) {
                    results = `
                        <div class="list-group-item d-flex flex-column align-items-center text-center py-4 text-muted" style="font-style: italic;">
                            <i class="bi bi-ban fs-3 mb-2"></i>
                            <span>No products found</span>
                        </div>`;
                } else {
                    data.forEach(product => {
                        results += `
                            <a href="${product.url}" class="list-group-item list-group-item-action d-flex align-items-center gap-3">
                                <img src="${product.image}" alt="${product.name}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                <div>
                                    <div class="fw-bold">${product.name}</div>
                                    <div class="text-muted">$${parseFloat(product.price).toFixed(2)}</div>
                                </div>
                            </a>`;
                    });
                }

                const $results = $('#search-results');
                $results.html(results);

                        setTimeout(() => {
                        openDropdown();
                        }, 30);     

            }
        });
    }, 300);

    $('#product-search').on('keyup', function (e) {
        if (e.key === "Escape") {
            closeDropdown();
            return;
        }

        handleSearch();
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('#product-search, #search-results').length) {
            closeDropdown();
        }
    });

    $(document).on('keydown', function (e) {
        if (e.key === "Escape") {
            closeDropdown();
        }
    });
});




