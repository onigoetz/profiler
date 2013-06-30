Profiler = {
    panels: {},

    hideAllTabs: function () {
        var blocks = document.querySelectorAll("#profiler-container .op-tab");
        for (var i = 0; i < blocks.length; ++i) {
            Profiler.utils.removeClass(blocks[i], 'op-tab--selected');
        }

        var boxes = document.querySelectorAll("#profiler-container .op-panels > div");
        for (i = 0; i < boxes.length; ++i) {
            Profiler.utils.removeClass(boxes[i], 'op-panel--selected');
        }
    },

    showHideTab: function (event) {
        var $container = document.getElementById('profiler-container');

        if (Profiler.utils.hasClass($container, 'op-container--hide')) {
            Profiler.utils.removeClass($container, 'op-container--hide');
        }

        Profiler.hideAllTabs();
        Profiler.utils.addClass(this, 'op-tab--selected');

        //select new tab
        var tab_name = this.getAttribute('data-name');
        Profiler.utils.addClass(document.getElementById("op-panel-" + tab_name), 'op-panel--selected');

        for (var panel in Profiler.panels) {
            if (Profiler.panels.hasOwnProperty(panel) && typeof Profiler.panels[panel].onPanelChange === "function") {
                Profiler.panels[panel].onPanelChange(this, event);
            }
        }
    },

    init: function () {

        var $container = document.getElementById('profiler-container');

        var close = Profiler.utils.query('#profiler-container .op-tabs .close');
        Profiler.utils.addEvent(close, 'click', function () {
            if (Profiler.utils.hasClass($container, 'op-container--hide')) {
                Profiler.utils.removeClass($container, 'op-container--hide');
            } else {
                Profiler.utils.addClass($container, 'op-container--hide');
            }

            Profiler.hideAllTabs();
        });

        var tabs = document.querySelectorAll('#profiler-container .op-tab:not(.close)');
        for (var i = 0; i < tabs.length; ++i) {
            Profiler.utils.addEvent(tabs[i], 'click', Profiler.showHideTab);
        }

        //onload events
        for (var panel in Profiler.panels) {
            if (Profiler.panels.hasOwnProperty(panel) && typeof Profiler.panels[panel].onLoad === "function") {
                Profiler.utils.addEvent(window, 'load', Profiler.panels[panel].onLoad);
            }
        }
    }
};

Profiler.utils = {
    /**
     * In-memory key-value cache manager
     */
    cacheManager: function () {
        "use strict";
        var dict = {};

        this.get = function (key) {
            return dict.hasOwnProperty(key) ? dict[key] : null;
        };

        this.set = function (key, value) {
            dict[key] = value;
            return value;
        };
    },

    /**
     * Query an element with a CSS selector.
     *
     * @param  string selector a CSS-selector-compatible query string.
     *
     * @return DOMElement|null
     */
    query: function (selector) {
        "use strict";
        var key = 'SELECTOR: ' + selector;

        return Profiler.utils.cache.get(key) || Profiler.utils.cache.set(key, document.querySelector(selector));
    },

    hasClass: function (objElement, strClass) {
        if (objElement.className) {
            var arrList = objElement.className.split(' ');
            var strClassUpper = strClass.toUpperCase();

            for (var i = 0; i < arrList.length; i++) {
                if (arrList[i].toUpperCase() == strClassUpper) {
                    return true;
                }
            }
        }

        return false;
    },

    //http://www.bigbold.com/snippets/posts/show/2630
    addClass: function (objElement, strClass, blnMayAlreadyExist) {
        if (objElement.className) {
            var arrList = objElement.className.split(' ');
            if (blnMayAlreadyExist) {
                var strClassUpper = strClass.toUpperCase();
                for (var i = 0; i < arrList.length; i++) {
                    if (arrList[i].toUpperCase() == strClassUpper) {
                        arrList.splice(i, 1);
                        i--;
                    }
                }
            }
            arrList[arrList.length] = strClass;
            objElement.className = arrList.join(' ');
        } else {
            objElement.className = strClass;
        }
    },

    //http://www.bigbold.com/snippets/posts/show/2630
    removeClass: function (objElement, strClass) {
        if (objElement.className) {
            var arrList = objElement.className.split(' ');
            var strClassUpper = strClass.toUpperCase();
            for (var i = 0; i < arrList.length; i++) {
                if (arrList[i].toUpperCase() == strClassUpper) {
                    arrList.splice(i, 1);
                    i--;
                }
            }
            objElement.className = arrList.join(' ');
        }
    },

    //http://ejohn.org/projects/flexible-javascript-events/
    addEvent: function (obj, type, fn) {
        if (obj.attachEvent) {
            obj["e" + type + fn] = fn;
            obj[type + fn] = function () {
                obj["e" + type + fn](window.event);
            };
            obj.attachEvent("on" + type, obj[type + fn]);
        } else {
            obj.addEventListener(type, fn, false);
        }
    },

    //TODO :: remove if unused
    fireEvent: function (element, event) {
        var evt;
        if (document.createEventObject) {
            // dispatch for IE
            evt = document.createEventObject();
            return element.fireEvent('on' + event, evt);
        } else {
            // dispatch for firefox + others
            evt = document.createEvent("HTMLEvents");
            evt.initEvent(event, true, true); // event type,bubbling,cancelable
            return !element.dispatchEvent(evt);
        }
    }
};

