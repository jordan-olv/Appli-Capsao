<template>
  <ion-page>
    <ion-content>
      <!-- <Loading v-if="isLoading" /> -->
      <section class="home">
        <div class="content-view home">
          <TheSlider />
          <div class="section--title">
            <div class="home__actu--title">
              <h2>Agenda événements</h2>
              <button @click="navigateTo('/agenda')">Plus...</button>
            </div>
          </div>
          <div class="home__actu">
            <div class="home__actu--content actuLeft actuRight">
              <ul ref="slid_actu" @scroll="handleScroll">
                <!-- <li class="space"></li> -->
                <li
                  v-for="agItem in agendaItem"
                  :key="agItem.guid[0]"
                  @click="navigateTo('/agenda', agItem)"
                >
                  <div class="actuDiv">
                    <img :src="agItem.enclosure[0].$['url']" alt="" />
                  </div>
                  <p class="actuP">{{ agItem.date }}</p>
                </li>
              </ul>
            </div>
          </div>
          <div class="section--title">
            <div class="home__actu--title">
              <h2>Derniers podcasts</h2>
              <button @click="navigateTo('/podcast')">Plus...</button>
            </div>
          </div>
          <div class="home__actu">
            <div class="home__actu--content podLeft podRight">
              <ul ref="slid_pod" @scroll="handleScrollTwo">
                <li
                  v-for="item in episodes"
                  @click="navigateTo('/podcast', item)"
                  :key="item.id"
                >
                  <div class="podDiv">
                    <img
                      class="li_img podImg"
                      :src="item['itunes:image'][0].$['href']"
                      alt=""
                    />
                  </div>
                  <div class="test">
                    <p class="podP">
                      {{ item.title[0] }}
                    </p>
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <div class="section--title">
            <div class="home__actu--title">
              <h2>Toutes les radios CAPSAO</h2>
            </div>
          </div>
          <div class="home__actu">
            <div class="home__actu--content radioLeft radioRight">
              <ul ref="slid_radio" @scroll="handleScrollThree">
                <!-- <li class="space"></li> -->
                <li
                  v-for="item in radioList"
                  :key="item.id"
                  @click="goToRadio(item)"
                >
                  <div class="podDiv">
                    <img :src="item.imageURL" alt="" />
                  </div>
                  <div class="test">
                    <p
                      :class="{ scrollX: item.nom.length > 10 }"
                      class="radioP"
                    >
                      {{ item.nom }}
                    </p>
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <div class="section--title" v-if="titreDesc || textDesc">
            <div class="home__actu--title textPres">
              <h2>{{ titreDesc }}</h2>
              <p>
                {{ textDesc }}
              </p>
            </div>
          </div>
        </div>
      </section>
    </ion-content>
  </ion-page>
</template>

<script setup>
import { IonPage, IonContent } from "@ionic/vue";
import TheSlider from "../components/TheSlider.vue";
import { ref, onMounted, reactive, onBeforeMount } from "vue";
import axios from "axios";
import Loading from "@/components/Loading.vue";
import { fetchData, fetchRss } from "@/services/api.js";
import { parseString } from "xml2js";
import { useRouter } from "vue-router";
import { usePlayerStore } from "@/store/radioPlayer";

const router = useRouter();
const store = usePlayerStore();

const isLoading = ref(true);

const slid_actu = ref(null);
const slid_pod = ref(null);
const slid_radio = ref(null);

const titreDesc = ref("");
const textDesc = ref("");

const actuLeft = ref(0);
const actuRight = ref(0);
const podLeft = ref(0);
const podRight = ref(0);
const radioLeft = ref(0);
const radioRight = ref(0);

const podcasts = ref([]);

const lastPosActu = ref(0);
const lastPosPod = ref(0);
const lastPosRadio = ref(0);

const episodes = reactive([]);
const agendaItem = ref(null);
const radioList = ref(null);

