import GoogleMapsLoader from 'google-maps';

export default class Map {
	constructor(key, id, center) {
		if (typeof center === 'undefined') { center = {lat: -23.4409191, lng: -46.543326}; }

		console.log({lat: -23.4409191, lng: -46.543326});
		console.log(center);
		GoogleMapsLoader.KEY = key;
		GoogleMapsLoader.LIBRARIES = ['places'];
		GoogleMapsLoader.load(google => {
			this.google = google;
			this.map = new google.maps.Map(document.getElementById(id), {
				zoom: 10,
				center: center,
			});
		});
	}

	addPin(position, description) {
		console.log(position);
		console.log(description);
		GoogleMapsLoader.load(google => {
			new google.maps.Marker({
				position: position,
				description: description,
				map: this.map,
			});
		});
	}
}