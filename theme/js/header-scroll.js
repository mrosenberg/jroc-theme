jQuery( function( $ ) {
  var className = 'scrolled';
  var header    = document.querySelectorAll( 'header.site-header' )[0];

  function throttle( type, name, obj ) {
    const el      = obj || window;
    let   running = false;

    const func    = function() {
      if (running) { return; }
      running = true;

       requestAnimationFrame( function() {
          el.dispatchEvent( new CustomEvent( name ) );
          running = false;
      });
    };

    el.addEventListener( type, func );
  };



  function scrollCheck() {
    const winPos  = window.scrollY;

    if( winPos > 50 ) {
      header.classList.add( className );
    }
    else {
      header.classList.remove( className );
    }
  }


  (function headerScroll() {

    throttle( 'scroll', 'debouncedScroll' );

    scrollCheck();

    window.addEventListener( 'debouncedScroll', scrollCheck );

  }());


});
