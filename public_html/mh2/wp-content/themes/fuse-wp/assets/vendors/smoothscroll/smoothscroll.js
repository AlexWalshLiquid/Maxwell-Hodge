/**
 * Smoothens scrolling for the whole webpage.
 *
 * Instructions: Just include this script in your head tag and it's good to go
 * <script type='text/javascript' src='nfwVCp-smoothscroll.js'></script>
 *
 * @package	nfwVCp Smooth Scroll script
 * @author	Benjamin Intal, nfwVCp
 * @url		http://nfwVCp.ph
 * @see		Inspired by: http://www.kirupa.com/html5/smooth_parallax_scrolling.htm
 * @version	1.1.1
 */

// Changeable settings
if ( typeof window.nfwVCpScrollDecompositionRate === 'undefined' ) {
	window.nfwVCpScrollDecompositionRate = 0.94;
}
if ( typeof window.nfwVCpScrollKeyAmount === 'undefined' ) {
	window.nfwVCpScrollKeyAmount = 16;
}
if ( typeof window.nfwVCpScrollWheelAmount === 'undefined' ) {
	window.nfwVCpScrollWheelAmount = 12;
}
if ( typeof window.nfwVCpUseRequestAnimationFrame === 'undefined' ) {
	window.nfwVCpUseRequestAnimationFrame = true;
}

var _nfwVCpScrollInterval = null;


//---------------------------------- DO NOT EDIT STUFF BELOW ----------------------------------//


/*
 * Modernizr touch detection only
 */
if ( typeof( Modernizr ) === 'undefined' ) {
	;window.Modernizr=function(a,b,c){function v(a){i.cssText=a}function w(a,b){return v(l.join(a+";")+(b||""))}function x(a,b){return typeof a===b}function y(a,b){return!!~(""+a).indexOf(b)}function z(a,b,d){for(var e in a){var f=b[a[e]];if(f!==c)return d===!1?a[e]:x(f,"function")?f.bind(d||b):f}return!1}var d="2.8.3",e={},f=b.documentElement,g="modernizr",h=b.createElement(g),i=h.style,j,k={}.toString,l=" -webkit- -moz- -o- -ms- ".split(" "),m={},n={},o={},p=[],q=p.slice,r,s=function(a,c,d,e){var h,i,j,k,l=b.createElement("div"),m=b.body,n=m||b.createElement("body");if(parseInt(d,10))while(d--)j=b.createElement("div"),j.id=e?e[d]:g+(d+1),l.appendChild(j);return h=["&#173;",'<style id="s',g,'">',a,"</style>"].join(""),l.id=g,(m?l:n).innerHTML+=h,n.appendChild(l),m||(n.style.background="",n.style.overflow="hidden",k=f.style.overflow,f.style.overflow="hidden",f.appendChild(n)),i=c(l,a),m?l.parentNode.removeChild(l):(n.parentNode.removeChild(n),f.style.overflow=k),!!i},t={}.hasOwnProperty,u;!x(t,"undefined")&&!x(t.call,"undefined")?u=function(a,b){return t.call(a,b)}:u=function(a,b){return b in a&&x(a.constructor.prototype[b],"undefined")},Function.prototype.bind||(Function.prototype.bind=function(b){var c=this;if(typeof c!="function")throw new TypeError;var d=q.call(arguments,1),e=function(){if(this instanceof e){var a=function(){};a.prototype=c.prototype;var f=new a,g=c.apply(f,d.concat(q.call(arguments)));return Object(g)===g?g:f}return c.apply(b,d.concat(q.call(arguments)))};return e}),m.touch=function(){var c;return"ontouchstart"in a||a.DocumentTouch&&b instanceof DocumentTouch?c=!0:s(["@media (",l.join("touch-enabled),("),g,")","{#modernizr{top:9px;position:absolute}}"].join(""),function(a){c=a.offsetTop===9}),c};for(var A in m)u(m,A)&&(r=A.toLowerCase(),e[r]=m[A](),p.push((e[r]?"":"no-")+r));return e.addTest=function(a,b){if(typeof a=="object")for(var d in a)u(a,d)&&e.addTest(d,a[d]);else{a=a.toLowerCase();if(e[a]!==c)return e;b=typeof b=="function"?b():b,typeof enableClasses!="undefined"&&enableClasses&&(f.className+=" "+(b?"":"no-")+a),e[a]=b}return e},v(""),h=j=null,e._version=d,e._prefixes=l,e.testStyles=s,e}(this,this.document);
}


/**
 * requestAnimationFrame polyfill
 *
 * http://paulirish.com/2011/requestanimationframe-for-smart-animating/
 * http://my.opera.com/emoller/blog/2011/12/20/requestanimationframe-for-smart-er-animating
 * requestAnimationFrame polyfill by Erik Möller. fixes from Paul Irish and Tino Zijdel
 * requestAnimationFrame polyfill under MIT license
 */
(function() {
    var lastTime = 0;
    var vendors = ['ms', 'moz', 'webkit', 'o'];
    for( var x = 0; x < vendors.length && ! window.requestAnimationFrame; ++x ) {
        window.requestAnimationFrame = window[vendors[x]+'RequestAnimationFrame'];
    }

    if (!window.requestAnimationFrame) {
        window.requestAnimationFrame = function( callback, element ) {
            return window.setTimeout( function() { callback() }, 16.667 );
        };
	}
}());


