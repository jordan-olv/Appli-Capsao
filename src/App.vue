<template>
  <ion-app>
    <the-header class="header"></the-header>
    <ion-content class="content">
      <ion-router-outlet> </ion-router-outlet>
      <ThePlayer />
    </ion-content>
  </ion-app>
</template>

<script setup>
import { IonApp, IonRouterOutlet, IonContent } from "@ionic/vue";
import TheHeader from "./components/TheHeader.vue";
import ThePlayer from "@/components/ThePlayer.vue";
import { ref } from "vue";

// BackgroundMode.enable();
// screen.orientation.lock("portrait");
</script>

<style lang="scss"></style>
