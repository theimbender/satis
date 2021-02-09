!function(){"use strict";var e={609:function(e,t){Object.defineProperty(t,"__esModule",{value:!0}),t.default=function(e,t){if(null==e)throw new TypeError("assign requires that input parameter not be null or undefined");for(var a in t=t||{})t.hasOwnProperty(a)&&(e[a]=t[a]);return e},e.exports=t.default},420:function(e,t,a){Object.defineProperty(t,"__esModule",{value:!0}),t.default=function(e){return(0,r.default)({},e)};var n,r=(n=a(609))&&n.__esModule?n:{default:n};e.exports=t.default},561:function(e,t){Object.defineProperty(t,"__esModule",{value:!0}),t.default=function(e){var t=new Date(e.getTime()),r=Math.ceil(t.getTimezoneOffset());t.setSeconds(0,0);var o=r>0?(a+n(t))%a:n(t);return r*a+o};var a=6e4;function n(e){return e.getTime()%a}e.exports=t.default},734:function(e,t){Object.defineProperty(t,"__esModule",{value:!0}),t.default=function(e,t){if(t.length<e)throw new TypeError(e+" argument"+(e>1?"s":"")+" required, but only "+t.length+" present")},e.exports=t.default},196:function(e,t,a){Object.defineProperty(t,"__esModule",{value:!0}),t.default=function(e,t){(0,r.default)(2,arguments);var a=(0,n.default)(e),o=(0,n.default)(t),u=a.getTime()-o.getTime();return u<0?-1:u>0?1:u};var n=o(a(171)),r=o(a(734));function o(e){return e&&e.__esModule?e:{default:e}}e.exports=t.default},509:function(e,t,a){Object.defineProperty(t,"__esModule",{value:!0}),t.default=function(e,t){(0,r.default)(2,arguments);var a=(0,n.default)(e),o=(0,n.default)(t),u=a.getFullYear()-o.getFullYear(),i=a.getMonth()-o.getMonth();return 12*u+i};var n=o(a(171)),r=o(a(734));function o(e){return e&&e.__esModule?e:{default:e}}e.exports=t.default},384:function(e,t,a){Object.defineProperty(t,"__esModule",{value:!0}),t.default=function(e,t){(0,r.default)(2,arguments);var a=(0,n.default)(e),o=(0,n.default)(t);return a.getTime()-o.getTime()};var n=o(a(171)),r=o(a(734));function o(e){return e&&e.__esModule?e:{default:e}}e.exports=t.default},650:function(e,t,a){Object.defineProperty(t,"__esModule",{value:!0}),t.default=function(e,t){(0,u.default)(2,arguments);var a=(0,n.default)(e),l=(0,n.default)(t),d=(0,o.default)(a,l),s=Math.abs((0,r.default)(a,l));1===a.getMonth()&&a.getDate()>27&&a.setDate(30);a.setMonth(a.getMonth()-d*s);var f=(0,o.default)(a,l)===-d;(0,i.default)((0,n.default)(e))&&1===s&&1===(0,o.default)(e,l)&&(f=!1);var c=d*(s-f);return 0===c?0:c};var n=l(a(171)),r=l(a(509)),o=l(a(196)),u=l(a(734)),i=l(a(165));function l(e){return e&&e.__esModule?e:{default:e}}e.exports=t.default},180:function(e,t,a){Object.defineProperty(t,"__esModule",{value:!0}),t.default=function(e,t){(0,r.default)(2,arguments);var a=(0,n.default)(e,t)/1e3;return a>0?Math.floor(a):Math.ceil(a)};var n=o(a(384)),r=o(a(734));function o(e){return e&&e.__esModule?e:{default:e}}e.exports=t.default},771:function(e,t,a){Object.defineProperty(t,"__esModule",{value:!0}),t.default=function(e){(0,r.default)(1,arguments);var t=(0,n.default)(e);return t.setHours(23,59,59,999),t};var n=o(a(171)),r=o(a(734));function o(e){return e&&e.__esModule?e:{default:e}}e.exports=t.default},554:function(e,t,a){Object.defineProperty(t,"__esModule",{value:!0}),t.default=function(e){(0,r.default)(1,arguments);var t=(0,n.default)(e),a=t.getMonth();return t.setFullYear(t.getFullYear(),a+1,0),t.setHours(23,59,59,999),t};var n=o(a(171)),r=o(a(734));function o(e){return e&&e.__esModule?e:{default:e}}e.exports=t.default},276:function(e,t,a){Object.defineProperty(t,"__esModule",{value:!0}),t.default=function(e,t,a){(0,s.default)(2,arguments);var f=a||{},m=f.locale||u.default;if(!m.formatDistance)throw new RangeError("locale must contain formatDistance property");var v=(0,n.default)(e,t);if(isNaN(v))throw new RangeError("Invalid time value");var p,g,y=(0,l.default)(f);y.addSuffix=Boolean(f.addSuffix),y.comparison=v,v>0?(p=(0,i.default)(t),g=(0,i.default)(e)):(p=(0,i.default)(e),g=(0,i.default)(t));var b,w=(0,o.default)(g,p),M=((0,d.default)(g)-(0,d.default)(p))/1e3,_=Math.round((w-M)/60);if(_<2)return f.includeSeconds?w<5?m.formatDistance("lessThanXSeconds",5,y):w<10?m.formatDistance("lessThanXSeconds",10,y):w<20?m.formatDistance("lessThanXSeconds",20,y):w<40?m.formatDistance("halfAMinute",null,y):w<60?m.formatDistance("lessThanXMinutes",1,y):m.formatDistance("xMinutes",1,y):0===_?m.formatDistance("lessThanXMinutes",1,y):m.formatDistance("xMinutes",_,y);if(_<45)return m.formatDistance("xMinutes",_,y);if(_<90)return m.formatDistance("aboutXHours",1,y);if(_<c){var P=Math.round(_/60);return m.formatDistance("aboutXHours",P,y)}if(_<2520)return m.formatDistance("xDays",1,y);if(_<h){var x=Math.round(_/c);return m.formatDistance("xDays",x,y)}if(_<86400)return b=Math.round(_/h),m.formatDistance("aboutXMonths",b,y);if((b=(0,r.default)(g,p))<12){var k=Math.round(_/h);return m.formatDistance("xMonths",k,y)}var j=b%12,O=Math.floor(b/12);return j<3?m.formatDistance("aboutXYears",O,y):j<9?m.formatDistance("overXYears",O,y):m.formatDistance("almostXYears",O+1,y)};var n=f(a(196)),r=f(a(650)),o=f(a(180)),u=f(a(512)),i=f(a(171)),l=f(a(420)),d=f(a(561)),s=f(a(734));function f(e){return e&&e.__esModule?e:{default:e}}var c=1440,h=43200;e.exports=t.default},82:function(e,t,a){Object.defineProperty(t,"__esModule",{value:!0}),t.default=function(e,t){return(0,r.default)(1,arguments),(0,n.default)(e,Date.now(),t)};var n=o(a(276)),r=o(a(734));function o(e){return e&&e.__esModule?e:{default:e}}e.exports=t.default},165:function(e,t,a){Object.defineProperty(t,"__esModule",{value:!0}),t.default=function(e){(0,u.default)(1,arguments);var t=(0,n.default)(e);return(0,r.default)(t).getTime()===(0,o.default)(t).getTime()};var n=i(a(171)),r=i(a(771)),o=i(a(554)),u=i(a(734));function i(e){return e&&e.__esModule?e:{default:e}}e.exports=t.default},289:function(e,t){Object.defineProperty(t,"__esModule",{value:!0}),t.default=function(e){return function(t){var a=t||{},n=a.width?String(a.width):e.defaultWidth;return e.formats[n]||e.formats[e.defaultWidth]}},e.exports=t.default},245:function(e,t){Object.defineProperty(t,"__esModule",{value:!0}),t.default=function(e){return function(t,a){var n,r=a||{};if("formatting"===(r.context?String(r.context):"standalone")&&e.formattingValues){var o=e.defaultFormattingWidth||e.defaultWidth,u=r.width?String(r.width):o;n=e.formattingValues[u]||e.formattingValues[o]}else{var i=e.defaultWidth,l=r.width?String(r.width):e.defaultWidth;n=e.values[l]||e.values[i]}return n[e.argumentCallback?e.argumentCallback(t):t]}},e.exports=t.default},421:function(e,t){Object.defineProperty(t,"__esModule",{value:!0}),t.default=function(e){return function(t,a){var n=String(t),r=a||{},o=r.width,u=o&&e.matchPatterns[o]||e.matchPatterns[e.defaultMatchWidth],i=n.match(u);if(!i)return null;var l,d=i[0],s=o&&e.parsePatterns[o]||e.parsePatterns[e.defaultParseWidth];return l="[object Array]"===Object.prototype.toString.call(s)?function(e,t){for(var a=0;a<e.length;a++)if(t(e[a]))return a}(s,(function(e){return e.test(d)})):function(e,t){for(var a in e)if(e.hasOwnProperty(a)&&t(e[a]))return a}(s,(function(e){return e.test(d)})),l=e.valueCallback?e.valueCallback(l):l,{value:l=r.valueCallback?r.valueCallback(l):l,rest:n.slice(d.length)}}},e.exports=t.default},926:function(e,t){Object.defineProperty(t,"__esModule",{value:!0}),t.default=function(e){return function(t,a){var n=String(t),r=a||{},o=n.match(e.matchPattern);if(!o)return null;var u=o[0],i=n.match(e.parsePattern);if(!i)return null;var l=e.valueCallback?e.valueCallback(i[0]):i[0];return{value:l=r.valueCallback?r.valueCallback(l):l,rest:n.slice(u.length)}}},e.exports=t.default},924:function(e,t){Object.defineProperty(t,"__esModule",{value:!0}),t.default=function(e,t,n){var r;n=n||{},r="string"==typeof a[e]?a[e]:1===t?a[e].one:a[e].other.replace("{{count}}",t);if(n.addSuffix)return n.comparison>0?"in "+r:r+" ago";return r};var a={lessThanXSeconds:{one:"less than a second",other:"less than {{count}} seconds"},xSeconds:{one:"1 second",other:"{{count}} seconds"},halfAMinute:"half a minute",lessThanXMinutes:{one:"less than a minute",other:"less than {{count}} minutes"},xMinutes:{one:"1 minute",other:"{{count}} minutes"},aboutXHours:{one:"about 1 hour",other:"about {{count}} hours"},xHours:{one:"1 hour",other:"{{count}} hours"},xDays:{one:"1 day",other:"{{count}} days"},aboutXWeeks:{one:"about 1 week",other:"about {{count}} weeks"},xWeeks:{one:"1 week",other:"{{count}} weeks"},aboutXMonths:{one:"about 1 month",other:"about {{count}} months"},xMonths:{one:"1 month",other:"{{count}} months"},aboutXYears:{one:"about 1 year",other:"about {{count}} years"},xYears:{one:"1 year",other:"{{count}} years"},overXYears:{one:"over 1 year",other:"over {{count}} years"},almostXYears:{one:"almost 1 year",other:"almost {{count}} years"}};e.exports=t.default},62:function(e,t,a){Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n,r=(n=a(289))&&n.__esModule?n:{default:n};var o={date:(0,r.default)({formats:{full:"EEEE, MMMM do, y",long:"MMMM do, y",medium:"MMM d, y",short:"MM/dd/yyyy"},defaultWidth:"full"}),time:(0,r.default)({formats:{full:"h:mm:ss a zzzz",long:"h:mm:ss a z",medium:"h:mm:ss a",short:"h:mm a"},defaultWidth:"full"}),dateTime:(0,r.default)({formats:{full:"{{date}} 'at' {{time}}",long:"{{date}} 'at' {{time}}",medium:"{{date}}, {{time}}",short:"{{date}}, {{time}}"},defaultWidth:"full"})};t.default=o,e.exports=t.default},102:function(e,t){Object.defineProperty(t,"__esModule",{value:!0}),t.default=function(e,t,n,r){return a[e]};var a={lastWeek:"'last' eeee 'at' p",yesterday:"'yesterday at' p",today:"'today at' p",tomorrow:"'tomorrow at' p",nextWeek:"eeee 'at' p",other:"P"};e.exports=t.default},839:function(e,t,a){Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n,r=(n=a(245))&&n.__esModule?n:{default:n};var o={ordinalNumber:function(e,t){var a=Number(e),n=a%100;if(n>20||n<10)switch(n%10){case 1:return a+"st";case 2:return a+"nd";case 3:return a+"rd"}return a+"th"},era:(0,r.default)({values:{narrow:["B","A"],abbreviated:["BC","AD"],wide:["Before Christ","Anno Domini"]},defaultWidth:"wide"}),quarter:(0,r.default)({values:{narrow:["1","2","3","4"],abbreviated:["Q1","Q2","Q3","Q4"],wide:["1st quarter","2nd quarter","3rd quarter","4th quarter"]},defaultWidth:"wide",argumentCallback:function(e){return Number(e)-1}}),month:(0,r.default)({values:{narrow:["J","F","M","A","M","J","J","A","S","O","N","D"],abbreviated:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],wide:["January","February","March","April","May","June","July","August","September","October","November","December"]},defaultWidth:"wide"}),day:(0,r.default)({values:{narrow:["S","M","T","W","T","F","S"],short:["Su","Mo","Tu","We","Th","Fr","Sa"],abbreviated:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],wide:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]},defaultWidth:"wide"}),dayPeriod:(0,r.default)({values:{narrow:{am:"a",pm:"p",midnight:"mi",noon:"n",morning:"morning",afternoon:"afternoon",evening:"evening",night:"night"},abbreviated:{am:"AM",pm:"PM",midnight:"midnight",noon:"noon",morning:"morning",afternoon:"afternoon",evening:"evening",night:"night"},wide:{am:"a.m.",pm:"p.m.",midnight:"midnight",noon:"noon",morning:"morning",afternoon:"afternoon",evening:"evening",night:"night"}},defaultWidth:"wide",formattingValues:{narrow:{am:"a",pm:"p",midnight:"mi",noon:"n",morning:"in the morning",afternoon:"in the afternoon",evening:"in the evening",night:"at night"},abbreviated:{am:"AM",pm:"PM",midnight:"midnight",noon:"noon",morning:"in the morning",afternoon:"in the afternoon",evening:"in the evening",night:"at night"},wide:{am:"a.m.",pm:"p.m.",midnight:"midnight",noon:"noon",morning:"in the morning",afternoon:"in the afternoon",evening:"in the evening",night:"at night"}},defaultFormattingWidth:"wide"})};t.default=o,e.exports=t.default},796:function(e,t,a){Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=o(a(926)),r=o(a(421));function o(e){return e&&e.__esModule?e:{default:e}}var u={ordinalNumber:(0,n.default)({matchPattern:/^(\d+)(th|st|nd|rd)?/i,parsePattern:/\d+/i,valueCallback:function(e){return parseInt(e,10)}}),era:(0,r.default)({matchPatterns:{narrow:/^(b|a)/i,abbreviated:/^(b\.?\s?c\.?|b\.?\s?c\.?\s?e\.?|a\.?\s?d\.?|c\.?\s?e\.?)/i,wide:/^(before christ|before common era|anno domini|common era)/i},defaultMatchWidth:"wide",parsePatterns:{any:[/^b/i,/^(a|c)/i]},defaultParseWidth:"any"}),quarter:(0,r.default)({matchPatterns:{narrow:/^[1234]/i,abbreviated:/^q[1234]/i,wide:/^[1234](th|st|nd|rd)? quarter/i},defaultMatchWidth:"wide",parsePatterns:{any:[/1/i,/2/i,/3/i,/4/i]},defaultParseWidth:"any",valueCallback:function(e){return e+1}}),month:(0,r.default)({matchPatterns:{narrow:/^[jfmasond]/i,abbreviated:/^(jan|feb|mar|apr|may|jun|jul|aug|sep|oct|nov|dec)/i,wide:/^(january|february|march|april|may|june|july|august|september|october|november|december)/i},defaultMatchWidth:"wide",parsePatterns:{narrow:[/^j/i,/^f/i,/^m/i,/^a/i,/^m/i,/^j/i,/^j/i,/^a/i,/^s/i,/^o/i,/^n/i,/^d/i],any:[/^ja/i,/^f/i,/^mar/i,/^ap/i,/^may/i,/^jun/i,/^jul/i,/^au/i,/^s/i,/^o/i,/^n/i,/^d/i]},defaultParseWidth:"any"}),day:(0,r.default)({matchPatterns:{narrow:/^[smtwf]/i,short:/^(su|mo|tu|we|th|fr|sa)/i,abbreviated:/^(sun|mon|tue|wed|thu|fri|sat)/i,wide:/^(sunday|monday|tuesday|wednesday|thursday|friday|saturday)/i},defaultMatchWidth:"wide",parsePatterns:{narrow:[/^s/i,/^m/i,/^t/i,/^w/i,/^t/i,/^f/i,/^s/i],any:[/^su/i,/^m/i,/^tu/i,/^w/i,/^th/i,/^f/i,/^sa/i]},defaultParseWidth:"any"}),dayPeriod:(0,r.default)({matchPatterns:{narrow:/^(a|p|mi|n|(in the|at) (morning|afternoon|evening|night))/i,any:/^([ap]\.?\s?m\.?|midnight|noon|(in the|at) (morning|afternoon|evening|night))/i},defaultMatchWidth:"any",parsePatterns:{any:{am:/^a/i,pm:/^p/i,midnight:/^mi/i,noon:/^no/i,morning:/morning/i,afternoon:/afternoon/i,evening:/evening/i,night:/night/i}},defaultParseWidth:"any"})};t.default=u,e.exports=t.default},512:function(e,t,a){Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=l(a(924)),r=l(a(62)),o=l(a(102)),u=l(a(839)),i=l(a(796));function l(e){return e&&e.__esModule?e:{default:e}}var d={code:"en-US",formatDistance:n.default,formatLong:r.default,formatRelative:o.default,localize:u.default,match:i.default,options:{weekStartsOn:0,firstWeekContainsDate:1}};t.default=d,e.exports=t.default},171:function(e,t,a){Object.defineProperty(t,"__esModule",{value:!0}),t.default=function(e){(0,r.default)(1,arguments);var t=Object.prototype.toString.call(e);return e instanceof Date||"object"==typeof e&&"[object Date]"===t?new Date(e.getTime()):"number"==typeof e||"[object Number]"===t?new Date(e):("string"!=typeof e&&"[object String]"!==t||"undefined"==typeof console||(console.warn("Starting with v2.0.0-beta.1 date-fns doesn't accept strings as date arguments. Please use `parseISO` to parse strings. See: https://git.io/fjule"),console.warn((new Error).stack)),new Date(NaN))};var n,r=(n=a(734))&&n.__esModule?n:{default:n};e.exports=t.default}},t={};function a(n){if(t[n])return t[n].exports;var r=t[n]={exports:{}};return e[n](r,r.exports,a),r.exports}a.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return a.d(t,{a:t}),t},a.d=function(e,t){for(var n in t)a.o(t,n)&&!a.o(e,n)&&Object.defineProperty(e,n,{enumerable:!0,get:t[n]})},a.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},function(){function e(e,t){for(var a=0;a<t.length;a++){var n=t[a];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}var t=function(){function t(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t),this.toggleElements=Array.prototype.slice.call(document.querySelectorAll('[data-toggle="collapse"]')),this.collapsibleElements=Array.prototype.slice.call(document.querySelectorAll(".collapse")),this.handleClick=this.handleClick.bind(this),this.init()}var a,n,r;return a=t,(n=[{key:"handleClick",value:function(e){var t=e.target.dataset.target||e.target.getAttribute("href"),a=document.querySelector(t);if(!a)return!1;if("true"===a.getAttribute("aria-expanded"))return a.setAttribute("aria-expanded","false"),a.style.maxHeight=0,!0;var n=parseInt(a.dataset.naturalHeight);return!(isNaN(n)||!n||(a.setAttribute("aria-expanded","true"),a.style.maxHeight=n+"px",0))}},{key:"init",value:function(){var e=this;this.toggleElements.forEach((function(t){t.addEventListener("click",(function(t){e.handleClick(t)&&t.preventDefault()}))})),this.collapsibleElements.forEach((function(e){var t=e.classList.contains("show");e.classList.add("show");var a=e.getBoundingClientRect().height;e.dataset.naturalHeight=a,e.style.overflow="hidden",e.style.maxHeight=t?a+"px":0,e.style.transition="max-height 0.25s",e.setAttribute("aria-expanded",t?"true":"false")}))}}])&&e(a.prototype,n),r&&e(a,r),t}(),n=a(82),r=a.n(n),o=a(512),u=a.n(o);function i(e,t){for(var a=0;a<t.length;a++){var n=t[a];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}var l=function(){function e(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e)}var t,a,n;return t=e,n=[{key:"calculate",value:function(e){"string"==typeof e&&(e=document.querySelectorAll(e));for(var t=0;t<e.length;t++){var a=e[t],n=a.attributes.datetime.value,o=new Date(n),i=r()(o,{addSuffix:!0,locale:u()});a.textContent=i}}}],(a=null)&&i(t.prototype,a),n&&i(t,n),e}();function d(e,t){for(var a=0;a<t.length;a++){var n=t[a];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}var s=function(){function e(t,a,n){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.input=document.querySelector(t),this.list=document.querySelector(a),this.packages=Array.prototype.slice.call(this.list.querySelectorAll(n)),this.inputTimeout=null,this.readHash=this.readHash.bind(this),this.updateHash=this.updateHash.bind(this),this.filterPackages=this.filterPackages.bind(this),this.init()}var t,a,n;return t=e,(a=[{key:"readHash",value:function(){var e=window.decodeURIComponent(window.location.hash.substr(1));e.length>0&&(this.input.value=e,this.filterPackages())}},{key:"updateHash",value:function(){window.location.hash=window.encodeURIComponent(this.input.value)}},{key:"filterPackages",value:function(){var e=this.input.value.toLowerCase();this.list.style.display="none",this.packages.forEach((function(t){var a=-1!==t.textContent.toLowerCase().indexOf(e);t.style.display=a?"block":"none"})),this.list.style.display="block"}},{key:"init",value:function(){var e=this;e.input.addEventListener("keyup",(function(){e.updateHash(),window.clearTimeout(e.inputTimeout),e.inputTimeout=window.setTimeout(e.filterPackages,350)})),document.addEventListener("keyup",(function(t){27===t.code&&(e.input.value="",e.filterPackages())})),e.readHash()}}])&&d(t.prototype,a),n&&d(t,n),e}();function f(){l.calculate("time")}document.addEventListener("DOMContentLoaded",(function(){new t,new s("input#search","#package-list",".card"),f(),window.setInterval(f,5e3)}))}()}();