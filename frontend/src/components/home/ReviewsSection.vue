<script setup>
import {onMounted} from 'vue'
import {Swiper, SwiperSlide} from 'swiper/vue'
import {Navigation, Pagination, Autoplay} from 'swiper/modules'
import {ref} from 'vue'
import 'swiper/css'
import 'swiper/css/navigation'
import 'swiper/css/pagination'

import {useReviews} from '@/composables/useReviews'
import ReviewSlide from '../additional/ReviewSliderComponent.vue'

const {reviewItems, loading, fetchReviews} = useReviews()
const {submitting, submitError, submitReview} = useReviews()
const successMessage = ref('')
import { useCategories } from "@/composables/useCategories.js";
const {categoryItems, fetchCategories} = useCategories()

onMounted(() => {
      fetchCategories()
    }
)

const form = ref({
  name: '',
  title: '',
  description: '',
})
const onSubmit = async () => {
  const result = await submitReview(form.value)
  if (result.success) {
    form.value = {name: '', description: '', title: ''}
    successMessage.value = 'Отзыв успешно отправлен!'
  } else {

  }
}

onMounted(fetchReviews)

const modules = [Navigation, Pagination, Autoplay]
</script>

<template>
  <section class="reviews">
    <div class="container">
      <div class="reviews_title">
        <h2>ОТЗЫВЫ</h2>
      </div>
      <div class="loading" v-if="loading">Loading...</div>
      <Swiper
          class="reviews_items"
          v-else
          :modules="modules"
          :slides-per-view="1"
          :loop="true"
          :autoplay="{
            delay:8000
          }"
          :pagination="{
            clickable:true
          }"
          :auto-height="true"
      >
        <SwiperSlide v-for="review in reviewItems" :key="review.id">
          <ReviewSlide :review="review"/>
        </SwiperSlide>
      </Swiper>
      <div class="review_form">
        <h2>Оставьте свой отзыв</h2>
        <input v-model="form.name" placeholder="Ваше имя" required />
        <textarea v-model="form.description" rows="5" placeholder="Ваш отзыв" required></textarea>
        <select v-model="form.title" required :class="{placeholder: !form.title}">
          <option disabled value="" class="review_option">Выбеирте категорию</option>
          <option v-for="category in categoryItems" :key="category.id" :value="category.title">{{category.title}}</option>
        </select>
        <div v-if="submitError" class="review_error">{{submitError}}</div>
        <button @click="onSubmit" :disabled="submitting">{{submitting ? 'Отправка...' : 'Отправить'}}</button>
      </div>
    </div>
  </section>
</template>

