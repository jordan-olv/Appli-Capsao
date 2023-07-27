<template>
  <div class="slider-bloc">
    <div class="slider" @click="test()">
      <!-- <router-link :to="`/agenda/${sliderObj[idxSlider - 1].urlImg}`"> -->
      <div class="slider__control">
        <button @click.stop="" @click="changeSlide('moins')">
          <i class="arrow left"></i>
        </button>
        <button @click.stop="" @click="changeSlide('plus')">
          <i class="arrow right"></i>
        </button>
      </div>
      <div class="slider__container">
        <img
          v-if="sliderObj[idxSlider - 1]"
          :src="sliderObj[idxSlider - 1].urlImg"
          alt=""
          srcset=""
        />
      </div>
      <!-- </router-link> -->
    </div>
    <div class="slider__dot">
      <span
        v-for="(i, idx) in sliderObj"
        :class="{ active: idx + 1 === idxSlider }"
        :key="i"
      ></span>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeMount } from "vue";
import { fetchData } from "@/services/api";
import { useRouter } from "vue-router";

const router = useRouter();
const idxSlider = ref(1);
const sliderObj = ref({});

const fetchSlider = async () => {
  const res = await fetchData("https://latinoclub.fr/api/sliders");
  sliderObj.value = res;
};

let intSlider;
console.log(idxSlider.value);
const changeSlide = (state) => {
  clearInterval(intSlider);
  intSlider = setInterval(() => {
    changeSlide("plus");
  }, 10000);

  if (state == "plus") {
    idxSlider.value++;
    if (idxSlider.value > sliderObj.value.length) {
      idxSlider.value = 1;
    }
  } else if (state == "moins") {
    idxSlider.value--;
    if (idxSlider.value < 1) {
      idxSlider.value = sliderObj.value.length;
    }
  }
};

const test = () => {
  const id = sliderObj.value[idxSlider.value - 1].guid.split("-");
  console.warn(id[id.length - 1]);

  router.push("/agenda/" + id[id.length - 1]);
};

onBeforeMount(() => {
  fetchSlider();
});
</script>

<style lang="scss" scoped>
.slider-bloc {
  display: flex;
  justify-content: center;
  width: 100%;
  flex-direction: column;
  align-items: center;
}
.slider {
  position: relative;
  width: 82%;
  height: 40%;
  display: flex;
  align-items: center;
  flex-direction: column;

  &__container {
    height: 100%;
    width: 100%;
    overflow: hidden;
    display: flex;
    align-items: center;
    border-radius: 9px;

    // width: 100%;
    // flex-shrink: 0;
    // box-shadow: 0px 2px 1px 0px rgba(0, 0, 0, 0.2);
    // border-radius: 7px;
    // display: flex;
    // justify-content: center;
    // overflow: hidden;
    // height: 20%;
    // height: 165px;
    img {
      // width: 100%;
      // object-fit: cover;
      object-fit: fill;
      width: 100%;
      height: 180px;
      // max-height: 340px;
    }
  }

  &__dot {
    display: flex;
    gap: 4px;
    margin-top: 8px;

    span {
      width: 11px;
      height: 11px;
      border-radius: 50%;
      background: #d9d9d9;
      cursor: pointer;

      &.active {
        background: #a3a3a3;
      }
    }
  }
}
.slider__control {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-right: 10px;
  padding-left: 10px;
  position: absolute;
  width: 100%;
  height: 100%;

  button {
    background: rgba(255, 255, 255, 0.685);
    padding: 12px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    margin-top: 3px;
  }
}

.arrow {
  border: solid #303030;
  border-width: 0 4px 4px 0;
  display: inline-block;
  padding: 5px;
}

.right {
  transform: rotate(-45deg);
  -webkit-transform: rotate(-45deg);
}

.left {
  transform: rotate(135deg);
  -webkit-transform: rotate(135deg);
}

@media screen and (min-width: 460px) {
  .slider {
    height: 100%;
    img {
      // object-fit: cover;
      height: 300px;
    }
  }
}
@media screen and (min-width: 768px) {
  .slider {
    height: 300px;
  }
}
</style>
