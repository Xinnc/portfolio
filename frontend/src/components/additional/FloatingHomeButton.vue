<script setup>

</script>

<template>
  <router-link class="home_button" to="/">На главную</router-link>
</template>

<style scoped>
.home_button{
  position: fixed;
  top: 30px;
  right: 30px;
  z-index: 99;

  padding: 10px 15px;
  background: transparent;
  border: 1px solid var(--border);
  color: var(--text);
  cursor: pointer;
  transition: background-color .3s ease,
  color .3s ease,
  border-color .3s ease,
  transform .2s ease;
}
.home_button:hover{
  background: var(--text);
  color: var(--background);
}
@media (max-width: 768px) {
  .home_button {
    top: 20px;
    right: 20px;
    padding: 8px 12px;
    font-size: 13px;
  }
}

@media (max-width: 500px) {
  .home_button {
    top: 15px;
    right: 15px;
    padding: 6px 10px;
    font-size: 12px;
  }
}
</style>