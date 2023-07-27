<template>
  <ion-page>
    <section class="podcast">
      <div class="content-view">
        <div class="list">
          <h2>{{ podTitle }}</h2>

          <button class="backBtn" @click="router.push('/podcast')">
            <img src="@/assets/icon/back.png" alt="" />
          </button>
        </div>
        <div class="filter">
          <label>
            <input type="checkbox" v-model="latest" style="display: none" />
            <span :class="{ underline: latest }">Latest</span>
          </label>
        </div>
        <ul>
          <li v-for="item in reversedItems">
            <img
              class="li_img"
              :src="item['itunes:image'][0].$['href']"
              alt=""
            />
            <!-- </div> -->
            <div class="btn_pod">
              <button @click.stop="">
                <img
                  src="@/assets/svg/pause.svg"
                  alt=""
                  v-if="
                    store.getIsPlaying &&
                    store.currentPodcast === item &&
                    store.getIsPodcast
                  "
                  @click="store.stopRadio(audioElement)"
                />
                <img
                  class="playSvg"
                  src="@/assets/svg/play.svg"
                  alt=""
                  v-else
                  @click="playPodcast(item)"
                />
              </button>
              <button @click="shareLink(item)">
                <img src="@/assets/svg/share.svg" alt="" />
              </button>
            </div>
            <h3>{{ item.title[0] }}</h3>
          </li>
        </ul>
      </div>
    </section>
  </ion-page>
</template>

<script setup>
import { ref, onMounted, onBeforeMount, computed } from "vue";
import { fetchData, fetchRss } from "@/services/api.js";
import { useRouter } from "vue-router";
import { usePlayerStore } from "@/store/radioPlayer";
import { Share } from "@capacitor/share";
import { IonPage } from "@ionic/vue";
import Loading from "@/components/Loading.vue";

const router = useRouter();
const store = usePlayerStore();

const isLoading = ref(true);

const podcasts = ref([]);
const podcastsId = ref();
const podTitle = ref("");
const episodes = ref([]);
const latest = ref(true);
onBeforeMount(async () => {
  podcasts.value = await fetchData("api_podcasts");

  podcasts.value.forEach(async (podcast) => {
    console.log("podcast", podcast);
    const ep = await fetchRss(podcast.link);
    const arrayId = ep.link[0].split("/");
    const podId = arrayId[arrayId.length - 1];
    if (podId == router.currentRoute.value.params.id) {
      podcastsId.value = ep;
      podTitle.value = podcastsId.value.title[0];
      episodes.value = ep.item.reverse();

      // reverseArr();
    }
  });
});

const reversedItems = computed(() => {
  const clonedItems = [...episodes.value];
  if (latest.value) {
    clonedItems.reverse();
  }
  return clonedItems;
});

const shareLink = async (pod) => {
  // Share url only
  console.log();
  await Share.share({
    url: pod.link[0],
  });
};

const playPodcast = async (item) => {
  await store.playPodcast(item);
  await store.refreshTextPlayer();
  await store.showPlayer();
};

onMounted(async () => {
  setTimeout(() => {
    isLoading.value = false;
  }, 1000);
});
</script>

<style lang="scss" scoped>
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
      // overflow: hidden;
      text-overflow: ellipsis;
      // white-space: nowrap;
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

.list {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.backBtn {
  background: none;

  img {
    width: 40px;
  }
}

.filter {
  margin-bottom: 10px;
  label span {
    font-weight: 400;
    color: #fd7307;
  }

  .underline {
    text-decoration: underline;
    color: #fd7307;
  }
}
</style>
