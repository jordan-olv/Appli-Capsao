<template>
  <ion-page>
    <section class="podcast">
      <div class="content-view">
        <div class="list">
          <h2>Nos Podcasts</h2>
          <ul>
            <li v-for="item in episodes" @click="navigateTo(item)">
              <!-- <router-link class="li_content" to=""> -->
              <!-- <div class="li__content"> -->
              <img :src="item['itunes:image'][0].$['href']" alt="" />
              <!-- </div> -->
              <h3>{{ item.title[0] }}</h3>
              <div class="btn_pod">
                <button>Play</button>
                <button @click="shareLink(item)">Share</button>
              </div>
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
import {
  IonContent,
  IonHeader,
  IonPage,
  IonTitle,
  IonToolbar,
} from "@ionic/vue";
import { ref, onMounted, reactive } from "vue";
import ThePlayer from "@/components/ThePlayer.vue";
import { fetchData, fetchRss } from "@/services/api.js";
import axios from "axios";
import { Share } from "@capacitor/share";
import { useRouter } from "vue-router";

const router = useRouter();

const podcasts = ref([]);

const shareLink = async (pod) => {
  // Share url only
  await Share.share({
    url: "http://ionicframework.com/",
  });
};

const navigateTo = (item) => {
  console.log("item", item);
  router.push({ name: "PodcastId", state: { id: "dd" } });
};

const episodes = reactive([]);
onMounted(async () => {
  // podcasts.value = await fetchData("api_podcasts");
  // console.log("aa", podcasts.value);

  // podcasts.value.forEach(async (podcast) => {
  //   console.log("podcast", podcast);
  //   const ep = await fetchRss(podcast.link);
  //   episodes.push(ep);

  //   console.log("episodes", episodes[0]);
  // });

  //test sans api
  episodes.push(
    {
      title: ["test"],
      "itunes:image": [
        {
          $: {
            href: "https://cdn.discordapp.com/attachments/685655650923053122/1123923007841239141/645b87197da629.01633555_1.png",
          },
        },
      ],
    },
    {
      title: ["test2 qsdf df dsf df sfd d"],
      "itunes:image": [
        {
          $: {
            href: "https://cdn.discordapp.com/attachments/685655650923053122/1123923008214536192/6479b5bf497704.61379988_1.png",
          },
        },
      ],
    },
    {
      title: ["test3"],
      "itunes:image": [
        {
          $: {
            href: "https://cdn.discordapp.com/attachments/685655650923053122/1107055380233724034/image.png",
          },
        },
      ],
    }
  );
});

// const xmlObject = fetchRss("apo_podcasts");
// console.log(xmlObject);
</script>

<style lang="scss" scoped>
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
    justify-content: center;
    position: relative;
    min-width: 145px;
    width: 90%;
    flex-grow: 1;
    border-radius: 7px;

    h3 {
      max-width: 165px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    img {
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

.li_content {
  .btn_pod {
    position: absolute;
    top: 5px;
    right: 0;
    display: flex;
    flex-direction: column;
    gap: 5px;

    > * {
      border-radius: 100%;
      aspect-ratio: 1/1;
      width: 40px;
      background: red;
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
</style>
