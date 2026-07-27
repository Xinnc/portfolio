<script setup>
import {ref, watch} from "vue";
const emit = defineEmits(['close'])
const props = defineProps({
  images: Array,
  currentIndex: Number,
  isOpen: Boolean
})

const current = ref(0)

watch(
    () => props.currentIndex,
    value => {
      current.value = value
    }
)
const next = () => {
  current.value =
      (current.value + 1) % props.images.length
}

const prev = () => {
  current.value =
      (current.value - 1 + props.images.length) % props.images.length
}
</script>

<template>
<Transition name="fade">
  <div v-if="isOpen" class="modal_overlay" @click.self="emit('close')">
    <div class="modal_content">
      <button class="close" @click="emit('close')">✕</button>
      <img class="modal_image" :src="images[current].url" alt="image"/>
      <div class="navigation">
        <button class="arrow" @click="prev">‹</button>
        <div class="counter">
          {{ current + 1 }} / {{ images.length }}
        </div>
        <button class="arrow" @click="next">›</button>
      </div>
    </div>
  </div>
</Transition>
</template>

<style scoped>
.navigation{
  display:flex;

  align-items:center;

  justify-content:center;

  gap:25px;

  width:100%;
}
.counter{
  position:static;

  transform:none;

  background:none;

  border:none;

  padding:0;

  letter-spacing:1px;

  color:#bbb;
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