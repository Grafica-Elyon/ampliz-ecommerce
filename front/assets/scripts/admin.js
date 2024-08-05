import GoogleMapsLoader from 'google-maps';

if ($('#gmap').length) {
  const base = '/wp-content/themes/cidademaia/resources/assets/images/icons/';
  const icons = {
	padaria: base + 'pin-bakery.png',
	mercado: base + 'pin-market.png',
	medico: base + 'pin-medic.png',
	escola: base + 'pin-school.png',
	shopping: base + 'pin-shopping.png',
	'cidade-maia': base + 'pin-cidade-maia.png',
  };

  const lat = $('#lat');
  const lng = $('#lng');
  const type = $('#type');
  const description = $('#description');
  let center = {lat: -23.4409191, lng: -46.543326};
  let pins = [];
  let currentPin = null;

  GoogleMapsLoader.KEY = 'AIzaSyA3shb7zFmvM-EGKIRhSlgP6VeOxyDokN0';
  GoogleMapsLoader.load(google => {
	let map = new google.maps.Map(document.getElementById('gmap'), {
	  zoom: 18,
	  center: center,
	});
	$.ajax({
	  type: 'POST',
	  url: '/wp-admin/admin-ajax.php',
	  dataType: 'json',
	  data: {
		action: 'get_locations',
	  },
	  success: response => {
		response = JSON.parse(response);
		response.map( pin => {
		  let marker = new google.maps.Marker({
			animation: google.maps.Animation.DROP,
			position: {
			  lat: Number(pin.lat),
			  lng: Number(pin.lng),
			},
			type: pin.type,
			description: pin.description,
			draggable:true,
			map: map,
			icon: icons[pin.type],
		  });
		  marker.addListener('drag', e => {
			currentPin = marker;
			type.val(marker.type);
			description.val(marker.description);
			lat.val(e.latLng.lat());
			lng.val(e.latLng.lng());
		  });
		  marker.addListener('click', e => {
			currentPin = marker;
			type.val(marker.type);
			description.val(marker.description);
			lat.val(e.latLng.lat());
			lng.val(e.latLng.lng());
		  });
		  pins.push(marker);
		});
	  },
	});

	$('#add-pin').click( e => {
	  e.preventDefault();
	  let marker = new google.maps.Marker({
		animation: google.maps.Animation.DROP,
		position: center,
		draggable:true,
		map: map,
	  });
	  marker.setPosition(center);
	  marker.addListener('drag', e => {
		currentPin = marker;
		type.val(marker.type);
		description.val(marker.description);
		lat.val(e.latLng.lat());
		lng.val(e.latLng.lng());
	  });
	  marker.addListener('click', e => {
		currentPin = marker;
		type.val(marker.type);
		description.val(marker.description);
		lat.val(e.latLng.lat());
		lng.val(e.latLng.lng());
	  });
	  pins.push(marker);
	  window.pins = pins;
	});

	$('#save-locations').submit( e => {
	  e.preventDefault();
	  let data = pins.map( pin => {
		return {
		  'lat': pin.position.lat(),
		  'lng': pin.position.lng(),
		  'type': pin.type,
		  'description': pin.description,
		};
	  });
	  $.ajax({
		type: 'POST',
		url: '/wp-admin/admin-ajax.php',
		dataType: 'json',
		data: {
		  action: 'save_locations',
		  pins: data,
		},
		beforeSend: () => {
		  $('.notice').remove();
		},
		success: () => {
		  $('.wrap').prepend(`
			<div class="updated notice">
			  <p><strong>Localizações salvas.</strong></p>
			</div>
		  `);
		},
	  });
	});

	$('#remove-pin').click( e => {
	  e.preventDefault();
	  let index = pins.indexOf(currentPin);
	  if (index > -1) {
		currentPin.setMap(null);
		pins.splice(index, 1);
		type.val('');
		description.val('');
		lat.val('');
		lng.val('');
	  }
	});
  });

  type.change(() => {
	currentPin.type = type.val();
	currentPin.setIcon(icons[type.val()]);
  });

  description.keyup(() => {
	currentPin.description = description.val();
  });
}
