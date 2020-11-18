@extends('layouts.admin')

@section('title', 'Productos')

@section('content')


  <!--Main layout-->
  <main class="mt-5 pt-4">
   
    <div class="container">


      <!--Grid row-->
      <div class="row wow fadeIn">
        <!--Grid column-->
        <div class="col-md-6">

          <img src="{{asset('images/productos/'.$producto->photo)}}" class="img-fluid" alt="">

        </div>
        <!--Grid column-->
        <div class="col-md-6">
          <div class="card">
          <div class="card-header card-header-success">
            <h4 class="text-center">{{$producto->nombre}} </h4>
            </div><br>
            <div class="card-body">
              <form  method="post" action="{{ url('/cart') }}">
              {{ csrf_field() }}
               <h4 >Precio: Bs.{{$producto->precio}} </h4>
                <input type="hidden" name="precio" id="productos" value="{{ $productoJson}}">
                 <h4 class="text-danger">
                   Incluye IVA
                 </h4>
                  <h4 class="title">
                   Cantidad (Disponibles +{{$producto->stock}} paq. )
                 </h4>
                 <h4 class="title"> <br>
                  Cantidad
                 <input type="number" name=quantity id="cantidades" value="1" class="form-control">

                 </h4>
                <div class="container">
                  <div class="container-fluid">
                    
                     

                    </h4><br><br><br>
                    <div class="container">
                      <div class="container-fluid">
                        <div class="col-sm-12">
                          <div class="text-center">
                            <input type="hidden" name="product_id" value="{{ $producto->id }}">
                               <button class="btn btn-primary btn-md my-0 p mt-5" type="submit">Añadir
                                  <i class="fas fa-shopping-cart ml-1"></i>
                               </button>
                          </div>
                        </div>
                      </div>
                    </div>

                   
                  </div>
                </div> 

                
             </div>
            </form> 
          </div>

       </div> 
      
  </main>
  
@endsection
@section('scripts')

<script>
  $(document).ready(function (){

 var precio = 1;
 var cantidad = 1;
 var total = 1;

 $("#precio").val(precio.toFixed(2));
 $("#cantidad").val(cantidad);
 $("#total").val(total.toFixed(2));

 $('[name=quantity]').change(function(){
          if (!(this.value < 1)) {

         $("#cantidad").val(this.value)
         $("#total").val(this.value * total.toFixed(2));
          }
      });

 });



</script>

 <script type="text/javascript">
     // Treeview Initialization
/**/

