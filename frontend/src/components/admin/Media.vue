<script setup>
import {onMounted, ref} from "vue";
import {useProjects} from "@/composables/useProjects.js";
import { onBeforeUnmount } from "vue"
import ImageModal from "@/components/additional/ImageModal.vue";
import VideoModal from "@/components/additional/VideoModal.vue";

const emit = defineEmits([
  'open-projects',
  'back-category',
  'open-media',
  'back-project'
])
const props = defineProps({
  category: {
    type: Object,
    default: null
  },
  project: {
    type: Object,
    default: null
  }
})
onBeforeUnmount(() => {
  files.value.forEach(item => {
    if (item.preview) {
      URL.revokeObjectURL(item.preview)
    }
  })
})
const {
  mediaItems,
  loading,
  submitting,
  adminGetMedia,
  adminAddMedia,
  adminDeleteMedia
} = useProjects();

const files = ref([]);

const prepareFiles = (list) => {
  const prepared = [...list]
      .filter(file =>
          !files.value.some(
              f =>
                  f.file.name === file.name &&
                  f.file.size === file.size
          )
      )
      .map(file => ({
        file,
        preview: URL.createObjectURL(file)
      }))

  files.value.push(...prepared)
}

onMounted(() => {
  adminGetMedia(props.project.id);
});

const handleFiles = (e) => {
  prepareFiles(e.target.files)
};

const upload = async () => {
  if (!files.value.length) return;

  const data = new FormData()

  files.value.forEach(item => {
    data.append('media[]', item.file)
  })

  try{
    await adminAddMedia(props.project.id, data);
    await adminGetMedia(props.project.id)

  } finally {
    files.value.forEach(item => {
      if (item.preview) {
        URL.revokeObjectURL(item.preview)
      }
    })

    files.value = []
  }
};
const remove = async (media) => {
  await adminDeleteMedia(media.id);
  await adminGetMedia(props.project.id);
};

const removeFile = (index) => {
  const item = files.value[index]

  if (!item) return

  URL.revokeObjectURL(item.preview)
  files.value.splice(index, 1)
}

const isDragging = ref(false);

const handleDrop = (e) => {
  e.preventDefault();
  isDragging.value = false;

  if (e.dataTransfer.files.length) {
    prepareFiles(e.dataTransfer.files)
  }
};

const handleDragOver = (e) => {
  e.preventDefault();
  isDragging.value = true;
};

const handleDragLeave = () => {
  isDragging.value = false;
};

const videoModal = ref({
  video: null,
  isOpen: false,
});

const openVideo = (media) => {
  videoModal.value.video = media
  videoModal.value.isOpen = true
}

const closeVideo = () => {
  videoModal.value.video = null
  videoModal.value.isOpen = false
}

const modal = ref({
  images: [],
  currentIndex: 0,
  isOpen: false,
})
const openImage = (media) => {
  const images = mediaItems.value.filter(item => item.type === 'image')

  modal.value.images = images
  modal.value.currentIndex = images.findIndex(item => item.id === media.id)
  modal.value.isOpen = true
}

const closeImage = () => {
  modal.value.isOpen = false
}
</script>

