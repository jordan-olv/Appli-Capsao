/*geo loc*/
import { Geolocation } from '@capacitor/geolocation';

export const printCurrentPosition = async (radio) => {

  let shortDist = 9999;
  let radioDefault;
  const coordinates = await Geolocation.getCurrentPosition();

  const latitudeUser = coordinates.coords.latitude;
  const longitudeUser = coordinates.coords.longitude;

  radio.forEach((element) => {
    if (element.coordonnees !== "0,0") {
      const coordinatesArray = element.coordonnees.split(',');
      const latitudeCity = coordinatesArray[0];
      const longitudeCity = coordinatesArray[1];

      const calcDist = getDistance(latitudeUser, longitudeUser, latitudeCity, longitudeCity, 'haversine');

      console.log(element, calcDist)

      if (calcDist < element.rayon) {

        if (calcDist < shortDist) {
          shortDist = calcDist;
          radioDefault = element;
        }
      }
    }
  });

  return radioDefault || null;
};

function degToRad(n) {
  return n * Math.PI / 180;
}

function radToDeg(n) {
  return n * 180 / Math.PI;
}

function getDistance(lat1, lon1, lat2, lon2, mode) {
  var R = 6371; // Earth radius in km

  switch (mode) {
    case 'spherical':
    default:
      var dLon = degToRad(lon2 - lon1);
      lat1 = degToRad(lat1);
      lat2 = degToRad(lat2);
      var d = Math.acos(Math.sin(lat1) * Math.sin(lat2) + Math.cos(lat1) * Math.cos(lat2) * Math.cos(dLon)) * R;
      break;

    case 'haversine':
      var dLat = degToRad(lat2 - lat1);
      var dLon = degToRad(lon2 - lon1);
      lat1 = degToRad(lat1);
      lat2 = degToRad(lat2);
      var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.sin(dLon / 2) * Math.sin(dLon / 2) * Math.cos(lat1) * Math.cos(lat2);
      var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
      var d = R * c;
      break;

    case 'rectangle':
      var x = degToRad(lon2 - lon1) * Math.cos(degToRad(lat1 + lat2) / 2);
      var y = degToRad(lat2 - lat1);
      var d = Math.sqrt(x * x + y * y) * R;
      break;
  }

  return (d).toFixed(2);
}
