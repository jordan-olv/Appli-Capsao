<template>
  <ion-page>
    <!-- <Loading v-if="isLoading" /> -->
    <section class="agenda">
      <div class="content-view">
        <div class="backBtnSolo">
          <button
            @click="
              () => {
                router.back();
              }
            "
          >
            <img src="@/assets/icon/back.png" alt="" />
          </button>
        </div>
        <div class="agenda__item">
          <img :src="agendaImg" alt="" />
          <h3 class="titleBig">{{ agendaTitle }}</h3>
          <div class="agenda__item--date">
            <h3 class="titleDate">Date:</h3>
            <div>
              <img width="25" src="@/assets/icon/calendar.png" alt="" />
              <p v-html="agendaDate"></p>
              <!-- <p v-html="agendaDate2"></p> -->
            </div>
          </div>

          <div class="agenda__item--desc" v-html="agendaDesc"></div>
        </div>
      </div>
    </section>
  </ion-page>
</template>

<script setup>
import { ref, onBeforeMount, onMounted } from "vue";
import axios from "axios";
import { parseString } from "xml2js";
import { useRouter } from "vue-router";
import { IonPage } from "@ionic/vue";
import Loading from "@/components/Loading.vue";
import { decode } from "html-entities";

const isLoading = ref(true);
const router = useRouter();
const agendaItem = ref(null);

const agendaTitle = ref("");
const agendaImg = ref("");
const agendaDesc = ref("");
const agendaDate = ref("");

onBeforeMount(async () => {
  try {
    const res = await axios.get(`https://latinoclub.fr/api/event`);

    if (res.status !== 200) {
      throw new Error("Problem getting text");
    }

    const data = res.data;
    if (data.fileContent) {
      parseString(data.fileContent, (err, result) => {
        if (err) {
          console.error(err);
        } else {
          result.rss.channel[0].item.forEach((item) => {
            const itemId = item.guid[0].split("-");
            if (
              itemId[itemId.length - 1] == router.currentRoute.value.params.id
            ) {
              agendaItem.value = item;
              agendaTitle.value = decode(agendaItem.value.title[0]);
              agendaImg.value = agendaItem.value.enclosure[0].$.url;

              const itemAg =
                agendaItem.value["content:encoded"][0].split("<br>");
              agendaDate.value = itemAg[0].split("<br/>")[0];
              itemAg.splice(0, 1);
              agendaDesc.value = itemAg.join("");
            }
          });
        }
      });
    }
  } catch (err) {
    console.error(err);
    router.push("/");
  }
});

onMounted(async () => {
  setTimeout(() => {
    isLoading.value = false;
  }, 1000);
});
</script>

<style lang="scss" scoped>
.agenda__item {
  color: #303030;

  .titleDate {
    color: #303030;
    font-weight: 600;
    font-size: 22px;
  }

  &--desc {
    display: flex;
    flex-direction: column;
    gap: 10px;
    line-height: 22px;
  }
  &--date {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    margin: 20px 0;
    padding: 10px;
    border-radius: 7px;
    background: red;
    background: #ebebeb;
    box-shadow: 0px 2px 1px 0px rgba(0, 0, 0, 0.2);

    div {
      display: flex;
      gap: 10px;
      align-self: flex-start;
      align-items: center;
      margin-left: 5px;
      color: #303030;

      p {
        font-size: 17px;
      }
    }
  }
  img {
    border-radius: 7px;
  }
  h3.titleBig {
    margin-top: 10px;
    margin-bottom: 10px;
    font-size: 20px;
    font-weight: 600;
    color: #e76806;
  }
}
</style>
