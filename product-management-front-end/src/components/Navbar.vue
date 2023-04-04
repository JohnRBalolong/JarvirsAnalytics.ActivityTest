<template>
  <div class="bg-gray-900 text-gray-100  px-6 shadow md:flex justify-between items-center ">
    <div class="flex items-center cursor-pointer">
  <router-link to="/">
    <span class="text-green-400 text-xl mr-1">
      <img src="../assets/logo/testLogo.jpg" class="mt-4 mx-14 h-12">
    </span>
  </router-link>
  <span @click="MenuOpen()" class="absolute md:hidden right-6 top-5 cursor-pointer text-4xl">
    <i :class="[open ? 'bi bi-x' : 'bi bi-filter-left']"></i>
  </span>
</div>

    <ul class="fixed w-full z-50 md:flex md:items-center md:justify-start md:px-0 px-20 md:pb-0 pb-10 md:static bg-gray-900 md:w-auto top-20 duration-700 ease-in" :class="[open ? 'left-0' : 'left-[100%]']">
      <li class="md:mx-4 md:my-0 my-6" v-for="(link, index) in Links" :key="index">
        <a v-if="!link.isRouterLink" :href="link.link" class="text-xl hover:text-green-400">{{link.name}}</a>
        <router-link v-else :to="link.link" class="text-xl hover:text-green-400">{{link.name}}</router-link>
      </li>
      <!-- <li class="md:mx-4 md:my-0 my-6">
  <router-link to="/products" class="text-xl hover:text-green-400">Products</router-link>
</li> -->
      <ProductButton>
        Goto Store 
      </ProductButton>
    </ul>
  </div>
</template>

  
  <script>
import { ref } from 'vue'
import ProductButton from './Button.vue'




export default {
  name: 'AppNavbar',
  components: {
    ProductButton,
  },
  setup() {
    let open = ref(false)
    let Links = [
  { name: 'Home', link: '/',  isRouterLink: false  },
  { name: 'Products', link: '/products', isRouterLink: false },
  { name: 'Sales', link: '#' },
  { name: 'Services', link: '#' },
  { name: 'Contacts', link: '#' },
]


    function MenuOpen() {
      open.value = !open.value
    }

    return { Links, open, MenuOpen }
  },
}
</script>

  
  

  
  