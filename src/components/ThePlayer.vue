<template>
  <audio ref="audioElement" src=""></audio>

  <div
    class="audio-player-container"
    v-if="store.getPlayerVisible"
    :class="{ hidden: store.getIsFullScreen }"
  >
    <div class="audio-player">
      <div class="audio-player-controls">
        <div class="radio-player-image">
          <img
            :src="imageSrc || './src/assets/images/bgdefault.jpg'"
            alt="Image"
            :class="{ 'cd-turn': store.getIsPlaying }"
          />
        </div>
        <div class="radio-player-text">
          <div class="radio-player-text-title">
            <p :class="{ scrollX: currentAudio.length > 25 }">
              {{ currentAudio }}
            </p>
          </div>
          <div class="radio-player-text-subtitle">
            <!-- <div :class="{ scrollt: currentArtist.length > 40 }"> -->
            <p :class="{ scrollX: currentArtist.length > 25 }">
              {{ currentArtist }}
            </p>

            <!-- {{ store.getCurrentRadio }} -->

            <!-- </div> -->
          </div>
        </div>
        <div class="radio-player-play">
          <img
            src="@/assets/svg/play.svg"
            v-if="!store.getIsPlaying"
            alt=""
            @click="store.playRadio(audioElement)"
          />

          <img
            src="@/assets/svg/pause.svg"
            alt=""
            v-if="store.getIsPlaying"
            @click="store.stopRadio(audioElement)"
          />
        </div>
        <div class="radio-player-close">
          <img
            src="@/assets/svg/close.svg"
            alt=""
            @click="
              () => {
                store.stopRadio(audioElement);
                store.hidePlayer();
              }
            "
          />
        </div>
      </div>
    </div>
  </div>

  <div
    class="audio-player-containerFull"
    v-if="store.getPlayerVisible"
    :class="{ hidden: !store.getIsFullScreen }"
  >
    <div class="select-wrapper">
      <div class="select-header" @click="toggleDropdown">
        <img src="@/assets/icon/capsao.png" alt="" />
        <span>{{ selectedOption }}</span>
        <i :class="`arrow ${isOpen ? 'arrow-up' : 'arrow-down'}`"></i>
      </div>
      <ul class="select-dropdown" v-show="isOpen">
        <li
          v-for="option in options"
          :key="option"
          @click="selectOption(option)"
        >
          <img src="@/assets/icon/capsao.png" alt="" />
          {{ option.nom }}
        </li>
      </ul>
    </div>

    <div class="imgFullPlayer">
      <img
        :class="{ 'cd-turn': store.getIsPlaying }"
        :src="imageSrc || './src/assets/images/bgdefault.jpg'"
        alt="Image"
      />
    </div>

    <div class="textFullPlayer">
      <div class="textFullPlayer-title">{{ currentAudio }}</div>
      <div class="textFullPlayer-subtitle">{{ currentArtist }}</div>
    </div>

    <div class="controlFullPlayer">
      <span></span>
      <img
        src="@/assets/svg/playFull.svg"
        v-if="!store.getIsPlaying"
        alt=""
        @click="store.playRadio(audioElement)"
      />
      <img
        src="@/assets/svg/pauseFull.svg"
        alt=""
        v-if="store.getIsPlaying"
        @click="store.stopRadio(audioElement)"
      />
      <span></span>
    </div>
    <!-- <div class="audio-playerFull">
      <img
        src="@/assets/svg/play.svg"
        v-if="!store.getIsPlaying"
        alt=""
        @click="playAudio"
      />

      <img
        src="@/assets/svg/pause.svg"
        alt=""
        v-if="store.getIsPlaying"
        @click="pauseAudio"
      />
    </div>
    <div class="radio-player-close">
      <img
        src="@/assets/svg/close.svg"
        alt=""
        @click="
          () => {
            store.hidePlayer();
          }
        "
      />
    </div> -->
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from "vue";
import { useRoute } from "vue-router";
import { usePlayerStore } from "@/store/radioPlayer";
import axios from "axios";
import { parseString } from "xml2js";