<style scoped>
.reviews {
  border-bottom: 1px solid var(--border);
  padding: 40px 0;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

.reviews_title {
  margin-bottom: 30px;
  font-size: 18px;
  font-weight: 500;
  letter-spacing: 0.15px;
}

.reviews_items :deep(.swiper-pagination-bullet) {
  background: var(--text);
}

.review_form {
  display: flex;
  flex-direction: column;
  align-items: center;
  max-width: 600px;
  margin: 0 auto;
  padding: 40px 0;
}

.review_form select.placeholder{
  color: var(--sub-text);
  font-weight:300;
}

.review_form select{
  color:#fff;
}

.review_form select option{
  color:#fff;
  background:#111;
}
.review_form h2 {
  margin-bottom: 30px;
  font-size: 32px;
  text-transform: uppercase;
}

.review_form input,
.review_form textarea,
.review_form select {
  width: 100%;
  padding: 16px 0 12px 0;
  margin-bottom: 24px;
  background: transparent;
  border: none;
  border-bottom: 1px solid rgba(255, 255, 255, 0.2);
  color: #fff;
  font-size: 18px;
  font-weight: 300;
  outline: none;
  transition: border-color 0.3s ease;
  resize: none;
}
.review_form select{
  width:100%;
  padding:16px 0 12px;
  margin-bottom:24px;
  background:transparent;
  border:none;
  border-bottom:1px solid rgba(255,255,255,.2);
  font-size:18px;
  font-weight:300;

  outline:none;

  transition:border-color .3s ease;

  cursor:pointer;

  appearance:none;
  -webkit-appearance:none;
  -moz-appearance:none;

  background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' fill='white' viewBox='0 0 16 16'%3E%3Cpath d='M1.5 5l6.5 6 6.5-6' stroke='white' stroke-width='2' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");

  background-repeat:no-repeat;
  background-position:right center;
  background-size:18px;

  padding-right:30px;
}

.review_form select:focus{
  border-bottom-color:#fff;
}

.review_form select option{
  background:#111;
  color:#fff;
}

.review_form input::placeholder,
.review_form textarea::placeholder {
  color: var(--sub-text);
  font-weight: 300;
}


.review_form input:focus,
.review_form textarea:focus {
  border-bottom-color: #ffffff;
}

.review_form textarea {
  min-height: 80px;
}

.review_form button {
  margin-top: 20px;
  padding: 14px 48px;
  background: transparent;
  border: 1px solid var(--border);
  color: var(--text);
  font-size: 16px;
  letter-spacing: 1px;
  cursor: pointer;
  transition: all 0.3s ease;
  text-transform: uppercase;
  font-weight: 300;
}

.review_form button:hover:not(:disabled) {
  background: var(--text);
  color: var(--background);
  border-color: var(--text);
}

.review_form button:disabled {
  opacity: 0.3;
  cursor: not-allowed;
}

/* Сообщения об ошибках / успехе (если есть) */
.review_form .error-message,
.review_form .success-message {
  width: 100%;
  text-align: center;
  padding: 8px 0;
  margin-bottom: 16px;
  font-size: 14px;
}
.review_form .error-message {
  color: #f44336;
}
.review_form .success-message {
  color: #4caf50;
}
@media (max-width: 992px) {

  .reviews{
    padding:35px 0;
  }

  .container{
    padding:0 18px;
  }

  .reviews_title{
    margin-bottom:25px;
  }

  .reviews_title h2{
    font-size:30px;
  }

  .review_form{
    max-width:100%;
    padding:35px 0;
  }

  .review_form h2{
    font-size:28px;
    text-align:center;
  }

  .review_form input,
  .review_form textarea,
  .review_form select{
    font-size:17px;
  }

  .review_form button{
    width:100%;
  }

}

/* ============================= */
/* Телефоны */
/* ============================= */
@media (max-width:768px){

  .reviews{
    padding:30px 0;
  }

  .container{
    padding:0 16px;
  }

  .reviews_title{
    margin-bottom:22px;
  }

  .reviews_title h2{
    font-size:24px;
    text-align:center;
  }

  .review_form{
    padding:30px 0;
  }

  .review_form h2{
    font-size:24px;
    line-height:1.3;
    margin-bottom:24px;
    text-align:center;
  }

  .review_form input,
  .review_form textarea,
  .review_form select{
    font-size:16px;
    padding:14px 0 10px;
    margin-bottom:20px;
  }

  .review_form textarea{
    min-height:120px;
  }

  .review_form button{
    width:100%;
    margin-top:10px;
    padding:14px;
    font-size:15px;
  }

}

/* ============================= */
/* Маленькие телефоны */
/* ============================= */
@media (max-width:480px){

  .reviews{
    padding:25px 0;
  }

  .container{
    padding:0 14px;
  }

  .reviews_title h2{
    font-size:22px;
  }

  .review_form{
    padding:25px 0;
  }

  .review_form h2{
    font-size:20px;
    margin-bottom:20px;
  }

  .review_form input,
  .review_form textarea,
  .review_form select{
    font-size:15px;
  }

  .review_form textarea{
    min-height:100px;
  }

  .review_form button{
    font-size:14px;
    letter-spacing:.5px;
  }

}
</style>