$(document).ready(function() {
  $("#myCarousel").on("slide.bs.carousel", function(e) {
    var $e = $(e.relatedTarget);
    var idx = $e.index();
    var itemsPerSlide = 3;
    var totalItems = $(".carousel-item").length;

    if (idx >= totalItems - (itemsPerSlide - 1)) {
      var it = itemsPerSlide - (totalItems - idx);
      for (var i = 0; i < it; i++) {
        // append slides to end
        if (e.direction == "left") {
          $(".carousel-item")
            .eq(i)
            .appendTo(".carousel-inner");
        } else {
          $(".carousel-item")
            .eq(0)
            .appendTo($(this).find(".carousel-inner"));
        }
      }
    }
  });
});

 </script>

 <script>
   $(document).ready(function() {
  /* ==========================================================================
   New Products Owl Carousel
   ========================================================================== */
  $("#new-products").owlCarousel({
      navigation: true,
      pagination: false,
      slideSpeed: 1000,
      stopOnHover: true,
      autoPlay: true,
      items: 4,
      itemsDesktopSmall: [1024, 2],
      itemsTablet: [600, 1],
      itemsMobile: [479, 1]
  });
  $('#new-products').find('.owl-prev').html('<i class="fa fa-angle-left"></i>');
  $('#new-products').find('.owl-next').html('<i class="fa fa-angle-right"></i>');

/* Client Owl Carousel
========================================================*/
$("#client-logo").owlCarousel({
    navigation: false,
    pagination: false,
    slideSpeed: 1000,
    stopOnHover: true,
    autoPlay: true,
    items: 5,
    itemsDesktopSmall: [1024, 3],
    itemsTablet: [600, 1],
    itemsMobile: [479, 1]
});

/* Testimonials Carousel active
========================================================*/
var owl = $(".testimonials-carousel");
  owl.owlCarousel({
    navigation: false,
    pagination: true,
    slideSpeed: 1000,
    stopOnHover: true,
    autoPlay: true,
    items: 1,
    itemsDesktopSmall: [1024, 1],
    itemsTablet: [600, 1],
    itemsMobile: [479, 1]
  });

/* Touch Owl Carousel active
========================================================*/
var owl = $(".touch-slider");
  owl.owlCarousel({
    navigation: true,
    pagination: false,
    slideSpeed: 1000,
    stopOnHover: true,
    autoPlay: true,
    items: 1,
    itemsDesktopSmall: [1024, 1],
    itemsTablet: [600, 1],
    itemsMobile: [479, 1]
  });

$('.touch-slider').find('.owl-prev').html('<i class="fa fa-angle-left"></i>');
$('.touch-slider').find('.owl-next').html('<i class="fa fa-angle-right"></i>');

$('.testimonials-carousel').find('.owl-prev').html('<i class="fa fa-angle-left"></i>');
$('.testimonials-carousel').find('.owl-next').html('<i class="fa fa-angle-right"></i>');

/* owl Carousel active
========================================================*/   
var owl;
$(window).on('load', function() {
    owl = $("#owl-demo");
    owl.owlCarousel({
        navigation: false, // Show next and prev buttons
        slideSpeed: 300,
        paginationSpeed: 400,
        singleItem: true,
        afterInit: afterOWLinit, // do some work after OWL init
        afterUpdate : afterOWLinit
    });

    function afterOWLinit() {
        // adding A to div.owl-page
        $('.owl-controls .owl-page').append('<a class="item-link" />');
        var pafinatorsLink = $('.owl-controls .item-link');
        /**
         * this.owl.userItems - it's your HTML <div class="item"><img src="http://www.ow...t of us"></div>
         */
        $.each(this.owl.userItems, function (i) {
          $(pafinatorsLink[i])
              // i - counter
              // Give some styles and set background image for pagination item
              .css({
                  'background': 'url(' + $(this).find('img').attr('src') + ') center center no-repeat',
                  '-webkit-background-size': 'cover',
                  '-moz-background-size': 'cover',
                  '-o-background-size': 'cover',
                  'background-size': 'cover'
              })
              // set Custom Event for pagination item
              .on('click',function () {
                  owl.trigger('owl.goTo', i);
              });

        });
         // add Custom PREV NEXT controls
        $('.owl-pagination').prepend('<a href="#prev" class="prev-owl"/>');
        $('.owl-pagination').append('<a href="#next" class="next-owl"/>');
        // set Custom event for NEXT custom control
        $(".next-owl").on('click',function () {
            owl.trigger('owl.next');
        });
        // set Custom event for PREV custom control
        $(".prev-owl").on('click',function () {
            owl.trigger('owl.prev');
        });
    }
});

/* Toggle active
========================================================*/
  var o = $('.toggle');
  $(window).on('load', function() {
    $('.toggle').on('click',function (e) {
      e.preventDefault();
      var tmp = $(this);
      o.each(function () {
        if ($(this).hasClass('active') && !$(this).is(tmp)) {
          $(this).parent().find('.toggle_cont').slideToggle();
          $(this).removeClass('active');
        }
      });
      $(this).toggleClass('active');
      $(this).parent().find('.toggle_cont').slideToggle();
    });
    $(window).on('click touchstart', function (e) {
      var container = $(".toggle-wrap");
      if (!container.is(e.target) && container.has(e.target).length === 0 && container.find('.toggle').hasClass('active')) { 
        container.find('.active').toggleClass('active').parent().find('.toggle_cont').slideToggle();
      }
    });
  });
  

/* Back Top Link active
========================================================*/
  var offset = 200;
  var duration = 500;
  $(window).scroll(function() {
    if ($(this).scrollTop() > offset) {
      $('.back-to-top').fadeIn(400);
    } else {
      $('.back-to-top').fadeOut(400);
    }
  });

  $('.back-to-top').on('click',function(event) {
    event.preventDefault();
    $('html, body').animate({
      scrollTop: 0
    }, 600);
    return false;
  })

});
 </script>

@endsection