(function() {

	// _nfwVCp_SMOOTH_SCROLLER will be defined if smooth scrolling here was already performed,
	// This is mainly here just incase our other items use this smooth scroller also
	if ( typeof _nfwVCp_SMOOTH_SCROLLER_DONE !== 'undefined' ) {
		return;
	}

	// Variables used by the script
	var scrollWheelActive = false;
	var scrollDelta = 0;
	var scrollAmount = 12;
	var scrollOverrideDelta = false;
	var scrollTarget = window;
	var isMac = navigator.platform.toUpperCase().indexOf('MAC') !== -1;

	/**
	 * Called on keydown, only entertain down/up keys
	 *
	 * @param	e Event object
	 * @return	void
	 */
	function keyDownListener(e) {
		if ( e.which === 40 ) {
			scrollOverrideDelta = true;
			scrollAmount = window.nfwVCpScrollKeyAmount;
			scrollDelta = -1;
			scrollWheelActive = true;
			scrollTarget = window; // Always scroll the whole window
		} else if ( e.which === 38 ) {
			scrollOverrideDelta = true;
			scrollAmount = window.nfwVCpScrollKeyAmount;
			scrollDelta = 1;
			scrollWheelActive = true;
			scrollTarget = window; // Always scroll the whole window
		}
	}


	/**
	 * Called when the mouse scroll wheel is used
	 *
	 * @param	e Event object
	 * @return	void
	 */
	function scrollListener( e ) {

		// Cancel the default scroll behavior
		if ( e.preventDefault ) {
			e.preventDefault();
		}

		// Deal with different browsers calculating the delta differently
		// Don't apply scroll stuff when the up/down keys were pressed
		// while we are scrolling to prevent jumping
		if ( ! scrollOverrideDelta ) {
			if ( e.wheelDelta ) {
				scrollDelta = e.wheelDelta / 120;
			} else if ( isMac && e.detail ) {
				scrollDelta = -e.detail;
			} else if ( e.detail ) {
				scrollDelta = -e.detail / 3;
			}
			scrollAmount = window.nfwVCpScrollWheelAmount;

			// Check whether we should scroll the inner scrollbar
			// or the main window
			var target = e.target;
			scrollTarget = window;
			while ( target.tagName != 'HTML' ) {
				if ( target.scrollHeight > target.clientHeight ) {
					if ( typeof target.style.overflow !== 'undefined' ) {
						if ( target.style.overflow !== 'hidden'
							 && target.style.overflow !== 'visible'
							 && target.style.overflow !== '' ) {
							scrollTarget = target;
							break;
						}
					}
				}
				target = target.parentNode;
			}
		}

		scrollWheelActive = true;
	}


	/**
	 * Performs the actual scrolling
	 *
	 * @return	void
	 */
	function animationLoop() {

		// Perform the scroll only on up/down/scroll events
		if ( scrollWheelActive ) {

			// Scroll the window
			if ( scrollTarget == window ) {
				scrollTarget.scrollBy( scrollTarget.scrollX, - scrollDelta * scrollAmount );
			// Scroll just scrollable the element
			} else {
				scrollTarget.scrollTop = scrollTarget.scrollTop - scrollDelta * scrollAmount;
			}

			// Lessen scroll amount gradually
			scrollAmount *= window.nfwVCpScrollDecompositionRate;

			// If scroll amount is too small, stop, we can't see
			// less than 1 pixel scrolls anyway
			if ( scrollAmount <= 1 ) {
				scrollAmount = 0;
				scrollWheelActive = false;
				scrollDelta = 0;
				scrollOverrideDelta = false;
			}
		}

		if ( window.nfwVCpUseRequestAnimationFrame ) {
			window.requestAnimationFrame( animationLoop );
			if ( _nfwVCpScrollInterval != null ) {
				clearInterval( _nfwVCpScrollInterval );
				_nfwVCpScrollInterval = null;
			}
		} else {
			if ( _nfwVCpScrollInterval === null ) {
				_nfwVCpScrollInterval = setInterval( function() {
					animationLoop();
				}, 16.667 );
			}
		}
	}


	/**
	 * Start the scrolling
	 */
	// Don't smoothen in mobile touch devices
	if ( ( Modernizr.touch && window.screen.width <= 1024 ) || // touch device estimate
	 	 ( window.screen.width <= 1281 && window.devicePixelRatio > 1 ) ) { // device size estimate
		return;
	}

	// Bind to the mousewheel to find out the direction of our scroll
	window.addEventListener( "mousewheel", scrollListener, false );
	window.addEventListener( "DOMMouseScroll", scrollListener, false );

	// Bind to the up & down keys also
	window.addEventListener( "keydown", keyDownListener, false );

	// This does the actual scroll
	if ( window.nfwVCpUseRequestAnimationFrame ) {
		window.requestAnimationFrame( animationLoop );
	} else {
		_nfwVCpScrollInterval = setInterval( function() {
			animationLoop();
		}, 16.667 );
	}

}());

// Define _nfwVCp_SMOOTH_SCROLLER to indicate that smooth scrolling was already performed,
// This is mainly here just incase our other items use this smooth scroller also
// and that smooth scrolling can only be bound/applied once.
var _nfwVCp_SMOOTH_SCROLLER_DONE = true;