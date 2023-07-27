div
<template>
  <audio ref="audioElement"></audio>

  <div
    class="audio-player-container"
    v-if="store.getPlayerVisible"
    :class="{ hidden: store.getIsFullScreen }"
  >
    <div class="audio-player" @click="() => router.push('/radio')">
      <div class="audio-player-controls">
        <div class="radio-player-image">
          <img
            :src="store.getPlayerImg || './src/assets/images/bgdefault.jpg'"
            alt="Image"
            :class="{ 'cd-turn': store.getIsPlaying }"
          />
        </div>
        <div class="radio-player-text">
          <div class="radio-player-text-title">
            <p :class="{ scrollX: store.getSongName.length > 25 }">
              {{ store.getSongName }}
            </p>
          </div>
          <div class="radio-player-text-subtitle">
            <!-- <div :class="{ scrollt: currentArtist.length > 40 }"> -->
            <p :class="{ scrollX: store.getArtistName.length > 25 }">
              {{ store.getArtistName }}
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
            @click.stop=""
            @click="store.playRadio(audioElement)"
          />

          <img
            src="@/assets/svg/pause.svg"
            alt=""
            v-if="store.getIsPlaying"
            @click.stop=""
            @click="store.stopRadio(audioElement)"
          />
        </div>
        <div class="radio-player-close">
          <img
            src="@/assets/svg/close.svg"
            alt=""
            @click.stop=""
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
        <img
          width="25"
          :src="store.getPlayerImg || './src/assets/images/bgdefault.jpg'"
          alt=""
        />
        <span v-if="store.getCurrentRadio">{{
          store.getCurrentRadio.nom
        }}</span>
        <i :class="`arrow ${isOpen ? 'arrow-up' : 'arrow-down'}`"></i>
      </div>
      <ul class="select-dropdown" v-show="isOpen">
        <li
          v-for="option in options"
          :key="option"
          @click="selectOption(option)"
        >
          <img width="25" :src="option.imageURL" alt="" />
          {{ option.nom }}
        </li>
      </ul>
    </div>

    <div class="imgFullPlayer">
      <img
        :class="{ 'cd-turn': store.getIsPlaying }"
        :src="store.getPlayerImg || './src/assets/images/bgdefault.jpg'"
        alt="Image"
      />
    </div>

    <div class="textFullPlayer">
      <div class="textFullPlayer-title">{{ store.getSongName }}</div>
      <div class="textFullPlayer-subtitle">{{ store.getArtistName }}</div>
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
import { ref, reactive, computed, onMounted, onBeforeMount } from "vue";
import { useRoute } from "vue-router";
import { usePlayerStore } from "@/store/radioPlayer";
import axios from "axios";
import { parseString } from "xml2js";
import { useRouter } from "vue-router";

const router = useRouter();
const imageSrc = ref("");
const store = usePlayerStore();
const audioElement = ref(null);

const lastTime = ref(null);

const selectedOption = ref("ded");
const isOpen = ref(false);
const options = ref();

setInterval(async () => {
  await store.refreshTextPlayer();
}, 10000);

function toggleDropdown() {
  isOpen.value = !isOpen.value;
}

async function selectOption(option) {
  // selectedOption.value = option.nom;
  isOpen.value = false;
  store.changeRadio(option);
  store.refreshTextPlayer();
  // if (option.imageURL) {
  //   imageSrc.value = option.imageURL;
  // } else {
  //   imageSrc.value = imageSrc.value = "";
  // }
}

onBeforeMount(async () => {
  // await store.refreshRadio();
  await store.refreshTextPlayer();

  options.value = store.getRadioList;

  await store.addAudioElement(audioElement);

  const option = store.getCurrentRadio;
  if (option) {
    // selectedOption.value = option.nom;
    if (option.imageURL) {
      imageSrc.value = option.imageURL;
    } else {
      imageSrc.value = "";
    }
  }
});

