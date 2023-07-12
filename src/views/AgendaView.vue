<template>
  <ion-page>
    <section class="agenda" @scroll="handleScroll">
      <div class="content-view">
        <h2 class="date_title">Lundi 19 Juin</h2>
        <ul>
          <!-- <li v-for="item in xmlObject.item" :key="item.guid[0]">
            <h3>{{ item.title }}</h3>
            <p>{{ item.description }}</p>
            <a :href="item.link">{{ item.link }}</a>
          </li> -->
          <li>
            <img
              src="https://cdn.discordapp.com/attachments/685655650923053122/997195123068780684/player1.png"
              alt=""
            />
            <div class="li__text">
              <h3>Titre</h3>

              <p class="text-content">
                Votre texte ici. kljnkl konj ko nkk nko iojiojoi iojiojj oij oij
                oi joi jio oi j iojo i
                jijjjjjjjjjjjjjjjjjjjjjjijiiiiiiiiiiiiiiiiii
                jjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjj..v=
                jk,,dfkvokjv ojfiofj jiovj ijfoivj jiojil
              </p>
            </div>
          </li>
          <li>
            <img
              src="https://cdn.discordapp.com/attachments/685655650923053122/997195123068780684/player1.png"
              alt=""
            />
            <div class="li__text">
              <h3>Titre</h3>

              <p class="text-content">
                Votre texte ici. kljnkl konj ko nkk nko iojiojoi iojiojj oij oij
                oi joi jio oi j iojo i
                jijjjjjjjjjjjjjjjjjjjjjjijiiiiiiiiiiiiiiiiii
                jjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjj..v=
                jk,,dfkvokjv ojfiofj jiovj ijfoivj jiojil
              </p>
            </div>
          </li>
        </ul>
        <h2 class="date_title">Mercredi 21 Juin</h2>
        <ul>
          <!-- <li v-for="item in xmlObject.item" :key="item.guid[0]">
            <h3>{{ item.title }}</h3>
            <p>{{ item.description }}</p>
            <a :href="item.link">{{ item.link }}</a>
          </li> -->
          <li>
            <img
              src="https://cdn.discordapp.com/attachments/685655650923053122/997195123068780684/player1.png"
              alt=""
            />
            <div class="li__text">
              <h3>Titre</h3>

              <p class="text-content">
                Votre texte ici. kljnkl konj ko nkk nko iojiojoi iojiojj oij oij
                oi joi jio oi j iojo i
                jijjjjjjjjjjjjjjjjjjjjjjijiiiiiiiiiiiiiiiiii
                jjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjj..v=
                jk,,dfkvokjv ojfiofj jiovj ijfoivj jiojil
              </p>
            </div>
          </li>
          <li>
            <img
              src="https://cdn.discordapp.com/attachments/685655650923053122/997195123068780684/player1.png"
              alt=""
            />
            <div class="li__text">
              <h3>Titre</h3>

              <p class="text-content">
                Votre texte ici. kljnkl konj ko nkk nko iojiojoi iojiojj oij oij
                oi joi jio oi j iojo i
                jijjjjjjjjjjjjjjjjjjjjjjijiiiiiiiiiiiiiiiiii
                jjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjj..v=
                jk,,dfkvokjv ojfiofj jiovj ijfoivj jiojil
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
import { ref, onMounted } from "vue";
import { parseString } from "xml2js";
import { usePlayerStore } from "@/store/radioPlayer";
import ThePlayer from "@/components/ThePlayer.vue";
import { fetchData } from "@/services/api";

const store = usePlayerStore();
const handleScroll = () => {
  console.log("in in");
  // Tu peux également effectuer d'autres actions lorsque le scroll commence
};

// const xmlObject = ref({ item: [] });
// onMounted(async () => {
//   try {
//     const response = await axios.get("https://capsao.com/rss-feed-34");
//     // console.log(response.data.fileContent);

//     parseString(response.data.fileContent, (err, result) => {
//       if (err) {
//         console.error(err);
//       } else {
//         xmlObject.value = result.rss.channel[0];
//       }
//     });
//   } catch (error) {
//     console.error(error);
//   }
//   console.log(xmlObject.value);
// });
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
h2.date_title {
  display: flex;
  justify-content: center;
  align-items: center;
  align-self: flex-start;
  color: #fff;
  font-family: Inter;
  font-size: 18px;
  border-radius: 0px 7px 7px 0px;
  background: var(
    --capsao-short,
    linear-gradient(180deg, #fd7307 0%, #d61f1f 100%)
  );
  width: 50%;
  height: 43px;
  flex-shrink: 0;
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
    gap: 20px;
    border-radius: 7px;
    background: #ebebeb;
    box-shadow: 0px 2px 1px 0px rgba(0, 0, 0, 0.2);
    width: 80%;
    padding: 15px;
    overflow: hidden;
    color: #303030;
    font-family: Inter;

    .li__text {
      width: 100%;
      overflow: hidden;
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

    img {
      width: 120px;
    }
  }
}
</style>
