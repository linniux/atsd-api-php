(function(global, undefined){

function updateWidgets(_widgetConfigs){
	if (_widgetConfigs == null) _widgetConfigs = global.widgetConfigs;
	
	Object.getOwnPropertyNames(_widgetConfigs).forEach(function(type){
		[].concat(_widgetConfigs[type]).forEach(function(config, index){
			updateWidget(config, type, index);
		});
	});
}

//------------------------------------------------------------------------------------------------------------------

function updateWidget(config, type, index){
	var className = ['widget', type, index].join('-'),
	contNode = d3.select('.' + className).node()
		|| config.forceRender && d3.select('body').append('div').classed(className, true).node();
	if (!contNode){
		return;
	}
	
	var display = nodeIsDisplayed(contNode),
	_widget = contNode.__innerWidget__;
	if (_widget){
		if (!_widget._contHidden != display && (_widget._contHidden = !display, true)){
			switchRealtimeUpdate(display, [_widget], true, true);
		}
		return;
	}
	
	return display && initializeWidget(config, type, contNode);
}

function initializeWidget(config, type, contNode){
	//config.updateinterval = 0;
	config.type = toCapital(type);
	config.fastenTooltips = true;
	if (config.url == null) config.url = '';
	config.series = config.series ? config.series.map(getSeriesConfig) : [];
	
	switch(config.type){
	case 'Bar':
		config.barColumns = [].concat(config.columns).filter(identity).forEach(function(c){
			if (c.series && c.series.length && (c.series = c.series.map(getSeriesConfig))){
				config.series = config.series.concat(c.series);
			}
		});
		break;
	}
	
	var widget = contNode.__innerWidget__ = appendWidget(config, contNode, config.initSize || getWidgetDefaultSize());
	resizeWidget(widget, true, config.initSize);
	
	switch(config.type){
	case 'Gauge':
		widget.progress.alignNode(contNode).redraw();
		break;
	}
	return widget;
}

function resizeWidget(widget, resizeOnlyContainer, size){
	if (typeof size != 'object') size = getWidgetDefaultSize(widget);
	if (size){
		var contNode = widget.config.renderTo;
		contNode.style.width = size.width + 'px';
		contNode.style.height = size.height + 'px';
		
		if (resizeOnlyContainer !== true){
			widget.resize(size);
		}
	}
}

function getWidgetDefaultSize(widget){
	var w = Math.floor((document.documentElement.clientWidth - 70) / 1),
	h = Math.floor((document.documentElement.clientHeight - 50) / 2);
	return { width: w, height: h };
}

function nodeIsDisplayed(node){ return node.offsetParent != null; }

global.updateWidgets = updateWidgets;
global.updateWidget = updateWidget;
global.resizeWidget = resizeWidget;

})(window);