<template>
  <section class="media-page">
    <div class="container">

      <div class="page-header">
        <button class="back-btn" @click="emit('back-project')">← К проектам</button>
        <div>
          <h2>Медиа проекта</h2>
          <p>{{ project.title }}</p>
        </div>
      </div>

      <div class="upload-card">
        <h3>Добавить файлы</h3>
        <div class="drop-zone" :class="{ active: isDragging }" @dragover="handleDragOver" @dragleave="handleDragLeave" @drop="handleDrop">

          <input id="media-upload" class="hidden-input" type="file" multiple @change="handleFiles">
          <label for="media-upload">
            <div class="drop-icon">📁</div>
            <h4>Перетащите файлы сюда</h4>
            <p>или нажмите для выбора</p>
          </label>

        </div>
        <div v-if="files.length" class="preview-grid">
          <div class="preview-card" v-for="(item,index) in files" :key="item.file.name">

            <img v-if="item.file.type.startsWith('image/')" :src="item.preview" alt="prepareImage">
            <video v-else-if="item.file.type.startsWith('video/')" :src="item.preview" muted/>

            <div v-else class="file-preview">📄</div>

            <div class="preview-footer">
              <span>{{ item.file.name }}</span>
              <button class="remove-preview" @click="removeFile(index)">✕</button>
            </div>

          </div>
        </div>

        <button v-if="files.length" class="upload-btn" @click="upload" :disabled="submitting">{{ submitting ? 'Сохранение...' : 'Загрузить ' + files.length + ' файл(ов)'}}</button>
      </div>

      <div class="loading" v-if="loading">Loading...</div>
      <div class="empty" v-else-if="!mediaItems.length">Пока файлов нет</div>

      <div v-else class="media-grid">
        <div class="media-card" v-for="media in mediaItems" :key="media.id">

          <div v-if="media.type === 'image'" class="media-wrapper" @click="openImage(media)">
            <img :src="media.url" alt="image" class="media-image">
          </div>


          <div v-else-if="media.type === 'video'" class="media-wrapper video-wrapper" @click="openVideo(media)">
            <video :src="media.url" muted class="media-video" />
            <div class="play-icon-overlay">
              <svg class="play-icon" viewBox="0 0 24 24" fill="currentColor">
                <polygon points="5,3 19,12 5,21"/>
              </svg>
            </div>
          </div>

          <div class="media-footer">
            <button class="delete-btn" @click="remove(media)">Удалить</button>
          </div>

        </div>
      </div>
    </div>
  </section>
  <ImageModal :images="modal.images"
              :current-index="modal.currentIndex"
              :is-open="modal.isOpen"
              @close="closeImage"
  />
  <VideoModal :video="videoModal.video"
              :is-open="videoModal.isOpen"
              @close="closeVideo"
  />
</template>

<style scoped>
.preview-grid{

  display:grid;

  grid-template-columns:repeat(auto-fill,minmax(170px,1fr));

  gap:18px;

  width:100%;
}

.preview-card{

  background:#181818;

  border:1px solid #333;

  border-radius:10px;

  overflow:hidden;
}
.preview-card img,
.preview-card video {
  width: 100%;
  aspect-ratio: 16/9;
  object-fit: cover;
  background: #000;
  display: block;
}

.video-preview-wrapper video {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.media-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 22px;
}

.media-card {
  background: #111;
  border: 1px solid #222;
  border-radius: 12px;
  overflow: hidden;
  transition: transform 0.3s, border-color 0.3s;
}

.media-card:hover {
  border-color: #444;
  transform: translateY(-4px);
}

.media-wrapper {
  position: relative;
  width: 100%;
  aspect-ratio: 16/9;
  background: #0a0a0a;
  overflow: hidden;
  cursor: pointer;
}

.media-image,
.media-video {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.media-video {
  object-fit: cover;
  background: #000;
}

.video-wrapper {
  position: relative;
  background: #000;
}

.play-icon-overlay {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 64px;
  height: 64px;
  background: rgba(255, 255, 255, 0.9);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
  opacity: 0.9;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
  pointer-events: none;
}

.play-icon {
  width: 28px;
  height: 28px;
  color: #000;
  margin-left: 5px;
}

.preview-card img {
  object-fit: cover;
}
.preview-card video{
  object-fit: contain;
  background: #000;
}


.file-preview{

  height:140px;

  display:flex;

  justify-content:center;

  align-items:center;

  font-size:50px;
}

.preview-footer{

  display:flex;

  justify-content:space-between;

  align-items:center;

  padding:10px;
}

.preview-footer span{

  overflow:hidden;

  text-overflow:ellipsis;

  white-space:nowrap;

  flex:1;

  font-size:13px;
}

.remove-preview{

  background:none;

  border:none;

  color:#ff6b6b;

  cursor:pointer;

  font-size:18px;
}
.media-page {
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 30px;
}
.container {
  display: flex;
  flex-direction: column;
  gap: 30px;
}
.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 20px;
}

