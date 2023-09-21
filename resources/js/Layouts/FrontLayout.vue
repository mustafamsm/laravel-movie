<template>
    <div>
      <Head :title="title" />
  
      
  
      <div class="min-h-screen bg-gray-100 dark:bg-gray-700">
        <!-- nav -->
        <Navbar ></Navbar>
        <!-- Page Content -->
        <main>
          <slot></slot>
        </main>
      </div>
      <Footer ></Footer    >
    </div>
  </template>
  
  <script>
  import { defineComponent } from "vue";
  import { Head, Link } from "@inertiajs/vue3";
 import Navbar from "@/components/Navbar.vue";
  import Footer from "@/components/Footer.vue";
  
  export default defineComponent({
    props: {
      title: String,
    },
  
    components: {
      Head,
      Link,
      Navbar,
      Footer,
    },
  });
  </script>
  