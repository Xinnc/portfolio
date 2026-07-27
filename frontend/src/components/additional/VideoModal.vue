<script setup>
import {watch} from "vue";

const emit = defineEmits(['close'])
const props = defineProps({
  video: {
    type: Object,
    default: null,
  },
  isOpen: Boolean
})
</script>

<template>
<Transition name="fade">
  <div v-if="isOpen" class="modal_overlay" @click.self="emit('close')">
    <div class="modal_content">
      <button class="close" @click="emit('close')">✕</button>
      <video controls autoplay playsinline preload="metadata" :src="video.url" controlsList="nodownload" class="modal_video"/>
    </div>
  </div>
</Transition>
</template>

<style scoped>
.modal_video{
  max-width:90vw;
  max-height:90vh;

  width:auto;
  height:auto;

  object-fit:contain;
}
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
  justify-content:center;
  align-items:center;

  gap:20px;

  padding:20px;

  max-width:95vw;
  max-height:95vh;
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

.arrow {
  width: 48px;
  height: 48px;

  border: 1px solid var(--border);
  background: transparent;

  color: var(--text);
  font-size: 26px;

  cursor: pointer;
  transition: .25s;

  display: flex;
  justify-content: center;
  align-items: center;
}

.arrow:hover {
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

  /* крестик над изображением */

  .close{
    position:static;

    order:-1;

    align-self:flex-end;

    margin-bottom:10px;
  }

  /* убираем абсолютное позиционирование счетчика */



  /* стрелки становятся рядом со счетчиком */

  .arrow{
    position:static;

    transform:none;

    width:44px;
    height:44px;

    font-size:24px;

    flex-shrink:0;
  }

  /* нижняя панель */



}
</style>