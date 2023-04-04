<template>
  <div class="bg-green-200 h-screen">
   <AppNavbar /> <!-- Use renamed component -->

   <div class="flex-1 p-4">
      <router-view />
    </div>
  

  </div>







</template>
<script>

import AppNavbar from './components/Navbar.vue';



export default {
  name: 'App',
  components: {
    AppNavbar,
  },
 
};
</script>