onBeforeMount(async () => {
  await fetchText();
  await fetchEvent();
  await fetchPodcast();

  console.log("dd");
}),
  onMounted(() => {
    radioList.value = store.getRadioList;
    console.log("RADIO", radioList.value);
    setTimeout(() => {
      isLoading.value = false;
    }, 1000);
  });

const fetchPodcast = async () => {
  podcasts.value = await fetchData("api_podcasts");

  podcasts.value.forEach(async (podcast, index) => {
    if (index >= 7) {
      return;
    }
    const ep = await fetchRss(podcast.link);
    const arrayId = ep.link[0].split("/");
    const podId = arrayId[arrayId.length - 1];
    ep.id = podId;
    episodes.push(ep);
  });
};

const fetchEvent = async () => {
  try {
    const res = await axios.get(`https://latinoclub.fr/api/event`);

    // console.log('test', res)
    if (res.status !== 200) {
      throw new Error("Problem getting text");
    }

    const data = res.data;

    if (data.fileContent) {
      parseString(data.fileContent, (err, result) => {
        if (err) {
          console.error(err);
        } else {
          console.log("de", result.rss.channel[0].item);
          agendaItem.value = result.rss.channel[0].item;
          agendaItem.value = agendaItem.value.slice(0, 7);

          // agendaItem.value.push({
          //   title: ["Le 21 septembre, RAUW ALEJANDRO à l'Accor Arena !"],
          //   description: [
          //     "Rauw Alejandro en concert exclusif &agrave; Paris : voyage caliente de Porto Rico &agrave; Saturne !&nbsp;\r\n...",
          //   ],
          //   pubDate: ["Thu, 27 Apr 2023 14:08:00 +0000"],
          //   link: [
          //     "https://capsao.com/agenda/le-21-septembre-rauw-alejandro-a-l-accor-arena-683",
          //   ],
          //   guid: [
          //     "https://capsao.com/agenda/le-21-septembre-rauw-alejandro-a-l-accor-arena-683",
          //   ],
          //   enclosure: [
          //     {
          //       $: {
          //         type: "image/jpeg",
          //         length: "114568",
          //         url: "https://capsao.com/upload/agenda/main/644a8311def576.40834257.jpg",
          //       },
          //     },
          //   ],
          //   "content:encoded": [
          //     'Jeudi 22 juillet 2023<br/>20:00 - 00:00<br><h2><b id="docs-internal-guid-0a3674e1-7fff-d314-3c1f-07c874b19d57"><span>Rauw Alejandro en concert exclusif &agrave; Paris : voyage caliente de Porto Rico &agrave; Saturne !&nbsp;</span></b><b><span></span></b></h2>\r\n<h2><span><b><b id="docs-internal-guid-bc3154dc-7fff-5bd4-24e6-6c287699f96c"><b id="docs-internal-guid-badfd2df-7fff-74ae-81cc-f2c2d42e5cb1"></b></b></b></span></h2>\r\n<p dir="ltr"><span>Rauw Alejandro,<strong> le King du Reggaeton</strong>, d&eacute;barque en France pour un <strong>concert de folie ! Le 21 septembre 2023,</strong> l\'Accor Arena va vibrer aux rythmes de la musique latine et du R&amp;B avec cet artiste de Porto Rico, laur&eacute;at de 2 Latin Grammy Awards. Et oui, vous avez bien lu, deux Grammy Awards, rien que &ccedil;a !</span></p>\r\n<p dir="ltr"><span>Alors,<strong> pr&eacute;parez-vous &agrave; bouger vos corps et &agrave; danser jusqu\'au bout de la nuit </strong>sur les tubes les plus caliente de<strong> Rauw Alejandro,</strong> tels que "Todo de Ti", "El Efecto", "Te Felicito" ou encore "Desesperados". Il a d&eacute;j&agrave; collabor&eacute; avec les plus grandes stars comme Shakira, Bad Bunny, Selena Gomez ou encore Manuel Turizo, et maintenant c\'est &agrave; vous de d&eacute;couvrir son <strong>univers explosif en live</strong> !</span></p>\r\n<p dir="ltr"><span><strong>Le Saturno World Tour 2023</strong> promet de vous emmener en voyage, de Porto Rico &agrave; Saturne, avec des chor&eacute;graphies endiabl&eacute;es et une ambiance de folie. Ne manquez pas cet &eacute;v&eacute;nement unique en France, et rendez-vous &agrave; l\'Accor Arena pour une soir&eacute;e inoubliable !</span></p>\r\n<p dir="ltr"><span></span></p>\r\n<p><strong>Infos pratiques :&nbsp;</strong></p>\r\n<ul>\r\n<li>- Date : Du 21 septembre 2023</li>\r\n<li>- Lieu : Accor Arena</li>\r\n<li>- Adresse : 8 boulevard de Bercy, 75012, Paris</li>\r\n</ul>',
          //   ],
          // });

          agendaItem.value.forEach((item) => {
            const arrayDate = item["content:encoded"][0].split("<br");
            item.date = arrayDate[0];
            const parsedDate = parseCustomDate(arrayDate[0]);
            const date = new Date(parsedDate);
            const dateNow = new Date();

            console.log(arrayDate[0], "->", date);

            // SUPPRIME LES EVENEMENTS DEJA PASSER ( comparaison longue car je voulais pas comparé avec les heures )
            if (
              date.getFullYear() < dateNow.getFullYear() ||
              (date.getFullYear() === dateNow.getFullYear() &&
                date.getMonth() < dateNow.getMonth()) ||
              (date.getFullYear() === dateNow.getFullYear() &&
                date.getMonth() === dateNow.getMonth() &&
                date.getDate() < dateNow.getDate())
            ) {
              agendaItem.value.splice(agendaItem.value.indexOf(item), 1);
            }
          });
        }
      });
    }
  } catch (err) {
    console.error(err);
  }
};