.page-header h2 {
  font-size: 34px;
  font-weight: 400;
  margin-bottom: 8px;
}

.page-header p {
  color: #777;
}

.back-btn {
  padding: 12px 22px;
  background: #111;
  color: #fff;
  border: 1px solid #333;
  border-radius: 8px;
  cursor: pointer;
  transition: .25s;
}

.back-btn:hover {
  background: #222;
}

.upload-card {
  background: #111;
  border: 1px solid #222;
  border-radius: 12px;
  padding: 24px;

  display: flex;
  align-items: center;
  gap: 20px;
  flex-wrap: wrap;
}

.upload-card h3 {
  width: 100%;
  font-weight: 400;
}

.upload-card input {
  flex: 1;
  min-width: 250px;
}

.hidden-input {
  display: none;
}

.drop-zone {

  border: 2px dashed #333;

  border-radius: 12px;

  padding: 45px 20px;

  cursor: pointer;

  transition: .25s;

  text-align: center;

  background: #0f0f0f;
}

.drop-zone:hover {

  border-color: #666;
}

.drop-zone.active {

  border-color: #16a34a;

  background: #0f1d13;
}

.drop-zone label {

  cursor: pointer;

  display: block;
}

.drop-icon {

  font-size: 54px;

  margin-bottom: 18px;
}

.drop-zone h4 {

  font-size: 22px;

  margin-bottom: 10px;

  font-weight: 400;
}

.drop-zone p {

  color: #777;
}

.selected-files {

  display: flex;

  flex-wrap: wrap;

  gap: 12px;

  margin-top: 20px;
}

.selected-file {

  padding: 10px 16px;

  background: #181818;

  border: 1px solid #2c2c2c;

  border-radius: 8px;

  font-size: 14px;

  color: #ccc;
}

.media-grid {
  display: grid;
  grid-template-columns:repeat(auto-fill, minmax(280px, 1fr));
  gap: 22px;
}

.media-card {
  background: #111;
  border: 1px solid #222;
  border-radius: 12px;
  overflow: hidden;
  transition: .25s;
}
.media-card img{
  width:100%;
  height:220px;
  object-fit:cover;
}
.media-card video{
  width:100%;
  height:220px;

  object-fit:contain;
  background:#000;
}
.media-card:hover {
  border-color: #444;
}

.media-card img,
.media-card video {

  width: 100%;
  height: 220px;

  object-fit: cover;

  display: block;
}

.media-footer {

  padding: 18px;

  display: flex;
  flex-direction: column;
  gap: 15px;
}

.media-footer span {

  color: #bbb;

  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.delete-btn {

  padding: 10px;

  background: transparent;

  border: 1px solid #333;

  color: #ddd;

  border-radius: 8px;

  cursor: pointer;

  transition: .25s;
}

.delete-btn:hover {

  background: #7f1d1d;
  border-color: #dc2626;

  color: white;
}

.empty {

  padding: 60px;

  border: 1px dashed #333;

  border-radius: 12px;

  text-align: center;

  color: #777;
}

@media (max-width: 700px) {

  .page-header {

    flex-direction: column;
    align-items: stretch;
  }

  .back-btn {

    width: 100%;
  }

  .upload-card {

    flex-direction: column;
    align-items: stretch;
  }

}
.upload-btn{
  margin-top:20px;

  align-self:flex-start;

  padding:14px 24px;

  background:#14532d;

  color:#fff;

  border:1px solid #16a34a;

  border-radius:8px;

  cursor:pointer;

  font-size:15px;

  transition:.25s;
}

.upload-btn:hover{
  background:#166534;
  transform:translateY(-2px);
}

.upload-btn:disabled{
  opacity:.6;
  cursor:not-allowed;
  transform:none;
}
</style>