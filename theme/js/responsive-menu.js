jQuery( function( $ ){
  var isActive  = false,
      threshold = 799,
      $bodyEl   = $( 'body' ),
      $navEl    = $( '.nav-primary .genesis-nav-menu' ),
      navClass  = 'responsive-menu-icon';




  function navToggle() {

    $navEl.slideToggle();
  }


  function navOn() {
    var el = '.' + navClass;

    isActive = true;

    $navEl.addClass("responsive-menu").after('<div class="'+navClass+'"></div>');

    $bodyEl.on( 'click', el, navToggle );
  }


  function navOff() {
    var el = '.' + navClass;

    isActive = false;

    $( el ).remove();

    $bodyEl.off( 'click', el );

    $navEl.removeAttr( 'style' ).removeClass( 'responsive-menu' );
  }


  function subNavOn() {

    $bodyEl.on( 'click', ".responsive-menu > .menu-item", function( event ) {
      if ( event.target !== this ) return;
      var $this = $( this );

        $this.find(".sub-menu:first")
        .slideToggle( function() {
          $this.parent().toggleClass("menu-open");
        });
    });
  }


  function subNavOff() {

    isActive = false;

    $bodyEl.off( 'click', ".responsive-menu > .menu-item");
    $("nav .sub-menu")
    $(".responsive-menu > .menu-item").removeClass("menu-open");
  }


  function navCheck() {

    if( threshold > window.innerWidth ) {

      if( isActive ) return;
      navOn();
      subNavOn();
    }
    else {
      navOff();
      subNavOff()
    }
  }


  (function navInit() {

    $( window ).on( 'resize', navCheck );

    if( threshold < window.innerWidth ) return;

    navOn();
    subNavOn();

  })();




});