const fetchText = async () => {
  const res = await axios.get("https://latinoclub.fr/api/zone_textes/1");

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
  podLeft.value = 0;
  podRight.value = 0;
  radioLeft.value = 0;
  radioRight.value = 0;
  if (slid_actu.value.scrollLeft > lastPosActu.value) {
    actuLeft.value = 1;
    actuRight.value = 0;
  } else {
    actuLeft.value = 0;
    actuRight.value = 1;
  }
  lastPosActu.value = slid_actu.value.scrollLeft;
};

const handleScrollTwo = () => {
  actuLeft.value = 0;
  actuRight.value = 0;
  radioLeft.value = 0;
  radioRight.value = 0;
  if (slid_pod.value.scrollLeft > lastPosPod.value) {
    podLeft.value = 1;
    podRight.value = 0;
  } else {
    podLeft.value = 0;
    podRight.value = 1;
  }
  lastPosPod.value = slid_pod.value.scrollLeft;
};

const handleScrollThree = () => {
  actuLeft.value = 0;
  actuRight.value = 0;
  podLeft.value = 0;
  podRight.value = 0;
  if (slid_radio.value.scrollLeft > lastPosRadio.value) {
    radioLeft.value = 1;
    radioRight.value = 0;
  } else {
    radioLeft.value = 0;
    radioRight.value = 1;
  }
  lastPosRadio.value = slid_radio.value.scrollLeft;
};

function parseCustomDate(dateString) {
  const monthsMapping = {
    janvier: 0,
    février: 1,
    mars: 2,
    avril: 3,
    mai: 4,
    juin: 5,
    juillet: 6,
    août: 7,
    septembre: 8,
    octobre: 9,
    novembre: 10,
    décembre: 11,
  };

  const dateParts = dateString.split(" ");
  const day = parseInt(dateParts[1], 10);
  const month = monthsMapping[dateParts[2].toLowerCase()];
  const year = parseInt(dateParts[3], 10);

  if (isNaN(day) || isNaN(month) || isNaN(year)) {
    return "Invalid date";
  }

  return new Date(year, month, day);
}

