<template>
  <div class="loading-screen">
    <!-- <ion-spinner /> -->
    <div class="lds-ring">
      <div></div>
      <div></div>
      <div></div>
      <div></div>
    </div>
  </div>
</template>

<script setup>
// Si vous avez besoin d'importer des dépendances dans le composant, vous pouvez les ajouter ici
// par exemple : import { ref } from "vue";
</script>

<style scoped>
.loading-screen {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: #f9f9f9;
  display: flex;
  justify-content: center;
  animation: fadeOut 2s ease-in-out;
  align-items: center;
  z-index: 999;
}

ion-spinner {
  color: #fd7307;
  width: 45px;
  height: 45px;
}

.lds-ring {
  display: inline-block;
  position: relative;
  width: 50px;
  height: 50px;
}
.lds-ring div {
  box-sizing: border-box;
  display: block;
  position: absolute;
  width: 45px;
  height: 45px;
  margin: 8px;
  border: 6px solid #fd7307;
  border-radius: 50%;
  animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
  border-color: #fd7307 transparent transparent transparent;
}
.lds-ring div:nth-child(1) {
  animation-delay: -0.45s;
}
.lds-ring div:nth-child(2) {
  animation-delay: -0.3s;
}
.lds-ring div:nth-child(3) {
  animation-delay: -0.15s;
}
@keyframes lds-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

@keyframes fadeOut {
  0% {
    opacity: 1;
  }
  100% {
    opacity: 0;
  }
}
</style>
