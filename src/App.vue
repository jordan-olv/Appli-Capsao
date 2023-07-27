<template>
  <ion-app>
    <the-header class="header"></the-header>
    <Loading v-if="isLoading" />
    <ion-content :class="{ hiddenSection: isLoading }" class="content">
      <ion-router-outlet> </ion-router-outlet>
      <ThePlayer />
    </ion-content>
  </ion-app>
</template>

<script setup>
import { IonApp, IonRouterOutlet, IonContent } from "@ionic/vue";
import TheHeader from "./components/TheHeader.vue";
import ThePlayer from "@/components/ThePlayer.vue";
import { ref, onMounted } from "vue";
import Loading from "@/components/Loading.vue";

const isLoading = ref(true);

onMounted(() => {
  setTimeout(() => {
    isLoading.value = false;
  }, 1000);
});
// import { BackgroundMode } from "@awesome-cordova-plugins/background-mode";
// BackgroundMode.enable();

screen.orientation.lock("portrait");
</script>

<style lang="scss">
.hiddenSection {
  display: none;
}
</style>
