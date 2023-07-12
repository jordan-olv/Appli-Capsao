<template>
  <ion-page>
    <ion-content>
      <section class="home">
        <div class="content-view home">
          <TheSlider />
          <div class="section--title">
            <div class="home__actu--title">
              <h2>Nos dernières actualité</h2>
            </div>
          </div>
          <div class="home__actu">
            <div class="home__actu--content actuLeft actuRight">
              <ul ref="slid_actu" @scroll="handleScroll">
                <!-- <li class="space"></li> -->
                <li>
                  <div>
                    <img
                      src="https://www.capsao.com/upload/agenda/main/6446913c9b88b6.06933536.jpg?=1688416081"
                      alt=""
                    />
                  </div>
                  <p>Title ldldl sklsksdd ddddk</p>
                </li>
                <li>
                  <div>
                    <img
                      src="https://www.capsao.com/upload/agenda/main/645e067b25bfd7.91676359.png?=1688416000"
                      alt=""
                    />
                  </div>
                  <p>Title ldldl sklsksdd ddddk</p>
                </li>
                <li>
                  <div>
                    <img
                      src="https://www.capsao.com/upload/agenda/main/649af745389f31.55943841.png?=1688416123"
                      alt=""
                    />
                  </div>
                  <p>Title ldldl sklsksdd ddddk</p>
                </li>
                <li>
                  <div>
                    <img
                      src="https://www.capsao.com/upload/agenda/main/649c37fbad0708.00736200.jpg?=1688416140"
                      alt=""
                    />
                  </div>
                  <p>Title ldldl sklsksdd ddddk</p>
                </li>
                <li>
                  <div>
                    <img
                      src="https://www.capsao.com/upload/agenda/main/644906c5d4d081.85408106.jpg?=1688416153"
                      alt=""
                    />
                  </div>
                  <p>Title ldldl sklsksdd ddddk</p>
                </li>
                <li>
                  <div>
                    <img
                      src="https://www.capsao.com/upload/agenda/main/6448fba2c4ffb2.46956344.jpg?=1688416166"
                      alt=""
                    />
                  </div>
                  <p>Title ldldl sklsksdd ddddk</p>
                </li>
                <li>
                  <div>
                    <img
                      src="https://www.capsao.com/upload/agenda/main/6448f1b0d93c06.68325864.jpg?=1688416175"
                      alt=""
                    />
                  </div>
                  <p>Title ldldl sklsksdd ddddk</p>
                </li>
              </ul>
            </div>
          </div>
          <div class="section--title">
            <div class="home__actu--title">
              <h2>Nos derniers Podcasts</h2>
            </div>
          </div>
          <div class="home__actu">
            <div class="home__actu--content podLeft podRight">
              <ul ref="slid_pod" @scroll="handleScrollTwo">
                <li>
                  <div>
                    <img
                      src="https://www.capsao.com/upload/agenda/main/644906c5d4d081.85408106.jpg?=1688416153"
                      alt=""
                    />
                  </div>
                  <p>Title ldldl sklsksdd ddddk</p>
                </li>
                <li>
                  <div>
                    <img
                      src="https://www.capsao.com/upload/agenda/main/6448fba2c4ffb2.46956344.jpg?=1688416166"
                      alt=""
                    />
                  </div>
                  <p>Title ldldl sklsksdd ddddk</p>
                </li>
                <li>
                  <div>
                    <img
                      src="https://www.capsao.com/upload/agenda/main/6448f1b0d93c06.68325864.jpg?=1688416175"
                      alt=""
                    />
                  </div>
                  <p>Title ldldl sklsksdd ddddk</p>
                </li>
                <li>
                  <div>
                    <img
                      src="https://www.capsao.com/upload/agenda/main/6446913c9b88b6.06933536.jpg?=1688416081"
                      alt=""
                    />
                  </div>
                  <p>Title ldldl sklsksdd ddddk</p>
                </li>
                <li>
                  <div>
                    <img
                      src="https://www.capsao.com/upload/agenda/main/645e067b25bfd7.91676359.png?=1688416000"
                      alt=""
                    />
                  </div>
                  <p>Title ldldl sklsksdd ddddk</p>
                </li>
                <li>
                  <div>
                    <img
                      src="https://www.capsao.com/upload/agenda/main/649af745389f31.55943841.png?=1688416123"
                      alt=""
                    />
                  </div>
                  <p>Title ldldl sklsksdd ddddk</p>
                </li>
                <li>
                  <div>
                    <img
                      src="https://www.capsao.com/upload/agenda/main/649c37fbad0708.00736200.jpg?=1688416140"
                      alt=""
                    />
                  </div>
                  <p>Title ldldl sklsksdd ddddk</p>
                </li>
              </ul>
            </div>
          </div>
          <div class="section--title" v-if="titreDesc || textDesc">
            <div class="home__actu--title">
              <h2>{{ titreDesc }}</h2>
              <p>
                {{ textDesc }}
              </p>
            </div>
          </div>
        </div>
        <!-- <the-player /> -->
      </section>
    </ion-content>
  </ion-page>
</template>

<script setup>
import { IonPage, IonContent } from "@ionic/vue";
// import ThePlayer from "@/components/ThePlayer.vue";
import TheSlider from "../components/TheSlider.vue";
import { ref, onMounted } from "vue";
import axios from "axios";
import { text } from "ionicons/icons";

