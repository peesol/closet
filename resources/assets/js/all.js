 $(document).ready(function() {

    $('.side-menu-btn').click(function(e) {
      e.preventDefault();
      $('.side-menu-btn').toggleClass('open');
      $('.left-side-menu').toggleClass('toggled');
      $('.overlay').toggleClass('overlay-open');
    });

    $('.overlay').click(function() {
      $('.overlay').removeClass('overlay-open');
      $('.side-menu-btn').removeClass('open');
      $('.left-side-menu').removeClass('toggled');
    });

    $(".left-side-menu").mouseenter(function() {
        $(".left-side-menu").addClass("scroll-bar");
    });
     $(".left-side-menu").mouseleave(function() {
        $(".left-side-menu").removeClass("scroll-bar");
    });
     $(".dropdown-btn").click( function(){
        $("#dropdown").toggleClass("show-dropdown");
    });

if(window.Closet.user.user !== null){
    window.onclick = function (e) {
        if (!e.target.matches('.dropdown-btn')) {
            var Dropdown = document.getElementById("dropdown");
            if (Dropdown.classList.contains('show-dropdown')) {
                Dropdown.classList.remove('show-dropdown');
            }
        }
    };
}

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
