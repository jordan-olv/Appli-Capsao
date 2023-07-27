import { defineStore } from 'pinia';
import axios from "axios";

import { printCurrentPosition } from '@/services/geoLoc';

export const usePlayerStore = defineStore('player', {
  state: () => ({
    isPlayerVisible: true,
    isFullScreen: false,
    isPlaying: false,
    isPodcast: false,
    audioElement: null,
    artistName: '',
    songName: '',
    currentRadio: null,
    currentPodcast: null,
    currentTime: 0,
    radioList: [

    ],
    podcastList: [

    ],
    playerImg: null,
  }),
  getters: {
    getPlayerVisible: (state) => state.isPlayerVisible,
    getCurrentRadio: (state) => state.currentRadio,
    getRadioList: (state) => state.radioList,
    getIsFullScreen: (state) => state.isFullScreen,
    getIsPlaying: (state) => state.isPlaying,
    getAudioElement: (state) => state.audioElement,
    getArtistName: (state) => state.artistName,
    getSongName: (state) => state.songName,
    getCurrentPodcast: (state) => state.currentPodcast,
    getIsPodcast: (state) => state.isPodcast,
    getPlayerImg: (state) => state.playerImg,
    getCurrentTime: (state) => state.currentTime,
  },
  actions: {
    async init() {
      this.radioList = [];
      await this.refreshRadio();

      this.getRadioList.forEach((element) => {
        if (element.isDefault) {
          this.currentRadio = element;
        }
      });

      const radioLoc = await printCurrentPosition(this.radioList);
      console.warn('radioLoc', radioLoc);
      if (radioLoc) {
        this.currentRadio = radioLoc;
      }
      await this.refreshTextPlayer();
    },
    async refreshRadio() {

      try {

        this.radioList = [];
        const res = await axios.get(
          "https://latinoclub.fr/api/api_radios"
        );
        if (res.status !== 200) {
          throw new Error("Problem getting text");
        }

        const data = await res.data["hydra:member"];

        data.forEach((element) => {
          this.addRadio(element);
        });

      }
      catch (error) {
        console.log(error);
      }
    },
    async refreshTextPlayer() {

      if (!this.isPodcast) {
        if (!this.currentRadio) return;
        const id = this.currentRadio.id;

        console.warn('refresh text player');
        try {
          console.log('in')
          const res = await axios.get(
            `https://latinoclub.fr/admin/radio/listen/${id}`, { timeout: 5000 }
          );


          if (res.status !== 200) {
            throw new Error("Problem getting text");
          }

          const data = res.data;
          if (data.fileContent) {

            this.playerImg = this.currentRadio.imageURL;

            data.fileContent = data.fileContent.replace(".mp3", "");
            if (data.fileContent.startsWith("BP Lyon")) {
              this.artistName = "";
              this.songName = "Capsao";
            } else {
              const text = data.fileContent.split(" - ");
              this.artistName = this.currentRadio.nom;
              this.songName = text[0] + ' - ' + text[1];
            }
          }
        } catch (error) {
          console.log(error);
          this.artistName = "Radio";
          this.songName = "Capsao";
          this.playerImg = this.currentRadio.imageURL;
        }
      } else {
        this.artistName = this.currentPodcast['itunes:subtitle'][0];
        this.songName = this.currentPodcast.title[0];
        this.playerImg = this.currentPodcast['itunes:image'][0].$.href;
      }

      // this.songName = this.CurrentTrack.name;
    },
    addRadio(radio) {
      this.radioList.push(radio);
    },
    addAudioElement(element) {
      this.audioElement = element;
    },
    showPlayer() {
      this.isPlayerVisible = true;
      // this.isFullScreen = false;
    },
    hidePlayer() {
      this.isPlayerVisible = false;
    },
    showFullPlayer() {
      // this.isPlayerVisible = false;
      this.isFullScreen = true;
    },
    hideFullPlayer() {
      this.isFullScreen = false;
    },
    async playRadio(track = this.getAudioElement) {
      if (this.isPodcast) {
        this.playPodcast(this.currentPodcast);
      } else {

        this.isPlaying = true;
        this.isPodcast = false;
        this.addAudioElement(track);
        track.src = this.getCurrentRadio.fluxAudio;
        if (!track.paused) {
          track.load();
        }

        try {
          await track.play();
        } catch (e) {
          console.log(e);
        }
      }
    },
    stopRadio(track = this.getAudioElement) {
      this.isPlaying = false;
      if (this.isPodcast) {
        this.currentTime = track.currentTime;
      }
      track.pause();
    },
    playPodcast(pod, state) {

      this.isPlaying = true;
      this.isPodcast = true;
      this.currentPodcast = pod;
      const audioPlayer = this.getAudioElement


      audioPlayer.src = pod.enclosure[0].$.url;

      if (!audioPlayer.paused) {
        audioPlayer.pause();
        audioPlayer.load();
      }
      audioPlayer.play();

      console.log(this.currentPodcast);

      if (this.songName == pod.title[0]) {
        if (this.currentTime > 0) {
          audioPlayer.currentTime = this.currentTime;
        }
      } else {
        this.currentTime = 0;
      }
      console.dir(audioPlayer)
      this.artistName = pod.title[0];
      this.songName = pod.title[0];
    },

    changeRadio(option) {
      console.warn('change radio');
      this.currentRadio = option;
      this.isPodcast = false;
      if (this.isPlaying) {
        this.playRadio();
      }
    },

    addPodcast(podcast) {
      this.podcastList.push(podcast);
    }
  }
});