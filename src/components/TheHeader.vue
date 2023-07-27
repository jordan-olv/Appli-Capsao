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
      <RouterLink to="/" @click="test()">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          x="0px"
          y="0px"
          width="50"
          height="50"
          viewBox="0 0 50 50"
        >
          <defs>
            <linearGradient id="grad1" x1="0%" y1="0%" x2="0%" y2="200%">
              <stop
                offset="0%"
                style="stop-color: rgb(253, 115, 7); stop-opacity: 1"
              />
              <stop
                offset="100%"
                style="stop-color: rgb(214, 31, 31); stop-opacity: 1"
              />
            </linearGradient>
          </defs>
          <path
            fill="url(#grad1)"
            d="M 25 1.0507812 C 24.7825 1.0507812 24.565859 1.1197656 24.380859 1.2597656 L 1.3808594 19.210938 C 0.95085938 19.550938 0.8709375 20.179141 1.2109375 20.619141 C 1.5509375 21.049141 2.1791406 21.129062 2.6191406 20.789062 L 4 19.710938 L 4 46 C 4 46.55 4.45 47 5 47 L 19 47 L 19 29 L 31 29 L 31 47 L 45 47 C 45.55 47 46 46.55 46 46 L 46 19.710938 L 47.380859 20.789062 C 47.570859 20.929063 47.78 21 48 21 C 48.3 21 48.589063 20.869141 48.789062 20.619141 C 49.129063 20.179141 49.049141 19.550938 48.619141 19.210938 L 25.619141 1.2597656 C 25.434141 1.1197656 25.2175 1.0507812 25 1.0507812 z M 35 5 L 35 6.0507812 L 41 10.730469 L 41 5 L 35 5 z"
          ></path>
        </svg>
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
    margin-left: 8.5%;
    margin-right: 8.5%;
    display: flex;
    justify-content: space-between;

    svg {
      width: 35px;
    }

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
      width: 100px;
    }
  }

  &::after {
    display: none;
  }
}
</style>
