<!--ПРОВЕРИТЬ, ВАЙБКОДИНГ + НЕ РАБОТАЮТ ФИЛЬТРЫ, НАДО ПЕРЕНЕСТИ В РАЗНЫЕ ФАЙЛЫ-->

<script setup>
import {getYoutubeEmbedUrl} from '@/composables/getYoutubeEmbedUrl.js'
import {onMounted} from 'vue'
import {useRoute} from 'vue-router'
import {useProjects} from '@/composables/useProjects'
import {Swiper, SwiperSlide} from 'swiper/vue'
import {Navigation, Pagination, Autoplay} from 'swiper/modules'
import {ref} from 'vue'
import 'swiper/css'
import 'swiper/css/navigation'
import 'swiper/css/pagination'
import FloatingHomeButton from "@/components/additional/FloatingHomeButton.vue";
import ImageModal from "@/components/additional/ImageModal.vue";
import VideoModal from "@/components/additional/VideoModal.vue";

const modal = ref({
  images: [],
  currentIndex: 0,
  isOpen: false,
})
const openImage = (mediaList, media) => {
  const images = mediaList.filter(item => item.type === 'image')

  modal.value.images = images
  modal.value.currentIndex = images.findIndex(item => item.id === media.id)
  modal.value.isOpen = true
}

const closeImage = () => {
  modal.value.isOpen = false
}

const route = useRoute()
const filters = ref({
  type: '',
  date: ''
})
const applyFilters = () => {
  fetchProjects(route.params.slug, filters.value)
}
const {
  projectItems,
  categoryTitle,
  loading,
  fetchProjects
} = useProjects()

onMounted(() => {
  applyFilters()
})
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
const modules = [Navigation, Pagination, Autoplay]
</script>

