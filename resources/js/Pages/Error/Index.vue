<template>
    <div>
      <h1>Error {{ page.props.status }}</h1>
      <p>{{ page.props.message }}</p>
    </div>
  </template>
<script setup>
import {usePage} from '@inertiajs/vue3';
const page = usePage();
</script>
