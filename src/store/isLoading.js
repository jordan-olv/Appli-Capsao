import { defineStore } from "pinia";
import { reactive, ref } from "vue";

export const useLoaderState = defineStore("isLoading", () => {

  const state = ref(false)

  const changeStateTrue = () => {
    state.value = true
    console.log('yes')
  }

  const changeStateFalse = () => {
    state.value = false
  }

  return { state, changeStateTrue, changeStateFalse }
})