<template>
  <FloatingHomeButton></FloatingHomeButton>
  <section class="category">
    <div class="container">
      <div class="category_title">
        <h1>{{ categoryTitle }}</h1>
      </div>
      <div v-if="!loading" class="filters">
        <div class="filter">
          <button
              :class="{ active: !filters.date }"
              @click="filters.date='asc'; applyFilters()"
          >
            Все
          </button>
          <button
              :class="{ active: filters.date === 'asc' }"
              @click="filters.date='asc'; applyFilters()"
          >
            Новые
          </button>

          <button
              :class="{ active: filters.date === 'desc' }"
              @click="filters.date='desc'; applyFilters()"
          >
            Старые
          </button>
        </div>

      </div>
      <div class="category_items">
        <div class="loading" v-if="loading">Loading...</div>
        <div class="category_item" v-else v-for="project in projectItems" :key="project.id">
          <div class="category_text">
            <h3>{{ project.title }}</h3>
          </div>
          <Swiper
              class="category_slides"
              :modules="modules"
              :slides-per-view="3"
              :space-between="20"
              :loop="true"
              :autoplay="{delay:6000}"
              :pagination="{clickable:true}"
              :auto-height="true"
          >
            <SwiperSlide class="category_slide" v-for="(media, index) in project.media" :key="media.id">
              <img
                  v-if="media.type === 'image'"
                  :src="media.url"
                  :alt="project.title"
                  class="media"
                  @click="openImage(project.media, media)"
              >
              <div
                  v-else
                  class="video-wrapper"
                  @click="openVideo(media)"
              >
                <video
                    :src="media.url"
                    muted
                    playsinline
                    preload="metadata"
                    class="media video-media"
                />
                <div class="play-icon-overlay">
                  <svg class="play-icon" viewBox="0 0 24 24" fill="currentColor">
                    <polygon points="5,3 19,12 5,21"/>
                  </svg>
                </div>
              </div>
            </SwiperSlide>
          </Swiper>
          <div class="category_text">
            <p>{{ project.description }}</p>
            <p>{{project.project_date}}</p>
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
.category {
  padding: 40px 0;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

.category_title {
  margin-bottom: 30px;
  font-size: 72px;
  font-weight: 500;
  letter-spacing: 3px;

}

.category_items {
  display: flex;
  flex-direction: column;
  gap: 120px;
}
.category_text {
  display: flex;
  justify-content: space-between;
}
.category_text h3 {
  font-size: 42px;
  line-height: 1.3;
  letter-spacing: 3px;
  text-transform: uppercase;
  margin-bottom: 10px;
}

.category_text p {
  font-size: 18px;
  line-height: 1;
  letter-spacing: 1px;
  color: #474747;
  margin-top: 20px;
  margin-left: 5px;
  max-width: 80%;
}

.category_slides {
  display: flex;
  justify-content: center;
  align-items: center;
}

.category_slides :deep(.swiper-pagination-bullet) {
  background: var(--text);
}

.category_slide {
  height: 420px;
  overflow: hidden;
  border: 1px solid var(--border);
}

.category_item {
  padding: 50px 0;
  border-bottom: 1px solid rgba(255, 255, 255, .08);
}

.media {
  width: 100%;
  height: 100%;
  display: block;
}

img.media {
  object-fit: cover;
}

iframe.media {
  border: none;
}

.filters {
  display: flex;
  justify-content: center;
  gap: 120px;
}

.filter {
  display: flex;
  justify-content: center;
  gap: 15px
}

.filter button {
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

.filter button:hover {
  background: var(--text);
  color: var(--background);
}

.filter button.active {
  background: var(--text);
  color: var(--background);
  border-color: var(--text);
}
.video-wrapper {
  position: relative;
  width: 100%;
  height: 100%;
  cursor: pointer;
  background: #000;
}

.video-media {
  width: 100%;
  height: 100%;
  object-fit: cover;
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
  pointer-events: none;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
}

.play-icon {
  width: 28px;
  height: 28px;
  color: #000;
  margin-left: 4px;
}

.video-wrapper:hover .play-icon-overlay {
  transform: translate(-50%, -50%) scale(1.1);
}
@media (max-width: 1024px) {
  .category_title h1 {
    font-size: 56px;
  }

  .category_text h3 {
    font-size: 32px;
  }

  .category_slide {
    height: 350px;
  }

  .category_items {
    gap: 80px;
  }
}

/* Планшеты */
@media (max-width: 768px) {
  .category {
    padding: 50px 0 40px;
  }

  .container {
    padding: 0 16px;
  }

  .category_title {
    margin-bottom: 30px;
  }

  .category_title h1 {
    font-size: 40px;
  }

  .category_items {
    gap: 60px;
  }

  .category_item {
    padding: 30px 0;
  }

  .category_text h3 {
    font-size: 28px;
    margin-bottom: 15px;
  }

  .category_text p {
    font-size: 16px;
    max-width: 100%;
    margin-top: 15px;
  }

  .category_slide {
    height: 280px;
  }

  .category_slides {
    padding: 5px 0 40px;
  }

  /* Фильтры */
  .filters {
    margin-bottom: 30px;
  }

  .filter {
    gap: 10px;
  }

  .filter button {
    padding: 8px 16px;
    font-size: 13px;
  }

  /* Кнопка play */
  .play-icon-overlay {
    width: 56px;
    height: 56px;
  }

  .play-icon {
    width: 22px;
    height: 22px;
  }
}

/* Мобильные телефоны */
@media (max-width: 500px) {
  .category_title h1 {
    font-size: 28px;
  }

  .category_items {
    gap: 40px;
  }

  .category_item {
    padding: 20px 0;
  }

  .category_text h3 {
    font-size: 22px;
  }

  .category_text p {
    font-size: 14px;
    line-height: 1.5;
  }

  .category_slide {
    height: 200px;
  }

  .category_slides {
    padding: 0 0 30px;
  }

  .category_slides :deep(.swiper-pagination-bullet) {
    width: 8px;
    height: 8px;
  }

  /* Фильтры */
  .filters {
    margin-bottom: 20px;
  }

  .filter {
    gap: 8px;
    flex-wrap: wrap;
    justify-content: center;
  }

  .filter button {
    padding: 6px 14px;
    font-size: 12px;
  }

  /* Кнопка play */
  .play-icon-overlay {
    width: 44px;
    height: 44px;
  }

  .play-icon {
    width: 18px;
    height: 18px;
  }

  .loading {
    padding: 40px 0;
    font-size: 16px;
  }
}

/* Очень маленькие телефоны */
@media (max-width: 380px) {
  .category_title h1 {
    font-size: 24px;
  }

  .category_text h3 {
    font-size: 18px;
  }

  .category_slide {
    height: 160px;
  }

  .filter button {
    padding: 5px 10px;
    font-size: 11px;
  }

  .play-icon-overlay {
    width: 36px;
    height: 36px;
  }

  .play-icon {
    width: 14px;
    height: 14px;
  }
}

/* Горизонтальная ориентация на телефонах */
@media (max-height: 500px) and (orientation: landscape) {
  .category_slide {
    height: 160px;
  }

  .category_items {
    gap: 30px;
  }

  .category_text h3 {
    font-size: 20px;
    margin-bottom: 10px;
  }

  .category_text p {
    font-size: 14px;
    margin-top: 10px;
  }
}

/* Для экранов с высоким разрешением */
@media (min-width: 1400px) {
  .container {
    max-width: 1400px;
  }

  .category_slide {
    height: 500px;
  }
}

/* Для печати */
@media print {
  .video-wrapper {
    display: none;
  }

  .category_slides :deep(.swiper-pagination) {
    display: none;
  }
}
</style>