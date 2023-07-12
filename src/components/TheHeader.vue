<!-- <template>
  <header>
    <div class="header__content">
      <RouterLink to="/">
        <img src="@/assets/images/logo-no-bg.png" alt="" />
      </RouterLink>
    </div>
  </header>
</template>

<script setup></script>

<style lang="scss" scoped>
.header {
  height: 9%;
  background: red;
  &__content {
    height: 100%;
    padding: 10px;
    img {
      margin-left: 5px;
      height: 100%;
      width: auto;
    }
  }
}
</style> -->

<template>
  <ion-header>
    <div class="header__content">
      <RouterLink to="/" @click="test()">
        <img src="@/assets/images/logo-no-bg.png" alt="" />
      </RouterLink>
    </div>
  </ion-header>
</template>

<script setup>
import { IonHeader, IonToolbar, IonTitle } from "@ionic/vue";
import { usePlayerStore } from "@/store/radioPlayer";
const store = usePlayerStore();
const test = () => {
  if (store.getPlayerVisible) {
    store.showPlayer();
    store.hideFullPlayer();
  }
};
</script>

<style lang="scss" scoped>
ion-header {
  background: none;
}
ion-toolbar {
  height: 100%;
  background: none;
}
.header {
  height: 11%;
  // background: #f9f9f9;

  border-bottom: none;

  &__content {
    height: 100%;
    margin-left: 8%;

    a {
      height: 100%;
      width: fit-content;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    img {
      // margin-left: 5px;
      // height: 100%;
      // width: auto;
      width: 90px;
    }
  }

  &::after {
    display: none;
  }
}
</style>
