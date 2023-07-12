<template>
  <div class="slider-bloc">
    <div class="slider">
      <div class="slider__control">
        <button @click="changeSlide('moins')">
          <i class="arrow left"></i>
        </button>
        <button @click="changeSlide('plus')">
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
import { ref, onMounted } from "vue";
import { fetchData } from "@/services/api";

const idxSlider = ref(1);
const sliderObj = ref({});

fetchData(
  "https://sc1ihlu1696.universe.wf/Appli-Capsao/public/api/sliders"
).then((res) => {
  console.log(res);
  sliderObj.value = res;
});

const imgSlider = ref([
  "https://cdn.discordapp.com/attachments/685655650923053122/1123923008214536192/6479b5bf497704.61379988_1.png",
  "https://cdn.discordapp.com/attachments/685655650923053122/1123923007841239141/645b87197da629.01633555_1.png",
]);

let intSlider;
console.log(idxSlider.value);
const changeSlide = (state) => {
  console.log("in");

  console.log(idxSlider.value);
  clearInterval(intSlider);

  intSlider = setInterval(() => {
    changeSlide("plus");
  }, 10000);

  if (state == "plus") {
    idxSlider.value++;
    if (idxSlider.value > imgSlider.value.length) {
      idxSlider.value = 1;
    }
  } else if (state == "moins") {
    idxSlider.value--;
    if (idxSlider.value < 1) {
      idxSlider.value = imgSlider.value.length;
    }
  }
};
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
  height: 160px;
  display: flex;
  align-items: center;
  flex-direction: column;

  &__container {
    height: 100%;
    width: 100%;
    overflow: hidden;
    border-radius: 9px;
    img {
      border-radius: 9px;
      width: 100%;
      object-fit: cover;
      overflow: hidden;
    }
  }

  &__dot {
    display: flex;
    gap: 4px;
    margin-top: 5px;

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
    padding: 10px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
  }
}

.arrow {
  border: solid black;
  border-width: 0 3px 3px 0;
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
    height: 230px;
  }
}
@media screen and (min-width: 768px) {
  .slider {
    height: 300px;
  }
}
</style>