const navigateTo = (path, item) => {
  if (item && path) {
    if (path == "/podcast") {
      console.log("item", item);
      router.push("/podcast/" + item.id);
    }

    if (path == "/agenda") {
      console.log("item", item);
      const id = item.guid[0].split("-");
      router.push("/agenda/" + id[id.length - 1]);
    }
  } else {
    router.push(path);
  }
};

const goToRadio = (item) => {
  console.log("item", item);
  store.changeRadio(item);
  store.refreshTextPlayer();
  store.playRadio();
  store.showPlayer();
  // router.push("/radio");
};
</script>

<style lang="scss" scoped>
ion-content {
  padding-top: 11%;
}
.actuLeft {
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

.radioLeft {
  &::before {
    content: "";
    opacity: v-bind(radioLeft);
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

.radioRight {
  &::after {
    content: "";
    opacity: v-bind(radioRight);
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
  width: 100%;
  &--title {
    width: 82%;
    display: flex;
    justify-content: space-between;

    button {
      background: #ffbd8b;
      border-radius: 7px;
      border: none;
      padding: 5px 10px;
      color: #303030;
      font-size: 12px;
      font-family: Inter;
      font-style: normal;
      font-weight: 600;
      line-height: normal;
      text-align: center;
      text-transform: uppercase;
      margin-bottom: 3px;
    }
    p {
      margin-top: 7px;
      border-radius: 7px;
      background: #ffbd8b;
      padding: 22px;
    }
  }
  &--content {
    width: 100%;

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
        width: 270px;
        &.space {
          width: 9%;
          height: 100%;
          background: red;
        }
        p.actuP {
          color: #303030;
          font-size: 17px;
          font-family: Inter;
          font-style: normal;
          font-weight: 600;
          line-height: normal;
          text-overflow: ellipsis;
          overflow: hidden;
          white-space: nowrap;
          width: 270px;
        }
        div.actuDiv {
          max-width: 270px;
          width: 270px;
          flex-shrink: 0;
          // background: rgb(97, 97, 97);
          box-shadow: 0px 2px 1px 0px rgba(0, 0, 0, 0.2);
          border-radius: 7px;
          display: flex;
          justify-content: center;
          overflow: hidden;
          height: 130px;

          img {
            // border-radius: 7px;
            // object-fit: cover;
            // box-shadow: 0px 2px 1px 0px rgba(0, 0, 0, 0.2);

            // border-radius: 7px;
            // max-width: 270px;
            // height: 125px;
            object-fit: initial;
            width: 100%;
          }
        }

        p.podP {
          color: #303030;
          font-size: 17px;
          font-family: Inter;
          font-style: normal;
          font-weight: 600;
          line-height: normal;
          text-overflow: ellipsis;
          overflow: hidden;
          white-space: nowrap;
          width: 125px;
        }

        p.radioP {
          // text-align: center;
          color: #303030;
          font-size: 17px;
          font-family: Inter;
          font-style: normal;
          font-weight: 600;
          line-height: normal;
          text-overflow: ellipsis;
          // overflow: hidden;
          white-space: nowrap;
          width: 125px;
        }
        div.podDiv {
          width: 125px;
          height: 110px;
          flex-shrink: 0;
          border-radius: 7px;
          // background: #ebebeb;
          // box-shadow: 0px 2px 1px 0px rgba(0, 0, 0, 0.2);
          // box-shadow: inset 0px -14px 15px -3px rgba(0, 0, 0, 0.1);

          display: flex;
          justify-content: center;
          overflow: hidden;

          img.podImg {
            width: 100%;
          }
          img {
            border-radius: 7px;
            object-fit: cover;
            // object-fit: cover;
            // box-shadow: 0px 2px 1px 0px rgba(0, 0, 0, 0.2);

            // border-radius: 7px;
            // max-width: 270px;
            // height: 125px;
            object-fit: cover;
          }
        }
      }
    }
  }
}

.test {
  width: 100%;
  overflow: hidden;
}
.textPres {
  display: flex;
  flex-direction: column;
}

.scrollX {
  white-space: nowrap;
  animation: scroll 7s linear infinite;
}

@keyframes scroll {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(-50%);
  }
}
</style>
