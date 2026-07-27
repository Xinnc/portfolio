<script setup>

import {useProjects} from "@/composables/useProjects.js";
import {ref} from "vue";

const props = defineProps({
  isOpen: Boolean,
  project: {
    type: Object,
    default: null,
  },
  category: {
    type: Object,
    default: null,
  }
})

const emit = defineEmits([
    'close',
    'saved'
])

const { projectItems, categoryTitle, loading, fetchProjects, submitting, submitError, adminCreateProjects, adminUpdateProjects, adminDeleteCategories, adminAddMedia, adminDeleteMedia} = useProjects()


const form = ref({
  title: '',
  description: '',
  project_date: '',
})

const save = async () => {
  const data = new FormData()

  data.append('title', form.value.title)
  data.append('description', form.value.description)
  data.append('project_date', form.value.project_date)

  if (props.project) {
    await adminUpdateProjects(props.project.id, data)
  } else {
    await adminCreateProjects(props.category.id, data)
  }
  if(Object.keys(submitError.value).length) {
    return
  }
  emit('saved')
  emit('close')
}

</script>

<template>
  <Transition name="fade">
    <div v-if="isOpen" class="modal-overlay" @click.self="$emit('close')">
      <div class="modal">

        <div class="modal-header">
          <h2>{{ project ? 'Редактирование проекта' : 'Создание проекта' }}</h2>
          <button class="close" @click="$emit('close')">✕</button>
        </div>

        <div class="modal-body">

          <div class="input-group">
            <label>Название проекта</label>
            <input v-model="form.title" placeholder="Введите название">
          </div>

          <div class="input-group">
            <label>Описание</label>
            <textarea v-model="form.description" rows="5" placeholder="Описание проекта"/>
          </div>

          <div class="input-group">
            <label>Дата проекта</label>
            <input type="date" v-model="form.project_date">
          </div>

          <div v-if="Object.keys(submitError).length" class="error">
            <div v-for="(messages, field) in submitError" :key="field">
              <div v-for="message in messages" :key="message">
                {{ message }}
              </div>
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button class="cancel" @click="$emit('close')">Отмена</button>
          <button class="save" @click="save" :disabled="submitting">{{ submitting ? 'Сохранение...' : 'Сохранить' }}</button>
        </div>
      </div>
    </div>
  </Transition>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active{
  transition:.25s;
}

.fade-enter-from,
.fade-leave-to{
  opacity:0;
}

.modal-overlay{
  position:fixed;
  inset:0;

  display:flex;
  justify-content:center;
  align-items:center;

  background:rgba(0,0,0,.75);
  backdrop-filter:blur(5px);

  z-index:999;
}

.modal{
  width:min(700px,95vw);

  background:#111;

  border:1px solid #2a2a2a;

  border-radius:12px;

  overflow:hidden;

  box-shadow:0 20px 60px rgba(0,0,0,.45);
}

.modal-header{
  display:flex;
  justify-content:space-between;
  align-items:center;

  padding:22px 28px;

  border-bottom:1px solid #222;
}

.modal-header h2{
  font-size:26px;
  font-weight:300;
}

.close{
  background:transparent;
  border:none;

  color:#888;

  font-size:24px;

  cursor:pointer;

  transition:.2s;
}

.close:hover{
  color:white;
}

.modal-body{
  padding:30px;

  display:flex;
  flex-direction:column;
  gap:22px;
}

.input-group{
  display:flex;
  flex-direction:column;
  gap:8px;
}

.input-group label{
  color:#bdbdbd;
  font-size:14px;
}

.input-group input,
.input-group textarea{
  width:100%;

  background:#0d0d0d;

  color:#fff;

  border:1px solid #333;

  border-radius:8px;

  padding:14px 16px;

  font-size:15px;

  transition:.25s;
}

.input-group textarea{
  resize:vertical;
}

.input-group input:focus,
.input-group textarea:focus{
  outline:none;
  border-color:#666;
}

.modal-footer{
  display:flex;
  justify-content:flex-end;
  gap:14px;

  padding:24px 30px;

  border-top:1px solid #222;
}

.modal-footer button{
  padding:12px 22px;

  border-radius:8px;

  cursor:pointer;

  border:1px solid #333;

  background:transparent;

  color:#ddd;

  transition:.25s;
}

.cancel:hover{
  background:#252525;
}

.save:hover{
  background:#14532d;
  border-color:#16a34a;
  color:white;
}

.error {

  padding: 12px;

  background: #4b1c1c;

  border: 1px solid #a31616;

  border-radius: 8px;

  color: #ffbdbd;
}

@media(max-width:700px){

  .modal{
    width:95%;
  }

  .modal-header{
    padding:18px;
  }

  .modal-body{
    padding:18px;
  }

  .modal-footer{
    padding:18px;
    flex-direction:column;
  }

  .modal-footer button{
    width:100%;
  }

}
</style>