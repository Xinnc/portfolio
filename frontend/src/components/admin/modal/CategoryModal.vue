<script setup>
import {ref, watch} from 'vue'
import {useCategories} from '@/composables/useCategories'

const props = defineProps({
  isOpen: Boolean,
  category: {
    type: Object,
    default: null
  }
})

const emit = defineEmits([
  'close',
  'saved'
])

const { submitting, submitError, adminCreateCategories, adminUpdateCategories} = useCategories();

const form = ref({
  title: '',
  description: '',
  slug: '',
  sort_order: '',
  cover_image: null
})

const coverPreview = ref(null)

const handleFile = (e) => {
  const file = e.target.files[0]
  console.log(file)
  if (!file) return

  form.value.cover_image = file

  if (coverPreview.value) {
    URL.revokeObjectURL(coverPreview.value)
  }

  coverPreview.value = URL.createObjectURL(file)
  console.log(coverPreview.value)
}

const save = async () => {

  const data = new FormData()

  data.append('title', form.value.title)
  data.append('description', form.value.description)
  data.append('slug', form.value.slug)
  data.append('sort_order', form.value.sort_order)

  if (form.value.cover_image) {
    data.append('cover_image', form.value.cover_image)
  }

  if (props.category) {
    await adminUpdateCategories(props.category.id, data)
  } else {
    await adminCreateCategories(data)
  }

  if(Object.keys(submitError.value).length) {
    return
  }

  resetForm()
  emit('saved')
  emit('close')
}

const resetForm = () => {
  form.value = {
    title: '',
    description: '',
    slug: '',
    sort_order: '',
    cover_image: null,
  }
  if(coverPreview.value?.startsWith('blob:')) {
    URL.revokeObjectURL(coverPreview.value)
  }
  coverPreview.value = null
}

const close = () => {
  resetForm()
  emit('close')
}

</script>

<template>
  <Transition name="fade">
    <div v-if="isOpen" class="modal" @click.self="close">
      <div class="modal_window">

        <div class="modal_header">
          <h2> {{ category ? 'Редактирование категории' : 'Создание категории' }} </h2>

          <button class="close" @click="close"> ✕</button>
        </div>

        <div class="modal_body">

          <div class="input-group">
            <label>Название</label>
            <input v-model="form.title" type="text">
          </div>

          <div class="input-group">
            <label>Описание</label>
            <textarea v-model="form.description" rows="4"/>
          </div>

          <div class="input-group">
            <label>Название в адресной строке</label>
            <input v-model="form.slug" type="text">
          </div>

          <div class="input-group">
            <label>Порядок</label>
            <input v-model="form.sort_order" type="number">
          </div>

          <div class="input-group">
            <label>Обложка</label>
            <label class="cover-upload">
              <input hidden type="file" accept="image/*" @change="handleFile" />
              <template v-if="coverPreview">
                <img :src="coverPreview" class="cover-preview" alt="preview">
              </template>
              <template v-else>
                <div class="cover-placeholder">
                  <span>Выберите обложку</span>
                </div>
              </template>
            </label>
          </div>

          <div v-if="Object.keys(submitError).length" class="error">
            <div v-for="(messages, field) in submitError" :key="field">
              <div v-for="message in messages" :key="message">
                {{ message }}
              </div>
            </div>
          </div>

        </div>

        <div class="modal_footer">

          <button class="cancel" @click="close"> Отмена</button>

          <button
              class="save"
              @click="save"
              :disabled="submitting">{{ submitting ? 'Сохранение...' : category ? 'Сохранить' : 'Создать' }}
          </button>

        </div>

      </div>
    </div>
  </Transition>
</template>

<style scoped>
.cover-upload{

  width:100%;
  height:220px;

  border:2px dashed #333;
  border-radius:10px;

  overflow:hidden;

  cursor:pointer;

  transition:.25s;

  display:flex;
  justify-content:center;
  align-items:center;

  background:#181818;
}

.cover-upload:hover{

  border-color:#666;
}

.cover-preview{

  width:100%;
  height:100%;

  object-fit:cover;
}

.cover-placeholder{

  display:flex;
  flex-direction:column;
  align-items:center;
  gap:10px;

  color:#777;
}

.cover-placeholder span{

  font-size:15px;
}
.fade-enter-active,
.fade-leave-active {
  transition: .25s;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.modal {
  position: fixed;
  inset: 0;

  background: rgba(0, 0, 0, .75);

  display: flex;
  justify-content: center;
  align-items: center;

  z-index: 1000;

  padding: 20px;
}

.modal_window {
  width: 100%;
  max-width: 700px;

  background: #111;

  border: 1px solid #222;

  border-radius: 12px;

  overflow: hidden;
}

.modal_header {
  display: flex;
  justify-content: space-between;
  align-items: center;

  padding: 20px 24px;

  border-bottom: 1px solid #222;
}

.modal_header h2 {
  font-size: 24px;
  font-weight: 300;
}

.close {
  background: none;
  border: none;

  color: #aaa;

  font-size: 24px;

  cursor: pointer;

  transition: .25s;
}

.close:hover {
  color: white;
}

.modal_body {
  padding: 24px;

  display: flex;
  flex-direction: column;
  gap: 22px;
}

.input-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.input-group label {
  color: #888;
}

.input-group input,
.input-group textarea {

  background: #191919;

  border: 1px solid #333;

  color: white;

  padding: 12px;

  border-radius: 8px;

  outline: none;

  transition: .25s;

  font-size: 15px;
}

.input-group textarea {
  resize: vertical;
}

.input-group input:focus,
.input-group textarea:focus {

  border-color: #666;
}

.modal_footer {

  padding: 20px 24px;

  border-top: 1px solid #222;

  display: flex;
  justify-content: flex-end;

  gap: 15px;
}

.modal_footer button {

  padding: 12px 22px;

  border-radius: 8px;

  cursor: pointer;

  transition: .25s;

  font-size: 15px;
}

.cancel {

  background: transparent;

  color: #bbb;

  border: 1px solid #333;
}

.cancel:hover {

  background: #222;
}

.save {

  background: white;

  color: black;

  border: none;
}

.save:hover {

  opacity: .9;
}

.save:disabled {

  opacity: .5;

  cursor: not-allowed;
}

.error {

  padding: 12px;

  background: #4b1c1c;

  border: 1px solid #a31616;

  border-radius: 8px;

  color: #ffbdbd;
}

@media (max-width: 700px) {

  .modal_window {

    max-width: 100%;
  }

  .modal_header h2 {

    font-size: 20px;
  }

  .modal_footer {

    flex-direction: column;
  }

  .modal_footer button {

    width: 100%;
  }

}

</style>