const imageSrc = ref("");
const store = usePlayerStore();
const audioElement = ref(null);

const selectedOption = ref("");
const isOpen = ref(false);
const options = ref(store.getRadioList);

const currentArtist = ref("");
const currentAudio = ref("");

let intReloadText = setInterval(async () => {
  // await refreshText();
}, 15000);

const refreshText = async () => {
  // await store.refreshTextPlayer();
  // console.log("SMALL");
  // console.log("OLD", currentAudio.value);
  // console.log("NEW", store.getSongName);

  if (currentAudio.value != store.getSongName) {
    currentAudio.value = store.getSongName;
    currentArtist.value = store.getArtistName;
  }
};

refreshText();

function toggleDropdown() {
  isOpen.value = !isOpen.value;
}

async function selectOption(option) {
  selectedOption.value = option.nom;
  isOpen.value = false;
  store.changeRadio(option);
  refreshText();
  console.log(option);
  if (option.imageURL) {
    imageSrc.value = option.imageURL;
  } else {
    imageSrc.value = imageSrc.value = "";
  }
}

onMounted(async () => {
  // await store.refreshTextPlayer();

  currentArtist.value = store.getArtistName;
  currentAudio.value = store.getSongName;

  const option = store.getCurrentRadio;
  if (option) {
    selectedOption.value = option.nom;
    if (option.imageURL) {
      console.log(option.imageURL);
      imageSrc.value = option.imageURL;
    } else {
      imageSrc.value = "";
    }
  }
});
</script>

<style lang="scss">
// section {
//   padding-bottom: 200px;
// }
.audio-player-container {
  width: 100%;
  display: flex;
  justify-content: center;
  position: absolute;
  bottom: 11%;
  .audio-player {
    // height: 70px;
    // width: 93%;
    // border-radius: 7px;
    // background: #ebebeb;
    // box-shadow: 0px 2px 1px 0px rgba(0, 0, 0, 0.2);
    // display: flex;
    // justify-content: center;
    // color: #303030;
    // overflow: hidden;
    // max-width: 600px;

    height: 75px;
    width: 93%;
    border-radius: 7px;
    /* background: #ebebeb; */
    /* box-shadow: 0px 2px 1px 0px rgba(0, 0, 0, 0.2); */
    display: flex;
    justify-content: center;
    color: #303030;
    overflow: hidden;
    background: rgba(255, 255, 255, 0.7);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.28);
    max-width: 600px;
    &-controls {
      display: flex;
      align-items: center;
      gap: 5px;
      height: 100%;
      width: 100%;
    }
  }

  .radio-player {
    &-image {
      // margin-left: 17px;
      height: 100%;
      width: 15%;
      margin-left: 2.5%;
      margin-right: 2.5%;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;

      &::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        width: 25%;
        max-width: 9px;
        border: 3px solid rgb(126 126 126 / 54%);
        aspect-ratio: 1/1;
        background: #f9f9f9;
      }

      img {
        border-radius: 50%;
        height: 72%;
        aspect-ratio: 1/1;
        max-width: none;
      }
    }

    &-text {
      display: flex;
      flex-direction: column;
      justify-content: center;
      height: 100%;
      width: 50%;
      overflow: hidden;

      &-title {
        color: #303030;
        font-weight: 600;
        font-family: Kanit;
        margin-bottom: 2px;
        width: 90%;
        white-space: nowrap;
        font-size: 18px;
      }

      &-subtitle {
        white-space: nowrap;
        width: 90%;
        font-size: 15px;
      }
    }

    &-play {
      margin-left: auto;
      display: flex;
      align-items: center;
      justify-content: flex-start;
      height: 100%;
      width: 10%;
      margin-right: 10px;

      img {
        width: 30px;
        height: 30px;
      }
    }

    &-close {
      display: flex;
      align-items: center;
      height: 100%;
      width: 10%;

      img {
        width: 20px;
        height: 20px;
      }
    }
  }
}

