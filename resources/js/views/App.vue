<template>
   <main>
       <transition mode="out-in">
           <router-view></router-view>
       </transition>
   </main>
</template>

<script>
    export default {
        mounted() {
            console.log("Component mounted.")
        }
    }
</script>
