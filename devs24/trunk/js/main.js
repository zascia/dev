
$( document ).ready(function() {
    // When the user scrolls the page, execute myFunction 
    window.onscroll = function() {myFunction()};

    // Get the header
    var header = document.getElementById("header");

    // Get the offset position of the navbar
    var sticky = header.offsetTop;

    // Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
    function myFunction() {
    if (window.pageYOffset > sticky) {
        header.classList.add("sticky");
    } else {
        header.classList.remove("sticky");
    }
    }
    // Cache selectors
    
    if (screen.width >= 768){
        var lastId,
        topMenu = $(".main-menu"),
        topMenuHeight = topMenu.outerHeight()+100,
        // All list items
        menuItems = topMenu.find("a"),
        // Anchors corresponding to menu items
        scrollItems = menuItems.map(function(){
        var item = $($(this).attr("href"));
        if (item.length) { return item; }
        });
    }
    else {
        var lastId,
        topMenu = $(".main-menu"),
        topMenuHeight = topMenu.outerHeight()-100,
        // All list items
        menuItems = topMenu.find("a"),
        // Anchors corresponding to menu items
        scrollItems = menuItems.map(function(){
        var item = $($(this).attr("href"));
        if (item.length) { return item; }
        });
    }
        

    // Bind click handler to menu items
    // so we can get a fancy scroll animation
    menuItems.click(function(e){
        var href = $(this).attr("href"),
            offsetTop = href === "#" ? 0 : $(href).offset().top-topMenuHeight+1;
        $('html, body').stop().animate({ 
            scrollTop: offsetTop
        }, 300);
        e.preventDefault();
    });

    // Bind to scroll
    $(window).scroll(function(){
    // Get container scroll position
    var fromTop = $(this).scrollTop()+topMenuHeight;
    
    // Get id of current scroll item
    var cur = scrollItems.map(function(){
        if ($(this).offset().top < fromTop)
        return this;
    });
    // Get the id of the current element
    cur = cur[cur.length-1];
    var id = cur && cur.length ? cur[0].id : "";
    
    if (lastId !== id) {
        lastId = id;
        // Set/remove active class
        menuItems
            .parent().removeClass("active")
            .end().filter("[href='#"+id+"']").parent().addClass("active");
    }                   
    });
    $("#burger-menu").on('click', function() {
        if(!$('#header').hasClass('sticky')){
            $('#header').toggleClass("sticky");
        }
        $(this).toggleClass("open");
        if ( $( ".main-menu" ).is( ":hidden" ) ) {
            $( ".main-menu" ).show( "slow" );
        } else {
            $( ".main-menu" ).slideUp();
        }
    })


});