.audio-player-containerFull {
  position: relative;
  width: 100%;
  height: 90%;
  background: #f9f9f9;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 10px;
  justify-content: center;
  z-index: 999;

  .select-wrapper {
    position: relative;
    display: flex;
    justify-content: center;
    color: #303030;
    font-size: 20px;
    font-family: Kanit;
    font-weight: 500;
    width: 100%;
    max-width: 500px;
  }

  .select-header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px;
    border-radius: 7px;
    background: #ebebeb;
    box-shadow: 0px 2px 1px 0px rgba(0, 0, 0, 0.2);
    z-index: 999;
    width: 80%;
    height: 61px;
    cursor: pointer;

    img {
      margin-left: 10px;
      border-radius: 50%;
    }
  }

  .imgFullPlayer {
    width: 80%;
    border-radius: 7px;
    margin-top: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
    &::after {
      content: "";
      position: absolute;
      border-radius: 50%;
      width: 11%;
      aspect-ratio: 1/1;
      background: #f9f9f9;
      z-index: 6;
      max-width: 35px;
    }

    &::before {
      content: "";
      position: absolute;
      border-radius: 50%;
      width: 15%;
      aspect-ratio: 1/1;
      background: #f9f9f98a;
      z-index: 5;
      max-width: 50px;
    }

    img {
      width: 93%;
      // height: 275px;
      aspect-ratio: 1/1;
      border-radius: 50%;
      object-fit: cover;
      max-width: 325px;
    }
  }

  .textFullPlayer {
    width: 82%;
    justify-content: center;
    align-items: center;
    margin-top: 15px;
    margin-bottom: 25px;

    & > * {
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
    }
    &-title {
      color: #303030;
      font-size: 23px;
      font-weight: 700;
      font-family: Kanit;
      margin-bottom: 10px;
    }

    &-subtitle {
      color: #303030;
      font-size: 18px;
      font-family: Kanit;
    }
  }

  .controlFullPlayer {
    width: 80%;
    display: flex;
    gap: 20px;
    align-items: center;
    justify-content: space-between;
    img {
      width: 53px;
      height: 53px;
    }
    span {
      width: 100%;
      height: 1px;
      background: rgba(48, 48, 48, 0.21);
    }
  }

  .arrow {
    margin-left: auto;
    margin-right: 10px;
    border-left: 11px solid transparent;
    border-right: 11px solid transparent;
    border-top: 12px solid #aaa;
    transition: transform 0.3s ease;
    pointer-events: none;
    transform-origin: center;
  }

  .arrow-up {
    transform: rotate(-180deg);
  }

  .arrow-down {
    transform: rotate(0deg);
  }

  .select-dropdown {
    position: absolute;
    top: 115%;
    left: 50%;
    transform: translateX(-50%);
    width: 80.5%;
    overflow-y: auto;
    z-index: 999;
    border-radius: 7px;
    border: 1px solid rgba(0, 0, 0, 0.07);
    opacity: 0.8500000238418579;
    background: #ebebeb;
    list-style-type: none;
    padding: 0;
  }

  .select-dropdown li {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 17px;
    cursor: pointer;
    border-bottom: 1px solid rgba(48, 48, 48, 0.21);
    font-size: 18px;

    img {
      border-radius: 50%;
    }
  }

  .select-dropdown li:hover {
    background-color: #f5f5f5;
  }
}

.scrollX {
  white-space: nowrap;
  animation: scroll 7s linear infinite;
}

.cd-turn {
  animation: rotation 5s infinite linear;
}

@keyframes scroll {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(-100%);
  }
}

@keyframes rotation {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}
@media screen and (min-width: 530px) {
  .audio-player-containerFull {
    padding: 30px;
  }
}

.hidden {
  display: none;
}
</style>
