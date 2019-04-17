<footer id="footer"><!--Footer-->
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <p class="pull-left">Copyright © 2019</p>
                <p class="pull-right">НУЗП</p>
            </div>
        </div>
    </div>
</footer><!--/Footer-->





<script src="/template/js/jquery.js"></script>
<script src="/template/js/bootstrap.min.js"></script>
<script src="/template/js/jquery.scrollUp.min.js"></script>
<script src="/template/js/price-range.js"></script>
<script src="/template/js/jquery.prettyPhoto.js"></script>
<script src="/template/js/main.js"></script>



<script type="text/javascript" src="/template/slick/slick.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('.slider-products').slick({
            autoplay: true,
            autoplaySpeed: 3000,
            dots: true,
            speed: 500
        });
    });
</script>

<script>
    $(document).ready(function () {
        $(".add-to-cart").click(function () {
            var id = $(this).attr('data-id');
            $.post("/cart/addAjax/"+id, {}, function (data) {
                $("#cart-count").html(data);
            })
        });
        return false;
    });
</script>


</body>
</html>