Profiler.utils.cache = new Profiler.utils.cacheManager();

Profiler.panels.bookmarklets = {
    get_js: function () {
        var html = '', i, filename, viewSource = '', js = document.getElementsByTagName('script');
        if (js.length > 0) {
            if (navigator.appName === 'Netscape') {
                viewSource = 'view-source:';
            }
            for (i = 0; i < js.length; i++) {
                if (js[i].src.length) {
                    filename = js[i].src.substring(js[i].src.lastIndexOf('/') + 1);
                    html = html + '<li><a href="' + viewSource + js[i].src + '" target="_blank">' + filename + '</a></li>';
                }
            }

            document.getElementById('js_files_container').innerHTML = '<ul>' + html + '</ul>';
        }
    },

    get_css: function () {
        var html = '', i, filename, viewSource = '', css = document.getElementsByTagName('link');
        if (css.length > 0) {
            if (navigator.appName === 'Netscape') {
                viewSource = 'view-source:';
            }
            for (i = 0; i < css.length; i++) {
                if (css[i].href.length && css[i].rel === 'stylesheet') {
                    filename = css[i].href.substring(css[i].href.lastIndexOf('/') + 1);
                    html = html + '<li><a href="' + viewSource + css[i].href + '" target="_blank">' + filename + '</a></li>';
                }
            }

            document.getElementById('css_files_container').innerHTML = '<ul>' + html + '</ul>';
        }
    },

    onLoad: function () {
        Profiler.panels.bookmarklets.get_css();
        Profiler.panels.bookmarklets.get_js();
    }
};

