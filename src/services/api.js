import axios from 'axios';
import { parseString } from "xml2js";
// import { CapacitorHttp } from '@capacitor/core';

export const api = axios.create({
  baseURL: 'https://latinoclub.fr/api',
});

export async function fetchData(url) {

  try {
    const response = await api.get(url);

    if (response.status == 200 || response.status == 201) {
      if (response.data['hydra:member']) {
        return response.data['hydra:member'];
      } else {
        return response.data;
      }
    }
  } catch (error) {
    console.error('Une erreur s\'est produite lors de la requête:', error);
    throw error;
  }
}

export const fetchRss = async (url) => {

  try {
    let array = [];
    const response = await axios.get(url);

    if (response.status == 200 || response.status == 201) {
      parseString(response.data, (err, result) => {
        if (err) {
        } else {
          array = result.rss.channel[0];
        }
      });
      return array;
    } else {
      console.error('Une erreur s\'est produite lors de la requête axios:', error);
    }
  } catch (error) {
    console.error('Une erreur s\'est produite lors de la requête:', error);
    throw error;
  }
}