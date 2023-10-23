<template>
  <ion-page>
    <Loading v-if="isLoading" />
    <section class="agenda">
      <div class="content-view">
        <ul v-for="dateEvent in agendaObject">
          <div class="date_title">
            <h2>{{ dateEvent[0].name }}</h2>
          </div>
          <li
            v-for="item in dateEvent"
            :key="item.guid[0]"
            @click="navigateTo(item)"
          >
            <img :src="item.enclosure[0].$['url']" alt="" />
            <div class="li__text">
              <h3>{{ decode(item.title[0]) }}</h3>

              <p class="text-content">
                {{ decode(item.description[0]) }}
              </p>
            </div>
          </li>
        </ul>
      </div>
      <!-- <the-player /> -->
    </section>
  </ion-page>
</template>

<script setup>
import { IonPage, IonContent } from "@ionic/vue";
import axios from "axios";
import { ref, onMounted, onBeforeMount } from "vue";
import { parseString } from "xml2js";
import { useRouter } from "vue-router";
import Loading from "@/components/Loading.vue";
import { decode } from "html-entities";

const agendaObject = ref({});
const isLoading = ref(true);
const router = useRouter();

onBeforeMount(async () => {
  try {
    const res = await axios.get(`https://latinoclub.fr/api/event`);

    // console.log('test', res)
    if (res.status !== 200) {
      throw new Error("Problem getting text");
    }

    const data = res.data;

    console.log("data", data);
    if (data.fileContent) {
      parseString(data.fileContent, (err, result) => {
        if (err) {
          console.error(err);
        } else {
          result.rss.channel[0].item.forEach((item) => {
            const itemDate = item["content:encoded"][0].split("<br");

            if (agendaObject.value.hasOwnProperty(itemDate[0])) {
              item.name = itemDate[0];
              agendaObject.value[itemDate[0]].push(item);
            } else {
              item.name = itemDate[0];
              agendaObject.value[itemDate[0]] = [item];
            }
          });
          console.log("dd", agendaObject.value);
        }
      });
    }
  } catch (err) {
    console.error(err);
  }
});

const navigateTo = (item) => {
  console.log("item", item);
  const id = item.guid[0].split("-");
  router.push("/agenda/" + id[id.length - 1]);
};

onMounted(async () => {
  setTimeout(() => {
    isLoading.value = false;
  }, 1000);
});
</script>

<style lang="scss" scoped>
section {
  align-items: flex-start;
}

.content-view {
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 20px;
  padding-top: 20px;
}
div.date_title {
  display: flex;
  justify-content: center;
  align-items: center;
  align-self: flex-start;
  padding: 10px;
  border-radius: 0px 7px 7px 0px;
  background: linear-gradient(180deg, #fd7307 0%, #d61f1f 175%);
  min-width: 50%;
  min-height: 43px;
  flex-shrink: 0;

  h2 {
    color: #fff;
    font-family: Inter;
    font-size: 18px;
    white-space: nowrap;
  }
}

ul {
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 15px;
  li {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
    border-radius: 7px;
    background: #ebebeb;
    box-shadow: 0px 2px 1px 0px rgba(0, 0, 0, 0.2);
    width: 80%;
    max-width: 450px;
    padding: 15px;
    overflow: hidden;
    color: #303030;
    font-family: Inter;

    img {
      width: 100%;
      max-width: 430px;
      border-radius: 7px;
    }

    .li__text {
      width: 100%;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      gap: 5px;
    }

    h3 {
      font-size: 20px;
      font-weight: 700;
    }

    p {
      font-size: 16px;
      font-weight: 400;
      display: -webkit-box;
      width: 100%;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      text-overflow: ellipsis;
      overflow: hidden;
    }
  }
}
</style>
