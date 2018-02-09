 $(document).ready(function() {

        var product = new Bloodhound({

        datumTokenizer: function(datum) {
            return Bloodhound.tokenizers.whitespace(datum.value);
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            wildcard: '%QUERY%',
            url: window.Closet.url + "/search/by/%QUERY%",
                transform: function(response) {
                    return $.map(response, function(products) {
                        return { value: products.name };
                    });
                }
        },
});
    product.initialize();

    $('.search-input').typeahead({
        hint: false,
        highlight: false,
        minLength: 3,
    },
    {
        name: 'Resteruant',
        display: 'value',
        source: product,
        limit:10,
        templates: {
            suggestion: function(data) {
                return '<p class="tt-p">' + data.value + '</p>';
                }
        }
    })

});
