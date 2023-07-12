import { defineStore } from 'pinia';
import axios from "axios";
import { Plugins } from '@capacitor/core';

const { Http } = Plugins;

export const usePlayerStore = defineStore('player', {
  state: () => ({
    isPlayerVisible: true,
    isFullScreen: false,
    isPlaying: false,
    audioElement: null,
    artistName: '',
    songName: '',
    currentRadio: null,
    radioList: [

    ],
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
  },
  actions: {
    async refreshRadio() {

      try {

        this.radioList = [];
        const res = await axios.get(
          "https://sc1ihlu1696.universe.wf/Appli-Capsao/public/api/api_radios"
        );
        if (res.status !== 200) {
          throw new Error("Problem getting text");
        }

        // const response = await Http.request({
        //   method: 'GET',
        //   url: 'https://sc1ihlu1696.universe.wf/Appli-Capsao/public/api/api_radios',
        // });

        // console.log('Response:', response);

        const data = await res.data["hydra:member"];

        data.forEach((element) => {
          if (element.isDefault) {
            this.currentRadio = element;
          }
          this.addRadio(element);
        });
      }
      catch (error) {
        console.log(error);
      }
      // console.log('ahah', this.radioList)
    },
    async refreshTextPlayer() {
      // console.log(this.currentRadio);
      const id = this.currentRadio.id;

      try {

        const res = await axios.get(
          `https://sc1ihlu1696.universe.wf/Appli-Capsao/public/admin/radio/${id}/listen`
        );

        // console.log('test', res)
        if (res.status !== 200) {
          throw new Error("Problem getting text");
        }

        // console.log(res)
        const data = res.data;
        // console.log(data);


        data.fileContent = data.fileContent.replace(".mp3", "");
        if (data.fileContent.startsWith("BP Lyon")) {
          this.artistName = "";
          this.songName = "Capsao";
        } else {
          const text = data.fileContent.split(" - ");
          this.artistName = text[0];
          this.songName = text[1];
        }
      } catch (error) {
        console.log(error);
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
    playRadio(track = this.getAudioElement) {
      this.isPlaying = true;
      this.addAudioElement(track);
      track.src = this.getCurrentRadio.fluxAudio;
      if (!track.paused) {
        track.pause();
        track.load();
      }
      console.dir(track.src);
      track.play();
    },
    stopRadio(track = this.getAudioElement) {
      this.isPlaying = false;
      track.pause();
    },
    changeRadio(option, track = this.getAudioElement) {
      this.currentRadio = option;
      if (this.isPlaying) {
        this.playRadio();
      }
    },

  }
});