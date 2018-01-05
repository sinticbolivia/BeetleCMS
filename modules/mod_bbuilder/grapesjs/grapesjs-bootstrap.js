function BootstrapBlocks(editor, opt = {}) 
{
	const c = opt;
	let bm = editor.BlockManager;
	let blocks = c.blocks;
	console.log(c.blocks);
	
	if ( blocks.indexOf('header') >= 0 ) 
	{
		bm.add('header', {
			label: c.labelHeader,
			category: 'Bootstrap 3.3.7',
			attributes: {class:'gjs-fonts gjs-f-b1'},
			content: `<header class="b-header" data-gjs-droppable="*" data-gjs-custom-name="HTML5 Header"> </header>`
		});
	}
	if ( blocks.indexOf('footer') >= 0 ) 
	{
		bm.add('footer', {
			label: c.labelFooter,
			category: 'Bootstrap 3.3.7',
			attributes: {class:'gjs-fonts gjs-f-b1'},
			content: `<footer class="b-footer" data-gjs-droppable="*" data-gjs-custom-name="HTML5 Footer"> </footer>`
		});
	}
	if ( blocks.indexOf('section') >= 0 ) 
	{
		bm.add('section', {
			label: c.labelSection,
			category: 'Bootstrap 3.3.7',
			attributes: {class:'gjs-fonts gjs-f-b1'},
			content: `<section class="b-section" data-gjs-droppable="*" data-gjs-custom-name="HTML5 Section"> </section>`
		});
	}
	if ( blocks.indexOf('div') >= 0 ) 
	{
		bm.add('div', {
			label: c.labelDiv,
			category: 'Bootstrap 3.3.7',
			attributes: {class:'gjs-fonts gjs-f-b1'},
			content: `<div class="b-div" data-gjs-droppable="*" data-gjs-custom-name="HTML DIV"> </div>`
		});
	}
	if ( blocks.indexOf('container') >= 0 ) 
	{
		bm.add('container', {
			label: c.labelContainer,
			category: 'Bootstrap 3.3.7',
			attributes: {class:'gjs-fonts gjs-f-b1'},
			content: `<div class="container" data-gjs-droppable="*" data-gjs-custom-name="Bootstrap Container"> </div>`
		});
	}
	if ( blocks.indexOf('container-fluid') >= 0 ) 
	{
		bm.add('container-fluid', {
			label: c.labelContainerFluid,
			category: 'Bootstrap 3.3.7',
			attributes: {class:'gjs-fonts gjs-f-b1'},
			content: `<div class="container-fluid" data-gjs-droppable="*" data-gjs-custom-name="Bootstrap Container Fluid"> </div>`
		});
	}
	if ( blocks.indexOf('row') >= 0 ) 
	{
		bm.add('row', {
			label: c.labelRow,
			category: 'Bootstrap 3.3.7',
			attributes: {class:'gjs-fonts gjs-f-b1'},
			content: `<div class="row" data-gjs-droppable="*" data-gjs-custom-name="Bootstrap Row"> </div>`
		});
	}
	if ( blocks.indexOf('column') >= 0 ) 
	{
		bm.add('column', {
			label: c.labelColumn,
			category: 'Bootstrap 3.3.7',
			attributes: {class:'gjs-fonts gjs-f-b1'},
			content: `<div class="col-md-3" data-gjs-droppable="*" data-gjs-custom-name="Bootstrap Column"> </div>`
		});
	}
	if ( blocks.indexOf('aside') >= 0 ) 
	{
		bm.add('column', {
			label: c.labelAside,
			category: 'Bootstrap 3.3.7',
			attributes: {class:'gjs-fonts gjs-f-b1'},
			content: `<aside class="b-sidebar" data-gjs-droppable="*" data-gjs-custom-name="HTML5 Sidebar"> </aside>`
		});
	}
}
grapesjs.plugins.add('gjs-bootstrap', (editor, opts) => {
	let c = opts || {};
	let config = editor.getConfig();
	let pfx = config.stylePrefix;
	let defaults = {
		blocks: ['header', 'footer', 'section', 'div', 'container', 'container-fluid', 'row', 'column', 'aside'],
		addBasicStyle: true,
		labelHeader: 'HTML5 Header',
		labelFooter: 'HTML5 Footer',
		labelSection: 'HTML5 Section',
		labelDiv: 'Div',
		labelContainer: 'Bootstrap Container',
		labelContainerFluid: 'Bootstrap Container Fluid',
		labelRow: 'Bootstrap Row',
		labelColumn: 'Bootstrap Column',
		labelAside: 'HTML5 Sidebar'
	};
	for (let name in defaults) 
	{
		if (!(name in c))
			c[name] = defaults[name];
	}
	if (c.addBasicStyle) 
	{
		editor.addComponents(`<style>

			</style>`);
	}
	// Add blocks
	BootstrapBlocks(editor, c);
});
