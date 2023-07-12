<template>
  <div></div>
</template>

<script setup>
import { ref, onMounted, reactive } from "vue";
import { fetchData, fetchRss } from "@/services/api.js";
import axios from "axios";
import { useRouter } from "vue-router";

const router = useRouter();
// console.log(router.listening);
console.log(router.currentRoute.value.params);
</script>

<style lang="scss" scoped></style>
