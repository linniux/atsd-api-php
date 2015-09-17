(function(global, undefined){

    var classNamePrefix = 'widget-';
    function nodeIsDisplayed(node){ return node.offsetParent != null; }
    function updateWidget(config, widget){
        if (arguments.length < 2){
            widget = config;
            config = undefined;
        }

        var isID = typeof widget == 'number' || typeof widget == 'string';
        if (isID){
            // if widget ID is passed instead of widget itself, then select widget by the given ID
            var className = classNamePrefix + widget,
                contNode = d3.select('.' + className).node()
                    || config && config.forceRender
                    && d3.select('body').append('div').classed(className, true).node();

            if (!contNode){
                return null;
            }
            widget = contNode.__innerWidget__;
        }
        else if (widget) contNode = widget.config.renderTo;
        else return;

        var display = nodeIsDisplayed(contNode);
        if (widget){
            // if config is not defined or is the same then update widget (or stop update if its container is hidden)
            if (typeof config == 'undefined' || widget.config.originalConfig == config){
                if (!widget._contHidden != display && (widget._contHidden = !display, true)){
                    switchRealtimeUpdate(display, [widget], true, true);
                }
                return widget;
            }
            widget.destroy();
        }

        // create a new widget if the old one was destroyed or there were not any
        return display && config && initializeWidget(config, contNode);
    }

    function initializeWidget(config, contNode){
        var type = config.type = toCapitalCase(config.type) || 'Chart';
        //config.updateinterval = 0;
        config.fastenTooltips = true;
        if (config.url == null) config.url = 'http://nur.axibase.com:8088';
        config.series = config.series ? config.series.map(getSeriesConfig) : [];

        switch(type){
            case 'Bar':
                config.barColumns = [].concat(config.columns).filter(identity).forEach(function(c){
                    if (c.series && c.series.length && (c.series = c.series.map(getSeriesConfig))){
                        config.series = config.series.concat(c.series);
                    }
                });
                break;
        }

        var typeClassName = classNamePrefix + type.toLowerCase(),
            contEl = d3.select(contNode).classed(typeClassName, true),
            contSize = { width: contNode.style.width, height: contNode.style.height },
            size = config.initSize || resizeWidget.getDefaultSize(),
            widget = contNode.__innerWidget__ = appendWidget(config, contNode, size);

        widget.destroy = extendFunction(widget.destroy, function(){
            contEl.classed(typeClassName, false);
            contNode.__innerWidget__ = null;
            resizeWidget(widget, true, contSize);
        });
        resizeWidget(widget, true, size);

        switch(type){
            case 'Gauge':
                widget.progress.alignNode(contNode).redraw();
                break;
        }
        return widget;
    }

    function resizeWidget(widget, resizeOnlyContainer, size){
        if (typeof size != 'object') size = resizeWidget.getDefaultSize(widget);
        if (size){
            var contNode = widget.config.renderTo;
            contNode.style.width = typeof size.width == 'number' ? size.width + 'px' : size.width;
            contNode.style.height = typeof size.height == 'number' ? size.height + 'px' : size.height;

            if (resizeOnlyContainer !== true){
                widget.resize(size);
            }
        }
    }

    resizeWidget.getDefaultSize = function(widget){
        if (widget && widget.config.originalConfig.initSize) return null;
        var w = Math.floor((document.documentElement.clientWidth - 70) / 1),
            h = Math.floor((document.documentElement.clientHeight - 50) / 2);
        return { width: w, height: h };
    };

    function forceReload(el, properties, copyProperties){
        var name = el.tagName.toLowerCase();
        if (copyProperties == null) copyProperties = defaultCopyProperties[name];

        var copy = document.createElement(name),
            parentNode = el.parentNode,
            beforeNode = el.nextSibling;

        if (copyProperties) copyProperties.forEach(function(p){ if (!properties.hasOwnProperty(p)) copy[p] = el[p]; });
        for (var p in properties) if (properties.hasOwnProperty(p)) copy[p] = properties[p];

        parentNode.removeChild(el);
        parentNode.insertBefore(copy, beforeNode);
        return copy;
    }

    var defaultCopyProperties = {
        script: ['__initialized__', 'id', 'async', 'type', 'onload', 'src']
    };

    function loadElement(el, src, callback){
        if (typeof el == 'string' && !(el = document.querySelector(el))){
            return;
        }
        if (callback){
            el.onload = extendFunction(el.onload, function(){
                if (!document.body) return onBodyLoad = extendFunction(onBodyLoad, callback);
                callback.apply(this, arguments);
            });
        }

        var init = !el.__initialized__ && (el.__initialized__ = true);
        if (init){
            el.src = src;
        }
        else el = forceReload(el, { src: src });
        return el;
    }

    global.loadElement = loadElement;
    global.forceReload = forceReload;
    global.updateWidget = updateWidget;
    global.resizeWidget = resizeWidget;

})(window);