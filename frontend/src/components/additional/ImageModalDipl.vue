<script setup>
const emit = defineEmits(['close'])
const props = defineProps({
  image: String,
  isOpen: Boolean
})
</script>

<template>
<Transition name="fade">
  <div v-if="isOpen" class="modal_overlay" @click.self="emit('close')">
    <div class="modal_content">
      <button class="close" @click="emit('close')">✕</button>
      <img class="modal_image" :src="image" alt="сертификат"/>
    </div>
  </div>
</Transition>
</template>

<style scoped>
.modal_overlay {
  position: fixed;
  inset: 0;
  background:rgba(0,0,0,.92);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 999;
  animation: fade .25s ease;
}

.modal_content{
  position:relative;

  display:flex;
  flex-direction:column;

  align-items:center;

  gap:20px;

  padding:20px;

  max-width:95vw;
  max-height:95vh;
}

.modal_image {
  display: block;
  max-width: 80vw;
  max-height: 80vh;
  object-fit: contain;
  user-select: none;
}

.close {

  align-self:flex-end;

  width:42px;
  height:42px;

  background: transparent;
  border: 1px solid var(--border);

  color: var(--text);
  font-size: 18px;

  cursor: pointer;
  transition: .25s;
}

.close:hover {
  background: var(--text);
  color: var(--background);
}

@media (max-width:700px){

  .modal_content{
    flex-direction:column;
    justify-content:center;
    gap:20px;
    padding:20px;
  }

  .modal_image{
    max-width:100%;
    max-height:70vh;
  }

  .close{
    position:static;

    order:-1;

    align-self:flex-end;

    margin-bottom:10px;
  }
}
</style>