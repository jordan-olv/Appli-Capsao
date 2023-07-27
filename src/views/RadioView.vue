<template>
  <ion-page>
    <!-- <Loading v-if="isLoading" /> -->
    <section class="radio">
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
import Loading from "@/components/Loading.vue";
import { ref, onMounted } from "vue";

const isLoading = ref(true);

// onMounted(async () => {
//   setTimeout(() => {
//     isLoading.value = false;
//   }, 1000);
// });
</script>

<style lang="scss" scoped></style>
