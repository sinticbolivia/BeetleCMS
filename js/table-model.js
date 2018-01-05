/**
 * A javascript class to easy handle table data and models
 * 
 * @author Sintic Bolivia - Juan Marcelo Aviles Paco
 * @package SBFramework
 * @version 1.0.0
 */
function SBTableModel(_model, _target)
{
	var model 			= {};
	var items 			= {};
	var target 			= _target || null;
	this.itemsName		= 'items';
	
	this.ItemExists = function(value)
	{
		return items[value] ? items[value] : false;
	};
	this.AddItem = function(data)
	{
		if( !model.key_field )
		{
			window.console && console.log('AddItem: Invalid model key_field');
			return false;
		}
		if( !data )
			return false;
		if( typeof data[model.key_field] == 'undefined' || data[model.key_field] == null )
		{
			window.console && console.log('AddItem: Model key_field is not defined into item');
			return false;
		}
		var proxy_handle = 
		{
			set: function(obj, prop, value)
			{
				if( prop.indexOf('node__') != -1 )
				{
					obj.nodes[prop] = value;
					return true;
				}
				if( obj.nodes['node__' + prop] )
				{
					if( obj.nodes['node__' + prop].type == 'text' 
						|| obj.nodes['node__' + prop].type == 'number' 
						|| obj.nodes['node__' + prop].type == 'hidden'
						|| obj.nodes['node__' + prop].tagName == 'SELECT'
					)
					{
						obj.nodes['node__' + prop].value = value;
					}
					else
					{
						obj.nodes['node__' + prop].innerHTML = value;
					}
				}
				obj.$data[prop] = value
				return true;
			},
			get: function(obj, prop)
			{
				if( obj[prop] )
					return obj[prop];
				return obj.$data[prop] != 'undefined' ? obj.$data[prop] : null;
			}
		};
		var exists = this.ItemExists(data[model.key_field]);
		if( !exists )
		{
			items[data[model.key_field]] = new Proxy({nodes:{}, $data: data}, proxy_handle);
		}
		else
		{
			
		}
		if( model.OnAddItem )
		{
			if( typeof model.OnAddItem == 'function' )
			{
				model.OnAddItem.call(this, items[data[model.key_field]], exists ? true : false);
			}
			else if( typeof model.OnAddItem == 'string' )
			{
				var fn = eval(model.OnAddItem);
				fn.call(this, items[data[model.key_field]], exists ? true : false);
			}
		}
		this.Build();
	};
	this.DeleteItem = function(index)
	{
		delete items[index];
		//delete items.$data[index];
		this.Build();
	}
	this.Build = function()
	{
		if( !target )
			return false;
		target.innerHTML = '';
			
		if( !model.columns )
		{
			target.innerHTML = 'Invalid table model';
			return false;
		}
		if( model.columns.length <= 0 )
		{
			target.innerHTML = 'Table model columns is empty';
			return false;
		}
		var thead_html = '<tr>';
		
		//##build table header
		for(let col of model.columns)
		{
			if( typeof col.show == 'undefined' || col.show )
			{
				var $class = col.class || '';
				thead_html += `<th class="${$class}">${col.label}</th>`;
			}
			
		}
		thead_html += '</tr>';
		var cont = document.createElement('div');
		var table = document.createElement('table');
		var thead = document.createElement('thead');
		var tbody = document.createElement('tbody');
		
		if( items )
		{
			for(let index in items)
			{
				var item = items[index];
				var row = document.createElement('tr');
				tbody.appendChild(row);
				for(let col of model.columns)
				{
					var cell        = document.createElement('td');
					cell.className  = col.class || '';
					var field       = document.createElement('div');
					var node_value = null;
					
					if( typeof col.show == 'undefined' || col.show )
					{
						row.appendChild(cell);
					}
					
					if( col.type == 'count' )
					{
						var num = tbody.getElementsByTagName('tr').length;
						num++;
						field.className = 'row-count';
						node_value = document.createElement('span');
						node_value.innerHTML = num;
					}
					else if( col.type == 'static' ) 
					{
						field.className = 'field-static';
						node_value = document.createElement('span');
						node_value.className = col.value_key;
						node_value.innerHTML = typeof item[col.value_key] != 'undefined' ? item[col.value_key] : 'invalid value_key';
					}
					else if( col.type == 'text' || col.type == 'number' || col.type == 'hidden' )
					{
						field.className 				= 'field-text';
						node_value 						= document.createElement('input');
						node_value.type 				= col.type;
						node_value.className 			= 'form-control ' + col.value_key;
						node_value.dataset.item_index 	= index;
						node_value.dataset.value_key 	= col.value_key;
						node_value.value 				= typeof item[col.value_key] != 'undefined' ? 
															item[col.value_key] : 
															'';
					}
					else if( col.type == 'select' )
					{
						field.className					= 'field-select';
						node_value						= document.createElement('select');
						node_value.className			= 'form-control ' + col.value_key;
						node_value.dataset.item_index 	= index;
						node_value.dataset.value_key 	= col.value_key;
						//##build select options
						if( col.options && col.options.length > 0 )
						{
							for(let op of col.options)
							{
								var option 			= document.createElement('option');
								option.value 		= op.value;
								option.innerHTML 	= op.text;
								node_value.appendChild(option);
							}
						}
						node_value.value = typeof item[col.value_key] != 'undefined' ? 
															item[col.value_key] : 
															'';
					}
					else if( col.type == 'buttons' )
					{
						field.className = 'field-buttons';
						node_value = document.createElement('div');
						if( col.buttons.length > 0 )
						{
							for(_btn of col.buttons)
							{
								var btn 				= document.createElement('a');
								btn.className 			= 'btn btn-default btn-xs' + (btn.class || '');
								btn.title				= _btn.title || '';
								btn.dataset.item_index 	= index;
								if( _btn.data && _btn.data.length > 0 )
								{
									for($var of _btn.data)
									{
										if( item[$var] != 'undefined' )
											btn.dataset[$var] = item[$var];
									}
								}
								btn.innerHTML = _btn.label || '';
								if( _btn.callback )
								{
									btn.addEventListener('click', eval(_btn.callback));
								}
								node_value.appendChild(btn);
							}
						}
					}
					//##attach events
					if( col.type == 'text' || col.type == 'number' || col.type == 'hidden' || col.type == 'select' )
					{
						//##attach onchange event
						jQuery(node_value).on('change', function()
						{
							var i = this.dataset.item_index;
							items[i][this.dataset.value_key] = this.value;
							if( model.OnChange )
							{
								var fn = typeof model.OnChange == 'string' ? eval(model.OnChange) : model.OnChange;
								fn.call(this, items[i], this.dataset.value_key);
							}
						});
					}
					if( field && node_value )
					{
						//##set node_value to proxy
						item['node__' + col.value_key] = node_value;
						if( typeof col.show == 'undefined' || col.show )
						{
							field.appendChild(node_value);
							cell.appendChild(field);
						}
						if( model.OnNodeAdded )
						{
							var fn = eval(model.OnNodeAdded);
							fn.call(this, item, node_value, col.value_key);
						}
					}
				}
				
			}
		}
		cont.className = 'table-responsive';
		table.className = 'table table-condensed';
		thead.innerHTML = thead_html;
		table.appendChild(thead);
		table.appendChild(tbody);
		cont.appendChild(table);
		target.appendChild(cont);
	};
	this.Serialize = function(format, skip)
	{
		var data = '';
		if( format == 'form' )
		{
			var i = 0;
			for(item of this.GetItems())
			{
				for(key in item)
				{
					if( skip && skip.indexOf(key) != -1 ) continue;
					data += `${this.itemsName}[${i}][${key}]=${item[key]}&`;
				}
				i++;
			}
		}
		else
		{
			data = JSON.stringify(this.GetItems());
		}
		return data;
	};
	this.GetItems = function()
	{
		var $array = [];
		for(proxy in items)
		{
			$array.push(items[proxy].$data);
		}
		return $array;
	};
	this.GetProxies = function()
	{
		return items;
	};
	this.AddEvent = function(event, callback)
	{
		model[event] = callback;
	};
	this.SetColumnData = function(value_key, prop, data)
	{
		for(let i in model.columns)
		{
			if( model.columns[i].value_key == value_key )
			{
				//model.columns[col][prop] = data;
                model.columns[i][prop] = null;
                model.columns[i][prop] = data;
				break;
			}
		}
        //console.log(model.columns);
	};
	if( _model )
	{
		model = Object.create(_model);
	}
}