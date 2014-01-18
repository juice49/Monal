/**
 * Conscious.js - v1.0.0
 *
 * A small and light weight standalone framework for writing javascript
 * bound to the window dimensions.
 *
 * @author Arran Jacques
 *
 * Licensed under The MIT License (MIT)
 * http://opensource.org/licenses/MIT
 * Copyright (c) 2013 Arran Jacques
 */

(function(window){
	
	'use strict';
	
	/**
	 * Conscious API
	 */
	window.conscious = {
		
		// Window's current state
		state : null,
		
		// State name assosicated with full screen display
		maxscreen : 'maxscreen',
		
		// Window states
		states : [],
		
		// A queue of functions to be called at each state change
		functionStateChangeQueue : [],
		
		// A queue of functions to be called each time the window is
		// resized
		functionResizeQueue : [],
		
		// Contains the <style> tag with the media queries for measuring
		// each break point
		styleTag: null,
		
		/**
		 * Loop through the function queues and call each function in turn
		 */
		callFunctionQueues : function(){
			
			var s = conscious.getState(true);
			if(s !== conscious.state){
				
				for(var n = 0; n < conscious.functionStateChangeQueue.length; n++){
					conscious.functionStateChangeQueue[n]();
				}
				
				conscious.state = s;
				
			}
			
			for(var i = 0; i < conscious.functionResizeQueue.length; i++){
				conscious.functionResizeQueue[i]();
			}
			
		},
		
		/**
		 * Return the current window state
		 *
		 * @param	Boolean			Use the window's width to work out
		 *							the current state where applicable.
		 *							This will force the function to call
		 *							in browsers that don't support media
		 *							queries
		 *
		 * @return	String
		 */
		getState : function(force){
			
			var ruler = document.getElementById('conscious_ruler_');

			if(ruler !== undefined && ruler !== null){
			
				if(ruler.clientWidth > 1){
				
					var rulerHeight = parseInt(ruler.clientHeight);
					
					if(rulerHeight >= rulerHeight && conscious.states[(rulerHeight - 1)] !== undefined){
						return conscious.states[(rulerHeight - 1)][0];
					}
					else if(rulerHeight === (conscious.states.length + 1)){
						return conscious.maxscreen;
					}
					
				}
			
			}
			
			if(force){
			
				var state = conscious.maxscreen,
					prevState = 0,
					windowWidth = window.innerWidth || document.documentElement.clientWidth;
					
				for(var i = 0; i < conscious.states.length; i++){
				
					if(windowWidth <= conscious.states[i][1] && windowWidth > prevState){
						state = conscious.states[i][0];
					}
					
					prevState = conscious.states[i][1];
				
				}
				
				return state;
				
			}
			
			return conscious.maxscreen;
			
		},
		
		/**
		 * Return the device's pixel ratio
		 *
		 * @return	Int
		 */
		pixelRatio : function(){
		
			if(window.devicePixelRatio){
				return window.devicePixelRatio;	
			}
			
			if(window.screen.availWidth && document.documentElement.clientWidth){
				return Math.round(window.screen.availWidth / document.documentElement.clientWidth);
			}
			
			return 1;
			
		},
		
		/**
		 * Return the array index of a specified state within the states
		 * array
		 *
		 * @param	String			Name of state to check
		 *
		 * @return	Mixed			Index of breakpoint / false if invalid
		 */
		statePosition : function(p){
		
			if(p === conscious.maxscreen){
				return parseInt(conscious.states.length);
			}
			
			for(var i = 0; i < conscious.states.length; i++){
				
				if(p === conscious.states[i][0]){
					return parseInt(i);
				}
			
			}
			
			return false;
			
		},
		
		/**
		 * Add a state
		 *
		 * @param	String/Object	String: the name of the new state.
		 *							Object: can be used to set multiple
		 *							states at once: {
		 *								'stateName' : 767,
		 *								'stateName' : 968
		 *							}
		 * @param	Int				Window width associated with state.
		 *							Only applicable if passing a string
		 *							as first param
		 *
		 * @return	Boolean
		 */
		setState : function(a, b){
			
			var c = new CONSCIOUS();
			
			if(typeof a === 'object'){
			
				for(var key in a){
					c.addState(key, parseInt(a[key]));
				}
			
			}
			else if(typeof a === 'string'){
				c.addState(a, parseInt(b));
			}
			else{
				return false;
			}
			
			var h = document.getElementsByTagName('head')[0];
			
			if(conscious.styleTag !== null){
				conscious.styleTag.parentNode.removeChild(conscious.styleTag);
			}
			
			conscious.styleTag = c.appendRulerStyles();
			h.appendChild(conscious.styleTag);

			return true;
		
		},
		
		/**
		 * Call a function when then DOM is ready or the window has
		 * loaded
		 *
		 * @param	String			'load' or 'ready'
		 * @param	Function		Function to call
		 *
		 * @return	Boolean
		 */
		pageInit : function(on, fn){
			
			if(typeof on === 'string'){
			
				if(on === 'ready'){
					DOMDETECT.queueReadyFunction(fn);
					return true;
				}
				else if(on === 'load'){
					DOMDETECT.queueLoadFunction(fn);
					return true;
				}
			
			}
			
			return false;
			
		},
		
		/**
		 * Call a function when then DOM is ready or the window has
		 * loaded based on the state it loads in
		 *
		 * @param	String			'load' or 'ready'
		 * @param	String/Object	String: the name of the state the
		 *							window should load in to call the
		 *							function.
		 *							Object: can be used to set functions 
		 *							for multiple states at once: {
		 *								'stateName' : functionToCall,
		 *								'stateName' : functionToCall
		 *							}
		 * @param	Function/Bool	Function  = function to call at given
		 *							state, if passing a string as second
		 *							param.
		 *							Boolean = use force state, if passing
		 *							an object for second param
		 * @param	Boolean			Use force state. Only applicable if
		 *							passing a string as second param
		 *
		 * @return	Boolean
		 */
		initByState : function(on, a, b, f){
			
			if(typeof on === 'string'){
			
				var c = new CONSCIOUS(),
					fn;

				if(typeof a === 'string' && typeof b === 'function'){
					fn = function(){
						c.initByState(a, b, f);
					};
				}
				else if(typeof a === 'object'){
					fn = function(){
						c.initByState(a, b);
					};
				}
					
				if(on === 'ready'){
					DOMDETECT.queueReadyFunction(fn);
					return true;
				}
				else if(on === 'load'){
					DOMDETECT.queueLoadFunction(fn);
					return true;
				}
			
			}
			
			return false;		
			
		},
		
		/**
		 * Call a given function every time the window in resized
		 *
		 * @param	Function		Function to call
		 *
		 * @return	Boolean
		 */
		onResize : function(fn){
		
			if(typeof fn === 'function'){

				var c = new CONSCIOUS(),
					fun = function(){
					c.defaultCall(fn);
				};
				conscious.functionResizeQueue.push(fun);
				return true;
			}
			
			return false;
			
		},
		
		/**
		 * Call a function when the window enters a new state if the
		 * new state matches the state assosiated with the function
		 *
		 * @param	String/Object	String: the name of the state the
		 *							window should enter to call the
		 *							function.
		 *							Object: can be used to set functions 
		 *							for multiple states at once: {
		 *								'stateName' : functionToCall,
		 *								'stateName' : functionToCall
		 *							}
		 * @param	Function/Bool	Function: function to call upon
		 *							entering new state, if passing a
		 *							string as first param.
		 *							Boolean: use force state, if passing
		 *							an object for first param
		 * @param	Boolean			Use force get state. Only applicable if
		 *							passing a function as second param
		 *
		 * @return	Boolean
		 */
		stateChangeTo : function(a, b, f){
			
			var c = new CONSCIOUS(),
				fun;
					
			if(typeof a === 'object'){
				
				fun = function(){
					c.stateCall(a, b);
				};
				conscious.functionStateChangeQueue.push(fun);
				return true;
			
			}
			else if(typeof a === 'string' && typeof b === 'function'){
			
				var obj = {};
				obj[a] = b;
				fun = function(){
					c.stateCall(obj, f);
				};
				conscious.functionStateChangeQueue.push(fun);
				return true;
				
			}
				
			return false;
			
		},
			
		/**
		 * Call a function on window resize if the window state matches
		 * the state assosiated with the function
		 *
		 * @param	String/Object	String: the name of the state the
		 *							window should be in to call the
		 *							function.
		 *							Object: can be used to set functions 
		 *							for multiple states at once: {
		 *								'stateName' : functionToCall,
		 *								'stateName' : functionToCall
		 *							}
		 * @param	Function/Bool	Function: function to call when
		 *							resizing in given state, if passing
		 *							a string as first param.
		 *							Boolean: use force state, if passing
		 *							an object for first param
		 * @param	Boolean			Use force state. Only applicable if
		 *							passing a function as second param
		 *
		 * @return	Boolean
		 */
		whenStateIs : function(a, b, f){

			var c = new CONSCIOUS(),
				fun;
				
			if(typeof a === 'object'){

				fun = function(){
					c.stateCall(a, b);
				};
				conscious.functionResizeQueue.push(fun);
				return true;

			}
			else if(typeof a === 'string' && typeof b === 'function'){
			
				var obj = {};
				obj[a] = b;
				fun = function(){
					c.stateCall(obj, f);
				};
				conscious.functionResizeQueue.push(fun);
				return true;
				
			}
				
			return false;
			
		},
		
		/**
		 * Call a function on window resize if the state falls between
		 * the two specified states 
		 *
		 * @param	String			First state
		 * @param	String			Last state
		 * @param	Function		Function to call between states
		 * @param	Boolean			Use force state
		 *
		 * @return	Boolean
		 */
		betweenStates : function(a, b, fn, f){

			if(typeof a === 'string' && typeof b === 'string' && typeof fn === 'function'){
				
				var cn = new CONSCIOUS(),
					obj = {},
					c = conscious.statePosition(a),
					d = conscious.statePosition(b),
					y,
					z,
					fun;
		
				if(c === false || b === false){
					return false;
				}
				
				if(c === d){
					obj[a] = fn;
					fun = function(){
						cn.stateCall(obj, f);
					};
					conscious.functionResizeQueue.push(fun);
					return true;
				}
				else if(c < d){
					y = c;
					z = d;
				}
				else{
					y = c;
					z = d;
				}
				
				for(var i = y; i <= z; i++){
					
					if(i === conscious.states.length){
						obj[conscious.maxscreen] = fn;
					}
					else{
						obj[conscious.states[i][0]] = fn;
					}
					
				}
				
				fun = function(){
					cn.stateCall(obj, f);
				};
				conscious.functionResizeQueue.push(fun);
				
				return true;
			
			}
			
			return false;
			 
		}
		
	};
	
	/**
	 * Conscious object
	 */
	function CONSCIOUS(){
		
		/**
		 * Appends the ruler div to the DOM
		 */
		this.appendRuler = function(){
			
			var r = document.createElement('div');
			r.style.position = 'absolute';
			r.style.left = '-10000px';
			r.setAttribute('id', 'conscious_ruler_');
			var b = document.getElementsByTagName('body')[0];
			b.appendChild(r);
			
			conscious.state = conscious.getState(true);
			
		};
	
		/**
		 * Return a style tag that contains media queries for each state
		 *
		 * @return	String
		 */
		this.appendRulerStyles = function(){
			
			var styleTag = document.createElement('style');
			styleTag.setAttribute('type', 'text/css');
			styleTag.setAttribute('media', 'screen');
			
			var css = '#conscious_ruler_{width:1px;height:' + (conscious.states.length + 1) + 'px;} ';

			for(var i = 0; i < conscious.states.length; i++){
			
				if(i === 0){
				
					var max = conscious.states[i][1];
					css += '@media screen and (max-device-width:' + max + 'px), screen and (max-width:' + max + 'px){#conscious_ruler_{height:' + (i + 1) + 'px;}} ';
						
				}
				else{
				
					var min = conscious.states[(i - 1)][1] + 1,
						max = conscious.states[i][1];
					css += '@media screen and (min-device-width:' + min + 'px) and (max-device-width:' + max + 'px), screen and (min-width:' + min + 'px) and (max-width:' + max + 'px){#conscious_ruler_{height:' + (i + 1) + 'px;}}';
					
				}
				
			}
			
			css += '@media screen and (min-device-width:1px), screen and (min-width:1px){#conscious_ruler_{width:10px;}} ';
			
			if(styleTag.styleSheet){
				styleTag.styleSheet.cssText = css;
			}
			else{
				styleTag.appendChild(document.createTextNode(css));
			}
			
			return styleTag;
			
		};
		
		/**
		 * Add a new state
		 *
		 * @param	String			Name of new state
		 * @param	Int				Window width assosiated with state
		 */
		this.addState = function(name, width){
			
			if(conscious.states.length === 0){
				conscious.states.push([name, width]);
			}
			else{
				
				var pos,
					trackVal = null;
					
				for(var i = 0; i < conscious.states.length; i++){
					
					if(width < conscious.states[i][1]){
						
						if(trackVal === null){
							trackVal = conscious.states[i][1];
							pos = i;
						}
			
					}
					else{
						pos = i + 1;
					}
					
				}
				
				conscious.states.splice(pos, 0, [name, width]);
				
			}
			
		};
		
		/**
		 * Call a function when then DOM is ready or the window has loaded
		 *
		 * @param	String/Object	String: the name of the state the
		 *							window should load in to call the
		 *							function.
		 *							Object: can be used to set functions 
		 *							for multiple states at once: {
		 *								'stateName' : functionToCall,
		 *								'stateName' : functionToCall
		 *							}
		 * @param	Function/Bool	Function: function to call, if passing
		 *							a string for first param.
		 *							Boolean: Use force state, if passing
		 *							a string for first param
		 * @param	Boolean			Use force state. Only applicable if
		 *							passing a function as second param
		 *
		 * @return	Boolean
		 */
		this.initByState = function(a, b, f){
		
			if(typeof a === 'string' && typeof b === 'function'){
				
				var force = f ? true : false;
				if(conscious.getState(force) === a){
					b();
				}
				
			}
			else if(typeof a === 'object'){
			
				var force = b ? true : false;
				if(typeof a[conscious.getState(force)] === 'function'){
					a[conscious.getState(force)]();
				}
			}
		
		};
		
		/**
		 * Calls any function it is passed
		 *
		 * @param	Function
		 */
		this.defaultCall = function(fn){
			
			if(typeof fn === 'function'){
				fn();
			}
			
		};
		
		/**
		 * Call a function associated with the current window state
		 *
		 * @param	Object			Object containing state and
		 *							assosiated function: {
		 *								'stateName' : functionToCall,
		 *								'stateName' : functionToCall
		 *							}
		 * @param	Boolean			Use force state
		 */
		this.stateCall = function(fn, f){
			
			var force = f ? true : false;
			if(typeof fn === 'object' && typeof fn[conscious.getState(force)] === 'function'){
				fn[conscious.getState(force)]();	
			}
			
		};
		
	}
	
	/**
	 * DOM State Detection Object
	 */
	var DOMDETECT = {
		
		// Has the DOM fully loaded
		domReady : false,
		
		// A queue of functions to be called as soon as the DOM is ready
		domReadyQueue : [],

		// Has the window fully loaded
		windowLoaded : false,
		
		// A queue of functions to be called once the window is fully
		// loaded
		windowLoadQueue : [],

		// Stores a timer that is used to check when the document is ready
		// via document.readyState
		domTimer : false,
		
		/**
		 * Queues functions to be called as soon as the DOM is ready
		 */
		queueReadyFunction : function(fn){
		
			// If the DOM isn't ready then start queuing functions
			if(!DOMDETECT.domReady){

				if(DOMDETECT.domReadyQueue[0] === undefined){
					DOMDETECT.domReadyQueue[DOMDETECT.domReadyQueue.length + 1] = fn;
				}
				else{
					DOMDETECT.domReadyQueue[DOMDETECT.domReadyQueue.length] = fn;
				}

			}
			// If the DOM has already loaded then go ahead and call the
			// function
			else{
				fn();
			}
			
		},

		/**
		 * Queues functions to be called once the window has loaded
		 */
		queueLoadFunction : function(fn){
		
			// If the window hasn't fully loaded then start queuing
			// functions
			if(!DOMDETECT.windowLoaded){
				DOMDETECT.windowLoadQueue[DOMDETECT.windowLoadQueue.length] = fn;
			}
			// If the window has already been loaded then go ahead and
			// call the function
			else{
				fn();
			}
			
		},
		
		/**
		 * Loop through the domReadyQueue queue and call each function
		 * in order
		 */
		callReadyQueue : function(){
			
			if(!DOMDETECT.domReady){
			
				for(var i = 0; i < DOMDETECT.domReadyQueue.length; i++){
					DOMDETECT.domReadyQueue[i]();
				}
				
				DOMDETECT.domReady = true;
				
			}
		},

		/**
		 * Loop through the windowLoaded queue and call each function
		 * in order
		 */
		callLoadQueue : function(){

			if(!DOMDETECT.windowLoaded){
			
				for(var i = 0; i < DOMDETECT.windowLoadQueue.length; i++){
					DOMDETECT.windowLoadQueue[i]();
				}
				
				DOMDETECT.windowLoaded = true;
				
			}
		},

		/**
		 * Clear both function queues by calling each function in turn
		 */
		clearQueues : function(){

			clearInterval(DOMDETECT.domTimer);
			DOMDETECT.callReadyQueue();
			DOMDETECT.callLoadQueue();

		}
		
	};
	
	var bdy = document.getElementsByTagName('body')[0];
	
	// Check if the body tag is available to append the ruler to and
	// if so append it
	if(bdy !== undefined && bdy !== null){
		var c = new CONSCIOUS();
		c.appendRuler();	
	}
	// If it's not, set the first index of the domReadyQueue to be the
	// function that adds the conscious ruler to the page. This will
	// ensure the ruler is added before any other functions are called
	else{
		var c = new CONSCIOUS();
		DOMDETECT.domReadyQueue[0] = c.appendRuler;
	}
	
	// listen for the DOM to be loaded. As soon as it is ready call
	// any functions queued in the domReadyQueue
	if(document.addEventListener){
	
        document.addEventListener('DOMContentLoaded', DOMDETECT.callReadyQueue, false);
        window.addEventListener('onload', DOMDETECT.callReadyQueue);
		
    }
    
    else if(document.attachEvent){
    
		document.attachEvent('onreadystatechange', DOMDETECT.callReadyQueue);
		window.attachEvent('onload', DOMDETECT.callReadyQueue);
		
    }
    else if(document.readyState){
		
		DOMDETECT.domTimer = setInterval(function(){
		
			if(document.readyState === 'complete'){
				DOMDETECT.callReadyQueue();
				clearInterval(DOMDETECT.domTimer);
			}
			
		}, 10);
		
    }
	
	// Once the window has loaded call both load and ready queues.
	// This will ensure that the ready queue is also cleared in the
	// event that none of the events above are fired
	window.onload = DOMDETECT.clearQueues;

	// On window resize call the functions queue
	window.onresize = conscious.callFunctionQueues;

})(window);