// onMounted(async () => {
//   firstSelect();
// });
// const firstSelect = () => {
//   selectedOption.value = store.getCurrentRadio.nom;
//   console.log("FIRST", selectedOption.value);
// };
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
  bottom: 10.5%;
  .audio-player {
    // animation: bounce 1.5s ease-in;
    // animation: bounceIn 2s ease-in-out;
    animation: myAnim 1s ease 0s 1 normal none;
    // animation-iteration-count: 2;
    height: 80px;
    width: 93%;
    border-radius: 7px;
    /* background: #ebebeb; */
    /* box-shadow: 0px 2px 1px 0px rgba(0, 0, 0, 0.2); */
    display: flex;
    justify-content: center;
    color: #303030;
    overflow: hidden;
    background: rgba(255, 255, 255, 0.705);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    border-radius: 10px;
    // border: 1px solid rgba(255, 255, 255, 0.28);
    max-width: 500px;

    &::after {
      content: "";
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 4%;
      background: linear-gradient(180deg, #fd7307 0%, #d61f1f 175%);
      z-index: 1;
      // animation: scrollRev 5s linear infinite;
    }

    // &::before {
    //   content: "";
    //   position: absolute;
    //   bottom: 0;
    //   width: 100%;
    //   right: 0;
    //   height: 4%;
    //   background: linear-gradient(180deg, #fd7307 0%, #d61f1f 175%);
    //   z-index: 1;
    //   animation: reverse scrollRev 5s linear infinite;
    // }

    &-controls {
      display: flex;
      align-items: center;
      gap: 5px;
      height: 100%;
      width: 100%;
      z-index: 2;
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
        width: 33px;
        height: 33px;
      }
    }

    &-close {
      display: flex;
      align-items: center;
      height: 100%;
      width: 10%;

      img {
        width: 23px;
        height: 23px;
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
  animation: fadeIn 0.5s ease-in-out;

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

@keyframes scrollRev {
  0% {
    width: 0%;
  }
  50% {
    width: 50%;
  }
  100% {
    width: 0%;
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

// @keyframes myAnim {
//   0% {
//     animation-timing-function: ease-in;
//     opacity: 0;
//     transform: translateY(-300px);
//   }

//   38% {
//     animation-timing-function: ease-out;
//     opacity: 1;
//     transform: translateY(0);
//   }

//   55% {
//     animation-timing-function: ease-in;
//     transform: translateY(-65px);
//   }

//   72% {
//     animation-timing-function: ease-out;
//     transform: translateY(0);
//   }

//   81% {
//     animation-timing-function: ease-in;
//     transform: translateY(-28px);
//   }

//   90% {
//     animation-timing-function: ease-out;
//     transform: translateY(0);
//   }

//   95% {
//     animation-timing-function: ease-in;
//     transform: translateY(-8px);
//   }

//   100% {
//     animation-timing-function: ease-out;
//     transform: translateY(0);
//     // background: rgba(255, 255, 255, 0.705);
//   }
// }

@keyframes myAnim {
  from,
  60%,
  75%,
  90%,
  to {
    -webkit-animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
    animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
  }

  0% {
    opacity: 0;
    -webkit-transform: translate3d(-3000px, 0, 0) scaleX(3);
    transform: translate3d(-3000px, 0, 0) scaleX(3);
  }

  60% {
    opacity: 1;
    -webkit-transform: translate3d(25px, 0, 0) scaleX(1);
    transform: translate3d(25px, 0, 0) scaleX(1);
  }

  75% {
    -webkit-transform: translate3d(-10px, 0, 0) scaleX(0.98);
    transform: translate3d(-10px, 0, 0) scaleX(0.98);
  }

  90% {
    -webkit-transform: translate3d(5px, 0, 0) scaleX(0.995);
    transform: translate3d(5px, 0, 0) scaleX(0.995);
  }

  to {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
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
