
export default class AsyncImages {
	constructor ( el ) {
		if ( "function" == typeof Blazy ) {
			let component = el.attributes.getNamedItem('data-component').value;
			let blazy = new Blazy({
				container: '[data-component='+JSON.stringify(component)+']',
				selector: '.mp-async-image',
			})
            blazy.revalidate();
			setInterval(()=>blazy.revalidate(), 1000);
		}
	}
}