const slid_actu = ref(null);
const slid_pod = ref(null);

const titreDesc = ref("");
const textDesc = ref("");

const actuLeft = ref(0);
const actuRight = ref(0);
const podLeft = ref(0);
const podRight = ref(0);

const lastPosActu = ref(0);
// const toRightActu = ref(false);
// const toLeftActu = ref(false);

const lastPosPod = ref(0);
// const toRightPod = ref(false);
// const toLeftPod = ref(false);

onMounted(async () => {
  await fetchText();
});

const fetchText = async () => {
  const res = await axios.get(
    "https://sc1ihlu1696.universe.wf/Appli-Capsao/public/api/zone_textes/1"
  );

  if (res.status !== 200) {
    throw new Error("Problem getting text");
  }

  // console.log(res.json());
  const data = await res.data;
  // console.log(data);

  titreDesc.value = data.titre;
  textDesc.value = data.texte;
};

const handleScroll = () => {
  // toRightPod.value = false;
  // toLeftPod.value = false;
  podLeft.value = 0;
  podRight.value = 0;
  if (slid_actu.value.scrollLeft > lastPosActu.value) {
    // toRightActu.value = true;
    // toLeftActu.value = false;
    actuLeft.value = 1;
    actuRight.value = 0;
  } else {
    actuLeft.value = 0;
    actuRight.value = 1;
    // toRightActu.value = false;
    // toLeftActu.value = true;
  }
  lastPosActu.value = slid_actu.value.scrollLeft;
};

const handleScrollTwo = () => {
  // toRightActu.value = false;
  // toLeftActu.value = false;
  actuLeft.value = 0;
  actuRight.value = 0;
  if (slid_pod.value.scrollLeft > lastPosPod.value) {
    // toRightPod.value = true;
    // toLeftPod.value = false;
    podLeft.value = 1;
    podRight.value = 0;
  } else {
    // toRightPod.value = false;
    // toLeftPod.value = true;
    podLeft.value = 0;
    podRight.value = 1;
  }
  lastPosPod.value = slid_pod.value.scrollLeft;
};
</script>

<style lang="scss" scoped>
.actuLeft {
  // padding-left: 0 !important;

  &::before {
    content: "";
    opacity: v-bind(actuLeft);
    transition: all 1.5s;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    width: 5%;
    height: 100%;
    left: 0;
    position: absolute;
    z-index: 9999999;
    margin-left: auto;
    top: 0;
    background: linear-gradient(
      to left,
      rgba(255, 255, 255, 0) 0,
      rgba(249, 249, 249, 0.7) 40%,
      rgb(249, 249, 249) 70%
    );
  }
}

.podLeft {
  // padding-left: 0 !important;

  &::before {
    content: "";
    opacity: v-bind(podLeft);
    transition: all 1.5s;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    width: 5%;
    height: 100%;
    left: 0;
    position: absolute;
    z-index: 9999999;
    margin-left: auto;
    top: 0;
    background: linear-gradient(
      to left,
      rgba(255, 255, 255, 0) 0,
      rgba(249, 249, 249, 0.7) 40%,
      rgb(249, 249, 249) 70%
    );
  }
}
.actuRight {
  // padding-left: 9% !important;

  &::after {
    content: "";
    opacity: v-bind(actuRight);
    transition: all 1s;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    width: 5%;
    height: 100%;
    right: 0;
    position: absolute;
    z-index: 9999999;
    margin-left: auto;
    top: 0;
    background: linear-gradient(
      to right,
      rgba(255, 255, 255, 0) 0,
      rgba(249, 249, 249, 0.7) 40%,
      rgb(249, 249, 249) 70%
    );
  }
}

.podRight {
  // padding-left: 9% !important;

  &::after {
    content: "";
    opacity: v-bind(podRight);
    transition: all 1s;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    width: 5%;
    height: 100%;
    right: 0;
    position: absolute;
    z-index: 9999999;
    margin-left: auto;
    top: 0;
    background: linear-gradient(
      to right,
      rgba(255, 255, 255, 0) 0,
      rgba(249, 249, 249, 0.7) 40%,
      rgb(249, 249, 249) 70%
    );
  }
}
.home__actu {
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  // overflow: hidden;
  width: 100%;
  &--title {
    width: 82%;

    p {
      margin-top: 7px;
      border-radius: 7px;
      background: #ffbd8b;
      padding: 22px;
    }
  }
  &--content {
    width: 100%;
    // padding-left: calc(18% / 2);
    // overflow-y: scroll;
    position: relative;

    ul {
      display: flex;
      overflow-x: scroll;
      padding-right: 9%;
      padding-left: 9%;
      gap: 20px;

      li {
        display: flex;
        align-items: center;
        flex-direction: column;
        gap: 5px;

        &.space {
          width: 9%;
          height: 100%;
          background: red;
        }
        p {
          color: #303030;
          font-size: 16px;
          font-family: Inter;
          font-style: normal;
          font-weight: 600;
          line-height: normal;
          text-overflow: ellipsis;
          overflow: hidden;
          white-space: nowrap;
          width: 125px;
        }
        div {
          width: 125px;
          height: 110px;
          flex-shrink: 0;
          background: rgb(97, 97, 97);
          border-radius: 7px;
          display: flex;
          justify-content: center;
          overflow: hidden;

          img {
            object-fit: cover;
          }
        }
      }
    }
  }
}
</style>
