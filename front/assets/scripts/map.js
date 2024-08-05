import GoogleMapsLoader from 'google-maps';

export default class Map {
  constructor() {
	this.base = '/wp-content/themes/cidademaia/resources/assets/images/icons/';
	this.icons = {
	  padaria: this.base + 'pin-bakery.png',
	  mercado: this.base + 'pin-market.png',
	  medico: this.base + 'pin-medic.png',
	  escola: this.base + 'pin-school.png',
	  shopping: this.base + 'pin-shopping.png',
	  'cidade-maia': this.base + 'pin-cidade-maia.png',
	};
	this.selectedType = $('[name="pin-type"]');
	this.pins = [];
	this.center = {lat: -23.4409191, lng: -46.543326};
	GoogleMapsLoader.KEY = 'AIzaSyA3shb7zFmvM-EGKIRhSlgP6VeOxyDokN0';
	GoogleMapsLoader.LIBRARIES = ['places'];
	GoogleMapsLoader.load(google => {
	  this.google = google;
	  this.map = new google.maps.Map(document.getElementById('gmap'), {
		zoom: 17,
		center: this.center,
	  });

	  this.selectedType.change(e => {
		this.loadPlaces(e.currentTarget.value, this.icons[e.currentTarget.getAttribute("data-pin")], e.currentTarget.getAttribute("data-pin"));
	  });
	  this.loadPlaces(this.selectedType.val(), this.icons.mercado, 'mercado');
	});
  }

  loadPlaces(type, icon, typeLocal) {
	this.pins.forEach(pin => {
	  pin.setMap(null);
	});
	this.pins = [];
	let bounds = new this.google.maps.LatLngBounds();
	const infowindow = new this.google.maps.InfoWindow();
	let placesService = new this.google.maps.places.PlacesService(this.map);
	placesService.nearbySearch(
	  {
		location: this.center,
		radius: 800,
		type: type.split(','),
	  },
	  (results) => {
		results.map(e => {
		  let position = new this.google.maps.LatLng(e.geometry.location.lat(), e.geometry.location.lng());
		  let pin = new this.google.maps.Marker({
			position: e.geometry.location,
			map: this.map,
			icon: icon,
			animation: this.google.maps.Animation.DROP,
		  });
		  this.pins.push(pin);
		  this.google.maps.event.addListener(pin, 'click', function () {
			infowindow.setContent(e.name);
			infowindow.open(this.map, this);
		  });
		  bounds.extend(position);
		});
		this.loadSavedPlaces(type, icon, bounds, infowindow, typeLocal);
		this.map.fitBounds(bounds);
	  }
	);
  }

  loadSavedPlaces(type, icon, bounds, infowindow, typeLocal) {
	$.ajax({
	  type: 'POST',
	  url: '/wp-admin/admin-ajax.php',
	  dataType: 'json',
	  data: {
		action: 'get_locations',
	  },
	  success: response => {
		response = JSON.parse(response);
		response.map(pin => {
		  if(typeLocal === pin.type || pin.type === 'cidade-maia') {
			let iconLocal = pin.type === 'cidade-maia' ? this.icons['cidade-maia'] : icon;
			let marker = new this.google.maps.Marker({
			  position: {
				lat: Number(pin.lat),
				lng: Number(pin.lng),
			  },
			  type: pin.type,
			  map: this.map,
			  icon: iconLocal,
			  animation: this.google.maps.Animation.DROP,
			});
			this.pins.push(marker);
			this.google.maps.event.addListener(marker, 'click', function () {
			  infowindow.setContent(pin.description);
			  infowindow.open(this.map, this);
			});
		  }
		});
	  },
	});
  }
}
