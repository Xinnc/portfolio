<script setup>
const props = defineProps({
  isOpen: {type: Boolean, default: false},
  title: {type: String, default: 'Подтверждение'},
  text: {type: String, default: 'Вы уверены?'},
  confirmText: {type: String, default: 'Удалить'},
  cancelText: {type: String, default: 'Отмена'},
})

const emit = defineEmits([
    'close',
    'confirm',
])
</script>

<template>
  <Transition name="fade">
    <div v-if="isOpen" class="modal-overlay" @click.self="emit('close')">
      <div class="modal">
        <h2> {{ title }} </h2>
        <p> {{ text }} </p>
        <div class="modal-actions">
          <button class="cancel" @click="emit('close')"> {{ cancelText }} </button>
          <button class="danger" @click="emit('confirm')"> {{ confirmText }} </button>
        </div>
      </div>
    </div>
  </Transition>
</template>

<style scoped>
.modal-overlay{
  position:fixed;
  inset:0;

  display:flex;
  justify-content:center;
  align-items:center;

  background:rgba(0,0,0,.75);
  backdrop-filter:blur(4px);

  z-index:9999;
}

.modal{
  width:450px;
  max-width:calc(100% - 40px);

  background:#111;
  border:1px solid #2a2a2a;
  border-radius:10px;

  padding:30px;
}

.modal h2{
  margin-bottom:18px;

  font-size:28px;
  font-weight:400;
}

.modal p{
  color:#9d9d9d;
  line-height:1.6;
}

.modal-actions{
  display:flex;
  justify-content:flex-end;
  gap:14px;

  margin-top:35px;
}

.modal-actions button{

  padding:12px 22px;

  border-radius:8px;
  border:1px solid #333;

  background:transparent;

  cursor:pointer;

  transition:
      background .25s,
      border-color .25s,
      color .25s,
      transform .2s;
}

.modal-actions button:hover{
  transform:translateY(-2px);
}

.cancel:hover{
  background:#2b2b2b;
}
button {
  color: white;
}
.danger:hover{
  background:#7f1d1d;
  border-color:#dc2626;
  color:white;
}

.fade-enter-active,
.fade-leave-active{
  transition:opacity .25s;
}

.fade-enter-from,
.fade-leave-to{
  opacity:0;
}

@media (max-width:600px){

  .modal{
    padding:22px;
  }

  .modal-actions{
    flex-direction:column-reverse;
  }

  .modal-actions button{
    width:100%;
  }

}
</style>