Profiler.panels.speed = {
    canvasManagerInstance: null,

    /**
     * Canvas Manager
     */
    CanvasManager: function (requests, maxRequestTime, colors) {
        "use strict";

        var _drawingColors = colors,
            _storagePrefix = 'sf2/profiler/timeline',
            _threshold = 1,
            _requests = requests,
            _maxRequestTime = maxRequestTime;

        /**
         * Check whether this event is a child event.
         *
         * @return true if it is.
         */
        function isChildEvent(event) {
            return '__section__.child' === event.name;
        }

        /**
         * Check whether this event is categorized in 'section'.
         *
         * @return true if it is.
         */
        function isSectionEvent(event) {
            return 'section' === event.category;
        }

        /**
         * Get the width of the container.
         */
        function getContainerWidth() {
            return Profiler.utils.query('#op-panel-time h2').clientWidth;
        }

        /**
         * Draw one canvas.
         *
         * @param request   the request object
         * @param max       <subjected for removal>
         * @param threshold the threshold (lower bound) of the length of the timeline (in miliseconds).
         * @param width     the width of the canvas.
         */
        this.drawOne = function (request, max, threshold, width) {
            var text,
                ms,
                xc,
                elementId = 'timeline_' + request.id,
                gapPerEvent = 32,
                colors = _drawingColors,
                space = 10,
                ratio = (width - space * 2) / max,
                h = space,
                x = request.left * ratio + space, // position
                canvas = Profiler.utils.cache.get(elementId) || Profiler.utils.cache.set(elementId, document.getElementById(elementId)),
                ctx = canvas.getContext("2d");

            // Filter events whose total time is below the threshold.
            var drawableEvents = request.events.filter(function (event) {
                return event.duration >= threshold;
            });

            // For retina displays so text and boxes will be crisp
            var devicePixelRatio = window.devicePixelRatio == "undefined" ? 1 : window.devicePixelRatio;
            var backingStoreRatio = ctx.webkitBackingStorePixelRatio == "undefined" ? 1 : ctx.webkitBackingStorePixelRatio;
            var scaleRatio = devicePixelRatio / 1;

            var canvasHeight = gapPerEvent * drawableEvents.length;

            canvas.width = width * scaleRatio;
            canvas.height = canvasHeight * scaleRatio;

            canvas.style.width = width + 'px';
            canvas.style.height = canvasHeight + 'px';

            ctx.translate(0.5, 0.5);
            ctx.scale(scaleRatio, scaleRatio);

            ctx.textBaseline = "middle";
            ctx.lineWidth = 0;

            // For each event, draw a line.
            ctx.strokeStyle = "#dfdfdf";

            drawableEvents.forEach(function (event) {
                event.periods.forEach(function (period) {
                    var timelineHeadPosition = x + period.start * ratio;

                    if (isChildEvent(event)) {
                        //child event rectangle
                        ctx.fillStyle = colors.child_sections;
                        ctx.fillRect(timelineHeadPosition, 0, (period.end - period.start) * ratio, canvasHeight);
                    } else if (isSectionEvent(event)) {
                        //vertical lines around sections
                        var timelineTailPosition = x + period.end * ratio;

                        ctx.beginPath();
                        ctx.moveTo(timelineHeadPosition, 0);
                        ctx.lineTo(timelineHeadPosition, canvasHeight);
                        ctx.moveTo(timelineTailPosition, 0);
                        ctx.lineTo(timelineTailPosition, canvasHeight);
                        ctx.fill();
                        ctx.closePath();
                        ctx.stroke();
                    }
                });
            });

            // Filter for main events.
            var mainEvents = drawableEvents.filter(function (event) {
                return !isChildEvent(event);
            });

            // For each main event, draw the visual presentation of timelines.
            mainEvents.forEach(function (event) {
                h += 7;

                // For each sub event, ...
                event.periods.forEach(function (period) {
                    // Set the drawing style.
                    ctx.fillStyle = ctx.strokeStyle = colors['default'];

                    if (colors[event.name]) {
                        ctx.fillStyle = ctx.strokeStyle = colors[event.name];
                    } else if (colors[event.category]) {
                        ctx.fillStyle = ctx.strokeStyle = colors[event.category];
                    }

                    // Draw the timeline
                    var timelineHeadPosition = x + period.start * ratio;

                    if (!isSectionEvent(event)) {
                        ctx.fillRect(timelineHeadPosition, h + 3, 2, 6);
                        ctx.fillRect(timelineHeadPosition, h + 0.5, (period.end - period.start) * ratio || 2, 5);
                    } else {
                        var timelineTailPosition = x + period.end * ratio;

                        ctx.beginPath();
                        ctx.moveTo(timelineHeadPosition, h);
                        ctx.lineTo(timelineHeadPosition, h + 11);
                        ctx.lineTo(timelineHeadPosition + 8, h);
                        ctx.lineTo(timelineHeadPosition, h);
                        ctx.fill();
                        ctx.closePath();
                        ctx.stroke();

                        ctx.beginPath();
                        ctx.moveTo(timelineTailPosition, h);
                        ctx.lineTo(timelineTailPosition, h + 11);
                        ctx.lineTo(timelineTailPosition - 8, h);
                        ctx.lineTo(timelineTailPosition, h);
                        ctx.fill();
                        ctx.closePath();
                        ctx.stroke();

                        ctx.beginPath();
                        ctx.moveTo(timelineHeadPosition, h);
                        ctx.lineTo(timelineTailPosition, h);
                        ctx.lineTo(timelineTailPosition, h + 2);
                        ctx.lineTo(timelineHeadPosition, h + 2);
                        ctx.lineTo(timelineHeadPosition, h);
                        ctx.fill();
                        ctx.closePath();
                        ctx.stroke();
                    }
                });

                h += 25;

                ctx.beginPath();
                ctx.strokeStyle = "#dfdfdf";
                ctx.moveTo(0, h - 10);
                ctx.lineTo(width, h - 10);
                ctx.closePath();
                ctx.stroke();
            });

            h = space;

            // For each event, draw the label.
            var font_12 = "12px sans-serif";
            var font_10 = "10px sans-serif";
            mainEvents.forEach(function (event) {

                ctx.fillStyle = "#444";
                ctx.font = font_12;
                text = event.name;
                ms = " ~ " + (event.duration < 1 ? event.duration : parseInt(event.duration, 10)) + " ms / ~ " + event.memory + " MB";
                if (x + event.starttime * ratio + ctx.measureText(text + ms).width > width) {
                    ctx.textAlign = "end";
                    ctx.font = font_10;
                    xc = x + event.endtime * ratio - 1;
                    ctx.fillText(ms, xc, h);

                    xc -= ctx.measureText(ms).width;
                    ctx.font = font_12;
                    ctx.fillText(text, xc, h);
                } else {
                    ctx.textAlign = "start";
                    ctx.font = font_12;
                    xc = x + event.starttime * ratio + 1;
                    ctx.fillText(text, xc, h);

                    xc += ctx.measureText(text).width;
                    ctx.font = font_10;
                    ctx.fillText(ms, xc, h);
                }

                h += gapPerEvent;
            });
        };

        this.drawAll = function (width, threshold) {
            width = width || getContainerWidth();
            threshold = threshold || this.getThreshold();

            var self = this;

            _requests.forEach(function (request) {
                self.drawOne(request, maxRequestTime, threshold, width);
            });
        };

        this.getThreshold = function () {
            var threshold = localStorage.getItem(_storagePrefix + '/threshold');

            if (threshold === null) {
                return _threshold;
            }

            _threshold = parseInt(threshold, 10);

            return _threshold;
        };

        this.setThreshold = function (threshold) {
            _threshold = threshold;

            localStorage.setItem(_storagePrefix + '/threshold', threshold);

            return this;
        };
    },

    onResizeAndSubmit: function (e) {
        e.preventDefault();
        Profiler.panels.speed.canvasManagerInstance.drawAll();
    },

    onThresholdChange: function (e) {
        Profiler.panels.speed.canvasManagerInstance
            .setThreshold(Profiler.utils.query('input[name="threshold"]').value)
            .drawAll();
    },

    onLoad: function() {
        if(window.onigoetz_profiler !== undefined) {
            Profiler.panels.speed.init(window.onigoetz_profiler.requests_data, window.onigoetz_profiler.colors);
        }
    },

    onPanelChange: function(item, event) {
        if (Profiler.utils.hasClass(item, "time")) {
            Profiler.panels.speed.onResizeAndSubmit(event);
        }
    },

    init: function (requests_data, colors) {
        var canvasManager = new Profiler.panels.speed.CanvasManager(requests_data.requests, requests_data.max, colors);
        Profiler.panels.speed.canvasManagerInstance = canvasManager;

        Profiler.utils.query('input[name="threshold"]').value = canvasManager.getThreshold();
        canvasManager.drawAll();

        // Update the colors of legends.
        var timelineLegends = document.querySelectorAll('#op-panel-time .legends > span[data-color]');

        for (var i = 0; i < timelineLegends.length; ++i) {
            var timelineLegend = timelineLegends[i];

            timelineLegend.style.borderLeftColor = timelineLegend.getAttribute('data-color');
        }

        // Bind event handlers
        var elementTimelineControl = Profiler.utils.query('#timeline-control'),
            elementThresholdControl = Profiler.utils.query('input[name="threshold"]');

        elementTimelineControl.onsubmit = window.onresize = Profiler.panels.speed.onResizeAndSubmit;
        elementThresholdControl.onclick = elementThresholdControl.onchange = elementThresholdControl.onkeyup = Profiler.panels.speed.onThresholdChange;
    }
};


Profiler.init();
