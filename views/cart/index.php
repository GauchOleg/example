<div class="wrapper">
    <div id="cart-view">
        <div class="container" id="cart">
dawd
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        $('[data-id="home"]').attr('href','/');
        $('[data-id="home"]').parent('li').removeClass('active');
        $('[data-id="catalog"]').attr('href','/#catalog');
        $('[data-id="cart"]').parent('li').addClass('active');

        $('[data-id="service"]').attr('href','/#service');
        $('[data-id="portfolio"]').attr('href','/#portfolio');
        $('[data-id="clients"]').attr('href','/#clients');
        $('[data-id="contact"]').attr('href','/#contact');
        $('[data-id="cart"]').attr('href','#cart');
        $('[data-id="cart"]').parent('li').addClass('active');
    });
</script>