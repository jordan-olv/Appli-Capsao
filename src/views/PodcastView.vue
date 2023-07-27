<template>
  <ion-page>
    <Loading v-if="isLoading" />
    <section class="podcast">
      <div class="content-view">
        <div class="list">
          <h2>Nos Podcasts</h2>
          <ul>
            <li
              v-for="item in episodes"
              @click="navigateTo(item)"
              :key="item.id"
            >
              <!-- <router-link class="li_content" to=""> -->
              <!-- <div class="li__content"> -->
              <img
                class="li_img"
                :src="item['itunes:image'][0].$['href']"
                alt=""
              />

              <!-- </div> -->
              <div class="btn_pod">
                <button @click="shareLink(item)" @click.stop="">
                  <img src="@/assets/svg/share.svg" alt="" />
                </button>
              </div>
              <h3>{{ item.title[0] }}</h3>

              <!-- </router-link> -->
            </li>
          </ul>
        </div>
      </div>
      <!-- <the-player /> -->
    </section>
  </ion-page>
</template>

<script setup>
import { IonPage } from "@ionic/vue";
import { ref, onMounted, reactive, computed } from "vue";
import { fetchData, fetchRss } from "@/services/api.js";
import { usePlayerStore } from "@/store/radioPlayer";
import { Share } from "@capacitor/share";
import { useRouter } from "vue-router";
import Loading from "@/components/Loading.vue";

const router = useRouter();
const store = usePlayerStore();
const isLoading = ref(true);
const podcasts = ref([]);

const shareLink = async (pod) => {
  try {
    await Share.share({
      url: pod.link[0],
    });
  } catch (err) {
    console.log("err", err);
  }
};

const navigateTo = (item) => {
  console.log("item", item);
  router.push("/podcast/" + item.id);
};

const episodes = reactive([]);
onMounted(async () => {
  podcasts.value = await fetchData("api_podcasts");
  console.log("aa", podcasts.value);

  podcasts.value.forEach(async (podcast) => {
    console.log("podcast", podcast);
    const ep = await fetchRss(podcast.link);
    const arrayId = ep.link[0].split("/");
    const podId = arrayId[arrayId.length - 1];
    ep.id = podId;
    episodes.push(ep);
    console.log(episodes);

    setTimeout(() => {
      isLoading.value = false;
    }, 1000);
  });

  //test sans api
  // episodes.push(
  //   {
  //     title: ["test"],
  //     "itunes:image": [
  //       {
  //         $: {
  //           href: "https://cdn.discordapp.com/attachments/685655650923053122/1123923007841239141/645b87197da629.01633555_1.png",
  //         },
  //       },
  //     ],
  //   },
  //   {
  //     title: ["test2 qsdf df dsf df sfd d"],
  //     "itunes:image": [
  //       {
  //         $: {
  //           href: "https://cdn.discordapp.com/attachments/685655650923053122/1123923008214536192/6479b5bf497704.61379988_1.png",
  //         },
  //       },
  //     ],
  //   },
  //   {
  //     title: ["test3"],
  //     "itunes:image": [
  //       {
  //         $: {
  //           href: "https://cdn.discordapp.com/attachments/685655650923053122/1107055380233724034/image.png",
  //         },
  //       },
  //     ],
  //   }
  // );
});

// const xmlObject = fetchRss("apo_podcasts");
// console.log(xmlObject);
</script>

<style lang="scss" scoped>
[v-cloak] {
  display: none;
}

a {
  text-decoration: none;
  color: #303030;
  font-weight: 700;
  font-size: 20px;
}
ul {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;

  li {
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
    min-width: 145px;
    max-width: 48%;
    width: 45%;
    flex-grow: 1;
    border-radius: 7px;

    h3 {
      max-width: 165px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      color: #303030;
      font-weight: 600;
    }

    img.li_img {
      object-fit: cover;
      max-width: 165px;
      height: 165px;
      min-height: 145px;
      vertical-align: middle;
      border-radius: 7px;
      margin-bottom: 7px;
    }
  }
  // .li__content {
  //   // width: 100%;
  //   // height: 100%;
  //   // border-radius: 7px;
  //   // flex-grow: 1;
  //   // flex-shrink: 0;
  //   // display: flex;
  //   // align-items: center;
  //   // // gap: 20px;
  //   // box-shadow: 0px 2px 1px 0px rgba(0, 0, 0, 0.2);
  //   // border-radius: 7px;
  //   // background: #ebebeb;
  //   // padding: 15px;
  //   // overflow: hidden;
  //   // color: #303030;
  //   // font-family: Inter;
  //   // position: relative;
  // }
}

.btn_pod {
  position: absolute;
  top: 10px;
  right: 10px;
  display: flex;
  flex-direction: column;
  gap: 5px;

  button {
    border-radius: 100%;
    aspect-ratio: 1/1;
    width: 40px;
    background: rgba(255, 255, 255, 0.7);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    backdrop-filter: blur(4px);
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;

    img {
      width: 20px;
      aspect-ratio: 1/1;
      color: #303030;
      fill: red;

      &.playSvg {
        margin-left: 3px;
      }
    }
  }
}

.list > h2 {
  font-size: 25px;
  margin-bottom: 20px;
}

@media screen and (min-width: 420px) {
  a {
    position: relative;

    .btn_pod {
      position: absolute;
      top: 5px;
      right: 0;
      display: flex;
      gap: 5px;

      > * {
        border-radius: 100%;
        aspect-ratio: 1/1;
        width: 40px;
        background: red;
      }
    }
  }

  ul {
    li {
      flex-grow: 0;
      background: none;
      border-radius: none;
      box-shadow: none;
      padding: 0;
      width: 165px;
    }
  }
}

@media screen and (max-width: 370px) {
  .content-view {
    width: 90%;
  }
  ul {
    align-items: center;
    // justify-content: center;
    li {
      // max-width: 85%;
      align-items: center;
      flex-wrap: wrap;
      flex-direction: row;
      justify-content: space-between;

      .btn_pod {
        margin-left: 10px;
        position: relative;
        align-self: flex-start;
        flex-direction: row;
        order: 3;
        margin-bottom: 20px;
      }

      h3 {
        flex-basis: 100%;
        margin-top: 5px;
      }
    }
  }
}

@media screen and (max-width: 309px) {
  .btn_pod {
    flex-direction: row;
    margin-left: 0 !important;
    margin-bottom: 10px;
  }
}
</style>
