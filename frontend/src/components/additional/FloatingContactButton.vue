<script setup>
import {onBeforeUnmount, onMounted, ref} from "vue";

const showButton = ref(false);

const handleScroll = () => {
  const contacts = document.getElementById("contacts");

  if(!contacts) {
    showButton.value = window.scrollY > 250;
  }
  const rect = contacts.getBoundingClientRect();
  const contactsVisible = rect.top <= window.innerHeight - 50;
  showButton.value = window.scrollY > 250 && !contactsVisible;
}

const scrollToContacts = () => {
  document.getElementById('contacts').scrollIntoView({
    behavior: 'smooth',
  })
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll);
  handleScroll();
})
onBeforeUnmount(() => {
  window.removeEventListener('scroll', handleScroll);
})
</script>

<template>
  <Transition name="fade-button">
    <button class="contact_button" @click="scrollToContacts" v-if="showButton">Показать контакты</button>
  </Transition>
</template>

<style scoped>
.contact_button{
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
.contact_button:hover{
  background: var(--text);
  color: var(--background);
}
.fade-button-enter-active,
.fade-button-leave-active {
  transition: all .3s ease;
}

.fade-button-enter-from,
.fade-button-leave-to {
  opacity: 0;
  transform: translateY(-15px);
}
@media (max-width:768px){

  .contact_button{

    padding:12px 18px;


    backdrop-filter:blur(10px);

    background:rgba(15,15,15,.8);

    font-size:14px;

    box-shadow:0 8px 24px rgba(0,0,0,.35);
  }

}
</style>